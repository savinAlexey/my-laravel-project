<div class="container py-4">
    <h2 class="mb-4">{{ $planId ? 'Редактировать подписку' : 'Создать подписку' }}</h2>

    <form wire:submit.prevent="save">
        <div class="form-group mb-3">
            <label for="name">Название подписки</label>
            <input type="text" id="name" class="form-control" wire:model.defer="name" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="platform_id">Платформа</label>
            <select id="platform_id" class="form-control" wire:model.defer="platform_id" required>
                <option value="">-- выберите --</option>
                @foreach($platforms as $platform)
                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
            </select>
            @error('platform_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="price">Цена</label>
            <input type="number" id="price" class="form-control" wire:model.defer="price" required>
            @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="currency">Валюта</label>
            <input type="text" id="currency" class="form-control" wire:model.defer="currency" required>
            @error('currency') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="period">Период (в днях)</label>
            <input type="number" id="period" class="form-control" wire:model.defer="period" required>
            @error('period') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-4">
            <label for="description">Описание</label>
            <textarea id="description" class="form-control" wire:model.defer="description"></textarea>
            @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
