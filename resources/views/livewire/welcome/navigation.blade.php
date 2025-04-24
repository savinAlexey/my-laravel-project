<nav class="navbar navbar-expand-lg border-bottom" style="background-color: #1f1f1f;">
    <div class="container-fluid">
        <!-- Логотип -->
        <div>
            <a href="/" wire:navigate>
                <x-application-logo class="d-inline-block align-text-top" style="height: 1.8rem;" />
            </a>
        </div>

        <!-- Кнопка-гамбургер -->
        <button class="navbar-toggler text-light border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#guestNavbar" aria-controls="guestNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Основное меню -->
        <div class="collapse navbar-collapse" id="guestNavbar">
            <div class="d-flex gap-2 mx-auto">
                @auth('web')
                    <a href="{{ route('account.dashboard') }}" class="nav-link text-light">
                        Личный кабинет
                    </a>
                @endauth
            </div>

            @guest('web')
                <div class="d-flex gap-2 ms-auto">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        Вход
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                            Регистрация
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</nav>
