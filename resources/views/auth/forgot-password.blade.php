@extends('layouts.auth-public', ['title' => 'Mot de passe oublié'])

@section('content')
    <div class="text-center">
        <div class="password-help-icon mb-3">
            <i data-eva="email-outline"></i>
        </div>
        <h5 class="mb-0">Mot de passe oublié ?</h5>
        <p class="text-muted mt-2">
            Saisissez l’adresse email utilisée lors de votre inscription.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success mt-4" role="alert">
            <i class="mdi mdi-check-circle-outline me-1"></i>
            {{ session('status') }}
        </div>
    @endif

    <form
        class="mt-4 pt-2"
        method="POST"
        action="{{ route('password.email') }}"
        data-submit-loader="Envoi du lien de réinitialisation..."
    >
        @csrf
        <div class="form-floating form-floating-custom mb-4">
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Adresse email"
                autocomplete="email"
                autofocus
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

        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <div class="mt-4 pt-3 text-center">
        <a href="{{ route('login') }}" class="text-primary fw-semibold">
            <i class="mdi mdi-arrow-left me-1"></i>
            Retour à la connexion
        </a>
    </div>
@endsection
