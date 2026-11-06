<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Custom Style --}}
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-effect {
            background: rgba(238, 239, 224, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(129, 154, 145, 0.2);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(129, 154, 145, 0.3);
        }

        .blob {
            position: absolute;
            filter: blur(40px);
            opacity: 0.6;
            z-index: 0;
        }
    </style>

    @stack('styles')
</head>

<body class="h-screen w-full overflow-hidden bg-[#EEEFE0] relative">

    @yield('content')

    @yield('scripts')
    @stack('scripts')
</body>
</html>
