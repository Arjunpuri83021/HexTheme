<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <!-- Row 1: Header Top -->
    <div class="header-top">
        <div class="container header-top-inner">
            <!-- Glowing Brand Logo -->
            <div class="site-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/comxxx_logo.png" alt="comxxx" class="logo-image">
                </a>
            </div>

            <!-- Search Capsule with Dropdown Filter & Magnifier Button -->
            <div class="search-capsule" style="position: relative;">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/search/')); ?>" class="search-form-wrap">
                    <input type="search" 
                           name="q" 
                           placeholder="Search by..." 
                           value="<?php echo isset($_GET['q']) ? esc_attr($_GET['q']) : ''; ?>"
                           autocomplete="off"
                           id="search-input"
                           class="search-input-field">
                    <div class="search-filter-select">
                        <span class="search-select-label">Videos</span>
                        <svg class="select-arrow" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 1L5 5L9 1" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <button type="submit" class="search-submit-btn" aria-label="Search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>
                <div class="search-suggestions-dropdown" id="search-suggestions" style="display: none;"></div>
            </div>

            <!-- Header Actions Area -->
            <div class="header-right-actions">
                <!-- Login/Register Links (UltimaTube Style) -->
                <a href="<?php echo esc_url(wp_login_url()); ?>" class="login-link-btn" style="font-size: 14px; font-weight: 700; color: #555555; margin-right: 15px;">Login</a>
                <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-primary register-btn-btn" style="font-size: 13px; font-weight: 700; background: var(--accent-red); color: #ffffff; padding: 8px 16px; border-radius: 4px;">Register</a>

                <!-- Responsive Search Toggle Magnifier -->
                <button class="search-toggle" id="search-toggle" aria-label="Toggle Search">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- Responsive Menu Toggle -->
                <button class="menu-toggle" id="menu-toggle" aria-label="Toggle Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Search Dropdown Panel -->
    <div class="mobile-search-dropdown" id="mobile-search-dropdown">
        <div class="container" style="position: relative;">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/search/')); ?>" class="mobile-search-form">
                <input type="search" 
                       name="q" 
                       placeholder="Search by..." 
                       value="<?php echo isset($_GET['q']) ? esc_attr($_GET['q']) : ''; ?>" 
                       autocomplete="off" 
                       id="mobile-search-input" 
                       class="mobile-search-input">
                <button type="submit" class="mobile-search-submit" aria-label="Submit Search">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </form>
            <div class="search-suggestions-dropdown" id="mobile-search-suggestions" style="display: none;"></div>
        </div>
    </div>

    <!-- Row 2: Header Bottom Navigation Bar -->
    <div class="header-bottom">
        <div class="container header-bottom-inner">
            <nav class="main-navigation">
                <ul>
                    <li class="nav-home <?php echo is_front_page() ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="<?php echo is_post_type_archive('video') || is_singular('video') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/videos/')); ?>">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                            </svg>
                            <span>Videos</span>
                        </a>
                    </li>
                    <li class="<?php echo is_tax('video_category') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/category/')); ?>">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"/>
                            </svg>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="<?php echo is_tax('video_tag') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/tag/')); ?>">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                            </svg>
                            <span>Tags</span>
                        </a>
                    </li>
                    <li class="<?php echo is_tax('pornstar') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(home_url('/pornstar/')); ?>">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span>Pornstars</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.44-6.19l-2.35 3.02-1.56-1.88c-.2-.25-.58-.24-.78.01l-2.1 2.53c-.26.31-.04.8.36.8h11.75c.41 0 .63-.5.36-.8l-3.32-4.48c-.2-.27-.61-.27-.8.02z"/>
                            </svg>
                            <span>Photo & GIFs</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                            <span>Community</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobile-menu">
    <nav class="mobile-navigation">
        <ul>
            <li class="nav-home <?php echo is_front_page() ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    <span>Home</span>
                </a>
            </li>
            <li class="<?php echo is_post_type_archive('video') || is_singular('video') ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/videos/')); ?>">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                    </svg>
                    <span>Videos</span>
                </a>
            </li>
            <li class="<?php echo is_tax('video_category') ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/category/')); ?>">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"/>
                    </svg>
                    <span>Categories</span>
                </a>
            </li>
            <li class="<?php echo is_tax('video_tag') ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/tag/')); ?>">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                    </svg>
                    <span>Tags</span>
                </a>
            </li>
            <li class="<?php echo is_tax('pornstar') ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(home_url('/pornstar/')); ?>">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                    <span>Pornstars</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.44-6.19l-2.35 3.02-1.56-1.88c-.2-.25-.58-.24-.78.01l-2.1 2.53c-.26.31-.04.8.36.8h11.75c.41 0 .63-.5.36-.8l-3.32-4.48c-.2-.27-.61-.27-.8.02z"/>
                    </svg>
                    <span>Photo & GIFs</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    <span>Community</span>
                </a>
            </li>
        </ul>

        <!-- Stacked buttons inside mobile navigation panel bottom -->
        <div class="mobile-menu-actions">
            <a href="<?php echo esc_url(home_url('/upgrade/')); ?>" class="mobile-upgrade-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="star-icon">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
                <span>Upgrade</span>
            </a>
            <div class="mobile-exclusive-banner">
                <span>EXCLUSIVE CONTENT</span>
            </div>
        </div>
    </nav>
</div>

<main class="site-main">
