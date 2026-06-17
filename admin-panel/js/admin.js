document.addEventListener('DOMContentLoaded', function() {
    // ── Demo Mode Configuration ──────────────────────────────────
    if (document.cookie.indexOf('is_demo=1') !== -1) {
        // Create demo banner
        const demoBanner = document.createElement('div');
        demoBanner.className = 'demo-top-banner';
        demoBanner.innerHTML = `
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:6px;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            This is a demo account. You can see admin only.
        `;
        document.body.insertBefore(demoBanner, document.body.firstChild);

        // Add custom styles for demo banner and disabled state
        const demoStyle = document.createElement('style');
        demoStyle.innerHTML = `
            .demo-top-banner {
                background: #dc2626 !important;
                color: #ffffff !important;
                text-align: center;
                padding: 10px;
                font-size: 14px;
                font-weight: 700;
                width: 100%;
                box-sizing: border-box;
                z-index: 10000;
                position: fixed;
                top: 0;
                left: 0;
                box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                height: 40px;
            }
            body {
                padding-top: 40px !important;
            }
            .sidebar {
                top: 40px !important;
                height: calc(100vh - 40px) !important;
            }
            /* Style buttons to look visually disabled and block clicks */
            button[type="submit"], 
            input[type="submit"],
            .btn:not(#menu-toggle),
            .action-btn.delete-btn,
            .action-btn.edit-btn,
            .table-container .btn,
            .section-title .btn,
            a[href^="edit-video.php"],
            a[href^="delete-video.php"],
            a[href*="delete="],
            a[href*="delete_tag="],
            a[href*="delete_pornstar="] {
                opacity: 0.5 !important;
                cursor: not-allowed !important;
                background: #888888 !important;
                border-color: #888888 !important;
            }
        `;
        document.head.appendChild(demoStyle);
        
        // Prevent all clicks on disabled actions, forms, and inputs to show the disclaimer alert
        document.addEventListener('click', function(e) {
            const target = e.target;
            
            // Check if clicked element or parent is form, input, select, textarea, button or action button
            const isAction = target.closest(
                'button, ' +
                'input, ' +
                'select, ' +
                'textarea, ' +
                '.btn:not(#menu-toggle), ' +
                '.action-btn.delete-btn, ' +
                '.action-btn.edit-btn, ' +
                '.table-container .btn, ' +
                '.section-title .btn, ' +
                'a[href^="edit-video.php"], ' +
                'a[href^="delete-video.php"], ' +
                'a[href*="delete="], ' +
                'a[href*="delete_tag="], ' +
                'a[href*="delete_pornstar="]'
            );
            
            if (isAction) {
                // Exclude theme toggle, menu toggle, and Target Website dropdown (view-only allowed)
                if (
                    target.id === 'menu-toggle' ||
                    target.id === 'scraper_site' ||
                    target.closest('#scraper_site') ||
                    target.classList.contains('theme-toggle-btn') ||
                    target.closest('.theme-toggle-btn') ||
                    target.closest('.menu-toggle')
                ) {
                    return;
                }
                
                e.preventDefault();
                e.stopPropagation();
                alert("This is a demo account. You can see admin only.");
            }
        }, true); // Capture phase

        // Prevent all keydown actions inside inputs to block typing
        document.addEventListener('keydown', function(e) {
            const target = e.target;
            if (target.closest('input, textarea, select') && !target.closest('.theme-toggle-btn') && !target.closest('#menu-toggle')) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true); // Capture phase

        // Mark form elements style as read-only and disabled cursor
        setTimeout(function() {
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(el => {
                // Skip menu toggle, theme toggle, and the Target Website dropdown (readable by demo)
                if (
                    el.id === 'menu-toggle' ||
                    el.id === 'scraper_site' ||
                    el.classList.contains('theme-toggle-btn') ||
                    el.closest('.theme-toggle-btn') ||
                    el.closest('.menu-toggle')
                ) {
                    return;
                }
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.readOnly = true;
                }
                el.style.opacity = '0.6';
                el.style.cursor = 'not-allowed';
                el.title = "This is a demo account. You can see admin only.";
            });
        }, 100);

    }

    if (document.cookie.indexOf('demo_alert=1') !== -1) {
        // Show alert
        alert("Demo Version: Actions/modifications are disabled. You can only view the data.");
        // Expire the cookie
        document.cookie = 'demo_alert=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    // Theme is always dark — no toggle needed.

    // ── Sidebar Enhancements ────────────────────────────────────────
    const sidebar = document.querySelector('.sidebar');
    if (sidebar && !sidebar.dataset.enhanced) {
        sidebar.dataset.enhanced = '1';

        // Sync active nav item from URL
        const currentPage = window.location.pathname.split('/').pop() || 'dashboard.php';
        sidebar.querySelectorAll('.nav-item').forEach(item => {
            const href = item.getAttribute('href');
            if (href === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
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
