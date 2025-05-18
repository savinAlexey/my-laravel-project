<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'app') }}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @livewireStyles  <!-- Подключение стилей для Livewire -->
    <style>
        .grid-item {
            width: 160px;
            height: 120px;
            float: left;
            border-radius: 5px;
        }
    </style>
</head>
<body class="bg-dark text-light">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <button class="toggle-btn" id="toggleSidebar">☰</button>
    <livewire:account.sidebar />  <!-- Сайдбар -->

    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <div class="content-wrapper" id="mainContent">
        {{ $slot }} <!-- Контент, включая Livewire компонент -->
    </div>
</div>
<!-- Модалка для каталога Swego -->
<div id="swegoModal" class="modal" style="display: none;">
    <div class="modal-overlay" onclick="hideModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Выберите тип доступа</h3>
            <button class="modal-close" onclick="hideModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="d-grid gap-3">
                <a href="{{ route('account.swego.catalog', 'admin') }}" class="btn btn-outline-primary text-start p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-shield-lock text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Admin доступ</h6>
                            <small class="text-muted">Полный контроль через API</small>
                        </div>
                    </div>
                </a>

                <a href="{{ route('account.swego.catalog', 'url') }}" class="btn btn-outline-success text-start p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                            <i class="bi bi-link-45deg text-success"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">URL доступ</h6>
                            <small class="text-muted">Доступ по публичной ссылке</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Правильное подключение скриптов -->
@livewireScripts

<!-- Ваши кастомные скрипты -->
@stack('scripts')
</body>
</html>
