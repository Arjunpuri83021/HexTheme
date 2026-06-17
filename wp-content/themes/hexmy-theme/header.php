<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<!-- SVG Icons Sprite Definitions -->
<svg style="display: none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="critical-sprite">
    <symbol id="ico-burger" viewBox="0 0 22 16">
        <path d="M1.04918033,0.0950006557 C0.469744262,0.0950006557 0,0.564716066 0,1.14418098 C0,1.72364328 0.469744262,2.19336131 1.04918033,2.19336131 L20.4590164,2.19336131 C21.0384525,2.19336131 21.5081967,1.72364328 21.5081967,1.14418098 C21.5081967,0.564716066 21.0384525,0.0950006557 20.4590164,0.0950006557 L1.04918033,0.0950006557 Z M1.04918033,6.91467279 C0.469744262,6.91467279 0,7.38439344 0,7.96385574 C0,8.54331803 0.469744262,9.01303607 1.04918033,9.01303607 L20.4590164,9.01303607 C21.0384525,9.01303607 21.5081967,8.54331803 21.5081967,7.96385574 C21.5081967,7.38439344 21.0384525,6.91467279 20.4590164,6.91467279 L1.04918033,6.91467279 Z M1.04918033,13.7343475 C0.469744262,13.7343475 0,14.2040656 0,14.7835279 C0,15.3629902 0.469744262,15.8327082 1.04918033,15.8327082 L20.4590164,15.8327082 C21.0384525,15.8327082 21.5081967,15.3629902 21.5081967,14.7835279 C21.5081967,14.2040656 21.0384525,13.7343475 20.4590164,13.7343475 L1.04918033,13.7343475 Z"/>
    </symbol>
    <symbol id="logo" viewBox="0 0 3500 990">
        <path fill="#fff" d="M1489.72,475.42h92.67c41.79,0,71.77-8.62,89.94-25.87,18.17-17.25,27.25-45.91,27.25-86s-9.08-68.75-27.25-85.99c-18.17-17.25-48.15-25.87-89.94-25.87h-92.67v223.73ZM1440.66,990h-196.23c-32.71,0-49.06-16.78-49.06-50.34V50.34c0-33.56,16.35-50.34,49.06-50.34h342.04c136.28,0,238.71,28.43,307.3,85.3,68.59,56.86,102.88,149.62,102.88,278.26s-34.29,221.4-102.88,278.26c-68.59,56.86-171.02,85.3-307.3,85.3h-96.75v212.54c0,33.56-16.35,50.34-49.06,50.34Z"/>
        <g>
            <path fill="#fff" d="M1060.87,0h-107.57l-120.03,983.65c7.49,4.23,17.03,6.35,28.64,6.35h198.96c32.7,0,49.06-16.78,49.06-50.34V50.34c0-33.56-16.36-50.34-49.06-50.34Z"/>
            <path fill="#9c9c9c" d="M947.14,0l-101.11,270.76-33.17,107.2v561.7c0,21.65,6.81,36.3,20.42,43.98L953.3,0h-6.17Z"/>
            <path fill="#fff" d="M874.41,0h-209.86c-32.71,0-52.69,15.38-59.96,46.14l-99.48,405.51-44.97,223.73h-5.45l-44.97-223.73L310.25,46.14C302.98,15.38,282.99,0,250.29,0H40.43C24.07,0,12.49,5.59,5.68,16.78-1.14,27.97-1.82,42.42,3.63,60.13l273.91,885.13c9.99,29.83,29.53,44.75,58.6,44.75h242.56c29.07,0,48.6-14.91,58.6-44.75l175.55-567.3,33.17-107.2L947.14,0h-72.72Z"/>
        </g>
        <path fill="#efc127" d="M2642.54,987.76v-182.86h70.2v-217.49h-70.2v-252.12l-244.36,155.15v96.97h-129.6L2615.54.05h-307.81l-301.06,599.83v205.02h391.51v182.86h244.36Z"/>
        <path fill="#efc127" d="M2986.99,987.76v-279.83l72.9-106.67,139.05,386.49h301.06l-230.86-597.06L3497.3.05h-270.01l-240.3,429.44V.05h-278.11v987.71h278.11Z"/>
    </symbol>
    <symbol id="ico-magnifier" viewBox="0 0 20 20">
        <path d="M19.7734375,17.9648438 L15.6679688,13.859375 C16.8359375,12.3671875 17.5,10.5078125 17.5,8.5 C17.5,3.8125 13.6875,0 9,0 C4.3125,0 0.5,3.8125 0.5,8.5 C0.5,13.1875 4.3125,17 9,17 C11.0078125,17 12.8671875,16.3359375 14.359375,15.1679688 L18.4648438,19.2734375 C18.6171875,19.4257812 18.8203125,19.5 19.0234375,19.5 C19.2265625,19.5 19.4296875,19.4257812 19.5820312,19.2734375 C19.9921875,18.8632812 19.9921875,18.375 19.7734375,17.9648438 Z M9,14.5 C5.6875,14.5 3,11.8125 3,8.5 C3,5.1875 5.6875,2.5 9,2.5 C12.3125,2.5 15,5.1875 15,8.5 C15,11.8125 12.3125,14.5 9,14.5 Z"/>
    </symbol>
    <symbol id="ico-del" viewBox="0 0 14 14">
        <path d="M14,1.41 L12.59,0 L7,5.59 L1.41,0 L0,1.41 L5.59,7 L0,12.59 L1.41,14 L7,8.41 L12.59,14 L14,12.59 L8.41,7 L14,1.41 Z"/>
    </symbol>
    <symbol id="ico-videos" viewBox="0 0 25 22">
        <path fill="currentColor" d="M22 0H3C1.34 0 0 1.34 0 3v16c0 1.66 1.34 3 3 3h19c1.66 0 3-1.34 3-3V3c0-1.66-1.34-3-3-3zm-2 18H5c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1h15c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.44-6.19l-2.35 3.02-1.56-1.88c-.2-.25-.58-.24-.78.01l-2.1 2.53c-.26.31-.04.8.36.8h11.75c.41 0 .63-.5.36-.8l-3.32-4.48c-.2-.27-.61-.27-.8.02z"/>
    </symbol>
    <symbol id="ico-actors" viewBox="0 0 23 20">
        <path fill="currentColor" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
    </symbol>
    <symbol id="ico-channels" viewBox="0 0 20 20">
        <path fill="currentColor" d="M4 4h12v12H4V4zm2 2h8v8H6V6z"/>
    </symbol>
    <symbol id="ico-earth" viewBox="0 0 16 16">
        <path fill="currentColor" d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 14.4A6.4 6.4 0 1 1 8 1.6a6.4 6.4 0 0 1 0 12.8z M8.8 4h-1.6v2.4H4.8v1.6h2.4V12h1.6V8h2.4V6.4H8.8V4z"/>
    </symbol>
</svg>

<header class="header">
    <div class="header__inner">
        <!-- Burger menu (Mobile nav drawer toggle) -->
        <button aria-label="Menu" class="header__burger" type="button" id="header-burger-btn">
            <svg class="ico ico--burger">
                <use xlink:href="#ico-burger"></use>
            </svg>
        </button>

        <!-- Brand Logo -->
        <div class="header__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" aria-label="Vip4k Logo">
                <?php
                $custom_logo = get_theme_mod('hexmy_logo');
                if ($custom_logo) {
                    echo '<img src="' . esc_url($custom_logo) . '" alt="' . get_bloginfo('name') . '" class="logo-image">';
                } else {
                    ?>
                    <svg alt="logo" class="logo">
                        <use xlink:href="#logo"></use>
                    </svg>
                    <?php
                }
                ?>
            </a>
        </div>

        <!-- Top Nav menu (Desktop middle) -->
        <div class="header__nav">
            <nav class="nav">
                <a class="nav__link <?php echo is_post_type_archive('video') || is_singular('video') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/videos/')); ?>">Videos</a>
                <a class="nav__link <?php echo is_tax('pornstar') || is_page('pornstar') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/pornstar/')); ?>">Pornstars</a>
                <a class="nav__link <?php echo is_tax('video_category') || is_page('category') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/category/')); ?>">Categories</a>
            </nav>
        </div>

        <!-- Search Capsule -->
        <form role="search" method="get" action="<?php echo esc_url(home_url('/search/')); ?>" class="header__search search">
            <input class="search__field" 
                   type="search" 
                   name="q" 
                   id="search-input" 
                   placeholder="Search" 
                   value="<?php echo isset($_GET['q']) ? esc_attr($_GET['q']) : ''; ?>" 
                   autocomplete="off">
            <button aria-label="Search" class="search__icon" type="submit">
                <svg class="ico ico--magnifier">
                    <use xlink:href="#ico-magnifier"></use>
                </svg>
            </button>
            <div class="search-suggestions-dropdown" id="search-suggestions"></div>
        </form>

        <!-- Mobile Search Magnifier (Displays only on Mobile <= 639px) -->
        <div class="mobile-search-toggle" id="mobile-search-trigger" style="display: none;">
            <svg class="ico ico--magnifier" style="width: 22px; height: 22px;">
                <use xlink:href="#ico-magnifier"></use>
            </svg>
        </div>

        <!-- Language Selector -->
        <div class="header__lang lang">
            <button aria-label="Language" class="lang__handler" type="button">
                <span class="lang__icon">
                    <img loading="lazy" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/flag-en.svg" alt="English Flag" width="25" height="16" onerror="this.src='//cdn.black4k.com/bundles/tour/Vip4k/images/flag-en.svg'">
                </span>
            </button>
        </div>

        <!-- Join & Login Buttons -->
        <div class="header__login header__login--hid">
            <a class="button button--dark" href="<?php echo esc_url(home_url('/login/')); ?>">Login</a>
        </div>
        <div class="header__login header__join">
            <a class="button" href="<?php echo esc_url(home_url('/upgrade/')); ?>">Join Now</a>
        </div>
    </div>

    <!-- Persistent Left Menu / Mobile Slide drawer overlay -->
    <div class="header__menu" id="header-menu-sidebar">
        <div class="header__links">
            <ul class="sidebar-nav">
                <li class="sidebar-nav__item <?php echo is_post_type_archive('video') || is_singular('video') ? 'active' : ''; ?>">
                    <a class="sidebar-nav__link" href="<?php echo esc_url(home_url('/videos/')); ?>" title="Videos">
                        <div class="sidebar-nav__icon">
                            <svg class="ico ico--videos">
                                <use xlink:href="#ico-videos"></use>
                            </svg>
                        </div>
                        <div class="sidebar-nav__text">Videos</div>
                    </a>
                </li>
                <li class="sidebar-nav__item <?php echo is_tax('pornstar') || is_page('pornstar') ? 'active' : ''; ?>">
                    <a class="sidebar-nav__link" href="<?php echo esc_url(home_url('/pornstar/')); ?>" title="Pornstars">
                        <div class="sidebar-nav__icon">
                            <svg class="ico ico--actors">
                                <use xlink:href="#ico-actors"></use>
                            </svg>
                        </div>
                        <div class="sidebar-nav__text">Pornstars</div>
                    </a>
                </li>
                <li class="sidebar-nav__item <?php echo is_tax('video_category') || is_page('category') ? 'active' : ''; ?>">
                    <a class="sidebar-nav__link" href="<?php echo esc_url(home_url('/category/')); ?>" title="Categories">
                        <div class="sidebar-nav__icon">
                            <svg class="ico ico--channels">
                                <use xlink:href="#ico-channels"></use>
                            </svg>
                        </div>
                        <div class="sidebar-nav__text">Categories</div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Mobile Login Panel bottom (visible inside Burger drawer on mobile) -->
        <div class="header__login">
            <a class="button button--dark" href="<?php echo esc_url(home_url('/login/')); ?>">Login</a>
            <a class="button button--primary" href="<?php echo esc_url(home_url('/upgrade/')); ?>" style="background: var(--accent-color); color: #000; width: 100%;">Join Now</a>
        </div>
    </div>
</header>

<div class="content">
    <div class="container">
        <main class="content__body">
