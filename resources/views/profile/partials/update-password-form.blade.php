<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    @if ($errors->updatePassword->any())
        <div class="alert alert-error" style="margin-bottom:16px;">
            <ul style="list-style:disc;padding-left:16px;">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="current_password">Mot de passe actuel</label>
        <input id="current_password" type="password" name="current_password"
               autocomplete="current-password" placeholder="••••••••">
    </div>

    <div class="form-group">
        <label for="new_password">Nouveau mot de passe</label>
        <input id="new_password" type="password" name="password"
               autocomplete="new-password" placeholder="••••••••">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               autocomplete="new-password" placeholder="••••••••">
    </div>

    <div class="save-row">
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        @if (session('status') === 'password-updated')
            <span class="save-confirm">✓ Mot de passe mis à jour</span>
        @endif
    </div>
</form>
