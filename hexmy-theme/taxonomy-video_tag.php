<?php
/**
 * Archive template for displaying Video Tags
 * File: taxonomy-video_tag.php
 */

get_header();

$term = get_queried_object();
$term_name = $term ? $term->name : __('Tag Archive', 'hexmy');
$term_desc = $term ? $term->description : '';
$count = $term ? $term->count : 0;
?>

<div class="container" style="padding-top: 30px; padding-bottom: 50px; min-height: 70vh;">
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
                    <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="<?php echo ($term && $term->term_id === $tag->term_id) ? 'active' : ''; ?>">
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
            <h2 class="widget-title">
                <?php echo esc_html($term_name); ?> Videos
            </h2>
            
            <p style="color: var(--text-secondary); font-size: 13px; margin-bottom: 20px;">
                <?php 
                if (!empty($term_desc)) {
                    echo esc_html($term_desc);
                } else {
                    echo sprintf(__('Browse our collection of %s videos tagged with &ldquo;%s&rdquo;.', 'hexmy'), number_format($count), esc_html($term_name));
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
                    <p style="color: var(--text-secondary); font-size: 16px; margin: 0;">No videos found in this tag.</p>
                </div>
            <?php endif; ?>
        </main>
        
    </div>
</div>

<?php get_footer(); ?>
