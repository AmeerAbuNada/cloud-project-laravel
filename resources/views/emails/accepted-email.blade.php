<x-mail::message>
# You have been accepted!

Your Unique ID for login is {{$id}}

<x-mail::button :url="route('login')">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
