@extends('layouts.sidebar')

@section('title', 'Nouveau Client - YA Consulting')

@section('content')
    <div class="page-header">
        <h1>Ajouter un Nouveau Client</h1>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">← Retour à la liste</a>
    </div>

    <div class="content-card">
        <h3 style="color: #1e1b4b; margin-top: 0; margin-bottom: 24px; font-size: 1.1em;">📝 Nouveau Client</h3>
        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Raison sociale *</label>
                <input type="text" name="raison_sociale" value="{{ old('raison_sociale') }}" placeholder="Ex: Entreprise ABC SARL" required>
            </div>

            <div class="form-group">
                <label>Adresse *</label>
                <textarea name="adresse" rows="3" placeholder="Rue, Code Postal, Ville" required>{{ old('adresse') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Téléphone *</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="Ex: +237 6XX XXX XXX" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label>RCCM / Compte Contribuable (Optionnel)</label>
                <input type="text" name="rccm_cc" value="{{ old('rccm_cc') }}" placeholder="Ex: RC/CM/YYYY/XXX">
            </div>

            <div class="form-group">
                <label>Logo du client <span style="font-weight:300;color:#9ca3af;">(optionnel)</span></label>
                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-top:6px;">
                    <img id="logo-preview-create" src="" style="display:none;max-width:100px;max-height:70px;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;">
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="logo-input-create" style="display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1px dashed #d1d5db;border-radius:6px;font-size:12px;color:#6b7280;cursor:pointer;font-weight:400;">
                            📎 Choisir un logo
                        </label>
                        <input type="file" id="logo-input-create" name="logo" accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp"
                               style="display:none;" onchange="previewLogoCreate(this)">
                        <span id="logo-info-create" style="font-size:11px;color:#9ca3af;">PNG ou JPG recommandé — max 4 Mo. Apparaît sur les PDF.</span>
                    </div>
                </div>
            </div>

            <div class="btn-group" style="margin-top: 28px;">
                <button type="submit" class="btn btn-success btn-lg">✓ Enregistrer le Client</button>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Liste des clients existants -->
    <div class="content-card">
        <h3 style="color: #1e1b4b; margin-top: 0; font-size: 1.1em;">📋 Clients Existants</h3>
        @if($clients->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Raison sociale</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td><strong>{{ $client->raison_sociale }}</strong></td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($client->adresse, 40) }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">✏️ Éditer</a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this.closest('form'), 'Supprimer ce client ?')">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>Aucun client pour le moment.</p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
function previewLogoCreate(input) {
    var file = input.files[0];
    if (!file) return;
    if (file.size > 4 * 1024 * 1024) {
        document.getElementById('logo-info-create').textContent = '⚠ Fichier trop lourd (max 4 Mo).';
        document.getElementById('logo-info-create').style.color = '#dc2626';
        input.value = ''; return;
    }
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = document.getElementById('logo-preview-create');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
    document.getElementById('logo-info-create').textContent = file.name + ' — prêt à enregistrer';
    document.getElementById('logo-info-create').style.color = '#15803d';
}
</script>
@endsection
