<div class="container py-4">
    <h2>Выберите план подписки</h2>

    @foreach($plans as $plan)
        <div class="plan-card">
            <h3>{{ $plan->name }}</h3>
            <p>{{ $plan->description }}</p>
            <p>Цена: {{ $plan->price }} {{ $plan->currency }}</p>
            <button wire:click="buySubscription({{ $plan->id }})">Подписаться</button>
        </div>
    @endforeach
</div>
