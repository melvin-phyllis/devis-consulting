<x-guest-layout title="Inscription">
    <h2 class="auth-title">Créer un compte</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
            <ul class="list-disc list-inside">
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
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="auth-input" placeholder="Jean Dupont">
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="auth-label">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="auth-input" placeholder="vous@exemple.com">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="auth-input" placeholder="••••••••">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="auth-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="auth-input" placeholder="••••••••">
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn">
            S'inscrire
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="auth-link font-semibold">Se connecter</a>
    </p>
</x-guest-layout>
