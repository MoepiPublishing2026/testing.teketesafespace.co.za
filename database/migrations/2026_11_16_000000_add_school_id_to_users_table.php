<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * School names are not unique, so a school admin must be tied to a school by ID.
 * Nullable on purpose: access fails closed until `php artisan schools:backfill-ids` has run.
 */
return new class extends Migration
{
    private const OWNERSHIP_TABLE = 'migration_c5_school_id';

    public function up(): void
    {
        if (Schema::hasColumn('users', 'school_id')) {
            return;
        }

        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            Schema::create(self::OWNERSHIP_TABLE, fn (Blueprint $table) => $table->boolean('owned')->primary());
        }

        // Persist ownership before DDL, which can commit independently on MySQL.
        DB::table(self::OWNERSHIP_TABLE)->insertOrIgnore(['owned' => true]);
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable()->index();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable(self::OWNERSHIP_TABLE)) {
            return;
        }

        if (DB::table(self::OWNERSHIP_TABLE)->where('owned', true)->exists() && Schema::hasColumn('users', 'school_id')) {
            if (Schema::hasIndex('users', ['school_id'])) {
                Schema::table('users', fn (Blueprint $table) => $table->dropIndex(['school_id']));
            }

            Schema::table('users', fn (Blueprint $table) => $table->dropColumn('school_id'));
        }

        Schema::drop(self::OWNERSHIP_TABLE);
    }
};
