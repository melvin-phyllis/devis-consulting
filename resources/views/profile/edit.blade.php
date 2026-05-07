@extends('layouts.sidebar')

@section('title', 'Mon profil — devis-consulting')

@section('styles')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }
    .profile-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
    }
    .profile-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
    }
    .profile-card-header h2 {
        font-size: 15px;
        font-weight: 500;
        color: var(--navy);
        letter-spacing: -0.1px;
    }
    .profile-card-header p {
        font-size: 12px;
        color: var(--slate);
        font-weight: 300;
        margin-top: 3px;
        line-height: 1.5;
    }
    .profile-card-body { padding: 24px; }
    .profile-card-body .form-group { margin-bottom: 16px; }
    .profile-card-body .form-group:last-of-type { margin-bottom: 20px; }

    .delete-zone {
        grid-column: 1 / -1;
        background: #fff;
        border: 1px solid #fecaca;
        border-left: 3px solid #dc2626;
        border-radius: 6px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .delete-zone-text h2 {
        font-size: 14px;
        font-weight: 500;
        color: #b91c1c;
        margin-bottom: 4px;
    }
    .delete-zone-text p {
        font-size: 12px;
        color: var(--slate);
        font-weight: 300;
        line-height: 1.55;
        max-width: 520px;
    }
    .save-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .save-confirm {
        font-size: 12px;
        color: #15803d;
        font-weight: 400;
    }
    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
        .delete-zone { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1>Mon profil</h1>
        <p class="page-header-sub">Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>
</div>

<div class="profile-grid">

    {{-- Informations du profil --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <h2>Informations du compte</h2>
            <p>Mettez à jour votre nom et votre adresse email.</p>
        </div>
        <div class="profile-card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Mot de passe --}}
    <div class="profile-card">
        <div class="profile-card-header">
            <h2>Mot de passe</h2>
            <p>Utilisez un mot de passe long et aléatoire pour sécuriser votre compte.</p>
        </div>
        <div class="profile-card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Zone de suppression --}}
    <div class="delete-zone">
        <div class="delete-zone-text">
            <h2>Supprimer le compte</h2>
            <p>Une fois supprimé, toutes vos données (clients, devis, factures) seront définitivement effacées. Cette action est irréversible.</p>
        </div>
        @include('profile.partials.delete-user-form')
    </div>

</div>

@endsection
