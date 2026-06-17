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

        <!-- Copyright Line & Age Disclaimer -->
        <div class="footer-bottom">
            <p style="margin-bottom: 15px;">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All fantasies are in ultra high resolution. All rights reserved.</p>
            
            <div class="footer-age-bar">
                <div class="footer-age-badge">18+</div>
                <p style="color: var(--text-muted); font-size: 11px; max-width: 650px; text-align: left; line-height: 1.5; margin: 0;">
                    This website contains sexually explicit material. You must be at least 18 years of age (or the age of majority in your jurisdiction) to access and view this content. All models and performers appearing on this website were 18 years of age or older at the time of photography/recording.
                </p>
                <div class="footer-age-links">
                    <a href="<?php echo esc_url(home_url('/dmca/')); ?>">DMCA</a>
                    <a href="<?php echo esc_url(home_url('/privacy/')); ?>">Privacy</a>
                    <a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms</a>
                    <a href="<?php echo esc_url(home_url('/2257/')); ?>">2257</a>
                    <a href="<?php echo esc_url(home_url('/rta/')); ?>">RTA</a>
                </div>
            </div>
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

<?php wp_footer(); ?>
</body>
</html>
