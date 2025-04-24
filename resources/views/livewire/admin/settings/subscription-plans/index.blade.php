<x-admin-layout>
    <div class="container py-4">
        <x-slot name="title">Планы подписки</x-slot>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Добавить план
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Платформа</th>  <!-- Изменено с "Код" на "Платформа" -->
                    <th>Цена</th>
                    <th>Валюта</th>
                    <th>Период (дней)</th>
                    <th>Дата окончания</th>
                    <th>Описание</th>
                    <th class="text-end">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->platform->name }}</td>  <!-- Отображаем платформу -->
                        <td>{{ number_format($plan->price, 2) }}</td>
                        <td>{{ $plan->currency }}</td>
                        <td>{{ $plan->period }} дней</td>
                        <td>{{ $plan->formatted_end_date }}</td>
                        <td>{{ $plan->description }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить этот план?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Планы пока не добавлены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
