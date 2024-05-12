@component('mail::message')
# Email Verification

We got a request to reset your password IMS Account
Your reset code is {{ $pin }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
