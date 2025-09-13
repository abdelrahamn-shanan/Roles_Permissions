<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <h2>Hello, {{ $user->name }} 👋</h2>
    <p>Welcome to <strong>{{ config('app.name') }}</strong>.</p>
    <p>Your registered email: {{ $user->email }}</p>
    <p>We’re glad to have you on board 🎉</p>
</body>
</html>
