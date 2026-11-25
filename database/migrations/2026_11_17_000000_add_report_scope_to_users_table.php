<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const OWNERSHIP_TABLE = 'migration_h8_user_scope_columns';

    private const COLUMNS = ['role', 'school_name', 'district_id', 'province_id'];

    public function up(): void
    {
        // MySQL DDL commits implicitly. Persist ownership before each ALTER so
        // retries and rollback in another process do not depend on PHP state.
        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            Schema::create(self::OWNERSHIP_TABLE, function (Blueprint $table) {
                $table->string('column_name')->primary();
            });
        }

        foreach (self::COLUMNS as $column) {
            if (Schema::hasColumn('users', $column)) {
                continue;
            }

            DB::table(self::OWNERSHIP_TABLE)->insertOrIgnore(['column_name' => $column]);
            Schema::table('users', function (Blueprint $table) use ($column) {
                match ($column) {
                    'role' => $table->string($column)->default('admin'),
                    'school_name' => $table->string($column)->nullable(),
                    default => $table->unsignedBigInteger($column)->nullable(),
                };
            });
        }
    }

    public function down(): void
    {
        // An older application of this migration may have no provenance.
        // Without proof of ownership, retain all columns rather than lose data.
        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            return;
        }

        $owned = DB::table(self::OWNERSHIP_TABLE)->pluck('column_name')->all();
        foreach (self::COLUMNS as $column) {
            if (in_array($column, $owned, true) && Schema::hasColumn('users', $column)) {
                Schema::table('users', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }

        Schema::drop(self::OWNERSHIP_TABLE);
    }
};
