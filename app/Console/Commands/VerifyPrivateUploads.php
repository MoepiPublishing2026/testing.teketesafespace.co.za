<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Models\User;
use App\Support\AttachmentAccess;
use App\Support\AvatarStore;
use App\Support\LegacyUploadFolders;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Deploy gate for the private-uploads migration. Exits NON-ZERO (so it can stop a deploy or CI job) if:
 *   - a report attachment or profile picture points at a file that is missing or empty on the private disk
 *   - a profile picture is still stored under a legacy (public) path
 *   - files are still sitting in a legacy public folder
 * Read-only: it never changes or deletes anything.
 *
 *   php artisan uploads:verify
 */
class VerifyPrivateUploads extends Command
{
    protected $signature = 'uploads:verify';

    protected $description = 'Check every upload is on the private disk and no public copies remain';

    public function handle(AvatarStore $avatars): int
    {
        $disk     = Storage::disk(config('attachments.disk'));
        $problems = [];
        $checked  = ['attachments' => 0, 'avatars' => 0];

        Report::whereNotNull('image_path')->where('image_path', '!=', '')
            ->chunkById(200, function ($reports) use ($disk, &$problems, &$checked) {
                foreach ($reports as $report) {
                    foreach (AttachmentAccess::paths($report) as $stored) {
                        $checked['attachments']++;
                        $path = ltrim(str_replace('\\', '/', $stored), '/');

                        if ($path === '' || str_contains($path, '..')) {
                            $problems[] = "report {$report->id}: invalid stored path";
                        } elseif (! $disk->exists($path)) {
                            $problems[] = "report {$report->id}: {$path} is not on the private disk";
                        } elseif ($disk->size($path) === 0) {
                            $problems[] = "report {$report->id}: {$path} is empty";
                        }
                    }
                }
            });

        User::whereNotNull('profile_picture')->where('profile_picture', '!=', '')
            ->chunkById(200, function ($users) use ($avatars, &$problems, &$checked) {
                foreach ($users as $user) {
                    $checked['avatars']++;
                    $stored = (string) $user->profile_picture;

                    if (! $avatars->isPrivate($stored)) {
                        $problems[] = "user {$user->id}: profile picture is still on a legacy path";
                        continue;
                    }

                    $absolute = $avatars->locate($stored);

                    if (! $absolute || (int) filesize($absolute) === 0) {
                        $problems[] = "user {$user->id}: profile picture file is missing or empty";
                    }
                }
            });

        $leftovers = [];
        $folders = array_merge($avatars->legacyDirectories(), LegacyUploadFolders::evidence());

        foreach ($folders as $folder) {
            foreach (glob($folder . '/*') ?: [] as $file) {
                if (is_file($file)) {
                    $leftovers[(string) realpath($file)] = $file;
                }
            }
        }

        $this->line("Checked {$checked['attachments']} report attachment(s) and {$checked['avatars']} profile picture(s).");

        foreach ($problems as $problem) {
            $this->error('  ' . $problem);
        }

        foreach (array_slice(array_values($leftovers), 0, 20) as $file) {
            $this->error('  public copy still present: ' . $file);
        }

        if (count($leftovers) > 20) {
            $this->error('  ... and ' . (count($leftovers) - 20) . ' more');
        }

        if ($problems || $leftovers) {
            $this->error(sprintf('FAILED: %d problem(s), %d public file(s) left.', count($problems), count($leftovers)));

            return self::FAILURE;
        }

        $this->info('OK: every upload is on the private disk and no public copies remain.');

        return self::SUCCESS;
    }
}
