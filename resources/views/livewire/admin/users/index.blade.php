<x-admin-layout>
    <div class="container py-4">
        <x-slot name="title">Пользователи и их подписки</x-slot>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Подписки</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse($user->subscriptions as $subscription)
                                <div>
                                    <strong>{{ $subscription->name }}</strong><br>
                                    Статус: {{ $subscription->stripe_status }}<br>
                                    Окончание: {{ optional($subscription->ends_at)->format('d.m.Y') ?? 'Не задана' }}
                                </div>
                            @empty
                                <span class="text-muted">Нет подписок</span>
                            @endforelse
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
