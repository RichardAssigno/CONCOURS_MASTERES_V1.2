@extends('layouts.auth-public', ['title' => 'Nouveau mot de passe'])

@section('content')
    <div class="text-center">
        <div class="password-help-icon mb-3">
            <i data-eva="lock-outline"></i>
        </div>
        <h5 class="mb-0">Choisissez un nouveau mot de passe</h5>
        <p class="text-muted mt-2">
            Utilisez un mot de passe personnel que vous n’employez pas ailleurs.
        </p>
    </div>

    <form
        class="mt-4 pt-2"
        method="POST"
        action="{{ route('password.update') }}"
        data-submit-loader="Réinitialisation du mot de passe..."
    >
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-floating form-floating-custom mb-4">
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $email) }}"
                placeholder="Adresse email"
                autocomplete="email"
                required
            >
            <label for="email">Adresse email</label>
            <div class="form-floating-icon">
                <i data-eva="email-outline"></i>
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                placeholder="Nouveau mot de passe"
                autocomplete="new-password"
                required
            >
            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0 password-toggle" data-target="password" aria-label="Afficher le mot de passe">
                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
            </button>
            <label for="password">Nouveau mot de passe</label>
            <div class="form-floating-icon">
                <i data-eva="lock-outline"></i>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating form-floating-custom mb-3 auth-pass-inputgroup">
            <input
                type="password"
                class="form-control"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Confirmer le mot de passe"
                autocomplete="new-password"
                required
            >
            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0 password-toggle" data-target="password_confirmation" aria-label="Afficher la confirmation">
                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
            </button>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <div class="form-floating-icon">
                <i data-eva="lock-outline"></i>
            </div>
        </div>

        <div class="password-requirements mb-4">
            Le mot de passe doit contenir au moins 8 caractères.
        </div>

        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
            Réinitialiser le mot de passe
        </button>
    </form>

    <div class="mt-4 pt-3 text-center">
        <a href="{{ route('login') }}" class="text-primary fw-semibold">
            <i class="mdi mdi-arrow-left me-1"></i>
            Retour à la connexion
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.target);
                const icon = button.querySelector('i');
                const showPassword = input.type === 'password';

                input.type = showPassword ? 'text' : 'password';
                icon.classList.toggle('mdi-eye-outline', !showPassword);
                icon.classList.toggle('mdi-eye-off-outline', showPassword);
            });
        });
    </script>
@endsection
