<div class="container py-4">
    @if(session('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif


            @if($showAdminForm)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-light">
                        <h5>Настройки Swego Admin</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="cookie" class="form-label">Cookie:</label>
                            <textarea wire:model="adminSettings.cookie"
                                      id="cookie"
                                      class="form-control bg-dark text-light border-secondary @error('adminSettings.cookie') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Введите cookie"></textarea>
                            @error('adminSettings.cookie')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="adminAlbumId" class="form-label">ID Альбома:</label>
                            <input type="text"
                                   wire:model="adminSettings.album_id"
                                   id="adminAlbumId"
                                   class="form-control bg-dark text-light border-secondary @error('adminSettings.album_id') is-invalid @enderror"
                                   placeholder="Введите ID альбома">
                            @error('adminSettings.album_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="adminShopName" class="form-label">Название магазина:</label>
                            <input type="text"
                                   wire:model="adminSettings.shop_name"
                                   id="adminShopName"
                                   class="form-control bg-dark text-light border-secondary @error('adminSettings.shop_name') is-invalid @enderror"
                                   placeholder="Введите название магазина">
                            @error('adminSettings.shop_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            @if($showUrlForm)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-light">
                        <h5>Настройки Swego URL</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="url" class="form-label">URL:</label>
                            <input type="url"
                                   wire:model="urlSettings.url"
                                   id="url"
                                   class="form-control bg-dark text-light border-secondary @error('urlSettings.url') is-invalid @enderror"
                                   placeholder="https://example.swego.com">
                            @error('urlSettings.url')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="urlAlbumId" class="form-label">ID Альбома:</label>
                            <input type="text"
                                   wire:model="urlSettings.album_id"
                                   id="urlAlbumId"
                                   class="form-control bg-dark text-light border-secondary @error('urlSettings.album_id') is-invalid @enderror"
                                   placeholder="Введите ID альбома">
                            @error('urlSettings.album_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="urlShopName" class="form-label">Название магазина:</label>
                            <input type="text"
                                   wire:model="urlSettings.shop_name"
                                   id="urlShopName"
                                   class="form-control bg-dark text-light border-secondary @error('urlSettings.shop_name') is-invalid @enderror"
                                   placeholder="Введите название магазина">
                            @error('urlSettings.shop_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            <button wire:click="save"
                    wire:loading.attr="disabled"
                    class="btn btn-primary">
                <span wire:loading.class="d-none">Сохранить все настройки</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm" role="status"></span>
                    Сохранение...
                </span>
            </button>

</div>
