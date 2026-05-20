/**
 * EduPath - Client-side interactions
 */

(function () {
    'use strict';

    // === Mobile menu toggle ===
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navMenu = document.querySelector('.navbar-nav');
    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('mobile-open');
        });
    }

    // === Notification panel toggle ===
    const notifBell = document.querySelector('.notif-bell');
    const notifPanel = document.querySelector('.notif-panel');
    if (notifBell && notifPanel) {
        notifBell.addEventListener('click', (e) => {
            e.stopPropagation();
            notifPanel.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!notifPanel.contains(e.target) && !notifBell.contains(e.target)) {
                notifPanel.classList.remove('show');
            }
        });
    }

    // === Mark individual notification as read on click ===
    document.querySelectorAll('.notif-item').forEach(item => {
        item.addEventListener('click', async () => {
            const id = item.dataset.id;
            const link = item.dataset.link;
            if (id && item.classList.contains('unread')) {
                const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
                try {
                    await fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-Token': token,
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `_csrf_token=${encodeURIComponent(token)}`,
                    });
                    item.classList.remove('unread');
                    // Decrement badge
                    const badge = document.querySelector('.notif-badge');
                    if (badge) {
                        const n = parseInt(badge.textContent, 10) - 1;
                        if (n <= 0) badge.remove();
                        else badge.textContent = n;
                    }
                } catch (e) {}
            }
            if (link) window.location.href = link;
        });
    });

    // === Success popup (iOS-inspired with shake) ===
    window.showSuccessPopup = function (title, message) {
        const overlay = document.getElementById('success-popup');
        if (!overlay) return;
        if (title) overlay.querySelector('.success-title').textContent = title;
        if (message) overlay.querySelector('.success-msg').textContent = message;
        overlay.classList.add('show');
        // Optional: subtle haptic-like feedback
        if (navigator.vibrate) navigator.vibrate(30);
    };

    window.hideSuccessPopup = function () {
        const overlay = document.getElementById('success-popup');
        if (overlay) overlay.classList.remove('show');
    };

    // Auto-show if flag set
    if (window.__showSuccessPopup) {
        setTimeout(() => showSuccessPopup(), 200);
    }

    // === Animate progress bars ===
    document.querySelectorAll('.progress-fill').forEach(el => {
        const target = el.dataset.progress || '0';
        el.style.width = '0%';
        setTimeout(() => { el.style.width = target + '%'; }, 100);
    });

    // === Save / unsave toggles ===
    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const url = btn.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `_csrf_token=${encodeURIComponent(token)}`,
                });
                const data = await res.json();
                btn.classList.toggle('active', !!data.saved);
                btn.innerHTML = data.saved ? '★ Saved' : '☆ Save';
            } catch (e) {
                console.error(e);
            }
        });
    });

    // === Smooth scroll ===
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // === Subtle fade-in on scroll for cards ===
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card, .list-card, .prof-card, .step').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(el);
        });
    }

    // === Confirm logout ===
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });
})();
