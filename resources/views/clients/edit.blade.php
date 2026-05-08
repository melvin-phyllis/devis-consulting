@extends('layouts.sidebar')

@section('title', 'Modifier Client - ' . $client->raison_sociale)

@section('content')
    <div class="page-header">
        <h1>✏️ Modifier : {{ $client->raison_sociale }}</h1>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">← Annuler</a>
    </div>

    @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px;">
        <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="content-card">
        <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Raison sociale *</label>
                <input type="text" name="raison_sociale" value="{{ old('raison_sociale', $client->raison_sociale) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" required>
                </div>
                <div class="form-group">
                    <label>Téléphone *</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $client->telephone) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Adresse *</label>
                <textarea name="adresse" rows="3" required>{{ old('adresse', $client->adresse) }}</textarea>
            </div>

            <div class="form-group">
                <label>RCCM / Compte Contribuable</label>
                <input type="text" name="rccm_cc" value="{{ old('rccm_cc', $client->rccm_cc) }}">
            </div>

            {{-- Logo --}}
            <div class="form-group">
                <label>Logo du client</label>
                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-top:6px;">
                    @if($client->logo)
                        <img id="logo-preview" src="{{ asset('storage/' . $client->logo) }}"
                             style="max-width:100px;max-height:70px;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;">
                    @else
                        <img id="logo-preview" src="" style="display:none;max-width:100px;max-height:70px;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;">
                    @endif
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label for="logo-input" style="display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1px dashed #d1d5db;border-radius:6px;font-size:12px;color:#6b7280;cursor:pointer;font-weight:400;">
                            📎 {{ $client->logo ? 'Changer le logo' : 'Choisir un logo' }}
                        </label>
                        <input type="file" id="logo-input" name="logo" accept="image/png,image/jpeg,image/gif,image/svg+xml,image/webp"
                               style="display:none;" onchange="previewLogo(this)">
                        <span id="logo-info" style="font-size:11px;color:#9ca3af;">PNG ou JPG recommandé — max 4 Mo. Apparaît sur les devis et factures PDF.</span>
                        @error('logo')<span style="font-size:11px;color:#dc2626;">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="btn-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary btn-lg">💾 Enregistrer les modifications</button>
            </div>
        </form>
    </div>

@section('scripts')
<script>
function previewLogo(input) {
    var file = input.files[0];
    if (!file) return;
    if (file.size > 4 * 1024 * 1024) {
        document.getElementById('logo-info').textContent = '⚠ Fichier trop lourd (max 4 Mo).';
        document.getElementById('logo-info').style.color = '#dc2626';
        input.value = ''; return;
    }
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = document.getElementById('logo-preview');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
    document.getElementById('logo-info').textContent = file.name + ' — prêt à enregistrer';
    document.getElementById('logo-info').style.color = '#15803d';
}
</script>
@endsection
@endsection
