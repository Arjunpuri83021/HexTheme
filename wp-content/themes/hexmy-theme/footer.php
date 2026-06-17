        </main><!-- .content__body -->
    </div><!-- .container -->
</div><!-- .content -->

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-brand">
                <div class="site-logo" style="margin-bottom: 15px;">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link" aria-label="Home" style="display: inline-block;">
                        <?php
                        $custom_logo = get_theme_mod('hexmy_logo');
                        if ($custom_logo) {
                            echo '<img src="' . esc_url($custom_logo) . '" alt="' . get_bloginfo('name') . '" class="logo-image">';
                        } else {
                            ?>
                            <svg class="logo" style="fill: #ffffff; width: 120px; height: 35px;">
                                <use xlink:href="#logo"></use>
                            </svg>
                            <?php
                        }
                        ?>
                    </a>
                </div>
                <p style="color: var(--text-secondary); font-size: 13.5px; max-width: 320px; line-height: 1.6;">
                    Old farts and young pussies, live shooting with the incredible 4K quality, tons of videos – and a single account.
                </p>
            </div>

            <!-- Quick Navigation Column -->
            <div class="footer-links">
                <h4>Videos & Stars</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/videos/')); ?>">Newest Videos</a></li>
                    <li><a href="<?php echo esc_url(add_query_arg('filter', 'popular', home_url('/videos/'))); ?>">Best Scenes</a></li>
                    <li><a href="<?php echo esc_url(home_url('/pornstar/')); ?>">Pornstars</a></li>
                    <li><a href="<?php echo esc_url(home_url('/category/')); ?>">Categories</a></li>
                </ul>
            </div>

            <!-- Legal Documents Column -->
            <div class="footer-links">
                <h4>Legal Info</h4>
                <ul>
                    <li><a href="#">DMCA / Copyright Compliance</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">2257 Record-Keeping Statement</a></li>
                </ul>
            </div>

            <!-- Support & Feedback Column -->
            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Frequently Asked Questions</a></li>
                    <li><a href="#">Contact Support</a></li>
                    <li><a href="#">Content Removal Request</a></li>
                    <li><a href="#">Advertise With Us</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright Line -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All fantasies are in ultra high resolution. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Ad Global / Popunder Embeds -->
<?php
$popunder_code = get_option('_hexmy_ad_popunder');
$socialbar_code = get_option('_hexmy_ad_socialbar');
if (!empty($popunder_code)) {
    echo $popunder_code;
}
if (!empty($socialbar_code)) {
    echo $socialbar_code;
}
?>

<!-- Mobile Sticky Bottom Nav bar (displays only <= 639px) -->
<nav class="mobile-bottom-nav">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="mob-nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
    </a>
    <a href="<?php echo esc_url(home_url('/category/')); ?>" class="mob-nav-item <?php echo is_tax('video_category') || is_page('category') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"/>
        </svg>
        <span>Categories</span>
    </a>
    <!-- Toggle overlay search -->
    <a href="#" class="mob-nav-item mob-nav-search" id="mobile-search-nav-trigger">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <span>Search</span>
    </a>
    <a href="<?php echo esc_url(home_url('/tag/')); ?>" class="mob-nav-item <?php echo is_tax('video_tag') || is_page('tag') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
        </svg>
        <span>Tags</span>
    </a>
    <a href="<?php echo esc_url(home_url('/pornstar/')); ?>" class="mob-nav-item <?php echo is_tax('pornstar') || is_page('pornstar') ? 'active' : ''; ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
        </svg>
        <span>Stars</span>
    </a>
</nav>

<!-- Mobile Search Panel Overlay (Displays when active on mobile) -->
<div class="mobile-search-dropdown" id="mobile-search-panel" style="position: fixed; top: -100px; left: 0; right: 0; background: var(--bg-secondary); border-bottom: 1px solid var(--border-color); padding: 12px; z-index: 10000; transition: top 0.3s ease-in-out; display: block;">
    <form role="search" method="get" action="<?php echo esc_url(home_url('/search/')); ?>" class="mobile-search-form" style="display: flex; align-items: center; background: rgba(255,255,255,0.07); padding: 0 10px; border-radius: 4px; height: 44px;">
        <input type="search" name="q" placeholder="Search..." id="mobile-search-input" autocomplete="off" style="width: 100%; height: 100%; color: #fff; font-size: 14px;">
        <button type="submit" aria-label="Search" style="cursor: pointer; display: flex; align-items: center; justify-content: center; width: 30px; height: 30px;">
            <svg class="ico ico--magnifier" style="width: 18px; height: 18px; fill: var(--text-secondary);">
                <use xlink:href="#ico-magnifier"></use>
            </svg>
        </button>
    </form>
    <div class="search-suggestions-dropdown" id="mobile-search-suggestions" style="top: 60px;"></div>
</div>

<?php wp_footer(); ?>
</body>
</html>
