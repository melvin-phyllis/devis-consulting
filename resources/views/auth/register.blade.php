<x-guest-layout title="Inscription">

    <h2 class="auth-title">Créer un compte.</h2>
    <p class="auth-subtitle">Votre espace de facturation en moins de 2 minutes.</p>

    @if ($errors->any())
        <div class="auth-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="auth-label">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   required autofocus autocomplete="name"
                   class="auth-input" placeholder="Jean Dupont">
        </div>

        <div>
            <label for="email" class="auth-label">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autocomplete="username"
                   class="auth-input" placeholder="vous@exemple.com">
        </div>

        <div>
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password"
                   required autocomplete="new-password"
                   class="auth-input" placeholder="••••••••">
        </div>

        <div>
            <label for="password_confirmation" class="auth-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   required autocomplete="new-password"
                   class="auth-input" placeholder="••••••••">
        </div>

        <button type="submit" class="auth-btn">Créer mon compte →</button>
    </form>

    <hr class="auth-divider">

    <p style="text-align:center; font-size:13px; color:#64748d; font-weight:300;">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="auth-link" style="font-weight:500;">Se connecter</a>
    </p>

</x-guest-layout>
