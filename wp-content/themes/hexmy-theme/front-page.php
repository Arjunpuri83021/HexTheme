<?php 
get_header(); 

// Read sort query parameters
$filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'latest';
$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($_GET['paged']) ? intval($_GET['paged']) : 1);

$args = array(
    'post_type' => 'video',
    'posts_per_page' => 16,
    'paged' => $paged,
);

if ($filter === 'popular') {
    $args['meta_key'] = '_video_likes';
    $args['orderby'] = 'meta_value_num';
    $args['order'] = 'DESC';
} elseif ($filter === 'most-viewed') {
    $args['meta_key'] = '_video_views';
    $args['orderby'] = 'meta_value_num';
    $args['order'] = 'DESC';
} elseif ($filter === 'longest') {
    $args['meta_key'] = '_video_minutes';
    $args['orderby'] = 'meta_value_num';
    $args['order'] = 'DESC';
} elseif ($filter === 'random') {
    $args['orderby'] = 'rand';
} else {
    // latest / fallback
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
}

$video_query = new WP_Query($args);
?>



<section class="section">
    <!-- Filters sub-menu row -->
    <div class="filters">
        <span class="filter-title">
            <?php
            if ($filter === 'popular') echo 'Best Videos';
            elseif ($filter === 'most-viewed') echo 'Most Viewed';
            elseif ($filter === 'longest') echo 'Longest';
            elseif ($filter === 'random') echo 'Random';
            else echo 'Newest Videos';
            ?>
        </span>
        <div class="filters-list">
            <a class="<?php echo $filter === 'latest' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'latest')); ?>">Newest</a>
            <a class="<?php echo $filter === 'popular' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'popular')); ?>">Best</a>
            <a class="<?php echo $filter === 'most-viewed' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'most-viewed')); ?>">Most viewed</a>
            <a class="<?php echo $filter === 'longest' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'longest')); ?>">Longest</a>
            <a class="<?php echo $filter === 'random' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'random')); ?>">Random</a>
        </div>
    </div>

    <!-- Videos grid list -->
    <div class="video-grid">
        <?php
        if ($video_query->have_posts()) :
            while ($video_query->have_posts()) : $video_query->the_post();
                get_template_part('template-parts/video-card');
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p style="color: var(--text-muted); padding: 40px; text-align: center; grid-column: 1 / -1; font-weight: 700;">No videos found.</p>';
        endif;
        ?>
    </div>

    <!-- Pagination block -->
    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $video_query->max_num_pages,
            'current' => $paged,
            'format' => '?paged=%#%',
            'prev_text' => __('&laquo; Prev', 'hexmy'),
            'next_text' => __('Next &raquo;', 'hexmy'),
            'type' => 'plain'
        ));
        ?>
    </div>
</section>

<?php get_footer(); ?>
