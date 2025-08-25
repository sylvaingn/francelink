document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.posts-slider-block .posts-slider--slider').forEach(postsSlider => {
        const isFullCard = postsSlider.classList.contains('full_card');
        const swiperEl = postsSlider.querySelector('.swiper');

        const swiperPagination = postsSlider.querySelector('.posts-slider-pagination');
        const pagination = swiperPagination.querySelector('.swiper-pagination');
        const next = swiperPagination.querySelector('.swiper-button-next');
        const prev = swiperPagination.querySelector('.swiper-button-prev');

        new Swiper(swiperEl, {
            slidesPerView: isFullCard ? 1 : 1.2,
            spaceBetween: isFullCard ? 0 : 20,
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
                disableOnInteraction: false
            },
            pagination: {el: pagination, clickable: true},
            navigation: {nextEl: next, prevEl: prev},
            breakpoints: {
                740: {
                    slidesPerView: isFullCard ? 1 : 2.2
                },
                1120: {
                    slidesPerView: isFullCard ? 1 : 4
                }
            },
            on: {
                init: swiper => {
                    if (swiper.slides.length <= swiper.params.slidesPerView) {
                        swiper.el.classList.add('swiper-navigation-disabled');
                    }
                }
            }
        });
    });
});
