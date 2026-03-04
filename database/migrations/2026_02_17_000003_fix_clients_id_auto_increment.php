<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ces corrections sont pour les imports cPanel où AUTO_INCREMENT peut être perdu.
        // Sur une base fraîche, les PK existent déjà, donc on ignore les erreurs.

        // 1. Fix 'migrations' table
        try {
            DB::statement('ALTER TABLE migrations MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT');
        } catch (\Exception $e) {
            // Ignore si déjà correct
        }

        // 2. Fix 'users' table
        try {
            DB::statement('ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        } catch (\Exception $e) {
            // Ignore si déjà correct
        }

        // 3. Fix 'clients' table
        try {
            DB::statement('ALTER TABLE clients MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        } catch (\Exception $e) {
            // Ignore si déjà correct
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert is risky as we don't know the exact previous state,
        // but typically we wouldn't want to remove auto-increment.
    }
};
