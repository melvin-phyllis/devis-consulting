<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom:16px;">
            <ul style="list-style:disc;padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label for="name">Nom complet</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
               required autofocus autocomplete="name" placeholder="Jean Dupont">
    </div>

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}"
               required autocomplete="username" placeholder="vous@exemple.com">

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p style="font-size:12px;color:#b45309;margin-top:6px;">
                Email non vérifié.
                <button form="send-verification" style="background:none;border:none;color:var(--purple);cursor:pointer;font-size:12px;padding:0;text-decoration:underline;">
                    Renvoyer le lien de vérification
                </button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p style="font-size:12px;color:#15803d;margin-top:4px;">Lien de vérification envoyé.</p>
            @endif
        @endif
    </div>

    <div class="save-row">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        @if (session('status') === 'profile-updated')
            <span class="save-confirm">✓ Modifications enregistrées</span>
        @endif
    </div>
</form>

<form id="send-verification" method="POST" action="{{ route('verification.send') }}" style="display:none;">
    @csrf
</form>
