<x-mail::message>
# Vérification de votre adresse e-mail

Bonjour {{ $name }},

Pour sécuriser votre compte, veuillez utiliser le code ci-dessous afin de confirmer votre adresse e-mail :

<x-mail::panel>
    {{ $optUser->opt }}
</x-mail::panel>

Ce code expire le {{ \Carbon\Carbon::parse($optUser->expirate)->translatedFormat('d F Y à H:i') }}.

Si vous n'avez pas demandé cette vérification, vous pouvez ignorer ce message en toute sécurité.

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
