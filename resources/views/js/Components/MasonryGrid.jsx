import Masonry from 'react-fast-masonry';
import { useEffect } from 'react';

export default function MasonryGrid({ products, hasMore, onLoadMore }) {
    // Автоподгрузка при скролле
    useEffect(() => {
        const handleScroll = () => {
            if (!hasMore) return;

            const { scrollTop, clientHeight, scrollHeight } = document.documentElement;
            if (scrollTop + clientHeight >= scrollHeight - 300) {
                onLoadMore();
            }
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, [hasMore, onLoadMore]);

    return (
        <div className="masonry-container">
            <Masonry
                columns={{ 1200: 4, 800: 3, 500: 2, 0: 1 }}
                gutter="16px"
                items={products}
                renderItem={(item) => (
                    <div key={item.id} className="masonry-item">
                        <div className="bg-white rounded-lg overflow-hidden shadow hover:shadow-md transition-shadow">
                            <img
                                src={item.image}
                                alt=""
                                className="w-full h-auto object-cover"
                                loading="lazy"
                            />
                            {item.icon && (
                                <div className="p-2 flex items-center">
                                    <img
                                        src={item.icon}
                                        className="w-8 h-8 rounded-full mr-2"
                                        alt=""
                                    />
                                </div>
                            )}
                        </div>
                    </div>
                )}
            />

            {hasMore && (
                <div className="text-center py-4">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                </div>
            )}
        </div>
    );
}
