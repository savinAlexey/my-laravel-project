const toggleBtn = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('mainContent');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('show');
    content.classList.toggle('shifted');
});

document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 992) {
            sidebar.classList.remove('show');
            content.classList.remove('shifted');
        }
    });
});

// Функция для показа модалки
function showSwegoModal() {
    const modal = document.getElementById('swegoModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Блокируем скролл страницы
    } else {
        console.error('Модальное окно не найдено!');
    }
}

// Функция для скрытия модалки
function hideModal() {
    const modal = document.getElementById('swegoModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = ''; // Восстанавливаем скролл
    }
}

// Делаем функции глобально доступными
window.showSwegoModal = showSwegoModal;
window.hideModal = hideModal;

// Закрытие по ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideModal();
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Обработка клика по вариантам доступа
    document.querySelectorAll('.swego-option').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const type = this.dataset.type;

            // Можно добавить AJAX-проверку перед переходом
            fetch('/account/check-swego-access', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type: type })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.has_access) {
                        window.location.href = this.href;
                    } else {
                        alert('Доступ запрещен');
                        // Или показать красивый toast
                    }
                })
                .catch(() => {
                    // В случае ошибки просто переходим
                    window.location.href = this.href;
                });
        });
    });
});




