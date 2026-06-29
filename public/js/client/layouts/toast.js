function showToast(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const maxToasts = 5;
    const currentToasts = container.querySelectorAll('.toast-item');
    if (currentToasts.length >= maxToasts) {
        currentToasts[0].remove();
    }

    const toast = document.createElement('div');
    toast.className = `toast-item toast-${type}`;
    
    const icons = {
        success: 'check_circle',
        error: 'error',
        warning: 'warning',
        waiting: 'sync'
    };
    
    toast.innerHTML = `
        <span class="material-symbols-outlined toast-icon">${icons[type] || 'info'}</span>
        <span class="toast-message" style="flex: 1; line-height: 1.4;">${message}</span>
        <button class="toast-close" onclick="this.parentElement.style.animation = 'toastSlideOut 0.3s ease-in forwards'; setTimeout(() => this.parentElement.remove(), 300)">
            <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
        </button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'toastSlideOut 0.3s ease-in forwards';
            setTimeout(() => toast.remove(), 300);
        }
    }, 4000);
}
