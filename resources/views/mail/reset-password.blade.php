<x-mail::message>
# Bonjour !

Nous avons reçu une demande pour réinitialiser le mot de passe associé à votre compte.

<x-mail::button :url="$url">
Réinitialiser mon mot de passe
</x-mail::button>

<p>
Ce lien est valable pendant 60 minutes. Passé ce délai, vous devrez effectuer une nouvelle demande.
</p>

<p>
Si vous n’êtes pas à l’origine de cette demande, vous pouvez simplement ignorer cet e-mail. Aucune action ne sera effectuée sur votre compte.
</p>

Merci de votre confiance,<br>
{{ config('app.name') }}
</x-mail::message>
