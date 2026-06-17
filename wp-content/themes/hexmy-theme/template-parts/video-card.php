<?php
/**
 * Template part for displaying video posts in grids
 * File: template-parts/video-card.php
 */

$image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
$preview_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
$duration = get_post_meta(get_the_ID(), '_video_minutes', true);
if (empty($duration)) {
    $duration = get_post_meta(get_the_ID(), '_video_duration', true) ?: '10:00';
}
$views = get_post_meta(get_the_ID(), '_video_views', true);

$pornstars = get_the_terms(get_the_ID(), 'pornstar');
$first_star = null;
$star_link = '#';
$star_image = '';

if (!empty($pornstars) && !is_wp_error($pornstars)) {
    $first_star = $pornstars[0];
    $star_link = get_term_link($first_star);
    $star_image = get_term_meta($first_star->term_id, '_pornstar_image_url', true);
}

$categories = get_the_terms(get_the_ID(), 'video_category');
$category_name = '69Tube';
if (!empty($categories) && !is_wp_error($categories)) {
    $category_name = $categories[0]->name;
}
?>

<a href="<?php the_permalink(); ?>" class="video-card fade-in-up">
    <div class="video-thumbnail">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium'); ?>
        <?php elseif (!empty($image_url)) : ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" referrerpolicy="no-referrer">
        <?php else : ?>
            <div class="skeleton" style="width: 100%; height: 100%;"></div>
        <?php endif; ?>

        <?php if (!empty($preview_url)) : ?>
            <video class="hover-preview" src="<?php echo esc_url($preview_url); ?>" muted loop playsinline preload="none"></video>
        <?php endif; ?>
        
        <span class="hd-badge"><?php echo esc_html(get_post_meta(get_the_ID(), '_video_quality', true) ?: (get_post_meta(get_the_ID(), '_video_resolution', true) ?: '1080p')); ?></span>
        <span class="duration-badge">
            <?php echo esc_html($duration); ?>
        </span>
    </div>
    
    <div class="video-info">
        <div class="video-card-meta-top">
            <span class="video-card-channel"><?php echo esc_html($category_name); ?></span>
            <span class="video-card-views"><?php echo number_format($views ?: rand(1000, 9999)); ?> views</span>
        </div>
        <h3 class="video-title"><?php the_title(); ?></h3>
        
        <?php if ($first_star) : ?>
            <div class="video-card-models">
                <div class="video-card-model">
                    <?php if (!empty($star_image)) : ?>
                        <img class="performer-avatar" src="<?php echo esc_url($star_image); ?>" alt="<?php echo esc_attr($first_star->name); ?>" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; flex-shrink: 0;" referrerpolicy="no-referrer">
                    <?php else : ?>
                        <span class="performer-letter-avatar" style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); color: #000; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;"><?php echo strtoupper(substr($first_star->name, 0, 1)); ?></span>
                    <?php endif; ?>
                    <span class="video-card-model-link"><?php echo esc_html($first_star->name); ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</a>
