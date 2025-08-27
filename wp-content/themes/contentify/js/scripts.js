let overlayFinished = false;

window.createGuardedScrollTrigger = function createGuardedScrollTrigger(vars) {
    const {
        onEnter, onLeave, onEnterBack, onLeaveBack,
        ...restVars
    } = vars;

    return ScrollTrigger.create({
        ...restVars,

        // onEnter “guardé”
        onEnter(self) {
            if (!overlayFinished) return;
            onEnter?.(self);
        },
        onLeave(self) {
            if (!overlayFinished) return;
            onLeave?.(self);
        },
        onEnterBack(self) {
            if (!overlayFinished) return;
            onEnterBack?.(self);
        },
        onLeaveBack(self) {
            if (!overlayFinished) return;
            onLeaveBack?.(self);
        },
        onRefresh(self) {
            if (overlayFinished && self.isActive && onEnter) {
                onEnter(self);
            }
        }
    });
}

window.getCoords = function getCoords(elem, inHeader) { // crossbrowser version
    const masthead = document.querySelector('#masthead');

    if (masthead !== null && elem !== null) {
        const box = elem.getBoundingClientRect();

        const body = document.body;
        const docEl = document.documentElement;

        const scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
        const scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

        const clientTop = docEl.clientTop || body.clientTop || 0;
        const clientLeft = docEl.clientLeft || body.clientLeft || 0;

        let top;
        if (inHeader) {
            top = box.top + scrollTop - clientTop;
        } else {
            top = box.top + scrollTop - clientTop - masthead.offsetHeight;
        }

        const left = box.left + scrollLeft - clientLeft;

        return {top: Math.round(top), left: Math.round(left)};
    }
}

window.addEventListener('resize', function () {
    ScrollTrigger.refresh();
})

document.addEventListener('DOMContentLoaded', function () {
    const wpadminbar = document.querySelector('#wpadminbar');

    const resizeObserver = new ResizeObserver(entries =>
        ScrollTrigger.refresh()
    )

    resizeObserver.observe(document.body)

    const masthead = document.querySelector('#masthead');
    const burger = masthead?.querySelector('.menu-burger');
    const mastheadMobile = masthead?.querySelector('#masthead--burger');
    const hasChildrenEls = masthead?.querySelectorAll('.menu-item-has-children');


    burger?.addEventListener('click', function (e) {
        mastheadMobile.classList.toggle('active');
        mastheadMobile.style.maxHeight = window.innerHeight - wpadminbar?.offsetHeight - masthead?.offsetHeight + 'px';
        // document.querySelector('html')?.classList.add('no-scroll');
        burger.classList.toggle('is-active'); // juste pour la couleur, facultatif
    });

    document.addEventListener('click', function (e) {
        if (!burger.contains(e.target) && !mastheadMobile.contains(e.target)) {
            mastheadMobile.classList.remove('active');
            // document.querySelector('html')?.classList.remove('no-scroll');
        }
    });

    hasChildrenEls?.forEach((el) => {
        const subMenu = el.querySelector('.sub-menu');
        el.addEventListener('click', function () {
            gsap.to(subMenu, {
                maxHeight: el.classList.contains('open') ? 0 : subMenu.scrollHeight
            })
            el.classList.toggle('open');
        })
    })

    // Prefetch

    const prefetched_links = document.querySelectorAll('a.prefetched');

    prefetched_links?.forEach((link) => {
        link.addEventListener('mouseenter', function () {
            const tag = document.createElement('link');
            tag.rel = 'prefetch';
            tag.href = link.href;

            document.body.appendChild(tag);
        }, {once: true})
    })

    // Lazy loading
    let lazyContainer = document.querySelectorAll('.lazy-img-container');

    if (lazyContainer.length > 0) {
        lazyContainer.forEach((container) => {
            const loadingScroll = createGuardedScrollTrigger({
                trigger: container,
                start: `top +=${window.innerHeight * 0.8}`,
                once: true,
                onEnter: () => {
                    container.classList.add('lazy-img-container-loaded');
                    const img = container.querySelector('img[data-src]');

                    if (img !== null) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                }
            });
        });
    }
})

