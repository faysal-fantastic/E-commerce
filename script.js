document.addEventListener('DOMContentLoaded', () => {
    // Scroll Animation using IntersectionObserver
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Animate only once
            }
        });
    }, observerOptions);

    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    animatedElements.forEach(el => observer.observe(el));

    // Copy to Clipboard Functionality
    const copyButtons = document.querySelectorAll('.copy-btn');
    copyButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const textToCopy = btn.getAttribute('data-clipboard-text');

            navigator.clipboard.writeText(textToCopy).then(() => {
                const originalText = btn.innerText;
                btn.innerText = 'Copied!';
                btn.classList.add('copied');

                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.classList.remove('copied');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });
    });
});
