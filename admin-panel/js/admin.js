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

    // ── Sidebar Responsive Drawer Toggle ─────────────────────────
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
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
