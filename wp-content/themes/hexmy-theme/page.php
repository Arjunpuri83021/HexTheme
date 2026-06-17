<?php get_header(); ?>

<div class="container" style="padding-top: 120px; padding-bottom: 60px;">
    <?php while (have_posts()) : the_post(); ?>
        <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 30px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <?php the_title(); ?>
        </h1>
        
        <div class="glass" style="padding: 30px;">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
