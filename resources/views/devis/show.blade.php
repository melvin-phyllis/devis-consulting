@extends('layouts.sidebar')

@section('title', ($devis->type === 'facture' ? 'Détails Facture' : 'Détails du Devis') . ' - YA Consulting')

@section('styles')
<style>
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
    .info-group { background: #f9fafb; border-radius: 12px; padding: 20px; }
    .info-group h3 { margin-top: 0; color: #1e1b4b; border-bottom: 2px solid #e5e7eb; padding-bottom: 12px; font-size: 1em; margin-bottom: 16px; }
    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding: 4px 0; }
    .info-label { font-weight: 600; color: #6b7280; font-size: 0.88em; }
    .info-value { color: #1f2937; font-size: 0.92em; }

    .totals-section { margin-top: 30px; display: flex; justify-content: flex-end; }
    .totals-box { background: linear-gradient(135deg, #f9fafb, #f3f4f6); padding: 24px; border-radius: 14px; width: 320px; border: 2px solid #e5e7eb; }
    .total-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.92em; color: #374151; }
    .total-row.final { font-size: 1.15em; font-weight: 700; color: #4f46e5; border-top: 2px solid #c7d2fe; padding-top: 12px; margin-top: 12px; }

    @media (max-width: 700px) { .info-grid { grid-template-columns: 1fr; } }

    @media print {
        .sidebar, .mobile-toggle, .btn-group, .page-header .badge { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
        body { background: white; }
        .content-card { box-shadow: none; border: none; padding: 0; margin: 0; }
        .page-header { margin-bottom: 20px; }
        .totals-box { background: transparent; border: none; }
    }
</style>
@endsection

@section('content')
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>{{ $devis->type === 'facture' ? 'Facture' : 'Devis' }} #{{ $devis->numero }}</h1>
            @if($devis->type === 'facture')
                @php $statutPaiement = $devis->statut_paiement; @endphp
                <span class="badge {{ $statutPaiement === 'soldée' ? 'badge-success' : ($statutPaiement === 'partiellement payée' ? 'badge-info' : 'badge-warning') }}" style="margin-top: 8px;">
                    {{ $statutPaiement === 'soldée' ? 'Soldée' : ($statutPaiement === 'partiellement payée' ? 'Partiellement payée' : 'Non payée') }}
                </span>
            @else
                <span class="badge {{ $devis->statut === 'accepte' ? 'badge-success' : ($devis->statut === 'refuse' ? 'badge-danger' : 'badge-warning') }}" style="margin-top: 8px;">
                    {{ ucfirst($devis->statut) }}
                </span>
            @endif
        </div>
        <div class="btn-group">
            <a href="{{ $devis->type === 'facture' ? route('factures.index') : route('devis.index') }}" class="btn btn-secondary">← Retour</a>
            @if($devis->type === 'devis')
                <a href="{{ route('devis.edit', $devis->id) }}" class="btn btn-warning">✏️ Éditer</a>
            @endif
            <a href="{{ route('devis.download', $devis->id) }}" class="btn btn-info">📥 PDF</a>
            <button onclick="window.print()" class="btn btn-primary" style="background: linear-gradient(135deg, #4f46e5, #3730a3);">🖨 Imprimer le Document</button>
            @if($devis->type === 'devis')
                <form action="{{ route('devis.transformer', $devis->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Transformer ce devis en facture ?');">
                    @csrf
                    <button type="submit" class="btn btn-success">⚡ Convertir en Facture</button>
                </form>
            @endif
            @if($devis->type === 'facture' && $devis->reste_a_payer > 0)
                <button type="button" class="btn btn-success" onclick="openPaiementModal({{ $devis->id }}, {{ $devis->reste_a_payer }}, '{{ $devis->numero }}')">💰 Enregistrer un paiement</button>
            @endif
        </div>
    </div>

    <!-- Logo et Informations de l'entreprise -->
    <div class="content-card" style="margin-bottom: 20px;">
        <div style="display: flex; align-items: flex-start;">
            <div style="flex: 1;">
                @if(isset($settings) && $settings->logo)
                    <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo {{ $settings->nom_entreprise ?? 'YA Consulting' }}" style="max-height: 100px; max-width: 200px; margin-bottom: 15px;">
                @endif
                <div style="margin-top: 10px;">
                    <strong style="font-size: 1.1em; color: #1e1b4b;">{{ $settings->nom_entreprise ?? 'YA Consulting' }}</strong><br>
                    <span style="color: #6b7280;">{{ $settings->adresse ?? 'Adresse non définie' }}</span><br>
                    @if(isset($settings->email) && $settings->email)
                        <span style="color: #6b7280;">{{ $settings->email }}</span><br>
                    @endif
                    @if(isset($settings->telephone) && $settings->telephone)
                        <span style="color: #6b7280;">{{ $settings->telephone }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Client & Info -->
    <div class="content-card">
        <div class="info-grid">
            <div class="info-group">
                <h3>👤 Informations Client</h3>
                @if($devis->client->logo)
                    <div style="margin-bottom: 15px;">
                        <img src="{{ asset('storage/' . $devis->client->logo) }}" alt="Logo {{ $devis->client->raison_sociale }}" style="max-height: 80px; border-radius: 8px; border: 1px solid #e5e7eb;">
                    </div>
                @endif
                <div class="info-row"><span class="info-label">Client</span> <span class="info-value">{{ $devis->client->raison_sociale }}</span></div>
                <div class="info-row"><span class="info-label">Email</span> <span class="info-value">{{ $devis->client->email ?? 'N/A' }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span> <span class="info-value">{{ $devis->client->telephone ?? 'N/A' }}</span></div>
                <div class="info-row"><span class="info-label">Adresse</span> <span class="info-value">{{ $devis->client->adresse ?? 'N/A' }}</span></div>
            </div>
            <div class="info-group">
                <h3>📄 Détails du Devis</h3>
                <div class="info-row"><span class="info-label">Date d'émission</span> <span class="info-value">{{ \Carbon\Carbon::parse($devis->date_emission)->format('d/m/Y') }}</span></div>
                <div class="info-row"><span class="info-label">Créé le</span> <span class="info-value">{{ $devis->created_at->format('d/m/Y H:i') }}</span></div>
            </div>
        </div>

        <!-- Lignes du devis -->
        <h3 style="color: #1e1b4b; margin-bottom: 8px;">🛒 Articles / Services</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Désignation</th>
                    <th style="width: 15%; text-align: center;">Quantité</th>
                    <th style="width: 15%; text-align: right;">Prix Unitaire</th>
                    <th style="width: 20%; text-align: right;">Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devis->lignes as $ligne)
                <tr>
                    <td><strong>{{ $ligne->designation }}</strong></td>
                    <td style="text-align: center;">{{ $ligne->quantite }}</td>
                    <td style="text-align: right;">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td style="text-align: right;"><strong>{{ number_format($ligne->quantite * $ligne->prix_unitaire, 0, ',', ' ') }} FCFA</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totaux -->
        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span>Total HT</span>
                    <span>{{ number_format($devis->total_ht, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="total-row">
                    <span>TVA (18%)</span>
                    <span>{{ number_format($devis->total_tva, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="total-row final">
                    <span>Total TTC</span>
                    <span>{{ number_format($devis->total_ttc, 0, ',', ' ') }} FCFA</span>
                </div>
                @if($devis->type === 'facture')
                    @php $paye = (float)($devis->montant_paye ?? 0); $reste = $devis->reste_a_payer; @endphp
                    <div class="total-row" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                        <span>Montant payé</span>
                        <span>{{ number_format($paye, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="total-row">
                        <span>Reste à payer</span>
                        <span style="font-weight: 700; color: {{ $reste > 0 ? '#dc2626' : '#059669' }};">{{ number_format($reste, 0, ',', ' ') }} FCFA</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($devis->type === 'facture')
    <div class="content-card">
        <h3 style="color: #1e1b4b; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; margin-bottom: 16px;">💰 Paiements</h3>
        @if($devis->paiements->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Mode</th>
                        <th>Référence</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devis->paiements as $p)
                    <tr>
                        <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
                        <td><strong>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</strong></td>
                        <td>{{ $p->mode_paiement ?? '—' }}</td>
                        <td>{{ $p->reference ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color: #6b7280; font-style: italic;">Aucun paiement enregistré.</p>
        @endif
    </div>

    {{-- Modal Paiement (facture) --}}
    <div class="modal-overlay" id="modal-paiement" style="display: none;">
        <div class="modal-box" onclick="event.stopPropagation()">
            <h3>💰 Enregistrer un paiement</h3>
            <p id="paiement-modal-numero" style="margin-bottom: 16px; color: #1e1b4b; font-weight: 600;"></p>
            <form action="" method="POST" id="form-paiement">
                @csrf
                <div class="form-group">
                    <label for="paiement_montant">Montant (FCFA) *</label>
                    <input type="number" name="montant" id="paiement_montant" step="0.01" min="0.01" required placeholder="Reste à payer">
                </div>
                <div class="form-group">
                    <label for="paiement_date">Date du paiement *</label>
                    <input type="date" name="date_paiement" id="paiement_date" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="paiement_mode">Mode de paiement</label>
                    <select name="mode_paiement" id="paiement_mode">
                        <option value="">-- Choisir --</option>
                        <option value="Virement">Virement</option>
                        <option value="Espèces">Espèces</option>
                        <option value="Chèque">Chèque</option>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Carte bancaire">Carte bancaire</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="paiement_reference">Référence</label>
                    <input type="text" name="reference" id="paiement_reference" placeholder="Optionnel">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closePaiementModal()">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer le paiement</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('print')) {
            window.print();
        }
    };
    @if($devis->type === 'facture' && $devis->reste_a_payer > 0)
    function openPaiementModal(factureId, reste, numero) {
        var form = document.getElementById('form-paiement');
        form.action = '{{ url("factures") }}' + '/' + factureId + '/paiements';
        document.getElementById('paiement_montant').setAttribute('max', reste);
        document.getElementById('paiement_montant').value = '';
        document.getElementById('paiement-modal-numero').textContent = 'Facture ' + numero + ' — Reste à payer : ' + new Intl.NumberFormat('fr-FR').format(reste) + ' FCFA';
        document.getElementById('modal-paiement').style.display = 'flex';
        document.getElementById('modal-paiement').classList.add('open');
    }
    function closePaiementModal() {
        document.getElementById('modal-paiement').style.display = 'none';
        document.getElementById('modal-paiement').classList.remove('open');
    }
    document.getElementById('modal-paiement').addEventListener('click', function(e) {
        if (e.target === this) closePaiementModal();
    });
    @endif
</script>
@endsection
