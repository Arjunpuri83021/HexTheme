<?php 
get_header(); 

// Read sort query parameters
$filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'latest';
$paged = (get_query_var('paged')) ? get_query_var('paged') : (isset($_GET['paged']) ? intval($_GET['paged']) : 1);
?>

<div class="container" style="padding-top: 30px; padding-bottom: 50px;">
    <div class="archive-layout">
        

        <!-- Right Content Block -->
        <main class="archive-content">
            <h2 class="widget-title">
                <?php
                if ($filter === 'popular') echo 'Best Videos';
                elseif ($filter === 'most-viewed') echo 'Most Viewed Videos';
                elseif ($filter === 'longest') echo 'Longest Videos';
                elseif ($filter === 'random') echo 'Random Videos';
                else echo 'All Videos';
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
            <?php if (have_posts()) : ?>
                <div class="video-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/video-card'); ?>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination block -->
                <div class="pagination" style="margin-top: 30px; display: flex; justify-content: center; gap: 8px;">
                    <?php the_posts_pagination(array(
                        'prev_text' => __('&laquo; Prev', 'hexmy'),
                        'next_text' => __('Next &raquo;', 'hexmy'),
                        'type' => 'plain'
                    )); ?>
                </div>
            <?php else : ?>
                <div style="text-align: center; padding: 60px 20px;">
                    <p style="color: var(--text-secondary); font-size: 16px;">No videos found.</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-primary" style="margin-top: 20px;">Back to Home</a>
                </div>
            <?php endif; ?>
        </main>
        
    </div>
</div>

<?php get_footer(); ?>
