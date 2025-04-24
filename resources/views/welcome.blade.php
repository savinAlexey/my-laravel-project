<x-guest-layout>
    @guest
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title">Подписка на платформу Szwego</h5>
                            <p class="card-text">
                                Получите доступ к расширенной выгрузке товаров, Telegram-уведомлениям и другим функциям платформы.
                            </p>

                            <ul class="list-group list-group-flush my-3 text-start">
                                <li class="list-group-item">• Доступ к закрытому API</li>
                                <li class="list-group-item">• Telegram-уведомления о новых товарах</li>
                                <li class="list-group-item">• Работа с куками для swego.com</li>
                            </ul>

                            <a href="{{ route('register') }}" class="btn btn-primary mt-3">
                                Подписаться
                            </a>

                            <p class="text-muted mt-2 mb-0">
                                Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</x-guest-layout>
