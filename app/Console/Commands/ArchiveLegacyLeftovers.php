<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Models\User;
use App\Support\AttachmentAccess;
use App\Support\AvatarStore;
use App\Support\LegacyUploadFolders;
use App\Support\LegacyUploadBackup;
use Illuminate\Console\Command;

/**
 * After the migrations, files nobody points at (old pictures of former users, duplicates, copies
 * from other branches) are still sitting in public folders. This moves them OUT of the web root:
 * each file is copied to --to, checked by SHA-256, and only then removed.
 *
 * It never touches a file that a user or report still references - migrate those first.
 *
 *   php artisan uploads:archive-leftovers --to=C:\secure-backup\leftovers --dry-run
 *   php artisan uploads:archive-leftovers --to=C:\secure-backup\leftovers
 */
class ArchiveLegacyLeftovers extends Command
{
    protected $signature = 'uploads:archive-leftovers
                            {--to= : ABSOLUTE folder outside the web root that receives the files (required)}
                            {--dry-run : List what would be moved without touching anything}';

    protected $description = 'Move unreferenced files out of the legacy public upload folders (copy, verify, then remove)';

    public function handle(AvatarStore $avatars, LegacyUploadBackup $backups): int
    {
        $to  = (string) $this->option('to');
        $dry = (bool) $this->option('dry-run');

        if ($to === '' || ! preg_match('#^([A-Za-z]:[\\\\/]|/)#', $to)) {
            $this->error('--to=ABSOLUTE_FOLDER is required (for example C:\secure-backup\leftovers).');

            return self::FAILURE;
        }

        try {
            $to = $backups->directory($to);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        // Every file name some user or report still points at: those are NOT leftovers.
        $referenced = [];
        $remember   = function ($path) use (&$referenced) {
            $referenced[strtolower(basename(str_replace('\\', '/', (string) $path)))] = true;
        };

        User::whereNotNull('profile_picture')->where('profile_picture', '!=', '')
            ->pluck('profile_picture')->each($remember);

        Report::whereNotNull('image_path')->where('image_path', '!=', '')
            ->chunkById(200, function ($reports) use ($remember) {
                foreach ($reports as $report) {
                    foreach (AttachmentAccess::paths($report) as $path) {
                        $remember($path);
                    }
                }
            });

        $files = [];

        foreach (array_merge($avatars->legacyDirectories(), LegacyUploadFolders::evidence()) as $dir) {
            $root = ! is_link($dir) ? realpath($dir) : false;
            if ($root === false) {
                continue;
            }
            foreach (glob($root . '/*') ?: [] as $file) {
                if (! is_link($file) && is_file($file)) {
                    $files[$file] = true;
                }
            }
        }

        $base  = (string) realpath(base_path());
        $tally = ['archived' => 0, 'still_referenced' => 0, 'failed' => 0];
        $kept  = [];

        $this->info($dry ? 'DRY RUN - nothing will be changed.' : "Archiving leftovers to {$to} ...");

        foreach (array_keys($files) as $file) {
            if (isset($referenced[strtolower(basename($file))])) {
                $tally['still_referenced']++;
                $kept[] = $file;
                continue;
            }

            $relative = ltrim(str_replace('\\', '/', substr($file, strlen($base))), '/');

            if ($dry) {
                $this->line("  would archive {$relative}");
                $tally['archived']++;
                continue;
            }

            $copy = $backups->copy($to, $file);
            if ($copy !== null && $backups->removeOriginal($file, $copy)) {
                $tally['archived']++;
            } else {
                $this->error("  FAILED to copy {$relative} - original kept");
                $tally['failed']++;
            }
        }

        foreach (array_slice($kept, 0, 20) as $file) {
            $this->warn('  kept (still referenced - run the migration for it first): ' . $file);
        }

        if (count($kept) > 20) {
            $this->warn('  ... and ' . (count($kept) - 20) . ' more kept');
        }

        $this->newLine();
        $this->table(['Result', 'Count'], collect($tally)->map(fn ($n, $k) => [$k, $n])->values()->all());

        return $tally['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
