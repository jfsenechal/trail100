<x-mail::message>
# Welcome {{$user->first_name}} {{$user->last_name}}

## Etapes pour votre enregistrement au {{ config('app.name') }}

- Ajouter d'autres participants
- Payer votre participation

---
## Informations de connection
Utilisez le bouton ci dessous.
<x-mail::button :url="$url" color="success">
    {{$textbtn}}
</x-mail::button>
<x-mail::panel>
@if ($user->plainPassword)
    Ou connectez vous avec le compte suivant:

    Login: {{$user->email}}

    Password: {{$user->plainPassword}}
@endif
</x-mail::panel>
[Site web des Marcheurs de la Famenne](https://marcheursdelafamenne.marche.be/)
<x-mail::subcopy>
    Ma subcopy
</x-mail::subcopy>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
