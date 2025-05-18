<div>
    <div id="masonry-container"></div>

    @push('scripts')
        <script>
            // 1. Передаем данные через JSON-encoded строку
            const masonryData = JSON.parse('{!! json_encode($products) !!}');
            const masonryHasMore = {!! json_encode(!empty($nextTimestamp)) !!};
        </script>
        <script type="module">
            import { createRoot } from 'react-dom/client';
            import MasonryGrid from '../../js/Components/MasonryGrid';

            const container = document.getElementById('masonry-container');

            if (container) {
                const root = createRoot(container);

                // 2. Используем данные из глобальной переменной
                root.render(
                    <MasonryGrid
                        products={window.masonryData}
                        hasMore={window.masonryHasMore}
                        onLoadMore={() => window.Livewire.dispatch('loadMore')}
                    />
                );

                // 3. Обновление при изменении данных
                Livewire.on('productsUpdated', () => {
                    window.masonryData = JSON.parse('{!! json_encode($products) !!}');
                    window.masonryHasMore = {!! json_encode(!empty($nextTimestamp)) !!};
                    root.render(
                        <MasonryGrid
                            products={window.masonryData}
                            hasMore={window.masonryHasMore}
                            onLoadMore={() => window.Livewire.dispatch('loadMore')}
                        />
                    );
                });
            }
        </script>
    @endpush
</div>




