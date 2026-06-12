<?php
/**
 * Archive template for displaying Video Categories
 * File: taxonomy-video_category.php
 */

get_header();

$term = get_queried_object();
$term_name = $term ? $term->name : __('Category Archive', 'hexmy');
$term_desc = $term ? $term->description : '';
$count = $term ? $term->count : 0;
?>

<div class="container" style="padding-top: 120px; padding-bottom: 60px; min-height: 70vh;">
    <header class="page-header" style="margin-bottom: 40px;">
        <h1 class="page-title" style="font-size: 36px; font-weight: 800; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 10px;">
            <?php echo esc_html($term_name); ?> Videos
        </h1>
        <p class="page-subtitle" style="color: var(--text-secondary); font-size: 15px;">
            <?php 
            if (!empty($term_desc)) {
                echo esc_html($term_desc);
            } else {
                echo sprintf(__('Browse our collection of %s videos categorized under &ldquo;%s&rdquo;.', 'hexmy'), number_format($count), esc_html($term_name));
            }
            ?>
        </p>
    </header>

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
        <div class="glass" style="max-width: 600px; margin: 40px auto; padding: 40px; text-align: center; border-radius: 16px;">
            <p style="color: var(--text-secondary); font-size: 16px; margin: 0;">No videos found in this category.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
