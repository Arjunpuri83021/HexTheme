<?php
/**
 * Shared Sidebar — included in every admin page.
 * Sets $active_page before including this file.
 * e.g.  $active_page = 'videos.php';
 */
if (!isset($active_page)) $active_page = '';

$nav_items = [
    'dashboard.php'  => 'Dashboard',
    'videos.php'     => 'Videos',
    'add-video.php'  => 'Add Video',
    'categories.php' => 'Categories',
    'tags.php'       => 'Tags',
    'pornstars.php'  => 'Pornstars',
    'ads.php'        => 'Ad Network',
    'scraper.php'    => 'Scraper',
];
?>
<script>
    (function() {
        const theme = localStorage.getItem('admin-theme') || 'light';
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    })();
</script>
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">HEXMY</div>
    </div>
    <nav class="sidebar-nav">
        <?php foreach ($nav_items as $file => $label): ?>
            <a href="<?php echo $file; ?>" class="nav-item<?php echo ($active_page === $file) ? ' active' : ''; ?>">
                <?php echo htmlspecialchars($label); ?>
            </a>
        <?php endforeach; ?>
    </nav>
</div>
