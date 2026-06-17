<?php
/**
 * Archive template for displaying Pornstars
 * File: taxonomy-pornstar.php
 */

get_header();

$term = get_queried_object();
$term_name = $term ? $term->name : __('Pornstar Archive', 'hexmy');
$term_desc = $term ? $term->description : '';
$count = $term ? $term->count : 0;
?>

<div class="container" style="padding-top: 30px; padding-bottom: 50px; min-height: 70vh;">
    <div class="archive-layout">
        
        <!-- Left Sidebar (UltimaTube Style) -->

        <!-- Right Content Block -->
        <main class="archive-content">
            <h2 class="widget-title">
                <?php echo esc_html($term_name); ?> Videos
            </h2>
            
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">
                <?php 
                if (!empty($term_desc)) {
                    echo esc_html($term_desc);
                } else {
                    echo sprintf(__('Browse our collection of %s videos featuring pornstar &ldquo;%s&rdquo;.', 'hexmy'), number_format($count), esc_html($term_name));
                }
                ?>
            </p>

            <?php if (have_posts()) : ?>
                <div class="video-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/video-card'); ?>
                    <?php endwhile; ?>
                </div>

                <div class="pagination" style="margin-top: 40px; display: flex; justify-content: center; gap: 8px;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => __('&laquo; Prev', 'hexmy'),
                        'next_text' => __('Next &raquo;', 'hexmy'),
                        'type' => 'plain',
                    ));
                    ?>
                </div>
            <?php else : ?>
                <div style="text-align: center; padding: 40px;">
                    <p style="color: var(--text-secondary); font-size: 16px; margin: 0;">No videos found featuring this performer.</p>
                </div>
            <?php endif; ?>
        </main>
        
    </div>
</div>

<?php get_footer(); ?>
