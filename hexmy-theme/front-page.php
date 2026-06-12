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

<div class="container" style="padding-top: 30px; padding-bottom: 50px;">
    <div class="archive-layout">
        
        <!-- Left Sidebar (UltimaTube Style) -->
        <aside class="archive-aside">
            <!-- Sort Filters block -->
            <div class="aside-block aside-filters">
                <h3>Sort Videos</h3>
                <span>
                    <a class="<?php echo $filter === 'latest' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'latest')); ?>">
                        Newest
                    </a>
                </span>
                <span>
                    <a class="<?php echo $filter === 'popular' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'popular')); ?>">
                        Best
                    </a>
                </span>
                <span>
                    <a class="<?php echo $filter === 'most-viewed' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'most-viewed')); ?>">
                        Most viewed
                    </a>
                </span>
                <span>
                    <a class="<?php echo $filter === 'longest' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'longest')); ?>">
                        Longest
                    </a>
                </span>
                <span>
                    <a class="<?php echo $filter === 'random' ? 'active' : ''; ?>" href="<?php echo esc_url(add_query_arg('filter', 'random')); ?>">
                        Random
                    </a>
                </span>
            </div>
            
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

            <!-- Actors/Pornstars block -->
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
            <h2 class="widget-title">
                <?php
                if ($filter === 'popular') echo 'Best Videos';
                elseif ($filter === 'most-viewed') echo 'Most Viewed Videos';
                elseif ($filter === 'longest') echo 'Longest Videos';
                elseif ($filter === 'random') echo 'Random Videos';
                else echo 'Newest Videos';
                ?>
            </h2>
            
            <!-- Filters sub-menu row -->
            <div class="filters">
                <a class="filter-title" href="#!">
                    <?php echo ucfirst($filter === 'latest' ? 'Newest' : $filter); ?>
                </a>
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
                        $image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                        $preview_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
                ?>
                    <a href="<?php the_permalink(); ?>" class="video-card">
                        <div class="video-thumbnail">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php elseif (!empty($image_url)) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else : ?>
                                <div class="skeleton" style="width: 100%; height: 100%;"></div>
                            <?php endif; ?>

                            <?php if (!empty($preview_url)) : ?>
                                <video class="hover-preview" src="<?php echo esc_url($preview_url); ?>" muted loop playsinline preload="none"></video>
                            <?php endif; ?>
                            
                            <span class="hd-badge">HD</span>
                            <span class="duration-badge">
                                <?php 
                                $duration = get_post_meta(get_the_ID(), '_video_minutes', true);
                                if (empty($duration)) {
                                    $duration = get_post_meta(get_the_ID(), '_video_duration', true) ?: '10:00';
                                }
                                echo esc_html($duration); 
                                ?>
                            </span>
                        </div>
                        
                        <div class="video-info">
                            <h3 class="video-title"><?php the_title(); ?></h3>
                            <div class="video-meta">
                                <span class="video-views">
                                    <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(1000, 9999)); ?> views
                                </span>
                                <span class="video-rating">
                                    <?php 
                                    $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                                    if (!empty($likes)) {
                                        echo esc_html($likes) . '%';
                                    } else {
                                        echo rand(70, 95) . '%';
                                    }
                                    ?> likes
                                </span>
                            </div>
                        </div>
                    </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p style="color: var(--text-muted); padding: 20px; text-align: center;">No videos found.</p>';
                endif;
                ?>
            </div>

            <!-- Pagination block -->
            <div class="pagination" style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
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
        </main>
        
    </div>
</div>

<?php get_footer(); ?>
