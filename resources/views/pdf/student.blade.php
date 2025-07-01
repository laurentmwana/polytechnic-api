<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé des Cotes - {{ $infos['nom'] ?? '' }} {{ $infos['postnom'] ?? '' }}</title>
</head>
<body style="font-family: 'Inter', serif; margin: 30px; font-size: 12px; color: black; line-height: 1.2;">

    <!-- En-tête officiel -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 16px; font-weight: bold; margin: 5px 0; text-transform: uppercase;">UNIVERSITE DE KINSHASA</h1>
        <h1 style="font-size: 16px; font-weight: bold; margin: 5px 0; text-transform: uppercase;">FACULTE POLYTECHNIQUE</h1>
        <br>
        <h2 style="font-size: 14px; font-weight: bold; margin: 5px 0; text-transform: uppercase;">RELEVE DES COTES DE L'ETUDIANT {{ strtoupper($infos['nom'] ?? '') }} {{ strtoupper($infos['postnom'] ?? '') }}</h2>
    </div>

    <!-- Informations académiques -->
    <div style="text-align: center; margin: 20px 0; font-size: 12px; font-weight: bold;">
        <div>ANNEE ACADEMIQUE : {{ $deliberation->yearAcademic->name ?? '2023-2024' }}</div>
        <div>{{ strtoupper($deliberation->semester ?? 'DEUXIEME SESSION') }}</div>
    </div>

    <!-- Tableau des cours -->
    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <thead>
            <tr>
                <th style="width: 8%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">NR</th>
                <th style="width: 45%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">INTITULE DU COURS</th>
                <th style="width: 12%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">HRS<br>TH/TP</th>
                <th style="width: 12%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">AN/20</th>
                <th style="width: 12%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">EX/20</th>
                <th style="width: 11%; border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px; background-color: #f0f0f0; font-weight: bold;">MOY/20</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;">{{ $course['numero'] ?? '' }}</td>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: left; font-size: 11px;">{{ $course['intitule'] ?? '' }}</td>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;">{{ $course['hrs_thtp'] ?? '' }}</td>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;">{{ $course['note_an'] ?? '' }}</td>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;">{{ $course['note_ex'] ?? '' }}</td>
                    <td style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;"><strong>{{ $course['moyenne'] ?? '' }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="border: 1px solid black; padding: 6px 8px; text-align: center; font-size: 11px;">Aucun cours trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Résumé final -->
    <div style="margin-top: 30px; font-size: 12px; font-weight: bold;">
        <div style="margin: 15px 0;">
            <strong>POURCENTAGE : {{ $summary['pourcentage'] ?? '' }}</strong>
        </div>
        <div style="margin: 15px 0;">
            <strong>DECISION : {{ $summary['decision'] ?? '' }}</strong>
        </div>
        @if(isset($summary['frais_academique']) || isset($summary['frais_labo']))
            <div style="margin: 15px 0; font-size: 11px;">
                <div>FRAIS ACADEMIQUE : {{ $summary['frais_academique'] ?? 'NON' }}</div>
                <div>FRAIS LABO : {{ $summary['frais_labo'] ?? 'NON' }}</div>
                @if(isset($summary['enrollment']))
                    <div>ENROLLMENT : {{ $summary['enrollment'] ?? 'NON' }}</div>
                @endif
            </div>
        @endif
    </div>

    <!-- Signature -->
    <div style="margin-top: 50px; text-align: right; font-size: 11px;">
        <div style="margin-top: 80px;">
            <div>Prés. du Jury, <strong>{{ $infos['mention'] ?? 'GÉNIE ÉLECTRIQUE' }}</strong></div>
        </div>
    </div>

</body>
</html>
