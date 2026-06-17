<?php get_header(); ?>

<div class="container" style="padding-top: 120px; padding-bottom: 60px;">
    <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 30px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        <?php single_post_title(); ?>
    </h1>

    <?php if (have_posts()) : ?>
        <div class="video-grid">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/video-card'); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p style="color: var(--text-secondary);">No videos found.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
