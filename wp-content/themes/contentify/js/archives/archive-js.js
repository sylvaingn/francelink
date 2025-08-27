document.addEventListener('DOMContentLoaded', () => {
    // Récupération rapide des éléments existants
    const searchInput = document.querySelector('.sorter--wrapper input[type="search"]');
    const newerFilter = document.querySelector('.sorter--selects .newer-posts');
    const olderFilter = document.querySelector('.sorter--selects .older-posts');
    const postsFilters = document.querySelector('.posts--filters');
    const allPostsFilter = postsFilters?.querySelector('[data-all-cat]');
    const catFilters = postsFilters?.querySelectorAll('[data-cat-slug]');
    const postsContainer = document.querySelector('.posts--container'); // conteneur d'articles + pagination

    // État interne
    let order = '';   // 'newer' ou 'older'
    let cats = [];   // Tableau des slugs sélectionnés

    // ------------------------------------------------------------------
    // (A) FONCTION fetchPosts : Effectue l'appel AJAX
    // ------------------------------------------------------------------
    // Compteur global du nombre de requêtes en cours
    let ongoingFetchCount = 0;

// Récupération éventuelle de l'overlay et du container
// (fais-le en dehors pour éviter de chercher dans le DOM à chaque appel)
    const loadingOverlay = document.querySelector('.loading-overlay');

// Helpers pour afficher/masquer l’overlay
    function showLoadingOverlay() {
        ongoingFetchCount++;
        if (loadingOverlay && !loadingOverlay.classList.contains('visible')) {
            loadingOverlay.classList.add('visible');
        }
    }

    function hideLoadingOverlay() {
        // On décrémente uniquement si ongoingFetchCount > 0, au cas où
        ongoingFetchCount = Math.max(0, ongoingFetchCount - 1);

        if (loadingOverlay && ongoingFetchCount === 0) {
            loadingOverlay.classList.remove('visible');
        }
    }

    /**
     * fetchPosts(urlParams)
     * Lance une requête POST vers WP (admin-ajax.php) pour récupérer des actualités,
     * et insère le HTML reçu dans `postsContainer`.
     */
    async function fetchPosts(urlParams) {
        try {
            showLoadingOverlay();

            // Prépare la data (FormData + paramètres)
            const formData = new FormData();
            formData.append('action', 'my_ajax_fetch_actualities');

            // Récupération du nonce et de l’URL via variables globales (myAjaxVars)
            const ajaxNonce = (typeof myAjaxVars !== 'undefined') ? myAjaxVars.ajaxNonce : '';
            const ajaxUrl = (typeof myAjaxVars !== 'undefined') ? myAjaxVars.ajaxUrl : '/wp-admin/admin-ajax.php';
            const postType = (typeof myAjaxVars !== 'undefined') ? myAjaxVars.currentPostType : '';

            formData.append('post_type', postType);
            formData.append('nonce', ajaxNonce);
            formData.append('ajax_action', true);

            // Ajout de chaque paramètre dans le FormData
            for (const [key, val] of urlParams.entries()) {
                formData.append(key, val);
            }

            // Appel AJAX
            const response = await fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                // Gestion d’un éventuel statut HTTP 4xx ou 5xx
                throw new Error(`Erreur HTTP : ${response.status}`);
            }

            // On suppose un retour HTML
            const html = await response.text();

            // Injection du HTML reçu
            if (postsContainer) {
                postsContainer.innerHTML = html;
            }

            // Réattacher la pagination, etc.
            attachPaginationLinks();

        } catch (error) {
            // Gestion d’erreur
            console.error('Erreur AJAX :', error);

        } finally {
            // Qu’il y ait eu succès ou erreur, on décrémente et on masque l’overlay si nécessaire
            hideLoadingOverlay();
        }
    }


    // ------------------------------------------------------------------
    // (B) FONCTION updateURL : Met à jour l'URL, puis fetch
    // ------------------------------------------------------------------
    const updateURL = () => {
        // On part des paramètres actuels
        const p = new URLSearchParams(window.location.search);

        // Recherche
        if (searchInput) {
            const val = searchInput.value.trim();
            val ? p.set('search', val) : p.delete('search');
        }

        // Ordre
        order ? p.set('order', order) : p.delete('order');

        // Catégories multiples
        cats.length ? p.set('cat', cats.join(',')) : p.delete('cat');

        // On remet 'paged' à 1 dès qu'on change un filtre
        p.delete('paged');

        // Mettre à jour l'URL
        window.history.replaceState({}, '', window.location.pathname + '?' + p.toString());

        // Fetch
        fetchPosts(p);
    };

    // ------------------------------------------------------------------
    // (C) LECTURE DES PARAMÈTRES INITIAUX (sans fetch si vide)
    // ------------------------------------------------------------------
    const initialParams = new URLSearchParams(window.location.search);

    // Remplir la barre de recherche si existant
    if (initialParams.has('search') && searchInput) {
        searchInput.value = initialParams.get('search');
    }

    // Ordre
    const paramOrder = initialParams.get('order');
    if (paramOrder === 'newer' || paramOrder === 'older') {
        order = paramOrder;
    }

    // Catégorie(s)
    if (initialParams.has('cat')) {
        cats = initialParams.get('cat').split(',');
        catFilters.forEach(el => {
            if (cats.includes(el.dataset.catSlug)) {
                el.classList.add('active');
            }
        });
        allPostsFilter?.classList.remove('active');
    } else {
        allPostsFilter?.classList.add('active');
    }

    // Vérifier si on a AU MOINS un param
    const hasAnyParam = (
        initialParams.has('search') ||
        initialParams.has('order') ||
        initialParams.has('cat') ||
        initialParams.has('paged')
    );

    // (Si la page arrive SANS param => on ne fetch pas)
    // if (hasAnyParam) {
    //     fetchPosts(initialParams); // On affiche selon l'URL
    // }

    // ------------------------------------------------------------------
    // (D) GESTION DES ÉVÉNEMENTS
    // ------------------------------------------------------------------
    // 1) Barre de recherche
    searchInput?.addEventListener('input', updateURL);

    // 2) Boutons Nouveau / Plus anciens
    newerFilter?.addEventListener('click', e => {
        olderFilter?.classList.remove('active');
        newerFilter.classList.add('active');
        e.preventDefault();
        order = 'newer';
        updateURL();
    });
    olderFilter?.addEventListener('click', e => {
        newerFilter?.classList.remove('active');
        olderFilter.classList.add('active');
        e.preventDefault();
        order = 'older';
        updateURL();
    });

    // 3) Bouton "Toutes"
    allPostsFilter?.addEventListener('click', e => {
        e.preventDefault();
        // On enlève "active" à toutes les catégories
        catFilters.forEach(filter => filter.classList.remove('active'));
        allPostsFilter.classList.add('active');
        cats = [];
        updateURL();
    });

    // 4) Clic sur chaque catégorie => toggle
    catFilters.forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault();
            allPostsFilter?.classList.remove('active');

            el.classList.toggle('active');
            const slug = el.dataset.catSlug;
            const i = cats.indexOf(slug);
            (i === -1) ? cats.push(slug) : cats.splice(i, 1);

            updateURL();
        });
    });

    // ------------------------------------------------------------------
    // (E) INTERCEPTION DES LIENS DE PAGINATION
    // ------------------------------------------------------------------
    attachPaginationLinks();

    function attachPaginationLinks() {
        const paginationLinks = document.querySelectorAll('.ajax-pagination a');

        paginationLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const url = new URL(link.href, window.location.origin);

                // Récupère paramètre 'paged'
                const paged = url.searchParams.get('paged') || '1';

                // On récupère l'URL courante
                const currentParams = new URLSearchParams(window.location.search);
                // Met à jour / ajoute 'paged'
                currentParams.set('paged', paged);

                // Met à jour l'URL
                window.history.replaceState({}, '', window.location.pathname + '?' + currentParams.toString());

                // Fetch
                fetchPosts(currentParams);
            });
        });
    }


    if (window.innerWidth < ContainerMedium) {
        const filterHead = postsFilters?.querySelector('.filters--head');
        const filterItems = postsFilters?.querySelector('.filters--items');

        filterHead?.addEventListener('click', function () {
            if (filterItems.classList.contains('open')) {
                filterItems.classList.remove('open');
                filterItems.style.maxHeight = '0px';
            } else {
                filterItems.classList.add('open');
                filterItems.setAttribute('aria-expanded', 'true');
                filterItems.style.maxHeight = filterItems.scrollHeight + 'px';
            }
        })
    }
});
