<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->decimal('montant_paye', 15, 2)->default(0)->after('total_ttc');
        });

        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 15, 2);
            $table->date('date_paiement');
            $table->string('mode_paiement')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        // Factures déjà marquées "payé" = considérées comme entièrement payées
        \DB::table('documents')
            ->where('type', 'facture')
            ->where('statut', 'payé')
            ->update(['montant_paye' => \DB::raw('total_ttc')]);
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('montant_paye');
        });
    }
};
