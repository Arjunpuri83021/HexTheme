document.addEventListener('DOMContentLoaded', function() {
    // ── Theme Switcher Configuration & Injection ────────────────
    const currentTheme = localStorage.getItem('admin-theme') || 'light';
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-theme');
    }

    const header = document.querySelector('.header');
    if (header) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'theme-toggle-btn';
        toggleBtn.setAttribute('type', 'button');
        toggleBtn.setAttribute('title', 'Toggle Light/Dark Mode');
        
        const isDark = document.body.classList.contains('dark-theme');
        toggleBtn.innerHTML = `
            <svg class="sun-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="${isDark ? 'display:block;' : 'display:none;'}">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <svg class="moon-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="${isDark ? 'display:none;' : 'display:block;'}">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        `;

        const logoutBtn = header.querySelector('.logout-btn');
        if (logoutBtn) {
            header.insertBefore(toggleBtn, logoutBtn);
        } else {
            header.appendChild(toggleBtn);
        }

        toggleBtn.addEventListener('click', function() {
            const body = document.body;
            body.classList.toggle('dark-theme');
            const darkActive = body.classList.contains('dark-theme');
            localStorage.setItem('admin-theme', darkActive ? 'dark' : 'light');

            const sunIcon = toggleBtn.querySelector('.sun-icon');
            const moonIcon = toggleBtn.querySelector('.moon-icon');
            if (darkActive) {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        });
    }

    // ── Dandelion Pro Sidebar Enhancements ────────────────────────
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        // 1. Inject User Profile Card
        const logo = sidebar.querySelector('.sidebar-logo');
        if (logo && !sidebar.querySelector('.sidebar-user')) {
            const userCard = document.createElement('div');
            userCard.className = 'sidebar-user';
            userCard.innerHTML = `
                <img src="https://secure.gravatar.com/avatar/d5e2e28cf692b72cfd8cc124d5e2e28c?s=96&d=mm&r=g" class="user-avatar" alt="User Avatar">
                <div class="user-name">Admin User</div>
                <div class="user-status"><span class="status-dot"></span> Online</div>
            `;
            logo.parentNode.insertBefore(userCard, logo.nextSibling);
        }

        // 2. Map SVGs to Menu Items and Inject Section Headers
        if (!sidebar.querySelector('a[href="ads.php"]')) {
            const adsLink = document.createElement('a');
            adsLink.href = 'ads.php';
            adsLink.className = 'nav-item';
            if (window.location.pathname.endsWith('ads.php')) {
                adsLink.classList.add('active');
            }
            adsLink.innerHTML = `<span>Ad Network</span>`;
            const scraperLink = sidebar.querySelector('a[href="scraper.php"]');
            if (scraperLink) {
                scraperLink.parentNode.insertBefore(adsLink, scraperLink);
            }
        }

        const navItems = sidebar.querySelectorAll('.nav-item');
        const icons = {
            'dashboard.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>`,
            'videos.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>`,
            'add-video.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>`,
            'categories.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>`,
            'tags.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>`,
            'pornstars.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`,
            'scraper.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>`,
            'ads.php': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>`
        };

        navItems.forEach(item => {
            const href = item.getAttribute('href');
            // Prepend matching SVG
            if (icons[href] && !item.querySelector('svg')) {
                item.insertAdjacentHTML('afterbegin', icons[href]);
            }

            // Insert Section Headers
            if (href === 'dashboard.php') {
                const headerDiv = document.createElement('div');
                headerDiv.className = 'menu-section-header';
                headerDiv.textContent = 'Dashboard';
                item.parentNode.insertBefore(headerDiv, item);
            } else if (href === 'videos.php') {
                const headerDiv = document.createElement('div');
                headerDiv.className = 'menu-section-header';
                headerDiv.textContent = 'Content Management';
                item.parentNode.insertBefore(headerDiv, item);
            } else if (href === 'scraper.php') {
                const headerDiv = document.createElement('div');
                headerDiv.className = 'menu-section-header';
                headerDiv.textContent = 'Tools';
                item.parentNode.insertBefore(headerDiv, item);
            }
        });
    }

    // ── Scraper Live Metrics Cards Vector Icons Injection ─────────
    const scraperCards = {
        'c-total': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>`,
        'c-done': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`,
        'c-skipped': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 4 15 12 5 20 5 4"></polygon><line x1="19" y1="5" x2="19" y2="19"></line></svg>`,
        'c-errors': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`,
        'c-remain': `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>`
    };

    Object.keys(scraperCards).forEach(className => {
        const card = document.querySelector(`.prog-card.${className}`);
        if (card && !card.querySelector('svg')) {
            card.insertAdjacentHTML('beforeend', scraperCards[className]);
        }
    });

    // ── Sidebar Responsive Drawer Toggle ─────────────────────────
    const menuToggle = document.getElementById('menu-toggle');
    if (menuToggle && sidebar) {
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
        }
        
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    }
});
