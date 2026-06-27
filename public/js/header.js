function showToast(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const maxToasts = 5;
    const currentToasts = container.querySelectorAll('.toast');
    if (currentToasts.length >= maxToasts) {
        currentToasts[0].remove();
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const iconName = type === 'success' ? 'check_circle' : 'error';
    toast.innerHTML = `
        <span class="material-symbols-outlined toast-icon">${iconName}</span>
        <span class="toast-message">${message}</span>
        <button class="btn-toast-close" onclick="this.parentElement.remove()">
            <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
        </button>
    `;

    container.appendChild(toast);

    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 10);

    // Remove after 4 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

document.addEventListener('DOMContentLoaded', function() {
    const hamburgerBtn = document.getElementById('btn-hamburger');
    const closeBtn = document.getElementById('btn-close-drawer');
    const overlay = document.getElementById('drawer-overlay');
    const drawer = document.getElementById('mobile-drawer');

    if (hamburgerBtn && drawer) {
        hamburgerBtn.addEventListener('click', function() {
            drawer.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        const closeDrawer = function() {
            drawer.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);
    }
});
