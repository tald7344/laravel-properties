import './bootstrap.js';

document.addEventListener('DOMContentLoaded', () => {
    if (document.body.dataset.page === 'admin') {
        import('./admin.js');
        const root = document.documentElement;
        const sidebar = document.querySelector('[data-sidebar-toggle]');
        const setSidebar = (collapsed) => {
            document.body.classList.toggle('sidebar-collapsed', collapsed);
            root.classList.toggle('sidebar-collapsed', collapsed);
            sidebar?.setAttribute('aria-expanded', String(!collapsed));
            sidebar?.setAttribute('aria-label', collapsed ? sidebar.dataset.labelExpand : sidebar.dataset.labelCollapse);
            localStorage.setItem('darak-admin-sidebar', collapsed ? 'collapsed' : 'expanded');
        };
        setSidebar(localStorage.getItem('darak-admin-sidebar') === 'collapsed');
        sidebar?.addEventListener('click', () => setSidebar(!document.body.classList.contains('sidebar-collapsed')));
    }

    const socialRows = document.querySelector('[data-social-links]');
    const socialTemplate = document.querySelector('template[data-social-template]');
    document.querySelector('[data-add-social]')?.addEventListener('click', () => {
        if (!socialRows || !socialTemplate) return;
        const index = Number(socialRows.dataset.nextIndex || 0);
        socialRows.dataset.nextIndex = String(index + 1);
        socialRows.insertAdjacentHTML('beforeend', socialTemplate.innerHTML.replaceAll('__INDEX__', String(index)));
    });
    socialRows?.addEventListener('click', (event) => {
        if (event.target instanceof Element && event.target.closest('[data-remove-social]')) {
            event.target.closest('[data-social-row]')?.remove();
        }
    });
    document.querySelectorAll('[data-confirm]').forEach((form) => form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    }));

    const authViews = document.querySelector('[data-auth-views]');
    if (authViews) {
        const views = [...authViews.querySelectorAll('[data-auth-view]')];
        const showAuthView = (name, updateHash = true) => {
            views.forEach((view) => {
                const active = view.dataset.authView === name;
                view.hidden = !active;
                view.classList.toggle('is-active', active);
                view.setAttribute('aria-hidden', String(!active));
            });
            if (updateHash) history.replaceState({}, '', `${location.pathname}${location.search}#${name}-section`);
        };
        document.querySelectorAll('[data-auth-target]').forEach((link) => link.addEventListener('click', (event) => {
            event.preventDefault();
            showAuthView(link.dataset.authTarget);
        }));
        showAuthView(location.hash === '#signup-section' ? 'signup' : 'login', false);
    }

    const propertySearch = document.querySelector('[data-property-search]');
    if (propertySearch) {
        Promise.all([import('vue'), import('./components/PropertySearch.vue')]).then(([{ createApp }, { default: PropertySearch }]) => {
            const readJson = (name, fallback) => {
                try {
                    return JSON.parse(propertySearch.dataset[name] || '');
                } catch {
                    return fallback;
                }
            };

            createApp(PropertySearch, {
                endpoint: propertySearch.dataset.endpoint,
                listingUrl: propertySearch.dataset.listingUrl,
                cities: readJson('cities', []),
                filters: readJson('filters', {}),
                initial: readJson('initial', { data: [], total: 0, current_page: 1, last_page: 1 }),
                translations: readJson('translations', {}),
                locale: propertySearch.dataset.locale,
            }).mount(propertySearch);
        }).catch((error) => console.error('Could not load property search.', error));
    }

    const revealItems = document.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window && revealItems.length) {
        const observer = new IntersectionObserver((entries, currentObserver) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    currentObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }
});
