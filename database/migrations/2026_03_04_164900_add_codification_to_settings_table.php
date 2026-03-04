<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('prefixe_entreprise', 10)->default('YAC')->after('devise'); // YAC = YA Consulting
            $table->string('code_ville', 10)->default('ABJ')->after('prefixe_entreprise'); // ABJ = Abidjan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['prefixe_entreprise', 'code_ville']);
        });
    }
};
