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
            sidebar?.setAttribute('aria-label', collapsed ? 'توسيع القائمة' : 'طي القائمة');
            localStorage.setItem('darak-admin-sidebar', collapsed ? 'collapsed' : 'expanded');
        };
        setSidebar(localStorage.getItem('darak-admin-sidebar') === 'collapsed');
        sidebar?.addEventListener('click', () => setSidebar(!document.body.classList.contains('sidebar-collapsed')));
    }
    document.querySelectorAll('[data-confirm]').forEach((form) => form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    }));
});
