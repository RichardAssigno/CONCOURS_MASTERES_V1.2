<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['titre' => trim($__env->yieldContent('title')) ?: 'Erreur'])
    @include('partials.css')
    <style>
        .error-page {
            align-items: center;
            background: #f5f7fb;
            display: flex;
            min-height: 100vh;
            padding: 32px 16px;
        }

        .error-panel {
            background: #fff;
            border: 1px solid #e8edf5;
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(22, 42, 84, .08);
            margin: 0 auto;
            max-width: 620px;
            padding: 42px 34px;
            text-align: center;
            width: 100%;
        }

        .error-code {
            color: var(--bs-primary);
            font-size: clamp(64px, 12vw, 112px);
            font-weight: 800;
            line-height: .95;
            margin-bottom: 18px;
        }

        .error-message {
            color: #111827;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .error-help {
            color: #64748b;
            font-size: 15px;
            margin: 0 auto 28px;
            max-width: 440px;
        }

        .error-logo {
            height: 70px;
            margin-bottom: 28px;
            width: 70px;
        }
    </style>
</head>

<body>
    <main class="error-page">
        <section class="error-panel">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo INP-HB" class="error-logo">
            </a>

            <div class="error-code">@yield('code')</div>
            <h1 class="error-message">@yield('message')</h1>
            <p class="error-help">
                @yield('help', 'Vous pouvez revenir a l\'accueil et reprendre votre navigation.')
            </p>

            <a class="btn btn-primary waves-effect waves-light" href="{{ route('home') }}">
                Retour a l'accueil
            </a>
        </section>
    </main>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
