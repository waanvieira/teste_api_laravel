@component('mail::message')
Sejá bem vindo.

Olá  {{ $user->name }}!

Seja bem vindo a plataforma

@component('mail::button', ['url' => ''])
Conheça nossa plataforma
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
