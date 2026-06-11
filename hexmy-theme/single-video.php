<?php get_header(); ?>

<style>
    .single-video-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }
    @media (max-width: 768px) {
        .single-video-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>

<div class="container" style="padding-top: 120px; padding-bottom: 60px;">
    <div class="single-video-layout">
        <!-- Video Player Section -->
        <div>
            <div class="glass" style="border-radius: 16px; overflow: hidden; margin-bottom: 30px;">
                <div style="aspect-ratio: 16/9; background: var(--bg-secondary); display: flex; align-items: center; justify-content: center; position: relative;">
                    <?php
                    $iframe_url = get_post_meta(get_the_ID(), '_video_iframe_url', true);
                    $video_url = get_post_meta(get_the_ID(), '_video_url', true);
                    
                    if (!empty($iframe_url)) :
                    ?>
                        <iframe src="<?php echo esc_url($iframe_url); ?>" width="100%" height="100%" frameborder="0" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"></iframe>
                    <?php
                    elseif (!empty($video_url) && preg_match('/\.mp4$/i', $video_url)) :
                    ?>
                        <video src="<?php echo esc_url($video_url); ?>" controls autoplay style="width: 100%; height: 100%; object-fit: contain;"></video>
                    <?php
                    else :
                    ?>
                        <p style="color: var(--text-muted); padding: 20px; text-align: center;">
                            <?php _e('Video playback is not available for this post.', 'hexmy'); ?>
                        </p>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
            
            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 20px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                <?php the_title(); ?>
            </h1>
            
            <div style="display: flex; gap: 20px; margin-bottom: 20px; color: var(--text-secondary); font-size: 14px;">
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; vertical-align: middle;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(1000, 9999)); ?> views
                </span>
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; vertical-align: middle;">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <?php echo get_the_date(); ?>
                </span>
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="display: inline; vertical-align: middle; color: var(--accent-purple);">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                    <?php 
                    $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                    $rating = 78 + (get_the_ID() % 20);
                    if (!empty($likes)) {
                        $rating = ($likes > 100) ? 78 + ($likes % 20) : $likes;
                    }
                    echo esc_html($rating); 
                    ?>% likes
                </span>
            </div>
            
            <!-- Like/Dislike/Share Buttons -->
            <div style="display: flex; gap: 15px; margin-bottom: 30px;">
                <button class="btn btn-secondary like-button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                    </svg>
                    Like
                </button>
                <button class="btn btn-secondary dislike-button">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                    </svg>
                    Dislike
                </button>
                <button class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    Share
                </button>
                <button class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Save
                </button>
            </div>
            
            <!-- Pornstars -->
            <?php
            $pornstars = get_the_terms(get_the_ID(), 'pornstar');
            if ($pornstars && !is_wp_error($pornstars)) :
            ?>
            <div style="margin-bottom: 25px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: var(--text-primary);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-pink)" stroke-width="2" style="display: inline; vertical-align: middle; margin-right: 6px;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <?php echo count($pornstars) > 1 ? 'Pornstars' : 'Pornstar'; ?>
                </h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php foreach ($pornstars as $pornstar) : ?>
                        <a href="<?php echo get_term_link($pornstar); ?>" style="display: inline-flex; align-items: center; gap: 10px; padding: 8px 16px 8px 8px; background: var(--bg-tertiary); border: 1px solid rgba(147, 51, 234, 0.2); border-radius: 30px; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.borderColor='rgba(147,51,234,0.6)';this.style.background='rgba(147,51,234,0.1)'" onmouseout="this.style.borderColor='rgba(147,51,234,0.2)';this.style.background='var(--bg-tertiary)'">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--accent-purple), var(--accent-pink)); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <span style="color: #fff; font-weight: 700; font-size: 13px;"><?php echo strtoupper(substr($pornstar->name, 0, 1)); ?></span>
                            </div>
                            <span style="color: var(--text-primary); font-size: 14px; font-weight: 600;"><?php echo esc_html($pornstar->name); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Video Description -->
            <div class="glass" style="padding: 30px; margin-bottom: 30px;">
                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 15px; color: var(--text-primary);">Description</h3>
                <div style="color: var(--text-secondary); line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <!-- Tags -->
            <?php
            $tags = get_the_terms(get_the_ID(), 'video_tag');
            if ($tags && !is_wp_error($tags)) :
            ?>
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 15px; color: var(--text-primary);">Tags</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?php echo get_term_link($tag); ?>" style="padding: 8px 16px; background: var(--bg-tertiary); border-radius: 20px; font-size: 13px; color: var(--text-secondary); transition: var(--transition-fast);" onmouseover="this.style.color='var(--accent-purple)'" onmouseout="this.style.color='var(--text-secondary)'">
                            <?php echo $tag->name; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Comments Section -->
            <div class="glass" style="padding: 30px;">
                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; color: var(--text-primary);">Comments</h3>
                <?php comments_template(); ?>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div>
            <!-- Related Videos -->
            <div class="glass" style="padding: 20px; margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; color: var(--text-primary);">Related Videos</h3>
                <?php
                $related_videos = new WP_Query(array(
                    'post_type' => 'video',
                    'posts_per_page' => 5,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand',
                ));
                
                if ($related_videos->have_posts()) :
                    while ($related_videos->have_posts()) : $related_videos->the_post();
                        $video_image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                        $preview_video_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
                ?>
                    <a href="<?php the_permalink(); ?>" class="video-card" data-video-url="<?php echo esc_url($preview_video_url); ?>" style="display: flex; gap: 15px; margin-bottom: 20px; text-decoration: none; color: inherit; width: 100%; box-sizing: border-box;">
                        <div style="width: 120px; aspect-ratio: 16/9; background: var(--bg-secondary); border-radius: 8px; overflow: hidden; flex-shrink: 0; position: relative;">
                            <?php if (!empty($video_image_url)) : ?>
                                <img src="<?php echo esc_url($video_image_url); ?>" alt="<?php the_title(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php elseif (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium'); ?>
                            <?php else : ?>
                                <div class="skeleton" style="width: 100%; height: 100%;"></div>
                            <?php endif; ?>
                            <span class="duration-badge" style="position: absolute; bottom: 5px; right: 5px; padding: 3px 6px; background: rgba(0,0,0,0.7); color: white; font-size: 10px; border-radius: 4px;">
                                <?php echo esc_html(get_post_meta(get_the_ID(), '_video_minutes', true) ?: '10:00'); ?>
                            </span>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 8px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: var(--text-primary);">
                                <?php the_title(); ?>
                            </h4>
                            <span style="font-size: 12px; color: var(--text-muted);">
                                <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(100, 999)); ?> views
                            </span>
                        </div>
                    </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
