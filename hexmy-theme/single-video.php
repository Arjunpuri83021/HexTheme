<?php get_header(); ?>

<<style>
    /* Prevent page-level horizontal overflow — ALL levels */
    html, body {
        overflow-x: hidden !important;
        max-width: 100% !important;
    }
    *, *::before, *::after {
        box-sizing: border-box;
    }

    /* Container override for single video page wrapper */
    .single-video-page-wrapper {
        color: var(--text-primary) !important;
        padding-top: 30px;
        padding-bottom: 60px;
        font-family: 'Inter', 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    .single-video-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        /* Prevent grid blowout — children can't expand grid beyond container */
        min-width: 0;
        max-width: 100%;
    }

    /* CRITICAL: grid children must have min-width:0 to prevent overflow */
    .single-video-layout > * {
        min-width: 0;
        overflow: hidden;
    }

    /* Glass panel styling override on single video page */
    .single-video-page-wrapper .glass {
        background: #ffffff !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04) !important;
        border-radius: 12px !important;
        overflow: hidden;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .single-video-page-wrapper .glass:hover {
        border-color: #cccccc !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* ---- Video player: force responsive iframe/video ---- */
    .video-player-wrap {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 aspect ratio */
        overflow: hidden;
        background: #000;
        border-radius: 12px;
    }
    .video-player-wrap iframe,
    .video-player-wrap video {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        border: none !important;
        max-width: 100% !important;
    }

    /* Large video player aspect shadow */
    .video-shadow-wrap {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06) !important;
        border: 1px solid #e5e5e5 !important;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Typography styles */
    .video-title-custom {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.35;
        margin-top: 25px;
        margin-bottom: 16px;
        color: #222222 !important;
        letter-spacing: -0.5px;
    }

    /* Metadata pill styles */
    .meta-pill-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        color: #555555;
        font-weight: 600;
    }

    .meta-pill svg {
        color: #777777;
    }

    /* Custom action buttons styling */
    .actions-container {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        color: #333333;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 18px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-btn:hover {
        background: #eaeaea;
        border-color: #cccccc;
        transform: translateY(-2px);
    }

    .action-btn.like-active {
        background: rgba(129, 189, 0, 0.15) !important;
        border-color: rgba(129, 189, 0, 0.3) !important;
        color: var(--accent-green) !important;
    }

    .action-btn.dislike-active {
        background: rgba(231, 67, 74, 0.1) !important;
        border-color: rgba(231, 67, 74, 0.2) !important;
        color: var(--accent-red) !important;
    }

    .action-btn.btn-download-premium {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        animation: pulse-glow 2s infinite;
        text-decoration: none;
    }

    .action-btn.btn-download-premium:hover {
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.6);
        transform: translateY(-2px) scale(1.02);
        color: #ffffff !important;
    }

    @keyframes pulse-glow {
        0% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.5); }
        70% { box-shadow: 0 0 0 10px rgba(236, 72, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0); }
    }

    /* Pornstar pills */
    .pornstar-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 6px 14px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pornstar-pill:hover {
        background: #fafafa !important;
        border-color: var(--accent-red) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(231, 67, 74, 0.15);
    }

    .pornstar-avatar {
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #e7434a, #ec4899);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #ffffff;
        font-size: 11px;
        flex-shrink: 0;
    }

    .pornstar-name {
        color: #333333;
        font-size: 13px;
        font-weight: 700;
        transition: color 0.2s ease;
    }

    .pornstar-pill:hover .pornstar-name {
        color: var(--accent-red);
    }

    /* Custom Tag styling */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag-pill {
        padding: 6px 14px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: #666666;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .tag-pill:hover {
        color: #ffffff !important;
        background: var(--accent-red);
        border-color: var(--accent-red);
        box-shadow: 0 4px 12px rgba(231, 67, 74, 0.25);
        transform: translateY(-1px);
    }

    /* Related video card in sidebar */
    .related-video-card-custom {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        text-decoration: none;
        width: 100%;
        box-sizing: border-box;
        padding: 8px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .related-video-card-custom:hover {
        background: #fafafa;
        border-color: #cccccc;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .related-video-thumb {
        width: 120px;
        aspect-ratio: 16/9;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
        background: #000;
    }

    .related-video-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .related-video-card-custom:hover .related-video-thumb img {
        transform: scale(1.08);
    }

    .related-video-title {
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #333333;
        transition: color 0.2s ease;
    }

    .related-video-card-custom:hover .related-video-title {
        color: var(--accent-red);
    }

    .related-video-meta {
        font-size: 11px;
        color: #777777;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* View More related videos button */
    .btn-view-more-custom {
        display: block;
        text-align: center;
        padding: 12px;
        font-weight: 700;
        border-radius: 50px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: #f5f5f5;
        border: 1px solid #e5e5e5;
        color: #333333;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-view-more-custom:hover {
        background: linear-gradient(135deg, #e7434a, #ec4899);
        border-color: transparent;
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(231, 67, 74, 0.4);
        transform: translateY(-2px);
    }

    /* Comments adjustments */
    .single-video-page-wrapper #respond {
        background: #fcfcfc;
        border: 1px solid #e8e8e8;
        padding: 24px;
        border-radius: 10px;
        margin-top: 25px;
    }
    .single-video-page-wrapper #reply-title {
        color: #333333;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
    .single-video-page-wrapper .comment-form textarea,
    .single-video-page-wrapper .comment-form input[type="text"],
    .single-video-page-wrapper .comment-form input[type="email"] {
        width: 100%;
        background: #ffffff !important;
        border: 1px solid #cccccc !important;
        color: #333333 !important;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
    }
    .single-video-page-wrapper .comment-form textarea:focus,
    .single-video-page-wrapper .comment-form input[type="text"]:focus,
    .single-video-page-wrapper .comment-form input[type="email"]:focus {
        border-color: var(--accent-red) !important;
        outline: none;
    }
    .single-video-page-wrapper .comment-form .submit {
        background: var(--accent-red);
        color: #ffffff;
        border: none;
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s ease;
    }
    .single-video-page-wrapper .comment-form .submit:hover {
        background: #c62828;
        transform: translateY(-2px);
    }
    .single-video-page-wrapper .comment-list {
        margin-top: 30px;
        list-style: none;
        padding: 0;
    }
    .single-video-page-wrapper .comment-body {
        background: #ffffff;
        border: 1px solid #e8e8e8;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .single-video-page-wrapper .comment-meta {
        color: #666666;
        font-size: 12px;
        margin-bottom: 8px;
    }
    .single-video-page-wrapper .comment-content {
        font-size: 14px;
        line-height: 1.6;
        color: #444444;
    }
    .single-video-page-wrapper .comment-content p {
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        /* Single video layout switches to 1 column */
        .single-video-layout {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        /* Title font size reduction */
        .video-title-custom {
            font-size: 18px !important;
            line-height: 1.4 !important;
            margin-top: 15px;
            margin-bottom: 12px !important;
        }

        /* Container padding fix */
        .container {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        /* Description and Comments glass panels */
        .single-video-page-wrapper .glass[style*="padding"] {
            padding: 16px !important;
        }

        /* Related videos: thumbnail width */
        .related-video-thumb {
            width: 100px !important;
        }

        /* Related videos: title font */
        .related-video-title {
            font-size: 12px !important;
        }
    }
</style>

<div class="single-video-page-wrapper">
    <div class="container">
        <div class="single-video-layout">
            <!-- Video Player Section -->
            <div>
                <div class="glass video-shadow-wrap" style="margin-bottom: 30px;">
                    <div class="video-player-wrap">
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
                            <p style="color: #66788f; padding: 20px; text-align: center;">
                                <?php _e('Video playback is not available for this post.', 'hexmy'); ?>
                            </p>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
                
                <h1 class="video-title-custom">
                    <?php the_title(); ?>
                </h1>
                
                <div class="meta-pill-container">
                    <div class="meta-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: inline; vertical-align: middle;">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(1000, 9999)); ?> views
                    </div>
                    <div class="meta-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: inline; vertical-align: middle;">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <?php echo get_the_date(); ?>
                    </div>
                    <div class="meta-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" style="display: inline; vertical-align: middle; color: #10b981;">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <span style="color: #10b981; font-weight: 700;">
                            <?php 
                            $likes = get_post_meta(get_the_ID(), '_video_likes', true);
                            $rating = 78 + (get_the_ID() % 20);
                            if (!empty($likes)) {
                                $rating = ($likes > 100) ? 78 + ($likes % 20) : $likes;
                            }
                            echo esc_html($rating); 
                            ?>% Rating
                        </span>
                    </div>
                </div>
                
                <!-- Like/Dislike/Share Buttons -->
                <div class="actions-container">
                    <button class="action-btn like-button" id="btn-like">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                        </svg>
                        Like
                    </button>
                    <button class="action-btn dislike-button" id="btn-dislike">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                        </svg>
                        Dislike
                    </button>
                    <button class="action-btn" onclick="copyShareLink()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                        Share
                    </button>
                    <button class="action-btn" id="btn-save">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Save
                    </button>
                    <?php 
                    $direct_link = get_option('_hexmy_ad_direct_link');
                    if (!empty($direct_link)) : 
                    ?>
                        <a href="<?php echo esc_url($direct_link); ?>" target="_blank" rel="noopener noreferrer" class="action-btn btn-download-premium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download HD
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Pornstars -->
                <?php
                $pornstars = get_the_terms(get_the_ID(), 'pornstar');
                if ($pornstars && !is_wp_error($pornstars)) :
                ?>
                <div style="margin-bottom: 25px;">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; color: #333333; text-transform: uppercase; letter-spacing: 0.5px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-red)" stroke-width="2.5" style="display: inline; vertical-align: middle; margin-right: 6px;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <?php echo count($pornstars) > 1 ? 'Pornstars' : 'Pornstar'; ?>
                    </h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <?php foreach ($pornstars as $pornstar) : ?>
                            <a href="<?php echo get_term_link($pornstar); ?>" class="pornstar-pill">
                                <div class="pornstar-avatar">
                                    <span><?php echo strtoupper(substr($pornstar->name, 0, 1)); ?></span>
                                </div>
                                <span class="pornstar-name"><?php echo esc_html($pornstar->name); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Video Description -->
                <div class="glass" style="padding: 24px; margin-bottom: 30px;">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; color: #333333; text-transform: uppercase; letter-spacing: 0.5px;">Description</h3>
                    <div style="color: #555555; line-height: 1.8; font-size: 14px;">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <!-- Tags -->
                <?php
                $tags = get_the_terms(get_the_ID(), 'video_tag');
                if ($tags && !is_wp_error($tags)) :
                ?>
                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; color: #333333; text-transform: uppercase; letter-spacing: 0.5px;">Tags</h3>
                    <div class="tags-container">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo get_term_link($tag); ?>" class="tag-pill">
                                <?php echo $tag->name; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Comments Section -->
                <div class="glass" style="padding: 30px;">
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333333;">Comments</h3>
                    <?php comments_template(); ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div>
                <!-- Ad Banner 300x250 -->
                <?php 
                $banner_code = get_option('_hexmy_ad_banner_300x250');
                if (!empty($banner_code)) : 
                ?>
                    <div class="glass" style="padding: 20px; margin-bottom: 30px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 290px;">
                        <span style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #66788f; margin-bottom: 12px; display: block; text-align: center; font-weight: 700;">Advertisement</span>
                        <div style="width: 300px; height: 250px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <?php echo $banner_code; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Related Videos -->
                <div class="glass" style="padding: 24px; margin-bottom: 30px;">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #333333; border-bottom: 1px solid #e5e5e5; padding-bottom: 10px;">Related Videos</h3>
                    <?php
                    $tag_ids = wp_get_post_terms(get_the_ID(), 'video_tag', array('fields' => 'ids'));
                    $pornstar_ids = wp_get_post_terms(get_the_ID(), 'pornstar', array('fields' => 'ids'));

                    $tax_query = array('relation' => 'OR');
                    if (!empty($tag_ids)) {
                        $tax_query[] = array(
                            'taxonomy' => 'video_tag',
                            'field' => 'term_id',
                            'terms' => $tag_ids,
                            'operator' => 'IN',
                        );
                    }
                    if (!empty($pornstar_ids)) {
                        $tax_query[] = array(
                            'taxonomy' => 'pornstar',
                            'field' => 'term_id',
                            'terms' => $pornstar_ids,
                            'operator' => 'IN',
                        );
                    }

                    $args = array(
                        'post_type' => 'video',
                        'posts_per_page' => 6,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand',
                    );

                    if (count($tax_query) > 1) {
                        $args['tax_query'] = $tax_query;
                    }

                    $related_videos = new WP_Query($args);
                    
                    if ($related_videos->have_posts()) :
                        while ($related_videos->have_posts()) : $related_videos->the_post();
                            $video_image_url = get_post_meta(get_the_ID(), '_video_image_url', true);
                            $preview_video_url = get_post_meta(get_the_ID(), '_video_preview_video', true);
                    ?>
                        <a href="<?php the_permalink(); ?>" class="related-video-card-custom" data-video-url="<?php echo esc_url($preview_video_url); ?>">
                            <div class="related-video-thumb">
                                <?php if (!empty($video_image_url)) : ?>
                                    <img src="<?php echo esc_url($video_image_url); ?>" alt="<?php the_title(); ?>">
                                <?php elseif (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <div class="skeleton" style="width: 100%; height: 100%;"></div>
                                <?php endif; ?>
                                <span class="duration-badge" style="position: absolute; bottom: 5px; right: 5px; padding: 2px 5px; background: rgba(0,0,0,0.8); color: white; font-size: 10px; border-radius: 4px; font-weight: 700;">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), '_video_minutes', true) ?: '10:00'); ?>
                                </span>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <h4 class="related-video-title">
                                    <?php the_title(); ?>
                                </h4>
                                <span class="related-video-meta">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: inline; vertical-align: middle; margin-right: 2px;">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <?php echo number_format(get_post_meta(get_the_ID(), '_video_views', true) ?: rand(100, 999)); ?> views
                                </span>
                            </div>
                        </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                    <div style="margin-top: 25px; text-align: center; border-top: 1px solid #e5e5e5; padding-top: 20px;">
                        <a href="<?php echo esc_url(add_query_arg('post_id', get_the_ID(), home_url('/related-videos/'))); ?>" class="btn-view-more-custom">
                            View More Related Videos
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function copyShareLink() {
    var dummy = document.createElement('input'),
    text = window.location.href;
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);
    
    // Create a temporary beautiful toast notification
    var toast = document.createElement('div');
    toast.textContent = 'Share link copied to clipboard!';
    toast.style.position = 'fixed';
    toast.style.bottom = '30px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.background = 'linear-gradient(135deg, #e7434a, #ec4899)';
    toast.style.color = '#ffffff';
    toast.style.padding = '12px 24px';
    toast.style.borderRadius = '50px';
    toast.style.fontWeight = '700';
    toast.style.fontSize = '14px';
    toast.style.zIndex = '9999';
    toast.style.boxShadow = '0 10px 25px rgba(231, 67, 74, 0.4)';
    toast.style.transition = 'opacity 0.3s ease';
    document.body.appendChild(toast);
    
    setTimeout(function() {
        toast.style.opacity = '0';
        setTimeout(function() {
            document.body.removeChild(toast);
        }, 300);
    }, 2000);
}

document.addEventListener('DOMContentLoaded', function() {
    const btnLike = document.getElementById('btn-like');
    const btnDislike = document.getElementById('btn-dislike');
    const btnSave = document.getElementById('btn-save');
    
    if(btnLike && btnDislike) {
        btnLike.addEventListener('click', function() {
            btnLike.classList.toggle('like-active');
            btnDislike.classList.remove('dislike-active');
        });
        btnDislike.addEventListener('click', function() {
            btnDislike.classList.toggle('dislike-active');
            btnLike.classList.remove('like-active');
        });
    }
    
    if(btnSave) {
        btnSave.addEventListener('click', function() {
            btnSave.classList.toggle('like-active');
            if(btnSave.classList.contains('like-active')) {
                btnSave.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> Saved`;
            } else {
                btnSave.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg> Save`;
            }
        });
    }
});
</script>

<?php get_footer(); ?>
