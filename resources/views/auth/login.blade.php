<x-guest-layout title="Connexion">
    <h2 class="auth-title">Connexion</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
            <ul class="list-disc list-inside">
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
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="auth-input" placeholder="vous@exemple.com">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="auth-input" placeholder="••••••••">
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        @if (Route::has('password.request'))
            <div class="text-right">
                <a class="auth-link" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            </div>
        @endif
        <button type="submit" class="auth-btn">
            Se connecter
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="auth-link font-semibold">S'inscrire</a>
    </p>
</x-guest-layout>
