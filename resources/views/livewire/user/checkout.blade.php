<div class="container py-4">
    <h2 class="mb-4">Оформление подписки</h2>
    <p>Платформа: <strong>{{ $plan->platform->name }}</strong></p>
    <p>Цена: <strong>{{ number_format($plan->price, 2) }} ₽</strong></p>

    <form method="POST" action="{{ route('account.payment.create') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <button type="submit" class="btn btn-success">Оплатить</button>
    </form>
</div>
