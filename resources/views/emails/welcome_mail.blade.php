<x-mail::message>
# Hello, {{ $user->name }} 👋

Welcome to **{{ config('app.name') }}**!  
We’re happy to have you on board 🎉



<x-mail::button :url="'http://localhost:8000/dashboard'">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
