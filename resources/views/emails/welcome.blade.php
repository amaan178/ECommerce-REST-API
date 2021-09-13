@component('mail::message')
# Hello, {{ $user->name }}

Thank you for creating an account with us. Please verify your account using the following link. If you have any problem in verification you can contact us on "admin@somedomain.com"

@component('mail::button', ['url' => route('users.verify', $user->verification_token)])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
