<?php
/**
 * Template Name: Categories Page
 * File: page-category.php
 */

get_header(); 

// Read current page number (supporting custom rewrite query var cat_paged to prevent static page 404s)
$paged = get_query_var('cat_paged') ? intval(get_query_var('cat_paged')) : (get_query_var('page') ? intval(get_query_var('page')) : (get_query_var('paged') ? intval(get_query_var('paged')) : 1));
$posts_per_page = 24; // 6 rows of 4-column cards
$offset = ($paged - 1) * $posts_per_page;

// Count total category terms that are non-empty
$total_terms = wp_count_terms('video_category', array('hide_empty' => true));
$total_pages = ceil($total_terms / $posts_per_page);

// Fetch categories for current page
$categories = get_terms('video_category', array(
    'hide_empty' => true,
    'orderby' => 'count',
    'order' => 'DESC',
    'number' => $posts_per_page,
    'offset' => $offset
));
$cat_count = (!empty($categories) && !is_wp_error($categories)) ? count($categories) : 0;
?>

<style>
    /* ==========================================================================
       VIP4K CATEGORY/CHANNELS PAGE STYLES (TAG-BASED DIRECTORY WITH PAGINATION)
       ========================================================================== */
    .channels-page {
        padding: 20px 0 60px;
    }

    .channels-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 24px;
        padding-top: 25px;
    }

    .category-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        position: relative; /* relative parent for absolute circle badge */
    }

    .category-item:hover {
        transform: translateY(-5px);
        border-color: rgba(247, 0, 35, 0.35);
        box-shadow: 0 12px 30px rgba(0,0,0,0.4);
    }

    .category-item__image-wrap {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #0d0d10;
        overflow: hidden;
        display: block;
    }

    .category-item__image {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .category-item:hover .category-item__image {
        transform: scale(1.06);
    }

    /* Floating Circle Badge overlapping bottom-left image */
    .category-item__circle-badge {
        position: absolute;
        left: 15px;
        bottom: 12px;
        width: 74px;
        height: 74px;
        border-radius: 50%;
        background: #111116;
        border: 2px solid rgba(255, 255, 255, 0.12);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 5;
        box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        padding: 4px;
        text-align: center;
        transition: border-color 0.3s ease;
    }

    .category-item:hover .category-item__circle-badge {
        border-color: var(--accent-color);
    }

    .circle-badge__title {
        font-size: 9.5px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.1;
        text-transform: uppercase;
        word-break: break-word;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 2px;
    }

    .circle-badge__sub {
        font-size: 8.5px;
        font-weight: 900;
        color: var(--accent-color);
        border: 1px solid var(--accent-color);
        padding: 0px 4px;
        border-radius: 2px;
        line-height: 1;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .category-item__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 15px 10px 104px; /* padding-left to clear the circle badge */
        background: #111116;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        min-height: 54px;
    }

    .category-item__associated-tags {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex-grow: 1;
        padding-right: 12px;
    }

    .category-item__counter {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-secondary);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 3px 8px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    /* ---- Pagination ---- */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 50px;
    }

    .pagination .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.07);
        color: var(--text-secondary);
        font-weight: 700;
        font-size: 13.5px;
        transition: var(--transition-fast);
        text-decoration: none;
    }

    .pagination .page-numbers:hover {
        background: rgba(247, 0, 35, 0.12);
        border-color: rgba(247, 0, 35, 0.35);
        color: var(--accent-color);
        transform: translateY(-2px);
    }

    .pagination .page-numbers.current {
        background: var(--accent-color);
        border-color: var(--accent-color);
        color: #000;
        cursor: default;
        box-shadow: 0 4px 15px rgba(247, 0, 35, 0.3);
    }

    .pagination .page-numbers.dots {
        background: transparent;
        border-color: transparent;
        color: var(--text-muted);
        cursor: default;
    }

    .no-categories-found {
        color: var(--text-muted);
        text-align: center;
        font-weight: 700;
        padding: 80px 20px;
    }

    /* Tablet viewport rules */
    @media screen and (max-width: 959px) {
        .channels-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding-top: 15px;
        }
        .category-item__image-wrap {
            padding-top: 56.25% !important; /* 16:9 Aspect Ratio */
            aspect-ratio: auto !important;
        }
        .category-item__circle-badge {
            width: 68px;
            height: 68px;
            left: 10px;
            bottom: 12px;
        }
        .circle-badge__title {
            font-size: 9px;
        }
        .circle-badge__sub {
            font-size: 8px;
        }
        .category-item__footer {
            padding: 8px 12px 8px 90px;
            min-height: 48px;
        }
        .category-item__associated-tags {
            font-size: 12px;
        }
    }

    /* Mobile viewport rules */
    @media screen and (max-width: 639px) {
        .channels-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding-top: 10px;
        }
        .category-item__image-wrap {
            padding-top: 56.25% !important; /* 16:9 Aspect Ratio */
            aspect-ratio: auto !important;
        }
        .category-item__circle-badge {
            width: 64px;
            height: 64px;
            left: 8px;
            bottom: 10px;
        }
        .circle-badge__title {
            font-size: 8.5px;
            line-height: 1;
        }
        .circle-badge__sub {
            font-size: 7.5px;
        }
        .category-item__footer {
            padding: 6px 8px 6px 80px;
            min-height: 44px;
        }
        .category-item__associated-tags {
            font-size: 11px;
            padding-right: 6px;
        }
        .category-item__counter {
            font-size: 10.5px;
            padding: 2px 6px;
        }
    }
</style>

<div class="channels-page">
    <div class="container">
        
        <section class="section">
            <div class="section__header" style="border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 15px;">
                <h1 class="section__title title" style="font-size: 24px; font-weight: 800; color: #fff; text-transform: uppercase;">Categories</h1>
            </div>

             <?php if (!empty($categories) && !is_wp_error($categories)) : 
                $used_image_urls = array();
                
                // Query a backup pool of recent videos to draw unique images from if a category's own videos are exhausted
                $backup_videos = get_posts(array(
                    'post_type' => 'video',
                    'posts_per_page' => 120,
                ));
            ?>
                <div class="channels-grid">
                    <?php foreach ($categories as $cat) : 
                        $term_link = get_term_link($cat, 'video_category');
                        if (is_wp_error($term_link)) continue;
                        $video_count = $cat->count;

                        // Retrieve category image url, checking if it was already used to avoid duplicate images
                        $image_url = '';
                        $cached_img = get_term_meta($cat->term_id, '_category_image_url', true);
                        
                        // If cached image is empty, find the first available image from the category's videos and cache it
                        if (empty($cached_img)) {
                            $tag_first_vids = get_posts(array(
                                'post_type' => 'video',
                                'posts_per_page' => 5,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field' => 'term_id',
                                        'terms' => $cat->term_id,
                                    )
                                ),
                            ));
                            if (!empty($tag_first_vids)) {
                                foreach ($tag_first_vids as $v) {
                                    $v_img = get_post_meta($v->ID, '_video_image_url', true);
                                    if (empty($v_img) && has_post_thumbnail($v->ID)) {
                                        $v_img = get_the_post_thumbnail_url($v->ID, 'medium');
                                    }
                                    if (!empty($v_img)) {
                                        $cached_img = $v_img;
                                        update_term_meta($cat->term_id, '_category_image_url', $v_img);
                                        break;
                                    }
                                }
                            }
                        }

                        // Resolve the final unique image for this card in memory
                        if (!empty($cached_img) && !in_array($cached_img, $used_image_urls)) {
                            $image_url = $cached_img;
                            $used_image_urls[] = $cached_img;
                        } else {
                            // The cached image is either empty or already used on this page.
                            // Query up to 100 videos of this category to find a unique image URL
                            $tag_videos = get_posts(array(
                                'post_type' => 'video',
                                'posts_per_page' => 100,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field' => 'term_id',
                                        'terms' => $cat->term_id,
                                    )
                                ),
                            ));
                            
                            if (!empty($tag_videos)) {
                                foreach ($tag_videos as $vid) {
                                    $vid_img = get_post_meta($vid->ID, '_video_image_url', true);
                                    if (empty($vid_img) && has_post_thumbnail($vid->ID)) {
                                        $vid_img = get_the_post_thumbnail_url($vid->ID, 'medium');
                                    }
                                    if (!empty($vid_img) && !in_array($vid_img, $used_image_urls)) {
                                        $image_url = $vid_img;
                                        $used_image_urls[] = $vid_img;
                                        break;
                                    }
                                }
                            }
                            
                            // If still empty (all videos of this tag are already used), pick from the backup pool
                            if (empty($image_url) && !empty($backup_videos)) {
                                foreach ($backup_videos as $vid) {
                                    $vid_img = get_post_meta($vid->ID, '_video_image_url', true);
                                    if (empty($vid_img) && has_post_thumbnail($vid->ID)) {
                                        $vid_img = get_the_post_thumbnail_url($vid->ID, 'medium');
                                    }
                                    if (!empty($vid_img) && !in_array($vid_img, $used_image_urls)) {
                                        $image_url = $vid_img;
                                        $used_image_urls[] = $vid_img;
                                        break;
                                    }
                                }
                            }
                            
                            // Fallback if all else fails
                            if (empty($image_url)) {
                                if (!empty($cached_img)) {
                                    $image_url = $cached_img;
                                } elseif (!empty($tag_videos)) {
                                    $first_vid = $tag_videos[0];
                                    $image_url = get_post_meta($first_vid->ID, '_video_image_url', true);
                                    if (empty($image_url) && has_post_thumbnail($first_vid->ID)) {
                                        $image_url = get_the_post_thumbnail_url($first_vid->ID, 'medium');
                                    }
                                }
                                if (!empty($image_url)) {
                                    $used_image_urls[] = $image_url;
                                }
                            }
                        }

                        // Retrieve associated video tags to display inside the card footer
                        $associated_videos = get_posts(array(
                            'post_type' => 'video',
                            'posts_per_page' => 10,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'video_category',
                                    'field' => 'term_id',
                                    'terms' => $cat->term_id,
                                )
                            ),
                            'fields' => 'ids'
                        ));
                        
                        $unique_tags = array();
                        if (!empty($associated_videos)) {
                            foreach ($associated_videos as $vid_id) {
                                $vid_tags = get_the_terms($vid_id, 'video_tag');
                                if ($vid_tags && !is_wp_error($vid_tags)) {
                                    foreach ($vid_tags as $t) {
                                        $unique_tags[$t->term_id] = $t;
                                    }
                                }
                            }
                        }
                        // Limit to top 2 associated tags
                        $display_cats = array_slice($unique_tags, 0, 2);
                        $cat_initial = strtoupper(substr($cat->name, 0, 1));
                    ?>
                        <div class="category-item">
                            <a href="<?php echo esc_url($term_link); ?>" class="category-item__image-wrap">
                                <?php if (!empty($image_url)) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" class="category-item__image" loading="lazy" referrerpolicy="no-referrer">
                                <?php else : ?>
                                    <div style="position: absolute; inset: 0; background: #111116; display: flex; align-items: center; justify-content: center;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.5">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </a>
                            
                            <!-- Floating Circle Badge overlapping bottom-left image -->
                            <a href="<?php echo esc_url($term_link); ?>" class="category-item__circle-badge">
                                <span class="circle-badge__title"><?php echo esc_html($cat->name); ?></span>
                                <span class="circle-badge__sub">69</span>
                            </a>
                            
                            <div class="category-item__footer">
                                <div class="category-item__associated-tags">
                                    <?php 
                                    if (!empty($display_cats)) {
                                        $names = array();
                                        foreach ($display_cats as $c) {
                                            $names[] = esc_html($c->name);
                                        }
                                        echo implode(' • ', $names);
                                    } else {
                                        echo '69Tube Tag';
                                    }
                                    ?>
                                </div>
                                
                                <div class="category-item__counter">
                                    <?php echo number_format($video_count); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination navigation bar -->
                <?php if ($total_pages > 1) : ?>
                    <div class="pagination">
                        <?php
                        echo paginate_links(array(
                            'base' => user_trailingslashit(home_url('/category/page/%#%/')),
                            'format' => '',
                            'current' => $paged,
                            'total' => $total_pages,
                            'prev_text' => __('&laquo; Prev', 'hexmy'),
                            'next_text' => __('Next &raquo;', 'hexmy'),
                            'type' => 'plain'
                        ));
                        ?>
                    </div>
                <?php endif; ?>

            <?php else : ?>
                <div class="no-categories-found">
                    <p>No categories found. Categories present in video posts will display here.</p>
                </div>
            <?php endif; ?>
        </section>

    </div>
</div>

<?php get_footer(); ?>
