<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\AvatarStore;
use App\Support\LegacyUploadBackup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Move referenced legacy profile pictures out of public folders before enabling
 * the authenticated avatar route.
 */
class MigrateLegacyAvatars extends Command
{
    protected $signature = 'avatars:migrate-legacy
                            {--dry-run : List changes without writing or deleting files}
                            {--keep-originals : Leave the public copies after migration}
                            {--backup= : Existing private backup directory (defaults to private application storage)}';

    protected $description = 'Move legacy publicly-served profile pictures to private storage';

    public function handle(AvatarStore $store, LegacyUploadBackup $backups): int
    {
        $dry = (bool) $this->option('dry-run');
        $keep = (bool) $this->option('keep-originals');
        $backup = null;
        if (! $dry && (! $keep || $this->option('backup'))) {
            try {
                $backup = $backups->directory($this->option('backup'));
            } catch (\RuntimeException $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
        }
        $originals = [];
        $tally = ['migrated' => 0, 'already_private' => 0, 'missing' => 0, 'blocked' => 0];

        User::whereNotNull('profile_picture')->where('profile_picture', '!=', '')
            ->chunkById(100, function ($users) use ($store, $dry, $backup, $backups, &$originals, &$tally) {
                foreach ($users as $user) {
                    $current = (string) $user->profile_picture;

                    if ($store->isPrivate($current)) {
                        $tally['already_private']++;

                        continue;
                    }

                    $sources = $store->legacyFiles($current);

                    if (! $sources) {
                        $this->warn("user {$user->id}: file not found on disk ({$current})");
                        $tally['missing']++;

                        continue;
                    }

                    if ($dry) {
                        $this->line("user {$user->id}: would move {$current}");
                        $tally['migrated']++;

                        continue;
                    }

                    $savedCopies = [];
                    if ($backup !== null) {
                        foreach ($sources as $source) {
                            $copy = $backups->copy($backup, $source);
                            if ($copy === null) {
                                $this->error("user {$user->id}: backup could not be verified; originals kept");
                                $tally['blocked']++;
                                continue 2;
                            }
                            $savedCopies[$source] = $copy;
                        }
                    }

                    try {
                        $new = $store->storeFromPath($savedCopies[$sources[0]] ?? $sources[0]);
                    } catch (ValidationException $e) {
                        $this->error("user {$user->id}: blocked {$current} - ".collect($e->errors())->flatten()->first());
                        $tally['blocked']++;

                        continue;
                    } catch (\Throwable $e) {
                        $this->error("user {$user->id}: failed {$current} - ".$e->getMessage());
                        $tally['blocked']++;

                        continue;
                    }

                    if (! $store->locate($new)) {
                        $store->delete($new);
                        $this->error("user {$user->id}: private copy could not be verified; public originals kept");
                        $tally['blocked']++;

                        continue;
                    }

                    $updated = DB::table('users')->where('id', $user->id)
                        ->where('profile_picture', $current)->update(['profile_picture' => $new]);

                    if ($updated !== 1) {
                        $store->delete($new);
                        $this->error("user {$user->id}: database row was not updated; public originals kept");
                        $tally['blocked']++;

                        continue;
                    }

                    $originals += $savedCopies;

                    $tally['migrated']++;
                }
            });

        if (! $keep && $originals !== []) {
            User::whereNotNull('profile_picture')->chunkById(100, function ($users) use ($store, &$originals) {
                foreach ($users as $user) {
                    foreach ($store->legacyFiles($user->profile_picture) as $source) {
                        unset($originals[$source]);
                    }
                }
            });
            foreach ($originals as $source => $copy) {
                if (! $backups->removeOriginal($source, $copy)) {
                    $this->error('A public avatar could not be safely removed; check the verified backups.');
                    $tally['blocked']++;
                }
            }
        }

        $this->table(['Result', 'Count'], collect($tally)->map(fn ($count, $result) => [$result, $count])->values()->all());

        return $tally['blocked'] > 0 || $tally['missing'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
