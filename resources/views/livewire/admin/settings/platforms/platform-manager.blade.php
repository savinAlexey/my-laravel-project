<div class="container py-4">
    <h2 class="mb-4">Управление платформами</h2>

    <form wire:submit.prevent="save" class="mb-4">
        <div class="mb-2">
            <input type="text" wire:model.defer="name" placeholder="Название" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-2">
            <input type="text" wire:model.defer="code" placeholder="Код (латиница)" class="form-control">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-2">
            <textarea wire:model.defer="description" placeholder="Описание" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">{{ $editingId ? 'Сохранить изменения' : 'Добавить' }}</button>
    </form>

    <table class="table table-dark table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Код</th>
            <th>Описание</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($platforms as $platform)
            <tr>
                <td>{{ $platform->name }}</td>
                <td>{{ $platform->code }}</td>
                <td>{{ $platform->description }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-light" wire:click="edit({{ $platform->id }})">Редактировать</button>
                    <button class="btn btn-sm btn-outline-danger" wire:click="delete({{ $platform->id }})">Удалить</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

