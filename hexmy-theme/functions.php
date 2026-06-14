<?php
/**
 * Hexmy Theme Functions
 */

// Theme Setup
function hexmy_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register Navigation Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'hexmy'),
        'footer' => __('Footer Menu', 'hexmy'),
    ));
}
add_action('after_setup_theme', 'hexmy_theme_setup');

// Enqueue Scripts and Styles
function hexmy_scripts() {
    wp_enqueue_style('hexmy-style', get_stylesheet_uri(), array(), time());
    
    // Google Fonts
    wp_enqueue_style('hexmy-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@800;900&family=Space+Grotesk:wght@700;800&display=swap', array(), null);
    
    // Main JavaScript
    wp_enqueue_script('hexmy-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), time(), true);
    
    // Localize script for AJAX
    wp_localize_script('hexmy-main', 'hexmy_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hexmy_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'hexmy_scripts');

// Register Sidebars
function hexmy_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'hexmy'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'hexmy'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Widgets', 'hexmy'),
        'id'            => 'footer-widgets',
        'description'   => __('Add footer widgets here.', 'hexmy'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'hexmy_widgets_init');

// Custom Post Type for Videos
function hexmy_register_video_post_type() {
    register_post_type('video', array(
        'labels' => array(
            'name' => __('Videos', 'hexmy'),
            'singular_name' => __('Video', 'hexmy'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-video-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'rewrite' => array('slug' => 'videos'),
    ));
}
add_action('init', 'hexmy_register_video_post_type');

// Custom Taxonomies
function hexmy_register_taxonomies() {
    // Categories
    register_taxonomy('video_category', 'video', array(
        'labels' => array(
            'name' => __('Categories', 'hexmy'),
            'singular_name' => __('Category', 'hexmy'),
        ),
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'video-category'),
    ));
    
    // Tags
    register_taxonomy('video_tag', 'video', array(
        'labels' => array(
            'name' => __('Tags', 'hexmy'),
            'singular_name' => __('Tag', 'hexmy'),
        ),
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'tag'),
    ));
    
    // Pornstars
    register_taxonomy('pornstar', 'video', array(
        'labels' => array(
            'name' => __('Pornstars', 'hexmy'),
            'singular_name' => __('Pornstar', 'hexmy'),
        ),
        'hierarchical' => false,
        'public' => true,
        'rewrite' => array('slug' => 'pornstar'),
    ));
}
add_action('init', 'hexmy_register_taxonomies');

// Custom Meta Boxes for Videos
function hexmy_add_video_meta_boxes() {
    add_meta_box(
        'video_details',
        __('Video Details', 'hexmy'),
        'hexmy_video_meta_box_callback',
        'video',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'hexmy_add_video_meta_boxes');

function hexmy_video_meta_box_callback($post) {
    wp_nonce_field('hexmy_video_meta_box', 'hexmy_video_meta_box_nonce');
    
    // Get existing values
    $image_url = get_post_meta($post->ID, '_video_image_url', true);
    $preview_video = get_post_meta($post->ID, '_video_preview_video', true);
    $alt_keywords = get_post_meta($post->ID, '_video_alt_keywords', true);
    $star_name = get_post_meta($post->ID, '_video_star_name', true);
    $views = get_post_meta($post->ID, '_video_views', true);
    $iframe_url = get_post_meta($post->ID, '_video_iframe_url', true);
    $video_url = get_post_meta($post->ID, '_video_url', true);
    $minutes = get_post_meta($post->ID, '_video_minutes', true);
    $likes = get_post_meta($post->ID, '_video_likes', true);
    
    ?>
    <div style="max-width: 600px;">
        <h3>Basic Information</h3>
        
        <p>
            <label for="video_image_url" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Image URL:', 'hexmy'); ?></label>
            <input type="url" id="video_image_url" name="video_image_url" value="<?php echo esc_url($image_url); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p>
            <label for="video_preview_video" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Preview Video URL:', 'hexmy'); ?></label>
            <input type="url" id="video_preview_video" name="video_preview_video" value="<?php echo esc_url($preview_video); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p>
            <label for="video_alt_keywords" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Alt Keywords (comma separated):', 'hexmy'); ?></label>
            <textarea id="video_alt_keywords" name="video_alt_keywords" style="width: 100%; padding: 8px;" rows="3"><?php echo esc_textarea($alt_keywords); ?></textarea>
        </p>
        
        <p>
            <label for="video_star_name" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Star Name:', 'hexmy'); ?></label>
            <input type="text" id="video_star_name" name="video_star_name" value="<?php echo esc_attr($star_name); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <h3 style="margin-top: 20px;">Video Information</h3>
        
        <p>
            <label for="video_views" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Views:', 'hexmy'); ?></label>
            <input type="number" id="video_views" name="video_views" value="<?php echo esc_attr($views); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p>
            <label for="video_iframe_url" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Iframe URL:', 'hexmy'); ?></label>
            <input type="url" id="video_iframe_url" name="video_iframe_url" value="<?php echo esc_url($iframe_url); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p>
            <label for="video_url" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Video URL:', 'hexmy'); ?></label>
            <input type="url" id="video_url" name="video_url" value="<?php echo esc_url($video_url); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p>
            <label for="video_minutes" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Duration (minutes):', 'hexmy'); ?></label>
            <input type="text" id="video_minutes" name="video_minutes" value="<?php echo esc_attr($minutes); ?>" style="width: 100%; padding: 8px;" placeholder="e.g., 10:30">
        </p>
        
        <p>
            <label for="video_likes" style="display: block; font-weight: 600; margin-bottom: 5px;"><?php _e('Likes:', 'hexmy'); ?></label>
            <input type="number" id="video_likes" name="video_likes" value="<?php echo esc_attr($likes); ?>" style="width: 100%; padding: 8px;">
        </p>
        
        <p style="color: #666; font-size: 13px; margin-top: 15px;">
            <strong>Note:</strong> Tags and Categories can be added in the right sidebar. Description can be added in the main content editor.
        </p>
    </div>
    <?php
}

function hexmy_save_video_meta($post_id) {
    if (!isset($_POST['hexmy_video_meta_box_nonce']) || !wp_verify_nonce($_POST['hexmy_video_meta_box_nonce'], 'hexmy_video_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save all fields
    if (isset($_POST['video_image_url'])) {
        update_post_meta($post_id, '_video_image_url', esc_url_raw($_POST['video_image_url']));
    }
    
    if (isset($_POST['video_preview_video'])) {
        update_post_meta($post_id, '_video_preview_video', esc_url_raw($_POST['video_preview_video']));
    }
    
    if (isset($_POST['video_alt_keywords'])) {
        update_post_meta($post_id, '_video_alt_keywords', sanitize_textarea_field($_POST['video_alt_keywords']));
    }
    
    if (isset($_POST['video_star_name'])) {
        update_post_meta($post_id, '_video_star_name', sanitize_text_field($_POST['video_star_name']));
    }
    
    if (isset($_POST['video_views'])) {
        update_post_meta($post_id, '_video_views', intval($_POST['video_views']));
    }
    
    if (isset($_POST['video_iframe_url'])) {
        update_post_meta($post_id, '_video_iframe_url', esc_url_raw($_POST['video_iframe_url']));
    }
    
    if (isset($_POST['video_url'])) {
        update_post_meta($post_id, '_video_url', esc_url_raw($_POST['video_url']));
    }
    
    if (isset($_POST['video_minutes'])) {
        update_post_meta($post_id, '_video_minutes', sanitize_text_field($_POST['video_minutes']));
    }
    
    if (isset($_POST['video_likes'])) {
        update_post_meta($post_id, '_video_likes', intval($_POST['video_likes']));
    }
    
    // Sync taxonomy terms after saving meta details
    hexmy_sync_post_terms($post_id);
}
add_action('save_post', 'hexmy_save_video_meta');

// AJAX Search Handler
function hexmy_ajax_search() {
    check_ajax_referer('hexmy_nonce', 'nonce');
    
    $search_query = sanitize_text_field($_POST['query']);
    
    $args = array(
        'post_type' => 'video',
        's' => $search_query,
        'posts_per_page' => 10,
    );
    
    $query = new WP_Query($args);
    
    $results = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'url' => get_permalink(),
            );
        }
    }
    
    wp_reset_postdata();
    
    wp_send_json_success($results);
}
add_action('wp_ajax_hexmy_search', 'hexmy_ajax_search');
add_action('wp_ajax_nopriv_hexmy_search', 'hexmy_ajax_search');

// Excerpt Length
function hexmy_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'hexmy_excerpt_length');

// Excerpt More
function hexmy_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'hexmy_excerpt_more');

function hexmy_customize_register($wp_customize) {
    // Logo
    $wp_customize->add_setting('hexmy_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hexmy_logo', array(
        'label' => __('Logo', 'hexmy'),
        'section' => 'title_tagline',
        'settings' => 'hexmy_logo',
    )));
}
add_action('customize_register', 'hexmy_customize_register');

// Auto-create Tags, Categories, Pornstars, and Search pages if they do not exist
function hexmy_auto_create_pages() {
    $pages = array(
        'tag' => array(
            'title' => 'Tags',
            'slug' => 'tag'
        ),
        'category' => array(
            'title' => 'Categories',
            'slug' => 'category'
        ),
        'pornstar' => array(
            'title' => 'Pornstars',
            'slug' => 'pornstar'
        ),
        'search' => array(
            'title' => 'Search',
            'slug' => 'search'
        ),
        'related-videos' => array(
            'title' => 'Related Videos',
            'slug' => 'related-videos'
        )
    );
    
    foreach ($pages as $slug => $page_data) {
        $page = get_page_by_path($slug);
        if (!$page) {
            wp_insert_post(array(
                'post_title'    => $page_data['title'],
                'post_name'     => $slug,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_author'   => 1
            ));
        }
    }
}
add_action('init', 'hexmy_auto_create_pages');

// Register custom query variables
function hexmy_register_query_vars($vars) {
    $vars[] = 'tag_slug';
    return $vars;
}
add_filter('query_vars', 'hexmy_register_query_vars');

// Filter CPT video archives when tag_slug query variable is active
function hexmy_handle_tag_slug_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        $tag_slug = $query->get('tag_slug');
        if (!empty($tag_slug)) {
            $query->set('post_type', 'video');
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'video_tag',
                    'field'    => 'slug',
                    'terms'    => $tag_slug,
                )
            ));
        }
    }
}
add_action('pre_get_posts', 'hexmy_handle_tag_slug_query');

// Synchronize taxonomy terms for a single video post
function hexmy_sync_post_terms($post_id) {
    if (get_post_type($post_id) !== 'video') {
        return;
    }
    
    // Sync Tags
    $alt_keywords = get_post_meta($post_id, '_video_alt_keywords', true);
    if (!empty($alt_keywords)) {
        $tags = array_map('trim', explode(',', $alt_keywords));
        $tags = array_filter($tags);
        wp_set_object_terms($post_id, $tags, 'video_tag', false);
    } else {
        wp_set_object_terms($post_id, array(), 'video_tag', false);
    }
    
    // Sync Performers
    $star_name = get_post_meta($post_id, '_video_star_name', true);
    if (!empty($star_name)) {
        $stars = array_map('trim', explode(',', $star_name));
        $stars = array_filter($stars);
        wp_set_object_terms($post_id, $stars, 'pornstar', false);
    } else {
        wp_set_object_terms($post_id, array(), 'pornstar', false);
    }
    
    update_post_meta($post_id, '_terms_synced', 'yes');
}

// Automatically synchronize tags and performers from metadata to terms incrementally
function hexmy_sync_tags_and_performers() {
    $unsynced_videos = get_posts(array(
        'post_type' => 'video',
        'posts_per_page' => 100,
        'post_status' => 'any',
        'meta_query' => array(
            array(
                'key' => '_terms_synced',
                'compare' => 'NOT EXISTS'
            )
        )
    ));
    
    if (!empty($unsynced_videos)) {
        foreach ($unsynced_videos as $video) {
            hexmy_sync_post_terms($video->ID);
        }
    }
}
add_action('wp_loaded', 'hexmy_sync_tags_and_performers');

// Autocomplete search suggestions handler
function hexmy_get_search_suggestions() {
    check_ajax_referer('hexmy_nonce', 'nonce');

    $q = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    $q = trim($q);

    if (empty($q)) {
        wp_send_json_success(array('suggestions' => array()));
    }

    // Query terms from video_tag and pornstar
    $tag_terms = get_terms(array(
        'taxonomy' => 'video_tag',
        'name__like' => $q,
        'hide_empty' => false,
        'number' => 30
    ));

    $pornstar_terms = get_terms(array(
        'taxonomy' => 'pornstar',
        'name__like' => $q,
        'hide_empty' => false,
        'number' => 30
    ));

    $suggestions = array();

    if (!is_wp_error($tag_terms) && !empty($tag_terms)) {
        foreach ($tag_terms as $term) {
            $suggestions[] = array(
                'type' => 'tag',
                'name' => $term->name,
                'href' => esc_url(get_term_link($term)),
            );
        }
    }

    if (!is_wp_error($pornstar_terms) && !empty($pornstar_terms)) {
        foreach ($pornstar_terms as $term) {
            $suggestions[] = array(
                'type' => 'pornstar',
                'name' => $term->name,
                'href' => esc_url(get_term_link($term)),
            );
        }
    }

    // Score and sort matches: exact match first (score 3), prefix match next (score 2), contains match last (score 1)
    $q_lower = strtolower($q);
    usort($suggestions, function($a, $b) use ($q_lower) {
        $name_a = strtolower($a['name']);
        $name_b = strtolower($b['name']);

        $score_a = 1;
        if ($name_a === $q_lower) {
            $score_a = 3;
        } elseif (strpos($name_a, $q_lower) === 0) {
            $score_a = 2;
        }

        $score_b = 1;
        if ($name_b === $q_lower) {
            $score_b = 3;
        } elseif (strpos($name_b, $q_lower) === 0) {
            $score_b = 2;
        }

        if ($score_a !== $score_b) {
            return $score_b - $score_a; // descending score
        }

        return strcmp($name_a, $name_b); // alphabetical order
    });

    // Limit to 15 results
    $suggestions = array_slice($suggestions, 0, 15);

    wp_send_json_success(array('suggestions' => $suggestions));
}
add_action('wp_ajax_hexmy_search_suggestions', 'hexmy_get_search_suggestions');
add_action('wp_ajax_nopriv_hexmy_search_suggestions', 'hexmy_get_search_suggestions');

// Remove Email, Website, and Cookies fields from comment form
function hexmy_remove_comment_fields($fields) {
    if (isset($fields['email'])) {
        unset($fields['email']);
    }
    if (isset($fields['url'])) {
        unset($fields['url']);
    }
    if (isset($fields['cookies'])) {
        unset($fields['cookies']);
    }
    return $fields;
}
add_filter('comment_form_default_fields', 'hexmy_remove_comment_fields');

// Supply dummy email if comment email requirement is enabled
function hexmy_bypass_comment_email_requirement($commentdata) {
    if (empty($commentdata['comment_author_email'])) {
        $commentdata['comment_author_email'] = 'anonymous@localhost.com';
    }
    return $commentdata;
}
add_filter('preprocess_comment', 'hexmy_bypass_comment_email_requirement');
