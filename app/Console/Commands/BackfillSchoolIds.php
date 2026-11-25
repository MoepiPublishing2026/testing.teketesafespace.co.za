<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Models\School;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * One-off, run right after the users.school_id migration: link school admins and legacy reports
 * to a school BY ID. A name that matches exactly one school is linked automatically; a name shared
 * by several schools is narrowed by district, then province, and anything still ambiguous is
 * listed for a person to resolve. Nothing is guessed.
 *
 *   php artisan schools:backfill-ids --dry-run
 *   php artisan schools:backfill-ids
 */
class BackfillSchoolIds extends Command
{
    protected $signature = 'schools:backfill-ids {--dry-run : Show what would change without writing}';

    protected $description = 'Link school admins and reports to schools by id (school names are not unique)';

    public function handle(): int
    {
        $dry   = (bool) $this->option('dry-run');
        $tally = ['users_linked' => 0, 'users_ambiguous' => 0, 'users_unmatched' => 0,
                  'reports_linked' => 0, 'reports_ambiguous' => 0, 'reports_unmatched' => 0];

        $this->info($dry ? 'DRY RUN - nothing will be changed.' : 'Linking schools by id...');

        User::where('role', 'school')->whereNull('school_id')
            ->chunkById(200, function ($users) use (&$tally, $dry) {
                foreach ($users as $user) {
                    [$status, $schoolId] = $this->resolve((string) $user->school_name, $user->district_id ?? null, $user->province_id ?? null);

                    if ($status === 'linked') {
                        if (! $dry) {
                            DB::table('users')->where('id', $user->id)->update(['school_id' => $schoolId]);
                        }
                        $tally['users_linked']++;
                    } else {
                        $tally["users_{$status}"]++;
                        $this->warn("  user {$user->id} ('{$user->school_name}'): {$status} - set users.school_id by hand");
                    }
                }
            });

        Report::whereNull('school_id')->whereNotNull('school_name')
            ->chunkById(200, function ($reports) use (&$tally, $dry) {
                foreach ($reports as $report) {
                    [$status, $schoolId] = $this->resolve((string) $report->school_name, $report->district_id ?? null, $report->province_id ?? null);

                    if ($status === 'linked') {
                        if (! $dry) {
                            DB::table('reports')->where('id', $report->id)->update(['school_id' => $schoolId]);
                        }
                        $tally['reports_linked']++;
                    } else {
                        $tally["reports_{$status}"]++;
                        $this->warn("  report {$report->id} ('{$report->school_name}'): {$status} - set reports.school_id by hand");
                    }
                }
            });

        $this->newLine();
        $this->table(array_keys($tally), [array_values($tally)]);
        $this->line('School admins without a school_id cannot open any report until they are linked.');

        return self::SUCCESS;
    }

    /** @return array{0: string, 1: int|null} [linked|ambiguous|unmatched, school_id] */
    private function resolve(string $name, $districtId, $provinceId): array
    {
        $name = trim($name);

        if ($name === '') {
            return ['unmatched', null];
        }

        $matches = School::whereRaw('LOWER(TRIM(school_name)) = ?', [mb_strtolower($name)])
            ->get(['school_id', 'district_id', 'province_id']);

        if (filled($districtId)) {
            $matches = $matches->where('district_id', $districtId);
        }

        if (filled($provinceId)) {
            $matches = $matches->where('province_id', $provinceId);
        }

        if ($matches->count() === 1) {
            return ['linked', (int) $matches->first()->school_id];
        }

        return [$matches->isEmpty() ? 'unmatched' : 'ambiguous', null];
    }
}
