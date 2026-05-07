<x-guest-layout title="Connexion">

    <h2 class="auth-title">Bon retour.</h2>
    <p class="auth-subtitle">Connectez-vous à votre espace de facturation.</p>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="auth-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="auth-label">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="auth-input" placeholder="vous@exemple.com">
        </div>

        <div>
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="auth-input" placeholder="••••••••">
        </div>

        @if (Route::has('password.request'))
            <div style="text-align:right; margin-top:4px;">
                <a href="{{ route('password.request') }}" class="auth-link">Mot de passe oublié ?</a>
            </div>
        @endif

        <button type="submit" class="auth-btn">Se connecter →</button>
    </form>

    <hr class="auth-divider">

    <p style="text-align:center; font-size:13px; color:#64748d; font-weight:300;">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="auth-link" style="font-weight:500;">Créer un compte</a>
    </p>

</x-guest-layout>
