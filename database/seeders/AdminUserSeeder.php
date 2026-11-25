<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    // Set identity, password, role and matching scope variables before seeding.
    /**
     * Create configured admin accounts without changing existing credentials.
     */
    public function run(): void
    {
        $provision = [];

        foreach (config('seed_admins.accounts', []) as $account) {
            $hasAnyConfiguration = collect($account)->contains(fn ($value) => filled($value));
            if (! $hasAnyConfiguration) {
                continue;
            }

            if (empty($account['name']) || empty($account['email']) || empty($account['password']) || empty($account['username'])) {
                throw new \InvalidArgumentException('Configured staff account is missing a required username, name, email, or password.');
            }

            $scope = $this->validatedScope($account);
            if ($scope === null) {
                throw new \InvalidArgumentException("Configured staff account '{$account['username']}' has an invalid or incomplete role/scope.");
            }

            $provision[] = [$account, $scope];
        }

        foreach ($provision as [$account, $scope]) {
            User::unguarded(fn () => User::firstOrCreate(
                ['username' => $account['username']],
                [
                    'name' => $account['name'],
                    'email' => $account['email'],
                    'password' => Hash::make($account['password']),
                    ...$scope,
                ]
            ));
        }
    }

    /** Validate an account's complete report scope before any user row is created. */
    private function validatedScope(array $account): ?array
    {
        $role = $account['role'] ?? null;

        return match ($role) {
            'national' => empty($account['school_name']) && empty($account['district_id']) && empty($account['province_id'])
                ? ['role' => 'national', 'school_name' => null, 'district_id' => null, 'province_id' => null]
                : null,
            'school' => $this->schoolScope($account),
            'district' => $this->districtScope($account),
            'provincial' => $this->provinceScope($account),
            default => null,
        };
    }

    private function schoolScope(array $account): ?array
    {
        $name = trim((string) ($account['school_name'] ?? ''));
        if ($name === '' || ! empty($account['district_id']) || ! empty($account['province_id'])) {
            return null;
        }

        // Match using the database's collation, then retain the canonical name
        // used by report authorization. Names are not stable school identities:
        // never provision when the configured name identifies multiple schools.
        $schools = School::where('school_name', $name)->limit(2)->get();
        if ($schools->count() !== 1) {
            return null;
        }

        return ['role' => 'school', 'school_id' => $schools->first()->school_id, 'school_name' => $schools->first()->school_name, 'district_id' => null, 'province_id' => null];
    }

    private function districtScope(array $account): ?array
    {
        $id = filter_var($account['district_id'] ?? null, FILTER_VALIDATE_INT);
        if (! $id || ! empty($account['school_name']) || ! empty($account['province_id']) || ! District::where('district_id', $id)->exists()) {
            return null;
        }

        return ['role' => 'district', 'school_name' => null, 'district_id' => $id, 'province_id' => null];
    }

    private function provinceScope(array $account): ?array
    {
        $id = filter_var($account['province_id'] ?? null, FILTER_VALIDATE_INT);
        if (! $id || ! empty($account['school_name']) || ! empty($account['district_id']) || ! Province::where('province_id', $id)->exists()) {
            return null;
        }

        return ['role' => 'provincial', 'school_name' => null, 'district_id' => null, 'province_id' => $id];
    }
}
