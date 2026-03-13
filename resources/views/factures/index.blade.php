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
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($factures as $facture)
                                            <tr>
                                                <td><strong>{{ $facture->numero ?? 'N/A' }}</strong></td>
                                                <td>{{ $facture->client->raison_sociale ?? 'Client supprimé' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') }}</td>
                                                <td><strong>{{ number_format($facture->total_ttc ?? 0, 2, ',', ' ') }} FCFA</strong></td>
                                                <td>
                                                    @if($facture->statut === 'payé')
                                                        <span class="badge badge-success">✓ Payée</span>
                                                    @elseif($facture->statut === 'accepte')
                                                        <span class="badge badge-info">✓ Acceptée</span>
                                                    @elseif($facture->statut === 'refuse')
                                                        <span class="badge badge-danger">✗ Refusée</span>
                                                    @else
                                                        <span class="badge badge-warning">⏱ En attente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('devis.show', $facture->id) }}" class="btn btn-info btn-sm">👁 Voir</a>
                                                        <a href="{{ route('devis.show', $facture->id) }}?print=1" target="_blank" class="btn btn-secondary btn-sm" style="background: #6b7280; color: white;">🖨 Impr.</a>
                                                        <a href="{{ route('factures.download', $facture->id) }}" class="btn btn-primary btn-sm">📥 PDF</a>
                                                        @if($facture->statut !== 'payé')
                                                            <form action="{{ route('facture.payer', $facture->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-sm">💰 Payée</button>
                                                            </form>
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

    @if($facturesParMois->count() > 0)
    @section('scripts')
    <script>
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
