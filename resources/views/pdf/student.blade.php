<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $infos['mention'] ?? '' }}</title>
</head>
<body style="font-family: Inter, sans-serif; margin: 20px; font-size: 14px; color: black; line-height: 1.4; background-color: white;">

    <!-- En-tête -->
    <div style="text-align: center; border-bottom: 2px solid black; padding-bottom: 20px; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 26px; font-weight: bold; color: black; margin-bottom:15px;">FACULTE POLYTECHNIQUE</h1>
        <h1 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">BULLETIN ACADÉMIQUE</h1>
        <div style="margin: 10px 0 0 0; font-size: 16px; color: black;">
            {{ $infos['mention'] ?? '' }} - Année {{ $deliberation->yearAcademic->name ?? '' }}
        </div>
    </div>

       <div style="margin-bottom: 30px;">
        <h2 style="background-color: black; color: white; padding: 10px; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">
            INFORMATIONS ÉTUDIANT
        </h2>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <tr>
                <td style="width: 25%; padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Nom :</td>
                <td style="width: 25%; padding: 10px; border: 1px solid black;">{{ $infos['noms'] ?? '' }}</td>
                <td style="width: 25%; padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Promotion :</td>
                <td style="width: 25%; padding: 10px; border: 1px solid black;">
                    {{ $deliberation->level->name ?? '' }} [{{ $deliberation->level->alias ?? '' }}]
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Année académique :</td>
                <td style="padding: 10px; border: 1px solid black;">{{ $deliberation->yearAcademic->name ?? '' }}</td>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Semestre :</td>
                <td style="padding: 10px; border: 1px solid black;">{{ $deliberation->semester }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Matricule :</td>
                <td style="padding: 10px; border: 1px solid black;">{{ $infos['matricule'] ?? '' }}</td>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Éligible :</td>
                <td style="padding: 10px; border: 1px solid black;">
                    {{ isset($is_eligible) ? ($is_eligible ? 'Oui' : 'Non') : ($infos['eligible'] ?? '-') }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Paiement Labo :</td>
                <td style="padding: 10px; border: 1px solid black;">
                    {{ isset($is_paid_labo) ? ($is_paid_labo ? 'Oui' : 'Non') : '-' }}
                </td>
                <td style="padding: 10px; border: 1px solid black; font-weight: bold; background-color: #f5f5f5;">Paiement Académique :</td>
                <td style="padding: 10px; border: 1px solid black;">
                    {{ isset($is_paid_academic) ? ($is_paid_academic ? 'Oui' : 'Non') : '-' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Section Résultats UE -->
    <div style="margin-bottom: 30px;">
        <h2 style="background-color: black; color: white; padding: 10px; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">
            RÉSULTATS DES UNITÉS D'ENSEIGNEMENT
        </h2>
        <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
            <thead>
                <tr style="background-color: black;">
                    <th style="color: white; font-weight: bold; font-size: 12px; padding: 10px; text-align: left; border: 1px solid black;">Code UE</th>
                    <th style="color: white; font-weight: bold; font-size: 12px; padding: 10px; text-align: left; border: 1px solid black;">Intitulé</th>
                    <th style="color: white; font-weight: bold; font-size: 12px; padding: 10px; text-align: left; border: 1px solid black;">Catégorie</th>
                    <th style="color: white; font-weight: bold; font-size: 12px; padding: 10px; text-align: left; border: 1px solid black;">Crédit</th>
                    <th style="color: white; font-weight: bold; font-size: 12px; padding: 10px; text-align: left; border: 1px solid black;">Moyenne</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ues as $index => $ue)
                    <tr style="{{ $index % 2 == 0 ? 'background-color: #f5f5f5;' : 'background-color: white;' }}">
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $ue['code_ue'] ?? '-' }}</td>
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $ue['intitule'] ?? '-' }}</td>
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $ue['categorie'] ?? '-' }}</td>
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $ue['credit'] ?? '-' }}</td>
                        <td style="padding: 8px; text-align: left; border: 1px solid black;">{{ $ue['moyenne'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 10px;">Aucune UE trouvée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Section Synthèse -->
    <div style="margin-bottom: 30px;">
        <h2 style="background-color: black; color: white; padding: 10px; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">
            SYNTHÈSE DES RÉSULTATS
        </h2>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <tr>
                <td style="width: 50%; padding: 15px; text-align: center; border: 1px solid black; background-color: #f5f5f5;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">MOYENNE CATÉGORIE A</div>
                    <div style="font-size: 20px; font-weight: bold; color: black;">{{ $summary['moyenne_categorie_a'] ?? '-' }}</div>
                </td>
                <td style="width: 50%; padding: 15px; text-align: center; border: 1px solid black; background-color: #f5f5f5;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">MOYENNE CATÉGORIE B</div>
                    <div style="font-size: 20px; font-weight: bold; color: black;">{{ $summary['moyenne_categorie_b'] ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px; text-align: center; border: 1px solid black; background-color: #f5f5f5;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">MOYENNE SEMESTRE</div>
                    <div style="font-size: 20px; font-weight: bold; color: black;">{{ $summary['moyenne_semestre'] ?? '-' }}</div>
                </td>
                <td style="padding: 15px; text-align: center; border: 1px solid black; background-color: #f5f5f5;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">CRÉDITS ECTS</div>
                    <div style="font-size: 20px; font-weight: bold; color: black;">{{ $summary['credits_capitaliser'] ?? '-' }}</div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 15px; text-align: center; border: 1px solid black; background-color: black; color: white;">
                    <div style="font-size: 12px; font-weight: bold; margin-bottom: 5px;">DÉCISION DU JURY</div>
                    <div style="font-size: 18px; font-weight: bold;">{{ $summary['decision'] ?? 'EN ATTENTE' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Pied de page -->
    <div style="border-top: 1px solid black; padding-top: 15px; text-align: center; font-size: 12px; color: black;">
        <div style="margin-bottom: 5px; font-weight: bold;">
            Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}
        </div>
        <div style="font-style: italic;">
            Ce document est confidentiel et destiné uniquement à l'étudiant concerné
        </div>
    </div>

</body>
</html>
