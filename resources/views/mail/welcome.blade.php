<x-mail::message>
# Bienvenue à {{ config('app.name') }}

Cher(e) étudiant(e),

Nous sommes heureux de vous accueillir au sein de notre communauté académique.

Vous pouvez dès à présent accéder à votre espace étudiant et consulter les informations utiles pour bien commencer votre parcours.

<x-mail::button :url="url('/')">
Accéder au portail étudiant
</x-mail::button>

Cordialement,<br>
L'équipe de {{ config('app.name') }}
</x-mail::message>
