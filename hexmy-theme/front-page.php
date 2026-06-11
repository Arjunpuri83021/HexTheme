<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-slider">
            <div class="hero-slide" style="background-image: linear-gradient(135deg, rgba(147, 51, 234, 0.3), rgba(236, 72, 153, 0.3)), url('https://images.unsplash.com/photo-1516726817505-f5ed825624d8?w=1920');">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h1 class="hero-title">Premium Adult Videos</h1>
                    <div class="hero-meta">
                        <span>🔥 Trending Now</span>
                        <span>⭐ 4.8 Rating</span>
                        <span>👁️ 1.2M Views</span>
                    </div>
                    <button class="btn btn-primary" style="margin-top: 15px;">Watch Now</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Watched Recently Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Watched Recently</h2>
            <a href="<?php echo home_url('/videos/'); ?>" class="btn btn-secondary">View All</a>
        </div>
        
        <div class="video-grid">
            <?php
            $recent_videos = new WP_Query(array(
                'post_type' => 'video',
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC',
            ));
            
            if ($recent_videos->have_posts()) :
                while ($recent_videos->have_posts()) : $recent_videos->the_post();
                    $image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                    $preview_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
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
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(1000, 9999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php 
                                $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                                if (!empty($likes)) {
                                    echo esc_html($likes) . '%';
                                } else {
                                    echo rand(70, 95) . '%';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback placeholder videos
                for ($i = 1; $i <= 8; $i++) :
            ?>
                <div class="video-card fade-in-up">
                    <div class="video-thumbnail">
                        <div class="skeleton" style="width: 100%; height: 100%;"></div>
                        <span class="hd-badge">HD</span>
                        <span class="duration-badge"><?php echo rand(5, 30); ?>:<?php echo str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Featured Video Title <?php echo $i; ?></h3>
                        <div class="video-meta">
                            <span class="video-views">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(rand(1000, 9999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php echo rand(70, 95); ?>%
                            </span>
                        </div>
                    </div>
                </div>
            <?php
                endfor;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Most Popular Section -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Most Popular</h2>
            <a href="<?php echo home_url('/videos/'); ?>" class="btn btn-secondary">More Videos</a>
        </div>
        
        <div class="video-grid">
            <?php
            $popular_videos = new WP_Query(array(
                'post_type' => 'video',
                'posts_per_page' => 8,
                'meta_key' => '_video_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));
            
            if ($popular_videos->have_posts()) :
                while ($popular_videos->have_posts()) : $popular_videos->the_post();
                    $image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                    $preview_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
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
                            <?php 
                            $duration = get_post_meta(get_the_ID(), '_video_minutes', true);
                            if (empty($duration)) {
                                $duration = get_post_meta(get_the_ID(), '_video_duration', true) ?: '15:00';
                            }
                            echo esc_html($duration); 
                            ?>
                        </span>
                    </div>
                    
                    <div class="video-info">
                        <h3 class="video-title"><?php the_title(); ?></h3>
                        <div class="video-meta">
                            <span class="video-views">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(10000, 99999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php 
                                $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                                if (!empty($likes)) {
                                    echo esc_html($likes) . '%';
                                } else {
                                    echo rand(80, 99) . '%';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                for ($i = 1; $i <= 8; $i++) :
            ?>
                <div class="video-card fade-in-up">
                    <div class="video-thumbnail">
                        <div class="skeleton" style="width: 100%; height: 100%;"></div>
                        <span class="hd-badge">HD</span>
                        <span class="duration-badge"><?php echo rand(10, 45); ?>:<?php echo str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Popular Video <?php echo $i; ?></h3>
                        <div class="video-meta">
                            <span class="video-views">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(rand(10000, 99999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php echo rand(80, 99); ?>%
                            </span>
                        </div>
                    </div>
                </div>
            <?php
                endfor;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- New Videos Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">New Videos</h2>
            <a href="<?php echo home_url('/videos/'); ?>" class="btn btn-secondary">View All</a>
        </div>
        
        <div class="video-grid">
            <?php
            $new_videos = new WP_Query(array(
                'post_type' => 'video',
                'posts_per_page' => 8,
                'orderby' => 'date',
                'order' => 'DESC',
            ));
            
            if ($new_videos->have_posts()) :
                while ($new_videos->have_posts()) : $new_videos->the_post();
                    $image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                    $preview_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
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
                            <?php 
                            $duration = get_post_meta(get_the_ID(), '_video_minutes', true);
                            if (empty($duration)) {
                                $duration = get_post_meta(get_the_ID(), '_video_duration', true) ?: '20:00';
                            }
                            echo esc_html($duration); 
                            ?>
                        </span>
                    </div>
                    
                    <div class="video-info">
                        <h3 class="video-title"><?php the_title(); ?></h3>
                        <div class="video-meta">
                            <span class="video-views">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(100, 999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php 
                                $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                                if (!empty($likes)) {
                                    echo esc_html($likes) . '%';
                                } else {
                                    echo rand(60, 90) . '%';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                for ($i = 1; $i <= 8; $i++) :
            ?>
                <div class="video-card fade-in-up">
                    <div class="video-thumbnail">
                        <div class="skeleton" style="width: 100%; height: 100%;"></div>
                        <span class="hd-badge">HD</span>
                        <span class="duration-badge"><?php echo rand(5, 25); ?>:<?php echo str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">New Video <?php echo $i; ?></h3>
                        <div class="video-meta">
                            <span class="video-views">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <?php echo number_format(rand(100, 999)); ?> views
                            </span>
                            <span class="video-rating" style="color: var(--accent-purple);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                <?php echo rand(60, 90); ?>%
                            </span>
                        </div>
                    </div>
                </div>
            <?php
                endfor;
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
