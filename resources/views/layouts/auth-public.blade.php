<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['title' => $title])
    @include('partials.css')
    <style>
        .password-help-card {
            border: 0;
            box-shadow: 0 18px 45px rgba(22, 42, 84, .08);
        }

        .password-help-icon {
            align-items: center;
            background: rgba(59, 130, 246, .1);
            border-radius: 18px;
            color: var(--bs-primary);
            display: inline-flex;
            height: 58px;
            justify-content: center;
            width: 58px;
        }

        .password-help-icon i {
            height: 28px;
            width: 28px;
        }

        .password-requirements {
            background: #f5f8fc;
            border-radius: 12px;
            color: #64748b;
            font-size: 13px;
            padding: 12px 15px;
        }

        .auth-submit-loader {
            align-items: center;
            backdrop-filter: blur(2px);
            background: rgba(15, 23, 42, .48);
            display: flex;
            flex-direction: column;
            inset: 0;
            justify-content: center;
            position: fixed;
            z-index: 99999;
        }

        .auth-submit-loader p {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            margin: 16px 24px 0;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .password-help-side {
                display: none !important;
            }
        }
    </style>
</head>

<body>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0 align-items-center">
            <div class="col-xxl-4 col-lg-4 col-md-6">
                <div class="row justify-content-center g-0">
                    <div class="col-xl-9">
                        <div class="p-4">
                            <div class="card password-help-card mb-0">
                                <div class="card-body">
                                    <div class="auth-full-page-content rounded d-flex p-3 my-2">
                                        <div class="w-100">
                                            <div class="d-flex flex-column h-100">
                                                <div class="mb-4 mb-md-5">
                                                    <a href="{{ route('login') }}" class="d-block auth-logo">
                                                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-dark me-start">
                                                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo INP-HB" width="70" height="70" class="auth-logo-light me-start">
                                                    </a>
                                                </div>

                                                <div class="auth-content my-auto">
                                                    @yield('content')
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <p class="mb-0">&copy; {{ date('Y') }} INP-HB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 col-lg-8 col-md-6 password-help-side">
                <div class="auth-bg bg-white py-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-white"></div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-8 text-center">
                            <img src="{{ asset('assets/images/login-img.png') }}" class="img-fluid" alt="Candidature aux concours INP-HB">
                            <div class="p-0 p-sm-4 px-xl-0 pt-5">
                                <h5 class="font-size-20">Retrouvez l’accès à votre espace candidat</h5>
                                <p class="font-size-15 text-muted mt-3 mb-0">
                                    Un lien sécurisé vous permet de choisir un nouveau mot de passe et de poursuivre votre candidature.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>
<script>
    if (typeof eva !== 'undefined') {
        eva.replace();
    }

    window.showLoader = function (message) {
        document.getElementById('globalLoaderOverlay')?.remove();

        const overlay = document.createElement('div');
        const spinner = document.createElement('div');
        const label = document.createElement('p');

        overlay.id = 'globalLoaderOverlay';
        overlay.className = 'auth-submit-loader';
        overlay.setAttribute('role', 'status');
        overlay.setAttribute('aria-live', 'polite');

        spinner.className = 'spinner-border text-light';
        spinner.style.width = '3rem';
        spinner.style.height = '3rem';
        spinner.setAttribute('aria-hidden', 'true');

        label.textContent = message || 'Traitement en cours...';

        overlay.append(spinner, label);
        document.body.appendChild(overlay);
    };

    window.hideLoader = function () {
        document.getElementById('globalLoaderOverlay')?.remove();
    };

    document.querySelectorAll('form[data-submit-loader]').forEach(function (form) {
        form.addEventListener('submit', function () {
            const submitButton = form.querySelector('button[type="submit"]');

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.setAttribute('aria-disabled', 'true');
            }

            window.showLoader(form.dataset.submitLoader);
        });
    });
</script>
@yield('scripts')
</body>
</html>
