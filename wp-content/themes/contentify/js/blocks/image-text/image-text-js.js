document.addEventListener("DOMContentLoaded", function () {
    const imageTextBlocks = document.querySelectorAll(".image-text-block");

    imageTextBlocks?.forEach((block) => {
        const listContainers = block.querySelectorAll("ul");

        listContainers?.forEach((listContainer) => {
            const listItems = listContainer?.querySelectorAll("li");

            if (listItems == null) return;

            ScrollTrigger.create({
                trigger: listContainer,
                start: "top bottom",
                once: true,
                onEnter: () => {
                    listItems.forEach((item, index) => {
                        setTimeout(function () {
                            gsap.to(item, {
                                x: 0,
                                opacity: 1,
                                ease: "maTransition",
                            });
                        }, index * 80);
                    });
                },
            });
        });
    });
});
