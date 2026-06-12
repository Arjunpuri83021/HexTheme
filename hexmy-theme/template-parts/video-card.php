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
$likes = get_post_meta(get_the_ID(), '_video_likes', true);
?>

<a href="<?php the_permalink(); ?>" class="video-card fade-in-up">
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
            <?php echo esc_html($duration); ?>
        </span>
    </div>
    
    <div class="video-info">
        <h3 class="video-title"><?php the_title(); ?></h3>
        <div class="video-meta">
            <span class="video-views">
                <?php echo number_format($views ?: rand(1000, 9999)); ?> views
            </span>
            <span class="video-rating">
                <?php echo esc_html(!empty($likes) ? $likes : rand(70, 95)); ?>% likes
            </span>
        </div>
    </div>
</a>
