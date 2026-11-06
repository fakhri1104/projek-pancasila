<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SpeakUp - @yield('title', 'Aspirasi Sekolah')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#819A91',
                        secondary: '#A7C1A8',
                        accent: '#D1D8BE',
                        background: '#EEEFE0',
                        surface: '#F5F5F0'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #EEEFE0;
            font-family: 'Inter', sans-serif;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hover-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(129, 154, 145, 0.15);
        }

        /* Main content transition */
        main {
            margin-left: 240px;
            transition: margin-left 0.3s ease-in-out;
        }

        @media (max-width: 767px) {
            main {
                margin-left: 0 !important;
            }

            #sidebar {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="text-gray-700 antialiased">

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="min-h-screen overflow-y-auto">
        <!-- Content -->
        <div class="p-6 md:p-8 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>

    @yield('scripts')
</body>

</html>
