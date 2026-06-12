<?php
/**
 * Template Name: Pornstars Page
 * File: page-pornstar.php
 */

get_header(); 

// Configure manual pagination for get_terms
$items_per_page = 24;
$paged = 1;
if (get_query_var('page')) {
    $paged = intval(get_query_var('page'));
} elseif (get_query_var('paged')) {
    $paged = intval(get_query_var('paged'));
} elseif (isset($_GET['paged'])) {
    $paged = intval($_GET['paged']);
}
$paged = max(1, $paged);
$offset = ($paged - 1) * $items_per_page;

$total_pornstars = wp_count_terms(array(
    'taxonomy' => 'pornstar',
    'hide_empty' => false,
));
$total_pages = ceil($total_pornstars / $items_per_page);

$pornstars = get_terms(array(
    'taxonomy' => 'pornstar',
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC',
    'number' => $items_per_page,
    'offset' => $offset,
));
?>

<div class="container page-container">
    <header class="page-header" style="text-align: center; margin-bottom: 40px;">
        <h1 class="page-title">Explore Pornstars</h1>
        <p class="page-subtitle">Browse through our directory of the world's most popular adult performers.</p>
    </header>

    <?php if (!empty($pornstars) && !is_wp_error($pornstars)) : ?>
        <div class="pornstars-grid" id="pornstars-list-grid" style="margin-bottom: 40px;">
            <?php foreach ($pornstars as $star) : 
                $term_link = get_term_link($star);
                if (is_wp_error($term_link)) continue;
                $video_count = $star->count;

                // Try to get cached performer image
                $random_image = get_term_meta($star->term_id, '_pornstar_image_url', true);
                if (empty($random_image)) {
                    // Query 1 random video to pick a random image URL for the performer
                    $videos = get_posts(array(
                        'post_type' => 'video',
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'pornstar',
                                'field' => 'term_id',
                                'terms' => $star->term_id,
                            )
                        ),
                        'fields' => 'ids',
                    ));

                    if (!empty($videos)) {
                        $random_image = get_post_meta($videos[0], '_video_image_url', true);
                        if (!empty($random_image)) {
                            update_term_meta($star->term_id, '_pornstar_image_url', $random_image);
                        }
                    }
                }
            ?>
                <a href="<?php echo esc_url($term_link); ?>" class="pornstar-card">
                    <?php if (!empty($random_image)) : ?>
                        <img src="<?php echo esc_url($random_image); ?>" alt="<?php echo esc_attr($star->name); ?>" class="pornstar-card-image" referrerpolicy="no-referrer">
                    <?php else : ?>
                        <div class="pornstar-placeholder-avatar">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="pornstar-card-overlay">
                        <h3 class="pornstar-card-name"><?php echo esc_html($star->name); ?></h3>
                        <span class="pornstar-card-count"><?php echo number_format($video_count); ?> videos</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Block -->
        <div class="pagination" style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
            <?php
            echo paginate_links(array(
                'total' => $total_pages,
                'current' => $paged,
                'format' => '?paged=%#%',
                'prev_text' => __('&laquo; Prev', 'hexmy'),
                'next_text' => __('Next &raquo;', 'hexmy'),
                'type' => 'plain'
            ));
            ?>
        </div>
        
    <?php else : ?>
        <div class="no-tags-found">
            <p>No performers found. Performer tax terms enqueued in scrapers will display here.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
