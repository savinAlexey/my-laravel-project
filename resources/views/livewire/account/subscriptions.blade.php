<div class="container py-4">
    <h2 class="mb-4">Мои подписки</h2>

    @if(empty($subscriptions))
        <p>У вас пока нет активных подписок.</p>
        <small><a href="{{ route('account.plans') }}" wire:navigate>Хотите выбрать подписку?</a></small>
    @else
        <ul class="list-group">
            @foreach($subscriptions as $subscription)
                <li class="list-group-item bg-dark text-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong>{{ $subscription['platform']['name'] ?? 'Не указано' }}</strong></p>
                            <small class="text-muted">
                                Действует до: {{ \Illuminate\Support\Carbon::parse($subscription['ends_at'])->format('d.m.Y H:i') ?? 'Не указано' }}
                            </small>
                        </div>
                        <span class="badge bg-success">Активна</span>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
