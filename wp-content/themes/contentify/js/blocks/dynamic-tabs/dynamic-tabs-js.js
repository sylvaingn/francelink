document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.dynamic-tabs-block');

    blocks?.forEach(block => {
        const titlesContainer = block.querySelector('.missions-tabs--titles');
        const contentsContainer = block.querySelector('.missions-tabs--content');

        if (!titlesContainer || !contentsContainer) return;

        // On transforme en tableaux pour pouvoir utiliser indexOf etc.
        const titles = Array.from(titlesContainer.querySelectorAll('.title'));
        const contents = Array.from(contentsContainer.querySelectorAll('.dynamic-tab--item'));

        // Initialisation des états CSS via GSAP.set
        contents.forEach((content, i) => {
            const img = content.querySelector('.missions-text-img-img');
            const txt = content.querySelector('.missions-text-img-text');

            if (i === 0) {
                ScrollTrigger.create({
                    trigger: block,
                    start: "center bottom",
                    once: true,
                    onEnter: () => {
                        titles[i].classList.add('active');
                        content.classList.add('active');
                        gsap.to(img, {duration: 0.6, opacity: 1, x: 0, ease: 'power2.out'});
                        gsap.to(txt, {duration: 0.6, opacity: 1, x: 0, ease: 'power2.out', stagger: 0.04});
                    }
                })
            }

        });

        titlesContainer.setAttribute('role', 'tablist');
        titles.forEach((title, idx) => {
            title.setAttribute('role', 'tab');
            title.setAttribute('aria-selected', idx === 0);
            title.setAttribute('tabindex', idx === 0 ? '0' : '-1');
        });

        // Gestion du clic (et entrée clavier si besoin)
        titles.forEach((title, idx) => {
            const onSelect = () => {
                const prevIdx = titles.findIndex(t => t.classList.contains('active'));
                if (prevIdx === idx) return;

                const prevTitle = titles[prevIdx];
                const prevContent = contents[prevIdx];
                const newContent = contents[idx];

                // Désactivation de l’onglet précédent
                prevTitle.classList.remove('active');
                prevTitle.setAttribute('aria-selected', 'false');
                prevTitle.setAttribute('tabindex', '-1');
                prevContent.classList.remove('active');

                // Activation du nouvel onglet
                title.classList.add('active');
                title.setAttribute('aria-selected', 'true');
                title.setAttribute('tabindex', '0');
                newContent.classList.add('active');
                title.focus();

                // Refraîchissement ScrollTrigger (si vous avez des animations liées au scroll)
                ScrollTrigger.refresh();

                // Animation sortie / entrée
                const prevImg = prevContent.querySelector('.missions-text-img-img');
                const prevTxt = prevContent.querySelector('.missions-text-img-text');
                const newImg = newContent.querySelector('.missions-text-img-img');
                const newTxt = newContent.querySelector('.missions-text-img-text');

                const tl = gsap.timeline();
                tl
                    // Masquer l’ancien
                    .to([prevImg, prevTxt], {
                        duration: 0.4,
                        opacity: 0,
                        x: i => i === 0 ? -100 : 100,
                        stagger: 0.02,
                        ease: 'power2.in'
                    })
                    // Afficher le nouveau
                    .fromTo(newImg,
                        {opacity: 0, x: -100},
                        {duration: 0.6, opacity: 1, x: 0, ease: 'power2.out'},
                        '-=0.2'
                    )
                    .fromTo(newTxt,
                        {opacity: 0, x: 100},
                        {duration: 0.6, opacity: 1, x: 0, ease: 'power2.out', stagger: 0.04},
                        '-=0.4'
                    );
            };

            title.addEventListener('click', onSelect);
        });
    });
});