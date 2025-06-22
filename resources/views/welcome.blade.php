<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Multiplic') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                text-align: center;
                color: white;
                padding: 2rem;
            }
            .logo {
                font-size: 4rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }
            .subtitle {
                font-size: 1.5rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }
            .description {
                font-size: 1.1rem;
                opacity: 0.8;
                max-width: 600px;
                margin: 0 auto;
                line-height: 1.6;
            }
        </style>
    @endif
</head>
<body>
    <div class="container">
        <div class="logo">
            {{ config('app.name', 'Multiplic') }}
        </div>
        <div class="subtitle">
            Plataforma Base
        </div>
        <div class="description">
            Sistema Laravel preparado para desenvolvimento.<br>
            Base limpa pronta para customização.
        </div>
    </div>
</body>
</html>
