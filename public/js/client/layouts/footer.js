document.addEventListener('DOMContentLoaded', function () {
    // --- 1. Back to Top Button Logic ---
    const backToTopBtn = document.getElementById('btn-back-to-top');

    if (backToTopBtn) {
        // Toggle visibility based on scroll position
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        // Scroll smoothly to top on click
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // --- 2. Newsletter Subscription Validation ---
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterInput = document.getElementById('newsletter-email');

    if (newsletterForm && newsletterInput) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const emailValue = newsletterInput.value.trim();

            // Simple Email Regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailValue === '') {
                if (typeof showToast === 'function') {
                    showToast('Vui lòng nhập địa chỉ email của bạn.', 'error');
                } else {
                    alert('Vui lòng nhập địa chỉ email của bạn.');
                }
                return;
            }

            if (!emailRegex.test(emailValue)) {
                if (typeof showToast === 'function') {
                    showToast('Địa chỉ email không hợp lệ. Vui lòng thử lại.', 'error');
                } else {
                    alert('Địa chỉ email không hợp lệ.');
                }
                return;
            }

            // If valid, show success toast and clear input
            if (typeof showToast === 'function') {
                showToast('Đăng ký nhận bản tin thành công! Cảm ơn bạn.', 'success');
            } else {
                alert('Đăng ký nhận bản tin thành công!');
            }
            newsletterInput.value = '';
        });
    }
});
