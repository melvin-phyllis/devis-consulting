@extends('layouts.sidebar')

@section('title', 'Paramètres — devis-consulting')

@section('styles')
<style>
    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }
    .settings-grid-full {
        grid-column: 1 / -1;
    }
    .settings-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 6px;
        overflow: hidden;
    }
    .settings-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .settings-card-icon {
        width: 32px; height: 32px;
        background: rgba(83,58,253,0.08);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .settings-card-header h2 {
        font-size: 14px;
        font-weight: 500;
        color: var(--navy);
        margin-bottom: 2px;
    }
    .settings-card-header p {
        font-size: 12px;
        color: var(--slate);
        font-weight: 300;
        line-height: 1.5;
    }
    .settings-card-body {
        padding: 20px 22px;
    }
    .settings-card-body .form-group { margin-bottom: 14px; }
    .settings-card-body .form-group:last-child { margin-bottom: 0; }

    /* Preview pied de page PDF */
    .footer-preview {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 10px 14px;
        margin-top: 14px;
        font-size: 11px;
        color: #00acee;
        text-align: center;
        line-height: 1.6;
        border-top: 2px solid #00acee;
    }
    .footer-preview-label {
        font-size: 11px;
        color: var(--slate);
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
    }

    /* Preview numérotation */
    .numero-preview {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 10px 14px;
        margin-top: 14px;
        font-family: monospace;
        font-size: 13px;
        font-weight: 600;
        color: var(--purple);
        letter-spacing: 0.5px;
        text-align: center;
    }

    /* File input */
    .file-wrap { display: flex; flex-direction: column; gap: 8px; }
    .file-preview-img {
        max-width: 100px;
        max-height: 80px;
        width: auto; height: auto;
        border: 1px solid var(--border);
        border-radius: 4px;
        object-fit: contain;
    }
    .file-input-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 1px dashed var(--border);
        border-radius: 4px;
        font-size: 12px;
        color: var(--slate);
        cursor: pointer;
        transition: border-color 0.15s, color 0.15s;
    }
    .file-input-label:hover { border-color: var(--purple); color: var(--purple); }
    input[type="file"] { display: none; }

    @media (max-width: 900px) {
        .settings-grid { grid-template-columns: 1fr; }
        .settings-grid-full { grid-column: 1; }
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1>Paramètres</h1>
        <p class="page-header-sub">Configurez les informations de votre entreprise — elles s'appliquent à tous vos PDF.</p>
    </div>
</div>

<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="settings-grid">

        {{-- Identité de l'entreprise --}}
        <div class="settings-card settings-grid-full">
            <div class="settings-card-header">
                <div class="settings-card-icon">🏢</div>
                <div>
                    <h2>Identité de l'entreprise</h2>
                    <p>Nom, adresse et contacts — affichés en en-tête de chaque devis et facture PDF.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nom de l'entreprise</label>
                        <input type="text" name="nom_entreprise" value="{{ $settings->nom_entreprise ?? '' }}" required placeholder="Ex : Mon Entreprise SARL">
                    </div>
                    <div class="form-group">
                        <label>Adresse / Siège social</label>
                        <input type="text" name="adresse" value="{{ $settings->adresse ?? '' }}" placeholder="Ex : Riviera Palmeraie, Cocody, Abidjan, Côte d'Ivoire">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>RCCM <span style="font-weight:300;color:var(--slate);">(optionnel)</span></label>
                        <input type="text" name="rccm_cc" value="{{ $settings->rccm_cc ?? '' }}" placeholder="Ex : N CI-ABJ-2020-B-13747">
                    </div>
                    <div class="form-group">
                        <label>NCC <span style="font-weight:300;color:var(--slate);">(Numéro Compte Contribuable — optionnel)</span></label>
                        <input type="text" name="ncc" value="{{ $settings->ncc ?? '' }}" placeholder="Ex : 2046187R">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Téléphone principal</label>
                        <input type="tel" name="telephone" value="{{ $settings->telephone ?? '' }}" placeholder="+225 01 52 22 63 12">
                    </div>
                    <div class="form-group">
                        <label>Téléphone secondaire <span style="font-weight:300;color:var(--slate);">(optionnel)</span></label>
                        <input type="tel" name="telephone2" value="{{ $settings->telephone2 ?? '' }}" placeholder="+225 05 65 24 69 74">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $settings->email ?? '' }}" placeholder="contact@monentreprise.com">
                    </div>
                    <div class="form-group">
                        <label>Site web <span style="font-weight:300;color:var(--slate);">(optionnel)</span></label>
                        <input type="text" name="site_web" value="{{ $settings->site_web ?? '' }}" placeholder="www.monentreprise.com">
                    </div>
                </div>
            </div>
        </div>

        {{-- Pied de page PDF --}}
        <div class="settings-card settings-grid-full">
            <div class="settings-card-header">
                <div class="settings-card-icon">📄</div>
                <div>
                    <h2>Pied de page des PDF</h2>
                    <p>Ce bloc apparaît en bas de chaque devis et facture. Il est généré automatiquement depuis vos informations ci-dessus.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <span class="footer-preview-label">Aperçu du pied de page :</span>
                <div class="footer-preview">
                    @php
                        $line1 = $settings->nom_entreprise ?? 'NOM ENTREPRISE';
                        if (!empty($settings->rccm_cc)) $line1 .= '-RCCM: ' . $settings->rccm_cc;
                        if (!empty($settings->ncc)) $line1 .= ', NCC: ' . $settings->ncc;
                        if (!empty($settings->adresse)) $line1 .= ', Siège social: ' . $settings->adresse;
                        $parts2 = [];
                        if (!empty($settings->telephone)) $parts2[] = 'Tél: ' . $settings->telephone;
                        if (!empty($settings->telephone2)) $parts2[] = $settings->telephone2;
                        if (!empty($settings->email)) $parts2[] = 'Email: ' . $settings->email;
                        if (!empty($settings->site_web)) $parts2[] = $settings->site_web;
                        $line2 = implode(', ', $parts2);
                    @endphp
                    {{ $line1 }}<br>{{ $line2 }}
                </div>
                <p style="font-size:11px;color:var(--slate);margin-top:8px;">Pour modifier ce pied de page, mettez à jour les champs ci-dessus (Identité de l'entreprise).</p>
            </div>
        </div>

        {{-- Numérotation des documents --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">🔢</div>
                <div>
                    <h2>Numérotation des documents</h2>
                    <p>Préfixe et code ville utilisés dans les numéros de devis et factures générés automatiquement.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Préfixe entreprise</label>
                        <input type="text" name="prefixe_entreprise"
                               value="{{ $settings->prefixe_entreprise ?? 'YAC' }}"
                               maxlength="10" required placeholder="YAC"
                               id="input-prefixe" oninput="updatePreview()">
                    </div>
                    <div class="form-group">
                        <label>Code ville</label>
                        <input type="text" name="code_ville"
                               value="{{ $settings->code_ville ?? 'ABJ' }}"
                               maxlength="10" required placeholder="ABJ"
                               id="input-ville" oninput="updatePreview()">
                    </div>
                </div>
                <span class="footer-preview-label" style="margin-top:6px;">Aperçu du numéro généré :</span>
                <div class="numero-preview" id="numero-preview">
                    {{ $settings->prefixe_entreprise ?? 'YAC' }}-DV-{{ $settings->code_ville ?? 'ABJ' }}-{{ date('Ym') }}-0001
                </div>
                <p style="font-size:11px;color:var(--slate);margin-top:8px;">
                    Format : <code style="background:var(--surface);padding:1px 5px;border-radius:3px;font-size:11px;">PRÉFIXE-TYPE-VILLE-AAAAMM-SÉQUENCE</code>
                    — La séquence se réinitialise chaque mois.
                </p>
            </div>
        </div>

        {{-- Facturation --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">💰</div>
                <div>
                    <h2>Facturation</h2>
                    <p>TVA et devise appliquées par défaut à la création d'un nouveau devis.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="form-group">
                    <label>Taux TVA par défaut (%)</label>
                    <input type="number" name="tva_defaut"
                           value="{{ $settings->tva_defaut ?? 18.00 }}"
                           step="0.01" min="0" max="100" required placeholder="18">
                </div>
                <div class="form-group">
                    <label>Devise</label>
                    <input type="text" name="devise"
                           value="{{ $settings->devise ?? 'FCFA' }}"
                           required placeholder="FCFA">
                </div>
            </div>
        </div>

        {{-- Logo --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">🖼️</div>
                <div>
                    <h2>Logo</h2>
                    <p>Apparaît en haut à gauche de chaque PDF.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="file-wrap">
                    @if(!empty($settings->logo))
                        <img src="{{ asset('storage/' . $settings->logo) }}" class="file-preview-img" alt="Logo actuel">
                    @endif
                    <label class="file-input-label" for="input-logo">
                        📎 {{ !empty($settings->logo) ? 'Changer le logo' : 'Choisir un fichier' }}
                    </label>
                    <input type="file" id="input-logo" name="logo" accept="image/*">
                    <span style="font-size:11px;color:var(--slate);">PNG ou JPG recommandé — max 2 Mo</span>
                </div>
            </div>
        </div>

        {{-- Cachet --}}
        <div class="settings-card">
            <div class="settings-card-header">
                <div class="settings-card-icon">🔏</div>
                <div>
                    <h2>Cachet / Tampon</h2>
                    <p>Apparaît en bas à gauche des PDF (zone signature).</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="file-wrap">
                    @if(!empty($settings->cachet))
                        <img src="{{ asset('storage/' . $settings->cachet) }}" class="file-preview-img" alt="Cachet actuel">
                    @endif
                    <label class="file-input-label" for="input-cachet">
                        📎 {{ !empty($settings->cachet) ? 'Changer le cachet' : 'Choisir un fichier' }}
                    </label>
                    <input type="file" id="input-cachet" name="cachet" accept="image/*">
                    <span style="font-size:11px;color:var(--slate);">PNG avec fond transparent recommandé</span>
                </div>
            </div>
        </div>

    </div>

    <div style="margin-top:20px;display:flex;align-items:center;gap:12px;">
        <button type="submit" class="btn btn-primary btn-lg">Enregistrer les modifications</button>
        @if(session('success'))
            <span style="font-size:13px;color:#15803d;font-weight:400;">✓ {{ session('success') }}</span>
        @endif
    </div>

</form>

@endsection

@section('scripts')
<script>
function updatePreview() {
    const prefixe = document.getElementById('input-prefixe').value.toUpperCase() || 'YAC';
    const ville   = document.getElementById('input-ville').value.toUpperCase() || 'ABJ';
    const now     = new Date();
    const ym      = now.getFullYear() + String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('numero-preview').textContent = prefixe + '-DV-' + ville + '-' + ym + '-0001';
}
</script>
@endsection
