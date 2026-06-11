<?php get_header(); ?>

<div class="container" style="padding-top: 120px; padding-bottom: 60px;">
    <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 30px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Videos
    </h1>

    <!-- Filters -->
    <div class="glass" style="padding: 20px; margin-bottom: 30px;">
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <select id="sort-videos" style="padding: 10px 15px; background: var(--bg-tertiary); border: 1px solid var(--glass-border); border-radius: 8px; color: var(--text-primary); min-width: 150px;">
                <option value="latest">Latest</option>
                <option value="popular">Most Popular</option>
                <option value="views">Most Views</option>
                <option value="rating">Highest Rated</option>
            </select>
            
            <select id="duration-filter" style="padding: 10px 15px; background: var(--bg-tertiary); border: 1px solid var(--glass-border); border-radius: 8px; color: var(--text-primary); min-width: 150px;">
                <option value="all">All Durations</option>
                <option value="short">Short (&lt;10 min)</option>
                <option value="medium">Medium (10-30 min)</option>
                <option value="long">Long (&gt;30 min)</option>
            </select>
            
            <select id="category-filter" style="padding: 10px 15px; background: var(--bg-tertiary); border: 1px solid var(--glass-border); border-radius: 8px; color: var(--text-primary); min-width: 150px;">
                <option value="all">All Categories</option>
                <?php
                $categories = get_terms('video_category');
                if ($categories && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                ?>
                    <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
    </div>

    <!-- Video Grid -->
    <?php if (have_posts()) : ?>
        <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px;">
            <style>
                @media (max-width: 768px) {
                    .video-grid {
                        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)) !important;
                        gap: 15px !important;
                    }
                }
            </style>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/video-card'); ?>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <div style="text-align: center; padding: 60px 20px;">
            <p style="color: var(--text-secondary); font-size: 18px;">No videos found.</p>
            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary" style="margin-top: 20px;">Back to Home</a>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
