<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ИдёмВКино</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .admin-btn {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .guest-btn {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <a href="/admin/login" class="admin-btn">
        <button class="conf-step__button conf-step__button-regular">Войти</button>
    </a>

    <a href="/client/index" class="guest-btn">
        <button class="conf-step__button conf-step__button-regular">Продолжить как гость</button>
    </a>
</body>
</html>
