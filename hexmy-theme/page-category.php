<?php
/**
 * Template Name: Categories Page
 * File: page-category.php
 */

get_header(); 

$categories = get_terms('video_category', array(
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));
$cat_count = (!empty($categories) && !is_wp_error($categories)) ? count($categories) : 0;
?>

<div class="container page-container">
    <header class="page-header" style="text-align: center; margin-bottom: 40px;">
        <h1 class="page-title">Explore Categories</h1>
        <p class="page-subtitle">Browse through our highly organized directory of <?php echo number_format($cat_count); ?> adult video categories.</p>
    </header>

    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
        <div class="categories-grid" id="categories-list-grid">
            <?php foreach ($categories as $cat) : 
                $term_link = get_term_link($cat, 'video_category');
                if (is_wp_error($term_link)) continue;
                $video_count = $cat->count;

                // Try to get cached category image
                $random_image = get_term_meta($cat->term_id, '_category_image_url', true);
                if (empty($random_image)) {
                    // Query 1 random video to pick a random image URL for the category
                    $videos = get_posts(array(
                        'post_type' => 'video',
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'video_category',
                                'field' => 'term_id',
                                'terms' => $cat->term_id,
                            )
                        ),
                        'fields' => 'ids',
                    ));

                    if (!empty($videos)) {
                        $random_image = get_post_meta($videos[0], '_video_image_url', true);
                        if (!empty($random_image)) {
                            update_term_meta($cat->term_id, '_category_image_url', $random_image);
                        }
                    }
                }
            ?>
                <a href="<?php echo esc_url($term_link); ?>" class="category-card">
                    <?php if (!empty($random_image)) : ?>
                        <img src="<?php echo esc_url($random_image); ?>" alt="<?php echo esc_attr($cat->name); ?>" class="category-card-image" referrerpolicy="no-referrer">
                    <?php else : ?>
                        <div class="category-placeholder-avatar">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="category-card-overlay">
                        <h3 class="category-card-name"><?php echo esc_html($cat->name); ?></h3>
                        <span class="category-card-count"><?php echo number_format($video_count); ?> videos</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="no-tags-found">
            <p>No video categories found. Video category terms enqueued in posts will display here.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
