@component('mail::message')

<h2>Sofra App reset password</h2>
<p>Hello {{ $user->name }}</p>

@component('mail::button', ['url' => 'http://sofra.com', 'color' => 'success'])
Reset password
@endcomponent

<p>Dear user, Your reset password is: {{ $user->pin_code }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
