@extends('layouts.sidebar')

@section('title', 'Tableau de bord — devis-consulting')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 20px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover {
        box-shadow: var(--shadow-blue) 0px 12px 24px -12px, var(--shadow-black) 0px 6px 12px -6px;
        transform: translateY(-1px);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: var(--slate);
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 400;
        color: var(--navy);
        letter-spacing: -0.8px;
        line-height: 1;
    }

    .stat-unit {
        font-size: 11px;
        color: var(--slate);
        font-weight: 300;
        margin-top: 4px;
    }

    .stat-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 500;
        padding: 2px 6px;
        border-radius: 3px;
        margin-top: 8px;
    }

    /* Progress */
    .progress-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .progress-label-text {
        font-size: 13px;
        color: var(--dark-slate);
        font-weight: 400;
        white-space: nowrap;
        min-width: 220px;
    }

    .progress-bar-wrap {
        flex: 1;
        background: var(--border);
        border-radius: 3px;
        height: 6px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 6px;
        background: var(--purple);
        border-radius: 3px;
        transition: width 0.8s ease;
    }

    .progress-pct {
        font-size: 13px;
        font-weight: 500;
        color: var(--navy);
        white-space: nowrap;
        min-width: 40px;
        text-align: right;
    }

    /* Overdue table */
    .overdue-card {
        background: #fff;
        border: 1px solid #fecaca;
        border-left: 3px solid #dc2626;
        border-radius: 6px;
        padding: 20px 24px;
        margin-bottom: 24px;
    }

    .overdue-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .overdue-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #b91c1c;
    }

    .pulse-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #dc2626;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }

    /* Quick actions */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .action-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 20px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        gap: 6px;
        transition: box-shadow 0.2s, transform 0.2s, border-color 0.2s;
    }
    .action-card:hover {
        border-color: var(--purple);
        box-shadow: var(--shadow-blue) 0px 8px 20px -8px;
        transform: translateY(-1px);
    }

    .action-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: var(--purple);
    }

    .action-title {
        font-size: 15px;
        font-weight: 400;
        color: var(--navy);
        letter-spacing: -0.15px;
    }

    .action-desc {
        font-size: 12px;
        color: var(--slate);
        font-weight: 300;
        line-height: 1.55;
    }

    .action-arrow {
        font-size: 12px;
        color: var(--purple);
        margin-top: 4px;
    }

    .section-heading {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark-slate);
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 14px;
    }

    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .actions-grid { grid-template-columns: 1fr; }
        .progress-card { flex-direction: column; align-items: flex-start; gap: 10px; }
        .progress-label-text { min-width: unset; }
        .progress-bar-wrap { width: 100%; }
    }
    @media (max-width: 500px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

{{-- Page header --}}
<div class="page-header">
    <div>
        <h1>Tableau de bord</h1>
        <p class="page-header-sub">Bonjour, {{ Auth::user()->name ?? 'Utilisateur' }} — {{ \Carbon\Carbon::now()->isoFormat('dddd D MMMM YYYY') }}</p>
    </div>
    <a href="{{ route('devis.create') }}" class="btn btn-primary">+ Nouveau devis</a>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Devis</div>
        <div class="stat-value">{{ $totalDevis ?? 0 }}</div>
        <div class="stat-unit">ce mois</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Factures</div>
        <div class="stat-value">{{ $totalFactures ?? 0 }}</div>
        <div class="stat-unit">émises</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">CA Prévu</div>
        <div class="stat-value">{{ number_format($CA_Prevu ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-unit">FCFA — total factures</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">CA Encaissé</div>
        <div class="stat-value">{{ number_format($CA_Encaisse ?? 0, 0, ',', ' ') }}</div>
        <div class="stat-unit">FCFA — paiements reçus</div>
        @php $taux = ($CA_Prevu ?? 0) > 0 ? round(($CA_Encaisse / $CA_Prevu) * 100) : 0; @endphp
        <div class="stat-badge" style="background:rgba(21,190,83,0.1);color:#15803d;">{{ $taux }}% encaissé</div>
    </div>
</div>

{{-- Barre de progression devis → factures --}}
<div class="progress-card">
    <div class="progress-label-text">Devis transformés en factures</div>
    <div class="progress-bar-wrap">
        <div class="progress-bar-fill" style="width: {{ $percentTransformed ?? 0 }}%;"></div>
    </div>
    <div class="progress-pct">{{ $percentTransformed ?? 0 }}%</div>
</div>

{{-- Factures en retard --}}
@if(isset($facturesEnRetard) && $facturesEnRetard->count() > 0)
<div class="overdue-card">
    <div class="overdue-header">
        <div class="overdue-title">
            <span class="pulse-dot"></span>
            Factures en retard
            <span class="badge badge-danger">{{ $totalFacturesEnRetard ?? $facturesEnRetard->count() }}</span>
        </div>
        <a href="{{ route('factures.index') }}" class="btn btn-danger btn-sm">Voir tout →</a>
    </div>

    @if(($totalFacturesEnRetard ?? 0) > 10)
        <p style="font-size:12px;color:var(--slate);margin-bottom:12px;">Les 10 factures les plus anciennes — <a href="{{ route('factures.index') }}" style="color:var(--purple);">voir toutes</a></p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Date d'émission</th>
                <th>Retard</th>
                <th>Montant TTC</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturesEnRetard as $facture)
            <tr>
                <td style="font-weight:500;color:var(--navy);">{{ $facture->numero }}</td>
                <td>{{ $facture->client->raison_sociale ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($facture->date_emission)->format('d/m/Y') }}</td>
                <td>
                    @php $jours = \Carbon\Carbon::parse($facture->date_emission)->diffInDays(now()); @endphp
                    <span class="badge {{ $jours > 30 ? 'badge-danger' : 'badge-warning' }}">{{ $jours }}j</span>
                </td>
                <td style="font-weight:500;">{{ number_format($facture->total_ttc, 0, ',', ' ') }} FCFA</td>
                <td><a href="{{ route('devis.show', $facture->id) }}" class="btn btn-success btn-sm">Paiement</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- Accès rapide --}}
<div class="section-heading">Accès rapide</div>
<div class="actions-grid">
    <a href="{{ route('devis.create') }}" class="action-card">
        <div class="action-label">Documents</div>
        <div class="action-title">Créer un devis</div>
        <div class="action-desc">Nouveau devis professionnel en quelques clics, prêt à télécharger en PDF.</div>
        <div class="action-arrow">Créer maintenant →</div>
    </a>
    <a href="{{ route('devis.index') }}" class="action-card">
        <div class="action-label">Documents</div>
        <div class="action-title">Gérer les devis</div>
        <div class="action-desc">Consultez, modifiez et convertissez vos devis existants en factures.</div>
        <div class="action-arrow">Voir les devis →</div>
    </a>
    <a href="{{ route('factures.index') }}" class="action-card">
        <div class="action-label">Paiements</div>
        <div class="action-title">Gérer les factures</div>
        <div class="action-desc">Suivez les statuts de paiement, enregistrez les règlements reçus.</div>
        <div class="action-arrow">Voir les factures →</div>
    </a>
</div>

<div style="border-top:1px solid var(--border);padding-top:20px;text-align:center;font-size:12px;color:var(--slate);">
    © {{ date('Y') }} devis-consulting — Conçu pour les entreprises francophones
</div>

@endsection
