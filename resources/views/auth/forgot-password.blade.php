<x-guest-layout title="Mot de passe oublié">
    <h2 class="auth-title">Mot de passe oublié</h2>

    <p class="mb-4 text-sm text-gray-600">
        Indiquez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </p>

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

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="auth-label">Adresse email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="auth-input" placeholder="vous@exemple.com">
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="auth-btn">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="auth-link font-semibold">← Retour à la connexion</a>
    </p>
</x-guest-layout>
