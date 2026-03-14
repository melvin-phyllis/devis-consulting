@extends('layouts.sidebar')

@section('title', 'Devis - YA Consulting')

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
    .accordion-header .chevron { font-size: 1.2em; color: #4f46e5; transition: transform 0.25s ease; }
    .accordion-header.open .chevron { transform: rotate(180deg); }
    .accordion-content { display: none; padding: 0; }
    .accordion-content.open { display: block; }
    .accordion-content .table-wrap { padding: 0 20px 20px; overflow-x: auto; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>📄 Devis</h1>
        <div class="btn-group">
            <a href="{{ route('factures.index') }}" class="btn btn-primary">🧾 Voir les Factures</a>
            <a href="{{ route('devis.create') }}" class="btn btn-success btn-lg">+ Créer un Devis</a>
        </div>
    </div>

    {{-- Filtre par date (année, mois, jour) --}}
    <div class="filter-bar">
        <form action="{{ route('devis.index') }}" method="GET" class="filter-form" style="display: flex; flex-wrap: wrap; align-items: flex-end; gap: 16px;">
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
                <a href="{{ route('devis.index') }}" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="content-card">
        @if($devisParMois->count() > 0)
            <div class="devis-accordion" id="devis-accordion">
                @php
                    $moisNoms = ['01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre'];
                @endphp
                @foreach($devisParMois as $cleMois => $devisDuMois)
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
                            <span class="month-count">{{ $devisDuMois->count() }} devis</span>
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
                                        @foreach($devisDuMois as $devis_item)
                                            <tr>
                                                <td><strong>{{ $devis_item->numero ?? 'N/A' }}</strong></td>
                                                <td>{{ $devis_item->client->raison_sociale ?? 'Client supprimé' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($devis_item->date_emission)->format('d/m/Y') }}</td>
                                                <td><strong>{{ number_format($devis_item->total_ttc ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                                <td>
                                                    @if($devis_item->statut === 'accepte')
                                                        <span class="badge badge-success">✓ Accepté</span>
                                                    @elseif($devis_item->statut === 'refuse')
                                                        <span class="badge badge-danger">✗ Refusé</span>
                                                    @else
                                                        <span class="badge badge-warning">⏱ En attente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('devis.show', $devis_item->id) }}" class="btn btn-info btn-sm">👁 Voir</a>
                                                        <a href="{{ route('devis.show', $devis_item->id) }}?print=1" target="_blank" class="btn btn-secondary btn-sm" style="background: #6b7280; color: white;">🖨 Impr.</a>
                                                        <a href="{{ route('devis.download', $devis_item->id) }}" class="btn btn-primary btn-sm">📥 PDF</a>
                                                        <a href="{{ route('devis.edit', $devis_item->id) }}" class="btn btn-warning btn-sm">✏️ Éditer</a>
                                                        <form action="{{ route('devis.transformer', $devis_item->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">⚡ Facturer</button>
                                                        </form>
                                                        <form action="{{ route('devis.destroy', $devis_item->id) }}" method="POST" style="display:inline;">
                                                            @csrf @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this.closest('form'), 'Êtes-vous sûr de vouloir supprimer ce devis ? Cette action est irréversible.')">🗑 Suppr.</button>
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
                <div class="empty-state-icon">📄</div>
                <h2>Aucun devis pour le moment</h2>
                <p>Commencez par <a href="{{ route('devis.create') }}">créer un nouveau devis</a></p>
            </div>
        @endif
    </div>

    @if($devisParMois->count() > 0)
    @section('scripts')
    <script>
        (function() {
            var headers = document.querySelectorAll('#devis-accordion .accordion-header');
            headers.forEach(function(header) {
                header.addEventListener('click', function() {
                    var targetId = this.getAttribute('data-target');
                    var content = document.getElementById('content-' + targetId);
                    var isOpen = content.classList.contains('open');

                    document.querySelectorAll('#devis-accordion .accordion-content.open').forEach(function(c) { c.classList.remove('open'); });
                    document.querySelectorAll('#devis-accordion .accordion-header.open').forEach(function(h) { h.classList.remove('open'); h.setAttribute('aria-expanded', 'false'); });

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
