<x-admin-layout>
    <x-slot name="title">Редактировать подписку</x-slot>
    @livewire('admin.settings.subscription-plans.form', ['plan' => $plan])
</x-admin-layout>
