<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>admin</title>

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
        }

        #mainContent{
            margin-left: 250px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #1f1f1f;
            padding-top: 60px;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .content-wrapper {
            position: relative;
            left: 0;
            transition: transform 0.3s ease;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            color: #E0E0E0;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: #2c2c2c;
        }

        .sidebar i {
            font-size: 1.2rem;
            width: 30px;
            text-align: center;
        }
        .sidebar .logo {
            text-align: center;
            color: #BB86FC;
            font-size: 1.4rem;
            padding: 1rem 0;
            border-bottom: 1px solid #333;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background-color: #BB86FC;
            color: #121212;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        /* Сдвигаем весь контент вместе с сайдбаром */
        .content-wrapper.shifted {
            transform: translateX(250px);
        }

        /* Кнопка переключения */
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background-color: #BB86FC;
            color: #121212;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            display: none;
        }

        /* Мобилки */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-wrapper {
                transform: none;
            }

            .content-wrapper.shifted {
                transform: translateX(250px);
            }

            .toggle-btn {
                display: block;
            }
            #mainContent{
                margin-left: 0;
            }
        }

        /* ПК: кнопка скрыта */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0);
            }

            .content-wrapper {
                transform: none;
            }

            .toggle-btn {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-dark text-light">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <livewire:admin.layout.sidebar />

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <div class="content-wrapper" id="mainContent">
            {{ $slot }}
    </div>
</div>
</body>
</html>
