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
    <defs>
        <linearGradient id="logo-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#f70023" />
            <stop offset="100%" stop-color="#d14900" />
        </linearGradient>
        <linearGradient id="promo-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#d14900" />
            <stop offset="100%" stop-color="#b4047c" />
        </linearGradient>
    </defs>
    <symbol id="ico-burger" viewBox="0 0 22 16">
        <rect y="0" width="22" height="2" rx="1"/>
        <rect y="7" width="22" height="2" rx="1"/>
        <rect y="14" width="22" height="2" rx="1"/>
    </symbol>
    <symbol id="logo" viewBox="0 0 200 50">
        <g transform="translate(0, 3)">
            <text x="5" y="38" font-family="'Outfit', sans-serif" font-weight="900" font-size="44" fill="#ffffff" letter-spacing="-1">69</text>
            <rect x="62" y="3" width="130" height="38" rx="7" fill="#f70023" />
            <text x="74" y="32" font-family="'Outfit', sans-serif" font-weight="900" font-size="28" fill="#ffffff" letter-spacing="2">TUBE</text>
        </g>
    </symbol>
    <symbol id="ico-magnifier" viewBox="0 0 20 20">
        <path fill="currentColor" d="M19.7734375,17.9648438 L15.6679688,13.859375 C16.8359375,12.3671875 17.5,10.5078125 17.5,8.5 C17.5,3.8125 13.6875,0 9,0 C4.3125,0 0.5,3.8125 0.5,8.5 C0.5,13.1875 4.3125,17 9,17 C11.0078125,17 12.8671875,16.3359375 14.359375,15.1679688 L18.4648438,19.2734375 C18.6171875,19.4257812 18.8203125,19.5 19.0234375,19.5 C19.2265625,19.5 19.4296875,19.4257812 19.5820312,19.2734375 C19.9921875,18.8632812 19.9921875,18.375 19.7734375,17.9648438 Z M9,14.5 C5.6875,14.5 3,11.8125 3,8.5 C3,5.1875 5.6875,2.5 9,2.5 C12.3125,2.5 15,5.1875 15,8.5 C15,11.8125 12.3125,14.5 9,14.5 Z"/>
    </symbol>
    <symbol id="ico-del" viewBox="0 0 14 14">
        <path d="M14,1.41 L12.59,0 L7,5.59 L1.41,0 L0,1.41 L5.59,7 L0,12.59 L1.41,14 L7,8.41 L12.59,14 L14,12.59 L8.41,7 L14,1.41 Z"/>
    </symbol>
    <!-- Nav icons (stroke-based, VRPorn style) -->
    <symbol id="ico-home" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M3 12L5 10M5 10L12 3L19 10M5 10V20C5 20.5523 5.44772 21 6 21H9M19 10L21 12M19 10V20C19 20.5523 18.5523 21 18 21H15M9 21C9 21 9 15 12 15C15 15 15 21 15 21M9 21H15"/>
    </symbol>
    <symbol id="ico-videos" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M2 11.5C2 8.21252 2 6.56878 2.90796 5.46243C3.07418 5.25989 3.25989 5.07418 3.46243 4.90796C4.56878 4 6.21252 4 9.5 4C12.7875 4 14.4312 4 15.5376 4.90796C15.7401 5.07418 15.9258 5.25989 16.092 5.46243C17 6.56878 17 8.21252 17 11.5V12.5C17 15.7875 17 17.4312 16.092 18.5376C15.9258 18.7401 15.7401 18.9258 15.5376 19.092C14.4312 20 12.7875 20 9.5 20C6.21252 20 4.56878 20 3.46243 19.092C3.25989 18.9258 3.07418 18.7401 2.90796 18.5376C2 17.4312 2 15.7875 2 12.5V11.5Z M17 9.5L17.6584 9.171C19.6042 8.198 20.5772 7.712 21.2886 8.151C22 8.591 22 9.679 22 11.854V12.146C22 14.322 22 15.409 21.2886 15.849C20.5772 16.289 19.6042 15.802 17.6584 14.829L17 14.5V9.5Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M11 12C11 12.5523 10.5523 13 10 13L7 13C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11L10 11C10.5523 11 11 11.4477 11 12Z"/>
    </symbol>
    <symbol id="ico-actors" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z"/>
    </symbol>
    <symbol id="ico-channels" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M2.5 6.5C2.5 4.61438 2.5 3.67157 3.08579 3.08579C3.67157 2.5 4.61438 2.5 6.5 2.5C8.38562 2.5 9.32843 2.5 9.91421 3.08579C10.5 3.67157 10.5 4.61438 10.5 6.5C10.5 8.38562 10.5 9.32843 9.91421 9.91421C9.32843 10.5 8.38562 10.5 6.5 10.5C4.61438 10.5 3.67157 10.5 3.08579 9.91421C2.5 9.32843 2.5 8.38562 2.5 6.5Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M13.5 17.5C13.5 15.6144 13.5 14.6716 14.0858 14.0858C14.6716 13.5 15.6144 13.5 17.5 13.5C19.3856 13.5 20.3284 13.5 20.9142 14.0858C21.5 14.6716 21.5 15.6144 21.5 17.5C21.5 19.3856 21.5 20.3284 20.9142 20.9142C20.3284 21.5 19.3856 21.5 17.5 21.5C15.6144 21.5 14.6716 21.5 14.0858 20.9142C13.5 20.3284 13.5 19.3856 13.5 17.5Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M2.5 17.5C2.5 15.6144 2.5 14.6716 3.08579 14.0858C3.67157 13.5 4.61438 13.5 6.5 13.5C8.38562 13.5 9.32843 13.5 9.91421 14.0858C10.5 14.6716 10.5 15.6144 10.5 17.5C10.5 19.3856 10.5 20.3284 9.91421 20.9142C9.32843 21.5 8.38562 21.5 6.5 21.5C4.61438 21.5 3.67157 21.5 3.08579 20.9142C2.5 20.3284 2.5 19.3856 2.5 17.5Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M13.5 6.5C13.5 4.61438 13.5 3.67157 14.0858 3.08579C14.6716 2.5 15.6144 2.5 17.5 2.5C19.3856 2.5 20.3284 2.5 20.9142 3.08579C21.5 3.67157 21.5 4.61438 21.5 6.5C21.5 8.38562 21.5 9.32843 20.9142 9.91421C20.3284 10.5 19.3856 10.5 17.5 10.5C15.6144 10.5 14.6716 10.5 14.0858 9.91421C13.5 9.32843 13.5 8.38562 13.5 6.5Z"/>
    </symbol>
    <symbol id="ico-tag" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M4.17157 4.17157C3 5.34315 3 7.22876 3 11V12C3 15.7712 3 17.6569 4.17157 18.8284C5.34315 20 7.22876 20 11 20H12C15.7712 20 17.6569 20 18.8284 18.8284C20 17.6569 20 15.7712 20 12V11C20 7.22876 20 5.34315 18.8284 4.17157C17.6569 3 15.7712 3 12 3H11C7.22876 3 5.34315 3 4.17157 4.17157Z"/>
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M8 12H16M8 8H12M8 16H14"/>
    </symbol>
    <symbol id="ico-star" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="1.5" fill="none" d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
    </symbol>
    <symbol id="ico-search" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="2" fill="none" d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z"/>
    </symbol>
    <symbol id="ico-earth" viewBox="0 0 16 16">
        <path fill="currentColor" d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 14.4A6.4 6.4 0 1 1 8 1.6a6.4 6.4 0 0 1 0 12.8z M8.8 4h-1.6v2.4H4.8v1.6h2.4V12h1.6V8h2.4V6.4H8.8V4z"/>
    </symbol>
</svg>

<!-- Top Header Bar (PervClips Style) -->
<header class="header">
    <div class="header__inner">
        <!-- Brand Logo -->
        <div class="header__logo">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" aria-label="69Tube Logo">
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

        <!-- Centered Search Form (inline, visible on desktop) -->
        <form role="search" method="get" action="<?php echo esc_url(home_url('/search/')); ?>" class="header__search">
            <input class="search__field" 
                   type="search" 
                   name="q" 
                   id="search-input" 
                   placeholder="Search videos, performers, categories..." 
                   value="<?php echo isset($_GET['q']) ? esc_attr($_GET['q']) : ''; ?>" 
                   autocomplete="off">
            <button aria-label="Search" class="search__icon" type="submit">
                <svg class="ico ico--magnifier">
                    <use xlink:href="#ico-magnifier"></use>
                </svg>
            </button>
            <div class="search-suggestions-dropdown" id="search-suggestions"></div>
        </form>

        <!-- Language Selector -->
        <div class="header__lang lang">
            <button aria-label="Language" class="lang__handler" type="button">
                <span class="lang__icon">
                    <img loading="lazy" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/flag-en.svg" alt="English Flag" width="25" height="16" onerror="this.src='//cdn.black4k.com/bundles/tour/Vip4k/images/flag-en.svg'">
                </span>
            </button>
        </div>

        <!-- Login Button -->
        <div class="header__login header__login--hid">
            <a class="button button--dark" href="<?php echo esc_url(home_url('/login/')); ?>">Log In</a>
        </div>

        <!-- Join Now button -->
        <div class="header__login header__join">
            <a class="button button--primary" href="<?php echo esc_url(home_url('/upgrade/')); ?>">Join Now</a>
        </div>
    </div>
</header>

<!-- Horizontal Sub-Navigation Menu Bar directly below header -->
<div class="subnav">
    <div class="subnav__inner">
        <a class="subnav__link <?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <a class="subnav__link <?php echo is_post_type_archive('video') && !isset($_GET['filter']) ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/videos/')); ?>">New Videos</a>
        <a class="subnav__link <?php echo is_post_type_archive('video') && isset($_GET['filter']) && $_GET['filter'] === 'popular' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'popular', home_url('/videos/'))); ?>">Best Videos</a>
        <a class="subnav__link <?php echo is_tax('video_category') || is_page('category') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/category/')); ?>">Categories</a>
        <a class="subnav__link <?php echo is_tax('pornstar') || is_page('pornstar') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/pornstar/')); ?>">Pornstars</a>
        <a class="subnav__link <?php echo is_tax('video_tag') || is_page('tag') ? 'active' : ''; ?>" href="<?php echo esc_url(home_url('/tag/')); ?>">Tags</a>
    </div>
</div>

<div class="content">
    <div class="container">
        <main class="content__body">
