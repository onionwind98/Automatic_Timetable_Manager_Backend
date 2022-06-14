@component('mail::message')
# Reset Password 

Please enter the verification code  below in the application to reset password.


@component('mail::panel')
{{$resetToken}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
