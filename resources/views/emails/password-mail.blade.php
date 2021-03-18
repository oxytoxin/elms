<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="p-5 text-center">
        <h1 class="my-5 text-4xl font-semibold text-gray-500">SKSU E-LeaDs</h1>
        <p>Your default password is <strong>{{ $password }}</strong>. Use it to login to your account at:</p>
        <a class="block my-5 underline text-primary-500" href="https://sksu-eleads.com">SKSU E-LeaDs</a>
    </div>
</body>
</html>
