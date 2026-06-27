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
