@extends('layouts.sidebar')

@section('title', 'Factures - YA Consulting')

@section('styles')
<style>
    .filter-bar {
        background: white; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;
        display: flex; flex-wrap: wrap; align-items: flex-end; gap: 16px;
    }
    .filter-bar .form-group { margin-bottom: 0; min-width: 120px; }
    .filter-bar .form-group label { font-size: 0.8em; color: #6b7280; margin-bottom: 4px; }
    .filter-bar select { padding: 10px 12px; font-size: 0.9em; }
    .filter-bar .btn-filter { margin-right: 8px; }
    .accordion-month { margin-bottom: 12px; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06); background: #fff; border: 1px solid #e5e7eb; }
    .accordion-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; cursor: pointer; user-select: none;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        transition: background 0.2s ease;
    }
    .accordion-header:hover { background: linear-gradient(135deg, #f1f5f9, #e2e8f0); }
    .accordion-header.open { background: linear-gradient(135deg, #eef2ff, #e0e7ff); border-bottom: 1px solid #c7d2fe; }
    .accordion-header .month-title { font-weight: 700; font-size: 1.05em; color: #1e1b4b; }
    .accordion-header .month-count { font-size: 0.85em; color: #6b7280; margin-left: 10px; }
    .accordion-header .chevron {
        font-size: 1.2em; color: #4f46e5; transition: transform 0.25s ease;
    }
    .accordion-header.open .chevron { transform: rotate(180deg); }
    .accordion-content { display: none; padding: 0; }
    .accordion-content.open { display: block; }
    .accordion-content .table-wrap { padding: 0 20px 20px; overflow-x: auto; }
    .payment-progress { font-size: 0.85em; color: #6b7280; }
    .payment-progress.soldée { color: #059669; font-weight: 600; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>🧾 Factures</h1>
        <div class="btn-group">
            <a href="{{ route('factures.export') }}" class="btn btn-success">📊 Exporter CSV</a>
            <a href="{{ route('devis.index') }}" class="btn btn-secondary">← Revenir aux Devis</a>
        </div>
    </div>

    {{-- Filtre par date (année, mois, jour) --}}
    <div class="filter-bar">
        <form action="{{ route('factures.index') }}" method="GET" class="filter-form" style="display: flex; flex-wrap: wrap; align-items: flex-end; gap: 16px;">
            <div class="form-group">
                <label for="annee">Année</label>
                <select name="annee" id="annee" class="filter-select">
                    <option value="">Toutes</option>
                    @foreach($anneesDisponibles ?? [] as $a)
                        <option value="{{ $a }}" {{ (request('annee', $filterAnnee ?? '') == $a) ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="mois">Mois</label>
                <select name="mois" id="mois" class="filter-select">
                    <option value="">Tous</option>
                    @php
                        $moisLabels = ['01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre'];
                    @endphp
                    @foreach($moisLabels as $num => $label)
                        <option value="{{ $num }}" {{ (request('mois', $filterMois ?? '') == $num) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jour">Jour</label>
                <select name="jour" id="jour" class="filter-select">
                    <option value="">Tous</option>
                    @for($d = 1; $d <= 31; $d++)
                        <option value="{{ str_pad((string)$d, 2, '0', STR_PAD_LEFT) }}" {{ (request('jour', $filterJour ?? '') == str_pad((string)$d, 2, '0', STR_PAD_LEFT)) ? 'selected' : '' }}>{{ $d }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-filter">🔍 Filtrer</button>
                <a href="{{ route('factures.index') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="content-card">
        @if($facturesParMois->count() > 0)
            <div class="factures-accordion" id="factures-accordion">
                @php
                    $moisNoms = ['01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre'];
                @endphp
                @foreach($facturesParMois as $cleMois => $factures)
                    @php
                        $parts = explode('-', $cleMois);
                        $annee = $parts[0] ?? '';
                        $moisNum = $parts[1] ?? '';
                        $labelMois = ($moisNoms[$moisNum] ?? $cleMois) . ' ' . $annee;
                        $isOpen = ($cleMois === $moisCourant);
                    @endphp
                    <div class="accordion-month" data-month="{{ $cleMois }}">
                        <div class="accordion-header {{ $isOpen ? 'open' : '' }}" data-target="{{ $cleMois }}" role="button" tabindex="0" aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                            <span class="month-title">📅 {{ $labelMois }}</span>
                            <span class="month-count">{{ $factures->count() }} facture(s)</span>
                            <span class="chevron">▼</span>
                        </div>
                        <div class="accordion-content {{ $isOpen ? 'open' : '' }}" id="content-{{ $cleMois }}">
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Numéro</th>
                                            <th>Client</th>
                                            <th>Date d'émission</th>
                                            <th>Montant TTC</th>
                                            <th>Payé / Total</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($factures as $facture)
                                            @php
                                                $paye = (float) ($facture->montant_paye ?? 0);
                                                $ttc = (float) $facture->total_ttc;
                                                $reste = $facture->reste_a_payer;
                                                $statutPaiement = $facture->statut_paiement;
                                            @endphp
                                            <tr>
                                                <td><strong>{{ $facture->numero ?? 'N/A' }}</strong></td>
                                                <td>{{ $facture->client->raison_sociale ?? 'Client supprimé' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') }}</td>
                                                <td><strong>{{ number_format($ttc, 0, ',', ' ') }} FCFA</strong></td>
                                                <td class="payment-progress {{ $statutPaiement === 'soldée' ? 'soldée' : '' }}">
                                                    {{ number_format($paye, 0, ',', ' ') }} / {{ number_format($ttc, 0, ',', ' ') }} FCFA
                                                </td>
                                                <td>
                                                    @if($statutPaiement === 'soldée')
                                                        <span class="badge badge-success">✓ Soldée</span>
                                                    @elseif($statutPaiement === 'partiellement payée')
                                                        <span class="badge badge-info">📊 Partielle</span>
                                                    @else
                                                        <span class="badge badge-warning">⏱ Non payée</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('devis.show', $facture->id) }}" class="btn btn-info btn-sm">👁 Voir</a>
                                                        <a href="{{ route('devis.show', $facture->id) }}?print=1" target="_blank" class="btn btn-secondary btn-sm" style="background: #6b7280; color: white;">🖨 Impr.</a>
                                                        <a href="{{ route('factures.download', $facture->id) }}" class="btn btn-primary btn-sm">📥 PDF</a>
                                                        @if($reste > 0)
                                                            <button type="button" class="btn btn-success btn-sm" onclick="openPaiementModal({{ $facture->id }}, {{ $reste }}, '{{ $facture->numero }}')">💰 Paiement</button>
                                                        @endif
                                                        <form action="{{ route('devis.destroy', $facture->id) }}" method="POST" style="display:inline;" id="delete-facture-{{ $facture->id }}">
                                                            @csrf @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this.closest('form'), 'Supprimer cette facture ? Cette action est irréversible.')">🗑 Suppr.</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🧾</div>
                <h2>Aucune facture pour le moment</h2>
                <p>Les factures générées à partir des devis apparaîtront ici.</p>
                <br>
                <a href="{{ route('devis.index') }}" class="btn btn-primary">📄 Voir les Devis</a>
            </div>
        @endif
    </div>

    {{-- Modal Enregistrer un paiement --}}
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
                    <label for="paiement_reference">Référence (n° chèque, virement…)</label>
                    <input type="text" name="reference" id="paiement_reference" placeholder="Optionnel">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closePaiementModal()">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer le paiement</button>
                </div>
            </form>
        </div>
    </div>

    @if($facturesParMois->count() > 0)
    @section('scripts')
    <script>
        function openPaiementModal(factureId, reste, numero) {
            var form = document.getElementById('form-paiement');
            var baseUrl = '{{ url("factures") }}';
            form.action = baseUrl + '/' + factureId + '/paiements';
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
        (function() {
            var headers = document.querySelectorAll('.accordion-header');
            headers.forEach(function(header) {
                header.addEventListener('click', function() {
                    var targetId = this.getAttribute('data-target');
                    var content = document.getElementById('content-' + targetId);
                    var isOpen = content.classList.contains('open');

                    // Fermer tous les autres mois
                    document.querySelectorAll('.accordion-content.open').forEach(function(c) { c.classList.remove('open'); });
                    document.querySelectorAll('.accordion-header.open').forEach(function(h) { h.classList.remove('open'); h.setAttribute('aria-expanded', 'false'); });

                    if (!isOpen) {
                        content.classList.add('open');
                        this.classList.add('open');
                        this.setAttribute('aria-expanded', 'true');
                    }
                });
                header.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
                });
            });
        })();
    </script>
    @endsection
    @endif
@endsection
