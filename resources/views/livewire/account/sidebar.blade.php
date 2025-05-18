<div class="sidebar" id="sidebar">
    <div class="logo">
        <i class="bi bi-person-circle me-2"></i>
        <span class="link-text">Личный кабинет</span>
    </div>

    <a href="{{ route('account.subscriptions') }}">
        <i class="bi bi-box-seam"></i>
        <span class="link-text">Мои подписки</span>
    </a>

    <a href="{{ route('account.plans') }}">
        <i class="bi bi-stars"></i>
        <span class="link-text">Купить подписку</span>
    </a>
    @if($showSwegoSetupButtonSwego)
    <a href="{{ route('account.swego.settings') }}"
       @if($showSwegoSetupButton)
           title="Заполните настройки для доступа"
       class="text-warning"
        @endif>
        <i class="bi bi-gear"></i>
        <span class="link-text">Настройки каталога Swego</span>
        @if($showSwegoSetupButton)
            <span class="badge bg-warning ms-2">!</span>
        @endif
    </a>

        @if(!$showSwegoSetupButton)
            @if($hasAdminSubscription && $hasUrlSubscription)
                <a href="#" onclick="showSwegoModal(); return false;">
                    <i class="bi bi-box"></i>
                    <span class="link-text">Каталог Swego1</span>
                </a>
                @elseif($hasAdminSubscription || $hasUrlSubscription)
                <a href="{{ route('account.swego.catalog', $availableSwegoType) }}">
                <i class="bi bi-box"></i>
                    <span class="link-text">Каталог Swego2</span>
                </a>
            @endif
        @endif
    @endif
    <a href="{{ route('account.profile') }}">
        <i class="bi bi-person"></i>
        <span class="link-text">{{ __('app.profile') }}</span>
    </a>

    <a href="#" wire:click="logout" role="button">
        <i class="bi bi-box-arrow-right"></i>
        <span class="link-text">{{ __('logout') }}</span>
    </a>
</div>

