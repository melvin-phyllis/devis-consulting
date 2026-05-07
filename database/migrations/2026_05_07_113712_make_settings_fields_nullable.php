<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('adresse')->nullable()->change();
            $table->string('telephone')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('site_web')->nullable()->change();
            $table->string('rccm_cc')->nullable()->change();
            $table->decimal('tva_defaut', 5, 2)->nullable()->change();
            $table->string('devise')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('adresse')->nullable(false)->change();
            $table->string('telephone')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('site_web')->nullable(false)->change();
            $table->string('rccm_cc')->nullable(false)->change();
            $table->decimal('tva_defaut', 5, 2)->nullable(false)->change();
            $table->string('devise')->nullable(false)->change();
        });
    }
};
