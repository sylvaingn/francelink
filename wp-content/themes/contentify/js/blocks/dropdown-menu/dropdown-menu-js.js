document.addEventListener('DOMContentLoaded', function () {
    const headers = document.querySelectorAll('.header--dropdown-menu-item');

    headers.forEach(header => {
        const content = header.nextElementSibling;

        header.addEventListener('click', () => {
            const isOpen = content.classList.contains('open');

            headers.forEach(header => {
                const c = header.nextElementSibling;
                c.style.height = '0px';
                c.classList.remove('open');
                header.classList.remove('open');
            });

            const paddingBottom = 30;

            if (!isOpen) {
                const fullHeight = (content.scrollHeight + paddingBottom) + 'px';
                content.style.height = fullHeight;
                content.classList.add('open');
                header.classList.add('open');
            }
        });
    });
});
