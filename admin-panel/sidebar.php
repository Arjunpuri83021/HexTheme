<?php
/**
 * Shared Sidebar — included in every admin page.
 * Sets $active_page before including this file.
 * e.g.  $active_page = 'videos.php';
 */
if (!isset($active_page)) $active_page = '';

$nav_items = [
    'dashboard.php'  => ['label' => 'Dashboard',   'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>'],
    'videos.php'     => ['label' => 'Videos',      'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>'],
    'add-video.php'  => ['label' => 'Add Video',   'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>'],
    'categories.php' => ['label' => 'Categories',  'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5S15.01 22 17.5 22 22 19.99 22 17.5 19.99 13 17.5 13zm0 7c-1.38 0-2.5-1.12-2.5-2.5S16.12 15 17.5 15 20 16.12 20 17.5 18.88 20 17.5 20zM3 21.5h8v-8H3v8zm2-6h4v4H5v-4z"/></svg>'],
    'tags.php'       => ['label' => 'Tags',        'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg>'],
    'pornstars.php'  => ['label' => 'Pornstars',   'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>'],
    'ads.php'        => ['label' => 'Ad Network',  'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h2v2H6zm0 4h8v2H6zm10 0h2v2h-2zm-6-4h8v2h-8z"/></svg>'],
    'scraper.php'    => ['label' => 'Scraper',     'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93C9.33 17.79 7 14.5 7 11V7.18L12 5zm-2 4v2h4v-2h-4zm0 3v2h4v-2h-4z"/></svg>'],
];
?>
<!-- SVG Icons inline for sidebar (play icon for logo) -->
<svg style="display:none" xmlns="http://www.w3.org/2000/svg">
    <symbol id="admin-play-icon" viewBox="0 0 24 24">
        <path d="M8 5v14l11-7z" fill="currentColor"/>
    </symbol>
</svg>

<div class="sidebar" id="admin-sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <svg viewBox="0 0 24 24"><use href="#admin-play-icon"/></svg>
            </div>
            <div>
                <div class="sidebar-logo-text">
                    <span class="vip">VIP</span><span class="fourk">4K</span>
                </div>
                <div class="sidebar-logo-admin">Admin Panel</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="menu-section-header">Main Menu</div>
        <?php foreach ($nav_items as $file => $item): ?>
            <a href="<?php echo $file; ?>" class="nav-item<?php echo ($active_page === $file) ? ' active' : ''; ?>">
                <span class="nav-icon"><?php echo $item['icon']; ?></span>
                <?php echo htmlspecialchars($item['label']); ?>
            </a>
        <?php endforeach; ?>

        <div class="menu-section-header" style="margin-top: 30px;">Account</div>
        <a href="logout.php" class="nav-item">
            <span class="nav-icon">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
            </span>
            Logout
        </a>
    </nav>
</div>

<div class="sidebar-overlay" id="sidebar-overlay"></div>
