document.addEventListener('DOMContentLoaded', () => {
    // Add micro-animation for cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Simple form validation confirmation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = 'Odesílám...';
                btn.style.opacity = '0.7';
                btn.disabled = true;
                // Allow the form to actually submit
            }
        });
    });
});
