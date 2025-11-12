function updatePaginationVisibility(sw) {
    // nombre de "vraies" slides (sans les duplications de loop)
    const totalSlides = sw.slidesEl
        ? sw.slidesEl.querySelectorAll(':scope > .swiper-slide:not(.swiper-slide-duplicate)').length
        : sw.slides.length;
    // nombre de pages (snap points) => c’est ce que Swiper utilise pour les bullets
    const pages = Array.isArray(sw.snapGrid) ? sw.snapGrid.length : 0;

    // 1) règle générale: s'il n'y a qu'UNE page, on cache
    // 2) en plus, si slidesPerView est un nombre et que totalSlides <= slidesPerView, on cache
    const numericSPV = Number.isFinite(sw.params.slidesPerView) ? sw.params.slidesPerView : null;
    const shouldHide = pages <= 1 || (numericSPV !== null && totalSlides <= numericSPV);

    sw.el.classList.toggle('swiper-navigation-disabled', shouldHide);
}

document.addEventListener('DOMContentLoaded', function () {
    const quoteBlocks = document.querySelectorAll('.block--quote');
    if (quoteBlocks.length === 0) return;

    quoteBlocks.forEach(block => {
        const swiperEl = block.querySelector('.swiper');
        if (!swiperEl) return;

        new Swiper(swiperEl, {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            pagination: {
                el: block.querySelector('.swiper-pagination'),
                clickable: true,
            },
            on: {
                init: (swiper) => {
                    updatePaginationVisibility(swiper);
                }
            },
            breakpoints: {
                576: {
                    slidesPerView: 2
                },
                1040: {
                    slidesPerView: 3
                }
            }
        });
    });
});