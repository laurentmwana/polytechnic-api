<x-mail::message>
# Importation des résultats terminée

Bonjour {{ $user->name }},

L’importation des résultats académiques pour la délibération suivante a été effectuée avec succès :

- **Promotion:** {{ $deliberation->level->name }} [{{ $deliberation->level->alias }}]
- **Année académique :** {{ $deliberation->yearAcademic->name }}
- **Date de la délibération :** {{ $deliberation->created_at->format('d/m/Y à H:i') }}

L’ensemble des bulletins individuels a été généré et archivé dans le système.

Aucune action supplémentaire n’est requise pour le moment.

Cordialement,  
Thanks,<br>
Le système de gestion académique

</x-mail::message>
