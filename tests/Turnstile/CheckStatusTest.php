<?php

namespace Tests\Turnstile;

use App\Livewire\CheckStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

class CheckStatusTest extends TurnstileTestCase
{
    // Regression coverage for the revised modal-first Check Status CAPTCHA flow.
    private function report(): void
    {
        DB::table('reports')->insert([
            'case_number' => 'BU-0101-0001', 'status' => 'under-review', 'abuse_type_id' => 1,
            'subtype_id' => 1, 'description' => 'Fictional description', 'school_name' => 'Test School',
            'is_anonymous' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function verified(string $action = 'check_status'): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response([
            'success' => true, 'hostname' => 'reports.test', 'action' => $action,
        ])]);
    }

    private function openChallenge(string $caseNumber = 'BU-0101-0001')
    {
        $component = Livewire::test(CheckStatus::class)->set('caseNumber', $caseNumber)->call('checkStatus');

        return [$component, $component->get('captchaChallengeId')];
    }

    public function test_search_opens_captcha_without_looking_up_the_case(): void
    {
        $this->report();
        DB::enableQueryLog();
        DB::flushQueryLog();

        [$component] = $this->openChallenge();

        $reportQueries = collect(DB::getQueryLog())->filter(fn ($query) => str_contains(strtolower($query['query']), ' from "reports"'));
        $component->assertSet('showCaptcha', true)->assertSet('reportData', []);
        $this->assertCount(0, $reportQueries);
        Http::assertNothingSent();
    }

    public function test_widget_is_only_rendered_inside_the_open_dialog(): void
    {
        $html = $this->get('/check-status')->assertOk()->getContent();
        $this->assertStringNotContainsString('Human verification', $html);
        $this->assertStringNotContainsString('data-action="check_status"', $html);
        $this->assertMatchesRegularExpression('/report-turnstile\.js\?v=[a-f0-9]{12}/', $html);
        $this->assertStringNotContainsString('unpkg.com/alpinejs', $html);
        $this->assertStringNotContainsString('test-secret', $html);
    }

    // Task 1: the dialog exposes an exit and keyboard focus handling.
    public function test_open_dialog_has_cancel_escape_and_focus_trap_controls(): void
    {
        $component = Livewire::test(CheckStatus::class)->set('caseNumber', 'BU-0101-0001')->call('checkStatus');

        $component->assertSee('Cancel')->assertSee('role="dialog"', false)
            ->assertSee('@keydown.window="onKeydown($event)"', false)
            ->assertSee('@focusin.window="keepFocus($event)"', false);
    }

    // Task 3: verification feedback appears before the automatic lookup continues.
    public function test_valid_captcha_callback_automatically_continues_the_lookup(): void
    {
        $this->report();
        $this->verified();
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasNoErrors()->assertSet('reportData', [])->assertSet('turnstileToken', '')
            ->assertSet('showCaptcha', true)->assertSet('captchaPassed', true)
            ->assertDispatched('check-status-captcha-passed')->assertDispatched('report-verification-reset')
            ->assertSee('Security check passed.')->assertSee('wire:poll.750ms="finishCaptcha"', false);
        Http::assertSentCount(1);

        $component->call('finishCaptcha')->assertSet('reportData.case_number', 'BU-0101-0001')
            ->assertSet('reportData.status', 'under-review')->assertSet('showCaptcha', false)
            ->assertSet('captchaPassed', false);
    }

    // Task 1: cancel preserves input and invalidates a callback already in flight.
    public function test_cancel_keeps_the_case_number_and_a_pending_callback_cannot_lookup(): void
    {
        $this->report();
        [$component, $challengeId] = $this->openChallenge();

        $component->call('cancelCaptcha')->assertSet('showCaptcha', false)
            ->assertSet('caseNumber', 'BU-0101-0001')->assertSet('reportData', []);
        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertSet('reportData', [])->assertSet('showCaptcha', false);
        Http::assertNothingSent();

        $component->call('checkStatus')->assertSet('showCaptcha', true);
        $this->assertNotSame($challengeId, $component->get('captchaChallengeId'));
    }

    // Task 3: duplicate callbacks cannot spend a second attempt or reuse the challenge.
    public function test_duplicate_callback_is_ignored_after_first_callback_consumes_challenge(): void
    {
        $this->report();
        $this->verified();
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertSet('captchaPassed', true)->assertSet('reportData', []);
        $component->call('finishCaptcha')->assertSet('reportData.case_number', 'BU-0101-0001');
        Http::assertSentCount(1);
    }

    public function test_cancel_after_success_feedback_stops_the_pending_lookup(): void
    {
        $this->report();
        $this->verified();
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertSet('captchaPassed', true)->assertSet('reportData', []);
        $component->call('cancelCaptcha')->call('finishCaptcha')
            ->assertSet('reportData', [])->assertSet('showCaptcha', false);
        Http::assertSentCount(1);
    }

    public function test_rejected_token_returns_nothing_and_reopens_fresh_challenge(): void
    {
        $this->report();
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => false, 'error-codes' => ['timeout-or-duplicate']])]);
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasErrors('turnstileToken')->assertSet('reportData', [])
            ->assertSet('turnstileToken', '')->assertSet('showCaptcha', true)
            ->assertDispatched('report-verification-reset');
        $this->assertNotSame($challengeId, $component->get('captchaChallengeId'));
        Http::assertSentCount(1);
    }

    public function test_token_issued_for_another_action_is_rejected(): void
    {
        $this->report();
        $this->verified('report_submit');
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasErrors('turnstileToken')->assertSet('reportData', []);
    }

    public function test_missing_configuration_fails_closed_and_can_be_cancelled(): void
    {
        $this->report();
        config(['turnstile.hostnames' => []]);
        [$component, $challengeId] = $this->openChallenge();

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasErrors('turnstileToken')->assertSet('reportData', [])->assertSet('showCaptcha', true);
        Http::assertNothingSent();
        $component->call('cancelCaptcha')->assertSet('showCaptcha', false)
            ->assertSet('caseNumber', 'BU-0101-0001');
    }

    // Task 2: a rate-limited callback clears its token and exposes the error outside the dialog.
    public function test_rate_limited_callback_closes_dialog_clears_token_and_keeps_case_number(): void
    {
        $this->report();
        $this->verified();
        [$component, $challengeId] = $this->openChallenge();
        for ($attempt = 0; $attempt < 5; $attempt++) {
            RateLimiter::hit('check-status:ip:127.0.0.1', 900);
        }

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasErrors('caseNumber')->assertSet('reportData', [])
            ->assertSet('turnstileToken', '')->assertSet('showCaptcha', false)
            ->assertSet('caseNumber', 'BU-0101-0001')->assertDispatched('check-status-focus-case-number');
        Http::assertNothingSent();
    }

    public function test_surrounding_spaces_and_lowercase_are_normalized(): void
    {
        $this->report();
        $this->verified();
        [$component, $challengeId] = $this->openChallenge(' bu-0101-0001 ');

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasNoErrors()->assertSet('reportData', []);
        $component->call('finishCaptcha')->assertSet('reportData.case_number', 'BU-0101-0001');
    }

    public function test_unknown_case_number_still_requires_verification(): void
    {
        $this->verified();
        [$component, $challengeId] = $this->openChallenge('NOPE-0000');

        $component->call('verifyTurnstile', 'fixture-only', $challengeId)
            ->assertHasNoErrors()->assertSet('reportData', []);
        $component->call('finishCaptcha')
            ->assertHasErrors('caseNumber')->assertSet('reportData', []);
    }

    public function test_case_number_in_the_url_is_prefilled_but_never_searched_on_load(): void
    {
        $this->report();
        Livewire::withQueryParams(['caseNumber' => 'bu-0101-0001'])->test(CheckStatus::class)
            ->assertSet('caseNumber', 'BU-0101-0001')->assertSet('reportData', [])->assertSet('showCaptcha', false);
        Http::assertNothingSent();
    }
}
