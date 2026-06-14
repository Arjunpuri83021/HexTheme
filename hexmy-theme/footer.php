</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-brand">
                <div class="site-logo" style="margin-bottom: 20px;">
                    <?php
                    $custom_logo = get_theme_mod('hexmy_logo');
                    if ($custom_logo) {
                        echo '<a href="' . esc_url(home_url('/')) . '"><img src="' . esc_url($custom_logo) . '" alt="' . get_bloginfo('name') . '"></a>';
                    } else {
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" style="display: inline-flex; align-items: center; text-decoration: none;">
                            <span class="site-logo-text">com</span>
                            <span class="site-logo-badge">xxx</span>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                <p style="color: var(--text-secondary); font-size: 14px; max-width: 300px;">
                    Premium adult video streaming platform with the best content from around the world.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                    <li><a href="<?php echo home_url('/videos/'); ?>">Videos</a></li>
                    <li><a href="<?php echo home_url('/category/'); ?>">Categories</a></li>
                    <li><a href="<?php echo home_url('/tag/'); ?>">Tags</a></li>
                    <li><a href="<?php echo home_url('/pornstar/'); ?>">Pornstars</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div class="footer-links">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">DMCA</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Content Removal</a></li>
                    <li><a href="#">Parental Control</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Report Issue</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Hexmy. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php
// Output Adsterra / Ad Network global scripts if configured
$popunder_code = get_option('_hexmy_ad_popunder');
$socialbar_code = get_option('_hexmy_ad_socialbar');
if (!empty($popunder_code)) {
    echo $popunder_code;
}
if (!empty($socialbar_code)) {
    echo $socialbar_code;
}
?>

<!-- Mobile Bottom Navigation Bar -->
<nav class="mobile-bottom-nav" id="mobile-bottom-nav">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mob-nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
    </a>
    <a href="<?php echo esc_url(home_url('/category/')); ?>" class="mob-nav-item <?php echo is_tax('video_category') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"/>
        </svg>
        <span>Categories</span>
    </a>
    <a href="<?php echo esc_url(home_url('/search/')); ?>" class="mob-nav-item mob-nav-search" id="mob-search-trigger">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <span>Search</span>
    </a>
    <a href="<?php echo esc_url(home_url('/tag/')); ?>" class="mob-nav-item <?php echo is_tax('video_tag') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
        </svg>
        <span>Tags</span>
    </a>
    <a href="<?php echo esc_url(home_url('/pornstar/')); ?>" class="mob-nav-item <?php echo is_tax('pornstar') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
        </svg>
        <span>Stars</span>
    </a>
</nav>

<?php wp_footer(); ?>
</body>
</html>

