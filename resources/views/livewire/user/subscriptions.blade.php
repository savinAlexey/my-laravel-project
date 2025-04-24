<div>
    <h2 class="mb-4">Мои подписки</h2>

    @if($subscriptions->isEmpty())
        <p>У вас пока нет активных подписок.</p>
    @else
        <ul class="list-group">
            @foreach($subscriptions as $subscription)
                <li class="list-group-item bg-dark text-light">
                    <p>Платформа: {{ $subscription->platform->name }}</p>
                    <p>Дата начала: {{ $subscription->starts_at }}</p>
                    <p>Дата окончания: {{ $subscription->ends_at }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
