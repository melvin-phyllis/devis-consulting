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

    /* Sélecteur de template PDF */
    .template-picker {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .template-card {
        position: relative;
        border: 2px solid var(--border);
        border-radius: 8px;
        padding: 14px 10px 12px;
        cursor: pointer;
        transition: border-color 0.15s, box-shadow 0.15s;
        display: block;
    }
    .template-card input[type="radio"] { display: none; }
    .template-card:hover { border-color: var(--purple); }
    .template-card.tpl-selected {
        border-color: var(--purple);
        box-shadow: 0 0 0 3px rgba(83,58,253,0.12);
    }
    .tpl-preview {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 8px 10px;
        margin-bottom: 10px;
        min-height: 110px;
        overflow: hidden;
    }
    .tpl-p-header {
        height: 10px;
        border-radius: 2px;
        margin-bottom: 6px;
        width: 100%;
    }
    .tpl-p-title {
        height: 8px;
        border-radius: 2px;
        width: 50%;
        margin: 0 auto 8px;
    }
    .tpl-p-row {
        padding: 3px 4px;
        margin-bottom: 2px;
        border-radius: 2px;
    }
    .tpl-p-bar {
        height: 5px;
        border-radius: 2px;
    }
    .tpl-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--navy);
        margin-bottom: 4px;
    }
    .tpl-desc {
        font-size: 11px;
        color: var(--slate);
        font-weight: 300;
        line-height: 1.4;
    }
    .tpl-badge {
        display: inline-block;
        font-size: 10px;
        background: rgba(83,58,253,0.08);
        color: var(--purple);
        border-radius: 3px;
        padding: 1px 6px;
        margin-top: 6px;
        font-weight: 500;
    }
    .tpl-selected .tpl-name { color: var(--purple); }

    @media (max-width: 900px) {
        .settings-grid { grid-template-columns: 1fr; }
        .settings-grid-full { grid-column: 1; }
        .template-picker { grid-template-columns: 1fr; }
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

@if($errors->any())
<div class="alert alert-error" style="margin-bottom: 16px;">
    <strong>Erreur(s) lors de l'enregistrement :</strong>
    <ul style="margin: 6px 0 0 18px; padding: 0;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

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

        {{-- Modèle de PDF --}}
        <div class="settings-card settings-grid-full">
            <div class="settings-card-header">
                <div class="settings-card-icon">🎨</div>
                <div>
                    <h2>Modèle de PDF</h2>
                    <p>Choisissez l'apparence de vos devis et factures. Le choix s'applique immédiatement aux prochains téléchargements.</p>
                </div>
            </div>
            <div class="settings-card-body">
                <div class="template-picker">

                    {{-- Classique --}}
                    <label class="template-card {{ ($settings->pdf_template ?? 'classique') === 'classique' ? 'tpl-selected' : '' }}" for="tpl-classique">
                        <input type="radio" name="pdf_template" id="tpl-classique" value="classique"
                               {{ ($settings->pdf_template ?? 'classique') === 'classique' ? 'checked' : '' }}
                               onchange="selectTemplate(this)">
                        <div class="tpl-preview">
                            <div class="tpl-p-header" style="background:#a9a9a9;"></div>
                            <div class="tpl-p-title" style="background:#1a2a5a;"></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#a9a9a9; width:100%;"></div></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#eee; width:80%;"></div></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#eee; width:65%;"></div></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#eee; width:90%;"></div></div>
                            <div style="margin-top:6px;"><div class="tpl-p-bar" style="background:#1a2a5a; width:50%; height:14px; margin-left:auto;"></div></div>
                        </div>
                        <div class="tpl-name">Classique</div>
                        <div class="tpl-desc">En-têtes gris, bordures noires, pied de page bleu. Style sobre et traditionnel.</div>
                        <div class="tpl-badge">Par défaut</div>
                    </label>

                    {{-- Moderne --}}
                    <label class="template-card {{ ($settings->pdf_template ?? '') === 'moderne' ? 'tpl-selected' : '' }}" for="tpl-moderne">
                        <input type="radio" name="pdf_template" id="tpl-moderne" value="moderne"
                               {{ ($settings->pdf_template ?? '') === 'moderne' ? 'checked' : '' }}
                               onchange="selectTemplate(this)">
                        <div class="tpl-preview">
                            <div style="background:#533afd; height:5px; margin:-8px -10px 8px; border-radius:2px 2px 0 0;"></div>
                            <div class="tpl-p-header" style="background:#533afd;"></div>
                            <div class="tpl-p-title" style="background:#533afd; border-radius:2px;"></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#533afd; width:100%;"></div></div>
                            <div class="tpl-p-row" style="background:#f5f3ff;"><div class="tpl-p-bar" style="background:#e0dbff; width:75%;"></div></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#eee; width:60%;"></div></div>
                            <div class="tpl-p-row" style="background:#f5f3ff;"><div class="tpl-p-bar" style="background:#e0dbff; width:85%;"></div></div>
                            <div style="margin-top:6px;"><div class="tpl-p-bar" style="background:#533afd; width:50%; height:14px; margin-left:auto;"></div></div>
                        </div>
                        <div class="tpl-name">Moderne</div>
                        <div class="tpl-desc">Thème violet, bande supérieure colorée, lignes alternées. Dynamique et contemporain.</div>
                    </label>

                    {{-- Élégance --}}
                    <label class="template-card {{ ($settings->pdf_template ?? '') === 'elegance' ? 'tpl-selected' : '' }}" for="tpl-elegance">
                        <input type="radio" name="pdf_template" id="tpl-elegance" value="elegance"
                               {{ ($settings->pdf_template ?? '') === 'elegance' ? 'checked' : '' }}
                               onchange="selectTemplate(this)">
                        <div class="tpl-preview">
                            <div style="background:#061b31; margin:-8px -10px 8px; padding:6px 10px; border-radius:2px 2px 0 0;">
                                <div style="background:rgba(255,255,255,0.2); height:6px; border-radius:1px; width:40%;"></div>
                                <div style="background:rgba(255,255,255,0.1); height:4px; border-radius:1px; width:60%; margin-top:3px;"></div>
                            </div>
                            <div class="tpl-p-title" style="background:#061b31;"></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#061b31; width:100%;"></div></div>
                            <div class="tpl-p-row" style="background:#f8f9fa;"><div class="tpl-p-bar" style="background:#dde; width:75%;"></div></div>
                            <div class="tpl-p-row"><div class="tpl-p-bar" style="background:#eee; width:60%;"></div></div>
                            <div class="tpl-p-row" style="background:#f8f9fa;"><div class="tpl-p-bar" style="background:#dde; width:85%;"></div></div>
                            <div style="margin-top:6px;"><div class="tpl-p-bar" style="background:#061b31; width:50%; height:14px; margin-left:auto;"></div></div>
                        </div>
                        <div class="tpl-name">Élégance</div>
                        <div class="tpl-desc">Bandeau sombre en en-tête, style corporate et premium. Idéal pour les grandes entreprises.</div>
                    </label>

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
                    <img id="preview-logo"
                         src="{{ !empty($settings->logo) ? asset('storage/' . $settings->logo) : '' }}"
                         class="file-preview-img"
                         alt="Logo actuel"
                         style="{{ empty($settings->logo) ? 'display:none;' : '' }}">
                    <label class="file-input-label" for="input-logo" id="label-logo">
                        📎 {{ !empty($settings->logo) ? 'Changer le logo' : 'Choisir un fichier' }}
                    </label>
                    <input type="file" id="input-logo" name="logo" accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp"
                           onchange="previewImage(this, 'preview-logo', 'label-logo', 'info-logo')">
                    <span id="info-logo" style="font-size:11px;color:var(--slate);">PNG ou JPG recommandé — max 4 Mo</span>
                    @error('logo')<span style="font-size:11px;color:#dc2626;font-weight:500;">{{ $message }}</span>@enderror
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
                    <img id="preview-cachet"
                         src="{{ !empty($settings->cachet) ? asset('storage/' . $settings->cachet) : '' }}"
                         class="file-preview-img"
                         alt="Cachet actuel"
                         style="{{ empty($settings->cachet) ? 'display:none;' : '' }}">
                    <label class="file-input-label" for="input-cachet" id="label-cachet">
                        📎 {{ !empty($settings->cachet) ? 'Changer le cachet' : 'Choisir un fichier' }}
                    </label>
                    <input type="file" id="input-cachet" name="cachet" accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp"
                           onchange="previewImage(this, 'preview-cachet', 'label-cachet', 'info-cachet')">
                    <span id="info-cachet" style="font-size:11px;color:var(--slate);">PNG avec fond transparent recommandé — max 4 Mo</span>
                    @error('cachet')<span style="font-size:11px;color:#dc2626;font-weight:500;">{{ $message }}</span>@enderror
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
function previewImage(input, previewId, labelId, infoId) {
    var file = input.files[0];
    if (!file) return;

    var maxMo = 4;
    if (file.size > maxMo * 1024 * 1024) {
        document.getElementById(infoId).textContent = '⚠ Fichier trop lourd (' + (file.size / 1024 / 1024).toFixed(1) + ' Mo). Maximum : ' + maxMo + ' Mo.';
        document.getElementById(infoId).style.color = '#dc2626';
        input.value = '';
        return;
    }

    var allowed = ['image/png','image/jpeg','image/gif','image/svg+xml','image/webp'];
    if (!allowed.includes(file.type)) {
        document.getElementById(infoId).textContent = '⚠ Format non supporté. Utilisez PNG, JPG, GIF, SVG ou WEBP.';
        document.getElementById(infoId).style.color = '#dc2626';
        input.value = '';
        return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var img = document.getElementById(previewId);
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);

    document.getElementById(labelId).textContent = '📎 ' + file.name;
    document.getElementById(infoId).textContent = (file.size / 1024).toFixed(0) + ' Ko — prêt à enregistrer';
    document.getElementById(infoId).style.color = '#15803d';
}

function selectTemplate(radio) {
    document.querySelectorAll('.template-card').forEach(function(c) { c.classList.remove('tpl-selected'); });
    radio.closest('.template-card').classList.add('tpl-selected');
}

function updatePreview() {
    const prefixe = document.getElementById('input-prefixe').value.toUpperCase() || 'YAC';
    const ville   = document.getElementById('input-ville').value.toUpperCase() || 'ABJ';
    const now     = new Date();
    const ym      = now.getFullYear() + String(now.getMonth() + 1).padStart(2, '0');
    document.getElementById('numero-preview').textContent = prefixe + '-DV-' + ville + '-' + ym + '-0001';
}
</script>
@endsection
