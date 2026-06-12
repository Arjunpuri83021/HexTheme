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
                        echo '<img src="' . esc_url($custom_logo) . '" alt="' . get_bloginfo('name') . '">';
                    } else {
                        echo 'HEXMY';
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

<?php wp_footer(); ?>
</body>
</html>
