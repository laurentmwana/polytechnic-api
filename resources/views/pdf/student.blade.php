<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé des Cotes - {{ $infos['nom'] ?? '' }} {{ $infos['postnom'] ?? '' }}</title>
    <!-- Import Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS pour faciliter la personnalisation */
        :root {
            --color-primary: #003366;
            --color-secondary: #f0f0f0;
            --color-text: #222;
            --color-accent: #007acc;
            --font-family: 'Inter', Arial, sans-serif;
            --font-size-base: 12px;
            --line-height-base: 1.5;
            --border-color: #bbb;
            --border-thickness: 1px;
        }

        /* Reset léger */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            margin: 30px;
            font-size: var(--font-size-base);
            color: var(--color-text);
            line-height: var(--line-height-base);
            background-color: #fff;
        }

        /* En-têtes */
        .header h1, .header h2 {
            font-weight: 700;
            text-transform: uppercase;
            margin: 4px 0;
            color: var(--color-primary);
        }

        .header h1 {
            font-size: 18px;
        }

        .header h2 {
            font-size: 14px;
            margin-top: 20px;
            border-top: 2px solid var(--color-primary);
            padding-top: 10px;
        }

        /* Sections centrées */
        .header, .academic-info {
            text-align: center;
            margin-bottom: 40px;
        }

        .academic-info {
            margin: 20px 0;
            font-weight: 700;
            font-size: 12px;
            color: var(--color-primary);
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
            border: var(--border-thickness) solid var(--border-color);
            padding: 8px 12px;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: var(--color-secondary);
            font-weight: 700;
            color: var(--color-primary);
            letter-spacing: 0.05em;
        }

        /* Alignement spécifique */
        td:nth-child(2) {
            text-align: left;
        }

        /* Lignes alternées pour plus de lisibilité */
        tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        /* Résumé final */
        .summary {
            margin-top: 30px;
            font-weight: 700;
            font-size: 12px;
            color: var(--color-primary);
        }

        .summary div {
            margin: 12px 0;
        }

        .summary .details {
            font-weight: 400;
            font-size: 11px;
            margin-top: 10px;
            color: var(--color-text);
        }

        /* Signature */
        .signature {
            margin-top: 50px;
            text-align: right;
            font-size: 11px;
            color: var(--color-text);
        }

        .signature strong {
            font-weight: 700;
            color: var(--color-primary);
        }
    </style>
</head>
<body>

    <!-- En-tête officiel -->
    <div class="header">
        <h1>UNIVERSITE DE KINSHASA</h1>
        <h1>FACULTE POLYTECHNIQUE</h1>
        <h2>RELEVE DES COTES DE L'ETUDIANT {{ strtoupper($infos['nom'] ?? '') }} {{ strtoupper($infos['postnom'] ?? '') }}</h2>
    </div>

    <!-- Informations académiques -->
    <div class="academic-info">
        <div>ANNEE ACADEMIQUE : {{ $deliberation->yearAcademic->name ?? '2023-2024' }}</div>
        <div>{{ strtoupper($deliberation->semester ?? 'DEUXIEME SESSION') }}</div>
    </div>

    <!-- Tableau des cours -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">NR</th>
                <th style="width: 45%;">INTITULE DU COURS</th>
                <th style="width: 12%;">HRS<br>TH/TP</th>
                <th style="width: 12%;">AN/20</th>
                <th style="width: 12%;">EX/20</th>
                <th style="width: 11%;">MOY/20</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course['numero'] ?? '' }}</td>
                    <td>{{ $course['intitule'] ?? '' }}</td>
                    <td>{{ $course['hrs_thtp'] ?? '' }}</td>
                    <td>{{ $course['note_an'] ?? '' }}</td>
                    <td>{{ $course['note_ex'] ?? '' }}</td>
                    <td><strong>{{ $course['moyenne'] ?? '' }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucun cours trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Résumé final -->
    <div class="summary">
        <div class="details">
            <div>
                POURCENTAGE :
                @php
                    $pourcentage = $summary['pourcentage'] ?? '';
                    // Ajout du % s'il n'est pas présent
                    if ($pourcentage !== '' && strpos($pourcentage, '%') === false) {
                        $pourcentage .= '%';
                    }
                @endphp
                {{ $pourcentage }}
            </div>
            <div>CREDITS CAPITALISER : {{ $summary['credits_cap'] ?? '' }}</div>
            <div>STATUS : {{ $summary['status'] ?? '' }}</div>
            @if(isset($summary['frais_academique']) || isset($summary['frais_labo']) || isset($summary['enrollment']))
                <div>FRAIS ACADEMIQUE : {{ $summary['frais_academique'] ?? 'NON' }}</div>
                <div>FRAIS LABO : {{ $summary['frais_labo'] ?? 'NON' }}</div>
                <div>FRAIS INSCRIPTION : {{ $summary['enrollment'] ?? 'NON' }}</div>
            @endif
        </div>
    </div>

    <!-- Signature -->
    <div class="signature">
        <div style="margin-top: 80px;">
            <div>Prés. du Jury, <strong>{{ $infos['mention'] ?? 'GÉNIE ÉLECTRIQUE' }}</strong></div>
        </div>
    </div>

</body>
</html>
