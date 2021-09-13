@component('mail::message')
# Hello, {{ $user->name }}

Your email has been updated, please verify your new email using the following link

@component('mail::button', ['url' => route('users.verify', $user->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
