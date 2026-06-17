<?php
/**
 * Template Name: Related Videos Page
 * File: page-related-videos.php
 */

get_header();

// Get the source video post ID
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$source_post = $post_id ? get_post($post_id) : null;

$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($_GET['paged']) ? intval($_GET['paged']) : 1);

$video_query = null;
$title_suffix = "";

if ($source_post && $source_post->post_type === 'video') {
    $title_suffix = "Related to \"" . esc_html($source_post->post_title) . "\"";
    
    // Get taxonomies of this video
    $tag_ids = wp_get_post_terms($post_id, 'video_tag', array('fields' => 'ids'));
    $pornstar_ids = wp_get_post_terms($post_id, 'pornstar', array('fields' => 'ids'));
    
    $tax_query = array('relation' => 'OR');
    if (!empty($tag_ids)) {
        $tax_query[] = array(
            'taxonomy' => 'video_tag',
            'field'    => 'term_id',
            'terms'    => $tag_ids,
            'operator' => 'IN',
        );
    }
    if (!empty($pornstar_ids)) {
        $tax_query[] = array(
            'taxonomy' => 'pornstar',
            'field'    => 'term_id',
            'terms'    => $pornstar_ids,
            'operator' => 'IN',
        );
    }
    
    $args = array(
        'post_type' => 'video',
        'posts_per_page' => 24, // Show 24 related videos per page
        'post__not_in' => array($post_id),
        'paged' => $paged,
    );
    
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }
    
    $video_query = new WP_Query($args);
} else {
    $title_suffix = "Related Videos";
}
?>

<div class="container" style="padding-top: 30px; padding-bottom: 50px;">
    <div class="archive-layout">
        
        <!-- Left Sidebar (UltimaTube Style) -->
        <aside class="archive-aside">
            <!-- Categories block -->
            <div class="aside-block aside-cats">
                <h3>Categories</h3>
                <?php
                $cats = get_terms(array(
                    'taxonomy' => 'video_category',
                    'number' => 10,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ));
                if (!empty($cats) && !is_wp_error($cats)) :
                    foreach ($cats as $cat) :
                ?>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php 
                    endforeach;
                endif;
                ?>
                <a class="show-all-link" href="<?php echo esc_url(home_url('/category/')); ?>">
                    All categories <i class="fa fa-angle-right"></i>
                </a>
            </div>

            <!-- Tags block -->
            <div class="aside-block aside-tags">
                <h3>Tags</h3>
                <?php
                $tags = get_terms(array(
                    'taxonomy' => 'video_tag',
                    'number' => 15,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ));
                if (!empty($tags) && !is_wp_error($tags)) :
                    foreach ($tags as $tag) :
                ?>
                    <a href="<?php echo esc_url(get_term_link($tag)); ?>">
                        <?php echo esc_html($tag->name); ?>
                    </a>
                <?php 
                    endforeach;
                endif;
                ?>
                <a class="show-all-link" href="<?php echo esc_url(home_url('/tag/')); ?>">
                    All tags <i class="fa fa-angle-right"></i>
                </a>
            </div>

            <!-- Actors block -->
            <div class="aside-block aside-actors">
                <h3>Pornstars</h3>
                <?php
                $actors = get_terms(array(
                    'taxonomy' => 'pornstar',
                    'number' => 10,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ));
                if (!empty($actors) && !is_wp_error($actors)) :
                    foreach ($actors as $actor) :
                ?>
                    <a href="<?php echo esc_url(get_term_link($actor)); ?>">
                        <?php echo esc_html($actor->name); ?>
                    </a>
                <?php 
                    endforeach;
                endif;
                ?>
                <a class="show-all-link" href="<?php echo esc_url(home_url('/pornstar/')); ?>">
                    All stars <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </aside>

        <!-- Right Content Block -->
        <main class="archive-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                <h2 class="widget-title" style="margin-bottom: 0;">
                    <?php echo esc_html($title_suffix); ?>
                </h2>
                <?php if ($source_post) : ?>
                    <a href="<?php echo esc_url(get_permalink($source_post->ID)); ?>" class="btn btn-secondary" style="font-size: 13px; font-weight: 700; padding: 8px 15px; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid var(--border-color); background: var(--bg-secondary); color: var(--text-primary); transition: var(--transition-fast);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Video
                    </a>
                <?php endif; ?>
            </div>

            <!-- Videos grid list -->
            <?php if ($video_query && $video_query->have_posts()) : ?>
                <div class="video-grid">
                    <?php while ($video_query->have_posts()) : $video_query->the_post(); ?>
                        <?php get_template_part('template-parts/video-card'); ?>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination block -->
                <div class="pagination" style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
                    <?php 
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max(1, $paged),
                        'total' => $video_query->max_num_pages,
                        'prev_text' => __('&laquo; Prev', 'hexmy'),
                        'next_text' => __('Next &raquo;', 'hexmy'),
                        'type' => 'plain'
                    )); 
                    ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div style="text-align: center; padding: 60px 20px;">
                    <p style="color: var(--text-secondary); font-size: 16px;">No related videos found.</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-primary" style="margin-top: 20px;">Back to Home</a>
                </div>
            <?php endif; ?>
        </main>
        
    </div>
</div>

<?php get_footer(); ?>
