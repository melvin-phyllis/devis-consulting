<button type="button" class="btn btn-danger"
        onclick="document.getElementById('modal-delete-account').classList.add('open')">
    Supprimer mon compte
</button>

{{-- Modal de confirmation --}}
<div class="modal-overlay" id="modal-delete-account">
    <div class="modal-box">
        <h3>Supprimer le compte ?</h3>
        <p>Entrez votre mot de passe pour confirmer. Toutes vos données (clients, devis, factures) seront définitivement supprimées.</p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="form-group" style="margin-bottom:20px;">
                <label for="delete_password" style="font-size:13px;font-weight:500;color:var(--dark-slate);display:block;margin-bottom:6px;">
                    Mot de passe
                </label>
                <input id="delete_password" type="password" name="password"
                       style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:4px;font-family:'Inter',sans-serif;font-size:13px;outline:none;"
                       placeholder="••••••••">
                @if ($errors->userDeletion->get('password'))
                    <p style="font-size:12px;color:#dc2626;margin-top:4px;">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('modal-delete-account').classList.remove('open')">
                    Annuler
                </button>
                <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('modal-delete-account').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
