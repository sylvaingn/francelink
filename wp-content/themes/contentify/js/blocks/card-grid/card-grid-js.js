import Masonry from 'masonry-layout';

document.addEventListener('DOMContentLoaded', function () {
    const elem = document.querySelector('.card-list--wrapper.layout-text_image_cards');

    if (elem !== null) {
        const elem_variables = getComputedStyle(elem);
        const gap = elem_variables.getPropertyValue('--gap').replace('px', '');

        const msnry = new Masonry(elem, {
            itemSelector: '.text-image-card',
            columnWidth: '.text-image-card',
            percentPosition: true,
            gutter: parseInt(gap)
        });
    }
});