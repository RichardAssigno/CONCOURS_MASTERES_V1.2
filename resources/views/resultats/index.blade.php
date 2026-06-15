<!doctype html>
<html lang="fr">

<head>
    @include('partials.meta', ['titre' => 'Résultats des concours'])
    @include('partials.css')
    <style>
        :root {
            --results-primary: #184e77;
            --results-primary-dark: #103c5d;
            --results-accent: #2ab57d;
            --results-border: #e5eaf2;
            --results-muted: #667085;
        }

        body {
            background: #f4f7fb;
            color: #293042;
        }

        .results-header {
            background: linear-gradient(135deg, var(--results-primary) 0%, #25636f 62%, #6f4e37 100%);
            color: #fff;
            overflow: hidden;
            padding: 26px 0 92px;
            position: relative;
        }

        .results-header::after {
            background: rgba(255, 255, 255, .09);
            border-radius: 50%;
            content: "";
            height: 320px;
            position: absolute;
            right: -110px;
            top: -150px;
            width: 320px;
        }

        .results-brand,
        .results-hero {
            position: relative;
            z-index: 1;
        }

        .results-logo {
            background: #fff;
            border-radius: 12px;
            height: 62px;
            object-fit: contain;
            padding: 5px;
            width: 62px;
        }

        .results-brand-title {
            color: #fff;
            font-size: 17px;
            font-weight: 700;
            margin: 0;
        }

        .results-brand-subtitle {
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            margin: 2px 0 0;
        }

        .results-login-link {
            border-color: rgba(255, 255, 255, .65);
            color: #fff;
        }

        .results-login-link:hover,
        .results-login-link:focus {
            background: #fff;
            border-color: #fff;
            color: var(--results-primary);
        }

        .results-hero {
            margin: 54px auto 0;
            max-width: 780px;
            text-align: center;
        }

        .results-session {
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 30px;
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .05em;
            padding: 7px 14px;
            text-transform: uppercase;
        }

        .results-hero h1 {
            color: #fff;
            font-size: clamp(29px, 5vw, 43px);
            font-weight: 750;
            margin: 18px 0 10px;
        }

        .results-hero p {
            color: rgba(255, 255, 255, .82);
            font-size: 16px;
            margin: 0;
        }

        .results-main {
            margin-top: -52px;
            padding-bottom: 45px;
            position: relative;
            z-index: 2;
        }

        .results-card {
            background: #fff;
            border: 1px solid var(--results-border);
            border-radius: 14px;
            box-shadow: 0 18px 45px rgba(20, 39, 63, .11);
            padding: 28px;
        }

        .results-label {
            color: #344054;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .results-search {
            display: grid;
            gap: 12px;
            grid-template-columns: minmax(0, 1fr) auto;
        }

        .results-input-wrap {
            position: relative;
        }

        .results-input-wrap i {
            color: #98a2b3;
            font-size: 20px;
            left: 17px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .results-input {
            border: 1px solid #ccd4e0;
            border-radius: 9px;
            font-size: 15px;
            min-height: 50px;
            padding-left: 48px;
        }

        .results-input:focus {
            border-color: var(--results-primary);
            box-shadow: 0 0 0 3px rgba(24, 78, 119, .12);
        }

        .results-button {
            background: var(--results-primary);
            border: 0;
            border-radius: 9px;
            color: #fff;
            font-weight: 700;
            min-height: 50px;
            padding: 0 25px;
        }

        .results-button:hover,
        .results-button:focus {
            background: var(--results-primary-dark);
            color: #fff;
        }

        .results-help {
            color: var(--results-muted);
            font-size: 13px;
            margin: 10px 0 0;
        }

        .results-state {
            align-items: center;
            background: #f8fafc;
            border: 1px dashed #ccd4e0;
            border-radius: 11px;
            color: var(--results-muted);
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 24px;
            min-height: 180px;
            padding: 26px;
            text-align: center;
        }

        .results-state i {
            color: #98a2b3;
            font-size: 42px;
            margin-bottom: 10px;
        }

        .results-state strong {
            color: #344054;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .results-output {
            margin-top: 28px;
        }

        .results-output-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .results-output-header h2 {
            color: #293042;
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .results-count {
            background: #e9f8f1;
            border-radius: 30px;
            color: #167a52;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 11px;
        }

        .results-table-wrap {
            border: 1px solid var(--results-border);
            border-radius: 10px;
            overflow: hidden;
        }

        .results-table {
            margin-bottom: 0;
            min-width: 820px;
        }

        .results-table thead th {
            background: #f5f8fc;
            border-bottom: 1px solid var(--results-border);
            color: #475467;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: .035em;
            padding: 14px 16px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .results-table tbody td {
            border-color: #edf1f6;
            color: #344054;
            padding: 15px 16px;
            vertical-align: middle;
        }

        .results-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .results-matricule {
            color: var(--results-primary);
            font-weight: 750;
        }

        .results-year {
            white-space: nowrap;
        }

        .results-footer {
            color: #7b8190;
            font-size: 13px;
            padding: 20px 0 28px;
            text-align: center;
        }

        [hidden] {
            display: none !important;
        }

        @media (max-width: 767.98px) {
            .results-header {
                padding-top: 18px;
            }

            .results-brand-subtitle {
                display: none;
            }

            .results-hero {
                margin-top: 42px;
            }

            .results-main {
                margin-top: -42px;
            }

            .results-card {
                border-radius: 12px;
                padding: 20px;
            }

            .results-search {
                grid-template-columns: 1fr;
            }

            .results-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<header class="results-header">
    <div class="container">
        <div class="results-brand d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 text-decoration-none">
                <img src="{{ asset('assets/images/logo-dark.png') }}" class="results-logo" alt="Logo INP-HB">
                <span>
                    <span class="results-brand-title d-block">INP-HB</span>
                    <span class="results-brand-subtitle d-block">Plateforme des concours</span>
                </span>
            </a>
            <a href="{{ route('login') }}" class="btn btn-sm results-login-link">
                Espace candidat
            </a>
        </div>

        <div class="results-hero">
            <span class="results-session">Session {{ $annee }}</span>
            <h1>Résultats des concours</h1>
            <p>Consultez votre admissibilité avec votre matricule ou votre nom de famille.</p>
        </div>
    </div>
</header>

<main class="results-main">
    <div class="container">
        <section class="results-card" aria-labelledby="results-search-title">
            <form id="results-search-form" novalidate>
                <label class="results-label" id="results-search-title" for="results-search-input">
                    Matricule ou nom
                </label>
                <div class="results-search">
                    <div class="results-input-wrap">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                        <input
                            class="form-control results-input"
                            id="results-search-input"
                            type="search"
                            placeholder="Ex. CM20260001 ou KOUASSI"
                            autocomplete="off"
                            required
                        >
                    </div>
                    <button class="btn results-button" type="submit">
                        Rechercher
                    </button>
                </div>
                <p class="results-help">
                    La recherche par matricule affiche une personne. La recherche par nom affiche tous les admissibles portant ce nom.
                </p>
            </form>

            <div class="results-state" id="results-initial-state">
                <i class="mdi mdi-account-search-outline" aria-hidden="true"></i>
                <strong>Recherchez un résultat</strong>
                <span>Saisissez votre matricule ou votre nom dans le champ ci-dessus.</span>
            </div>

            <div class="results-state" id="results-empty-state" role="status" hidden>
                <i class="mdi mdi-account-alert-outline" aria-hidden="true"></i>
                <strong>Aucun admissible trouvé</strong>
                <span>Vérifiez le matricule ou saisissez uniquement le nom de famille.</span>
            </div>

            <section class="results-output" id="results-output" aria-live="polite" hidden>
                <div class="results-output-header">
                    <h2>Résultat de la recherche</h2>
                    <span class="results-count" id="results-count"></span>
                </div>
                <div class="table-responsive results-table-wrap">
                    <table class="table results-table">
                        <thead>
                        <tr>
                            <th scope="col">Matricule</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénoms</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Concours</th>
                            <th scope="col">Année</th>
                        </tr>
                        </thead>
                        <tbody id="results-table-body"></tbody>
                    </table>
                </div>
            </section>
        </section>
    </div>
</main>

<footer class="results-footer">
    &copy; {{ now()->year }} INP-HB. Tous droits réservés.
</footer>

<script>
    const ADMIS_2026_2027 = {{ Illuminate\Support\Js::from($admis) }};

    (() => {
        const form = document.getElementById('results-search-form');
        const input = document.getElementById('results-search-input');
        const initialState = document.getElementById('results-initial-state');
        const emptyState = document.getElementById('results-empty-state');
        const output = document.getElementById('results-output');
        const count = document.getElementById('results-count');
        const tableBody = document.getElementById('results-table-body');

        const normalize = (value) => String(value ?? '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim()
            .replace(/\s+/g, ' ')
            .toLocaleUpperCase('fr-FR');

        const createCell = (value, className = '') => {
            const cell = document.createElement('td');
            cell.textContent = value || '-';

            if (className) {
                cell.className = className;
            }

            return cell;
        };

        const render = (results) => {
            tableBody.replaceChildren();

            results.forEach((candidate) => {
                const row = document.createElement('tr');
                row.append(
                    createCell(candidate.matricule, 'results-matricule'),
                    createCell(candidate.nom),
                    createCell(candidate.prenoms),
                    createCell(candidate.genre),
                    createCell(candidate.concours),
                    createCell(candidate.annee, 'results-year')
                );
                tableBody.appendChild(row);
            });

            const total = results.length;
            count.textContent = `${total} admissible(s)`;
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const query = normalize(input.value);

            if (!query) {
                input.focus();
                return;
            }

            const matriculeMatch = ADMIS_2026_2027.find(
                (candidate) => normalize(candidate.matricule) === query
            );
            const results = matriculeMatch
                ? [matriculeMatch]
                : ADMIS_2026_2027.filter((candidate) => normalize(candidate.nom) === query);

            initialState.hidden = true;
            emptyState.hidden = results.length > 0;
            output.hidden = results.length === 0;

            if (results.length > 0) {
                render(results);
            }
        });
    })();
</script>
</body>
</html>
