document.addEventListener('DOMContentLoaded', function () {
    const reinsuranceBlocks = document.querySelectorAll('.reinsurances-block');

    reinsuranceBlocks?.forEach((block) => {
        const reinsuranceItems = block.querySelectorAll('.reinsurance--item');

        if (reinsuranceItems == null) return;

        ScrollTrigger.create({
            trigger: block,
            start: 'center bottom',
            once: true,
            onEnter: () => {
                reinsuranceItems.forEach((item, index) => {
                    setTimeout(function () {
                        gsap.to(item, {
                            x: 0,
                            opacity: 1,
                            duration: 1,
                            ease: "maTransition"
                        })
                    }, index * 100)
                })
            }
        })
    })
    if (window.innerWidth < ContainerSmall) {
        let swiperReinsurance = new Swiper('.reinsurances--items', {
            slidesPerView: 1,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            }
        })
    }
})