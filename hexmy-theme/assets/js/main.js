/**
 * Hexmy Theme JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Header scroll effect
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const searchToggle = document.getElementById('search-toggle');
    const mobileSearchDropdown = document.getElementById('mobile-search-dropdown');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            this.classList.toggle('active');
            
            // Close mobile search dropdown if open
            if (mobileSearchDropdown && mobileSearchDropdown.classList.contains('active')) {
                mobileSearchDropdown.classList.remove('active');
                if (searchToggle) searchToggle.classList.remove('active');
            }
        });
    }

    // Mobile Search Dropdown Toggle
    if (searchToggle && mobileSearchDropdown) {
        searchToggle.addEventListener('click', function() {
            mobileSearchDropdown.classList.toggle('active');
            this.classList.toggle('active');
            
            // Close mobile menu if open
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                if (menuToggle) menuToggle.classList.remove('active');
            }
        });
    }
    
    // Autocomplete Search Suggestions (dynamic tags and pornstars)
    const desktopInput = document.getElementById('search-input');
    const mobileInput = document.getElementById('mobile-search-input');
    const desktopDropdown = document.getElementById('search-suggestions');
    const mobileDropdown = document.getElementById('mobile-search-suggestions');
    
    let searchTimeout;

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function highlightQuery(name, query) {
        if (!query) return name;
        const escaped = escapeRegExp(query);
        const regex = new RegExp(`(${escaped})`, 'gi');
        return name.replace(regex, '<mark>$1</mark>');
    }

    function fetchSuggestions(query, dropdownEl) {
        if (!query) {
            dropdownEl.innerHTML = '';
            dropdownEl.style.display = 'none';
            return;
        }

        // Show loading spinner
        dropdownEl.innerHTML = `
            <div class="suggestion-loading">
                <span class="suggestion-loading-spinner"></span> Loading suggestions...
            </div>
        `;
        dropdownEl.style.display = 'block';

        if (typeof hexmy_ajax !== 'undefined') {
            fetch(hexmy_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=hexmy_search_suggestions&nonce=' + hexmy_ajax.nonce + '&query=' + encodeURIComponent(query)
            })
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data.suggestions && res.data.suggestions.length > 0) {
                    let html = '';
                    res.data.suggestions.forEach(item => {
                        const badgeClass = item.type === 'pornstar' ? 'badge-pornstar' : 'badge-tag';
                        const badgeLabel = item.type === 'pornstar' ? 'Pornstar' : 'Tag';
                        const highlighted = highlightQuery(item.name, query);
                        
                        html += `
                            <a href="${item.href}" class="suggestion-item">
                                <span class="suggestion-name">${highlighted}</span>
                                <span class="suggestion-badge ${badgeClass}">${badgeLabel}</span>
                            </a>
                        `;
                    });
                    dropdownEl.innerHTML = html;
                    dropdownEl.style.display = 'block';
                } else {
                    dropdownEl.innerHTML = '<div class="suggestion-empty">No suggestions found</div>';
                    dropdownEl.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Suggestions fetch error:', error);
                dropdownEl.innerHTML = '<div class="suggestion-empty">No suggestions found</div>';
                dropdownEl.style.display = 'block';
            });
        }
    }

    function setupInputSuggestions(inputEl, dropdownEl) {
        if (!inputEl || !dropdownEl) return;

        inputEl.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length === 0) {
                dropdownEl.innerHTML = '';
                dropdownEl.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetchSuggestions(query, dropdownEl);
            }, 300);
        });

        inputEl.addEventListener('focus', function() {
            const query = this.value.trim();
            if (query.length > 0) {
                fetchSuggestions(query, dropdownEl);
            }
        });
    }

    setupInputSuggestions(desktopInput, desktopDropdown);
    setupInputSuggestions(mobileInput, mobileDropdown);

    // Click outside listener to close dropdowns
    document.addEventListener('mousedown', function(e) {
        if (desktopInput && desktopDropdown && !desktopInput.contains(e.target) && !desktopDropdown.contains(e.target)) {
            desktopDropdown.style.display = 'none';
        }
        if (mobileInput && mobileDropdown && !mobileInput.contains(e.target) && !mobileDropdown.contains(e.target)) {
            mobileDropdown.style.display = 'none';
        }
    });

    // Escape key listener to close dropdowns
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (desktopDropdown) desktopDropdown.style.display = 'none';
            if (mobileDropdown) mobileDropdown.style.display = 'none';
        }
    });
    
    // Video card hover effects and video preview play
    const videoCards = document.querySelectorAll('.video-card');
    videoCards.forEach(card => {
        const video = card.querySelector('video.hover-preview');
        
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            if (video) {
                // Preload video on hover if set to none
                if (video.getAttribute('preload') === 'none') {
                    video.setAttribute('preload', 'auto');
                }
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log('Video preview playback error:', error);
                    });
                }
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        });
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in-up').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        observer.observe(el);
    });
    
    // Lazy loading images
    if ('loading' in HTMLImageElement.prototype) {
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        lazyImages.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const lazyImages = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Hero slider (auto-slide)
    const heroSlides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;
    
    function nextSlide() {
        heroSlides[currentSlide].style.opacity = '0';
        currentSlide = (currentSlide + 1) % heroSlides.length;
        heroSlides[currentSlide].style.opacity = '1';
    }
    
    if (heroSlides.length > 1) {
        setInterval(nextSlide, 5000);
    }
    
    // Button click effects
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Like/Dislike functionality
    const likeButtons = document.querySelectorAll('.like-button');
    const dislikeButtons = document.querySelectorAll('.dislike-button');
    
    likeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            // AJAX call to update like count
        });
    });
    
    dislikeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            // AJAX call to update dislike count
        });
    });
    
    // Infinite scroll (for video grids)
    let loading = false;
    const videoGrid = document.querySelector('.video-grid');
    
    function loadMoreVideos() {
        if (loading) return;
        loading = true;
        
        // AJAX call to load more videos
        // Implement infinite scroll logic
        
        setTimeout(() => {
            loading = false;
        }, 1000);
    }
    
    window.addEventListener('scroll', function() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
            loadMoreVideos();
        }
    });
    
    // Video player controls
    const videoPlayer = document.querySelector('video');
    if (videoPlayer) {
        videoPlayer.addEventListener('play', function() {
            this.parentElement.classList.add('playing');
        });
        
        videoPlayer.addEventListener('pause', function() {
            this.parentElement.classList.remove('playing');
        });
    }
    
    // Theater mode toggle
    const theaterButton = document.querySelector('.theater-button');
    if (theaterButton) {
        theaterButton.addEventListener('click', function() {
            document.body.classList.toggle('theater-mode');
        });
    }
    
    // Fullscreen toggle
    const fullscreenButton = document.querySelector('.fullscreen-button');
    if (fullscreenButton) {
        fullscreenButton.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
    }
    
    // Comments form submission
    const commentForm = document.querySelector('#commentform');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            if (typeof hexmy_ajax !== 'undefined') {
                fetch(hexmy_ajax.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload or append new comment
                        location.reload();
                    }
                })
                .catch(error => console.error('Comment error:', error));
            }
        });
    }
    
    // Category filter
    const categoryFilters = document.querySelectorAll('.category-filter');
    categoryFilters.forEach(filter => {
        filter.addEventListener('click', function() {
            const category = this.dataset.category;
            filterVideos(category);
        });
    });
    
    function filterVideos(category) {
        // Implement category filtering logic
        console.log('Filtering by category:', category);
    }
    
    // Duration filter
    const durationFilter = document.querySelector('#duration-filter');
    if (durationFilter) {
        durationFilter.addEventListener('change', function() {
            const duration = this.value;
            filterByDuration(duration);
        });
    }
    
    function filterByDuration(duration) {
        // Implement duration filtering logic
        console.log('Filtering by duration:', duration);
    }
    
    // Sort functionality
    const sortSelect = document.querySelector('#sort-videos');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            sortVideos(sortBy);
        });
    }
    
    function sortVideos(sortBy) {
        // Implement sorting logic
        console.log('Sorting by:', sortBy);
    }
        // Dynamic Active Navbar Link Highlighting
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.main-navigation a, .mobile-navigation a');
    navLinks.forEach(link => {
        if (link.href && currentUrl.includes(link.href) && link.getAttribute('href') !== '#') {
            const isHome = link.href === window.location.origin + '/' || link.href === window.location.origin + '/wordpress/';
            if (isHome) {
                if (window.location.pathname === '/' || window.location.pathname === '/wordpress' || window.location.pathname === '/wordpress/') {
                    const li = link.closest('li');
                    if (li) li.classList.add('active');
                } else {
                    const li = link.closest('li');
                    if (li && li.classList.contains('nav-home')) {
                        li.classList.remove('active');
                    }
                }
            } else {
                const li = link.closest('li');
                if (li) {
                    // Remove active from home link in same menu if we are on a deeper subpage
                    const menuUl = li.closest('ul');
                    if (menuUl) {
                        const homeLi = menuUl.querySelector('.nav-home');
                        if (homeLi) homeLi.classList.remove('active');
                    }
                    li.classList.add('active');
                }
            }
        }
    });

});
