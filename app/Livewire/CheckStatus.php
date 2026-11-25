<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\User;
use App\Mail\TrackStatusChange;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\TurnstileVerifier;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CheckStatus extends Component
{
    public $caseNumber = '';
    #[Locked] public array $reportData = []; //stops clients tampering with id/status
    public $message = '';
    public $turnstileToken = '';
    public bool $showCaptcha = false;
    #[Locked] public bool $captchaPassed = false;
    #[Locked] public string $captchaChallengeId = '';
    #[Locked] public string $captchaCaseNumber = '';

    protected $rules = [
        'caseNumber' => ['required', 'string', 'max:40', 'regex:/^[A-Za-z0-9-]{3,40}$/D'],
    ];

    protected $queryString = ['caseNumber'];

    public function mount()
    {
        if (!empty($this->caseNumber)) {
            $this->caseNumber = strtoupper(trim($this->caseNumber, " "));
        }
    }

    public function updatedCaseNumber()
    {
        $this->caseNumber = strtoupper(trim($this->caseNumber, " "));

        if (($this->reportData['case_number'] ?? $this->caseNumber) !== $this->caseNumber) {
            $this->reportData = [];
            $this->message = '';
        }
    }

    public function checkStatus()
    {
        $this->reportData = [];
        $this->message = '';
        $this->validate();
        $this->turnstileToken = '';
        $this->captchaPassed = false;
        $this->resetErrorBag('turnstileToken');
        $this->openCaptchaChallenge();
    }

    private function openCaptchaChallenge(): void
    {
        // Bind this widget instance to the normalized case so stale callbacks cannot switch lookups.
        $this->captchaChallengeId = (string) Str::uuid();
        $this->captchaCaseNumber = strtoupper(trim($this->caseNumber, " "));
        Cache::put($this->challengeCacheKey($this->captchaChallengeId), $this->captchaCaseNumber, now()->addMinutes(10));
        $this->showCaptcha = true;
        $this->captchaPassed = false;
        $this->dispatch('check-status-turnstile-open');
    }

    private function challengeCacheKey(string $id): string
    {
        return 'check-status:challenge:'.$id;
    }

    private function cancelledCacheKey(string $id): string
    {
        return 'check-status:challenge-cancelled:'.$id;
    }

    private function verifiedCacheKey(string $id): string
    {
        return 'check-status:challenge-verified:'.$id;
    }

    private function refreshExpiredChallenge(): void
    {
        $this->addError('turnstileToken', 'The security check expired. Please complete the new challenge.');
        $this->openCaptchaChallenge();
    }

    public function cancelCaptcha(): void
    {
        if ($this->captchaChallengeId !== '') {
            // Keep a cancellation marker long enough to stop an in-flight Siteverify response.
            Cache::put($this->cancelledCacheKey($this->captchaChallengeId), true, now()->addMinutes(10));
            Cache::forget($this->challengeCacheKey($this->captchaChallengeId));
            Cache::forget($this->verifiedCacheKey($this->captchaChallengeId));
        }
        $this->showCaptcha = false;
        $this->captchaPassed = false;
        $this->turnstileToken = '';
        $this->reportData = [];
        $this->captchaChallengeId = '';
        $this->captchaCaseNumber = '';
        $this->dispatch('report-verification-reset');
        $this->dispatch('check-status-captcha-closed');
    }

    public function clearCaseError(): void
    {
        $this->resetErrorBag('caseNumber');
    }

    public function verifyTurnstile(string $token, string $challengeId): void
    {
        // Accept only the active, case-bound challenge and consume it once to ignore duplicate callbacks.
        if (! $this->showCaptcha || $challengeId === '' || $challengeId !== $this->captchaChallengeId) {
            return;
        }

        $caseNumber = $this->captchaCaseNumber;
        $consumedKey = 'check-status:challenge-consumed:'.$challengeId;
        if ($caseNumber === '' || strtoupper(trim($this->caseNumber, " ")) !== $caseNumber
            || Cache::has($consumedKey) || Cache::has($this->cancelledCacheKey($challengeId))) {
            return;
        }

        if (Cache::get($this->challengeCacheKey($challengeId)) !== $caseNumber) {
            // The active challenge may have been consumed or cancelled by another request.
            if (! Cache::has($consumedKey) && ! Cache::has($this->cancelledCacheKey($challengeId))) {
                $this->refreshExpiredChallenge();
            }

            return;
        }

        if (! Cache::add($consumedKey, true, now()->addMinutes(10))) {
            return;
        }
        Cache::forget($this->challengeCacheKey($challengeId));
        $this->turnstileToken = $token;

        $ipKey = 'check-status:ip:' . request()->ip();
        $globalKey = 'check-status:global';
        if (RateLimiter::tooManyAttempts($ipKey, 5)) {
            // Dismiss the dialog so its higher z-index cannot cover the rate-limit message.
            $this->addError('caseNumber', 'Too many attempts. Please try again in a few minutes.');
            $this->reportData = [];
            $this->turnstileToken = '';
            $this->showCaptcha = false;
            $this->captchaChallengeId = '';
            $this->captchaCaseNumber = '';
            $this->dispatch('check-status-focus-case-number');
            return;
        }
        RateLimiter::hit($ipKey, 900);
        RateLimiter::hit($globalKey, 900);

        if (! $this->passesBotCheck()) {
            $this->reportData = [];
            if (Cache::get($this->cancelledCacheKey($challengeId))) {
                $this->showCaptcha = false;
                $this->captchaPassed = false;
                $this->captchaChallengeId = '';
                $this->captchaCaseNumber = '';
            } else {
                $this->openCaptchaChallenge();
            }
            return;
        }

        if (Cache::get($this->cancelledCacheKey($challengeId))) {
            $this->reportData = [];
            $this->showCaptcha = false;
            $this->captchaPassed = false;
            $this->captchaChallengeId = '';
            $this->captchaCaseNumber = '';
            return;
        }

        Cache::put($this->verifiedCacheKey($challengeId), $caseNumber, now()->addMinute());
        $this->captchaPassed = true;
        $this->showCaptcha = true;
        // Show the success state first; the user can still cancel before any report lookup runs.
        $this->dispatch('check-status-captcha-passed');
    }

    public function finishCaptcha(): void
    {
        if (! $this->captchaPassed) {
            return;
        }

        $challengeId = $this->captchaChallengeId;
        $caseNumber = $this->captchaCaseNumber;
        if ($challengeId === '' || $caseNumber === '' || strtoupper(trim($this->caseNumber, " ")) !== $caseNumber
            || Cache::has($this->cancelledCacheKey($challengeId))) {
            $this->cancelCaptcha();
            return;
        }

        // A verified browser state can only claim the short-lived server proof once.
        $completedKey = 'check-status:challenge-completed:'.$challengeId;
        if (! Cache::add($completedKey, true, now()->addMinutes(10))) {
            return;
        }

        if (Cache::pull($this->verifiedCacheKey($challengeId)) !== $caseNumber) {
            $this->refreshExpiredChallenge();

            return;
        }

        if (Cache::has($this->cancelledCacheKey($challengeId))) {
            $this->cancelCaptcha();

            return;
        }

        // Recheck cancellation before returning the lookup result.
        $report = Report::with(['abuseType', 'subtype'])->where('case_number', $caseNumber)->first();
        if (Cache::get($this->cancelledCacheKey($challengeId))) {
            $this->reportData = [];
            $this->showCaptcha = false;
            $this->captchaPassed = false;
            $this->captchaChallengeId = '';
            $this->captchaCaseNumber = '';
            return;
        }

        if (! $report) {
            $this->addError('caseNumber', 'No report found with the provided case number.');
            $this->message = '';
            $this->reportData = [];
            $this->dispatch('check-status-focus-case-number');
        } else {
            $this->reportData = [
                'id' => $report->id,
                'case_number' => $report->case_number,
                'status' => $report->status,
                'created_at' => $report->created_at->format('Y-m-d H:i:s'),
                'full_name' => $report->full_name,
                'reporter_email' => $report->reporter_email,
                'phone_number' => $report->phone_number,
                'location' => $report->location,
                'grade' => $report->grade,
                'school_name' => $report->school_name,
                'age' => $report->age,
                'description' => trim((string) ($report->description ?? '')),
                'image_path' => $report->image_path,
                'is_anonymous' => $report->is_anonymous,
                'latest_status_reason' => $report->latest_status_reason,
                'abuse_type' => $report->abuseType ? $report->abuseType->type_name : null,
                'subtype' => $report->subtype ? $report->subtype->sub_type_name : null,
            ];
            $this->message = '';
        }

        $this->showCaptcha = false;
        $this->captchaPassed = false;
        $this->captchaChallengeId = '';
        $this->captchaCaseNumber = '';
        $this->dispatch('check-status-captcha-closed');
    }

    protected function passesBotCheck(): bool
    {
        try {
            app(TurnstileVerifier::class)->verify($this->turnstileToken, 'check_status');

            return true;
        } catch (ValidationException $e) {
            $this->addError(
                'turnstileToken',
                $e->errors()['turnstileToken'][0] ?? 'Please complete a fresh verification and try again.'
            );

            return false;
        } finally {
            $this->turnstileToken = '';
            $this->dispatch('report-verification-reset');
        }
    }

    protected function findSchoolAdmin(Report $report)
    {
        return User::where('role', 'school')
            ->where('school_name', $report->school_name)
            ->first();
    }

    protected function sendNotifications(Report $report, string $reason, string $status)
    {
        $admin = $this->findSchoolAdmin($report);

        if ($admin && $admin->email) {
            try {
                Mail::to($admin->email)->send(
                    new TrackStatusChange($report, $reason, $status)
                );
            } catch (\Exception $e) {
                Log::error("Failed to send status update email to admin ({$admin->email}) for report #{$report->case_number}: " . $e->getMessage());
            }
        }
    }

    public function markUnresolved()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'forwarded') {
            $report = Report::find($this->reportData['id']);

            $newStatus = 'unresolved';
            $reason = 'Reporter chose not to keep the case forwarded, changing the status to Unresolved.';

            $report->status = $newStatus;
            $report->latest_status_reason = $reason;
            $report->save();

            $this->sendNotifications($report, $reason, $newStatus);

            $this->dispatch('status-updated', message: 'Your case status has been updated to Unresolved. A notification has been sent.', status: $newStatus);
        }

        $this->reset(['caseNumber', 'reportData']);
    }

    public function markForwarded()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'forwarded') {
            $report = Report::find($this->reportData['id']);

            $newStatus = 'forwarded';
            $reason = 'Reporter chose to keep the case Forwarded.';

            $report->latest_status_reason = $reason;
            $report->save();

            $this->sendNotifications($report, $reason, $newStatus);

            $this->dispatch('status-updated', message: 'Your case remains Forwarded. A notification has been sent.', status: $newStatus);
        }

        $this->reset(['caseNumber', 'reportData']);
    }

    public function appealReport()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'false-report') {
            return redirect()->route('edit-report', ['caseNumber' => $this->reportData['case_number']]);
        }
    }

    public function render()
    {
        return view('livewire.check-status');
    }
}
