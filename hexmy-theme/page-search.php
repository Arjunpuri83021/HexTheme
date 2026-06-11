<?php
/**
 * Template Name: Search Results Page
 * File: page-search.php
 */

get_header();

$s = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
$s = trim($s);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page = 16;

$search_query = null;
$total_results = 0;

if (!empty($s)) {
    global $wpdb;
    $search_term = '%' . $wpdb->esc_like($s) . '%';
    
    // Direct SQL query to select post IDs matching title, tag, or pornstar
    $query_str = $wpdb->prepare(
        "SELECT DISTINCT p.ID FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->term_relationships} tr ON (p.ID = tr.object_id)
        LEFT JOIN {$wpdb->term_taxonomy} tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
        LEFT JOIN {$wpdb->terms} t ON (tt.term_id = t.term_id)
        WHERE p.post_type = 'video' 
        AND p.post_status = 'publish'
        AND (
            p.post_title LIKE %s
            OR p.post_content LIKE %s
            OR (tt.taxonomy IN ('video_tag', 'pornstar') AND t.name LIKE %s)
        )",
        $search_term, $search_term, $search_term
    );
    
    $post_ids = $wpdb->get_col($query_str);
    
    if (!empty($post_ids)) {
        $args = array(
            'post_type' => 'video',
            'post__in' => $post_ids,
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'post__in',
        );
        $search_query = new WP_Query($args);
        $total_results = $search_query->found_posts;
    } else {
        $search_query = new WP_Query(array('post__in' => array(0)));
        $total_results = 0;
    }
}
?>

<div class="container" style="padding-top: 120px; padding-bottom: 60px; min-height: 70vh;">
    <?php if (empty($s)) : ?>
        <!-- Empty query state -->
        <div class="glass" style="max-width: 600px; margin: 60px auto; padding: 40px; text-align: center; border-radius: 16px;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: rgba(0, 240, 255, 0.1); border: 1px solid rgba(0, 240, 255, 0.2); border-radius: 50%; color: var(--accent-cyan); margin-bottom: 24px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <h2 style="font-size: 24px; font-weight: 700; color: #ffffff; margin-bottom: 12px;">Explore Hexmy Database</h2>
            <p style="color: var(--text-secondary); font-size: 15px; margin-bottom: 8px;">
                Enter keywords in the search bar above to look up pornstars, tags, or video titles.
            </p>
            <p style="color: var(--text-muted); font-size: 13px;">
                Search suggestions will appear dynamically as you type.
            </p>
        </div>
    <?php elseif ($total_results === 0) : ?>
        <!-- No results found state -->
        <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 30px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Search Results for &ldquo;<?php echo esc_html(ucfirst($s)); ?>&rdquo;
        </h1>
        
        <div class="glass" style="max-width: 600px; margin: 40px auto; padding: 40px; text-align: center; border-radius: 16px;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: rgba(236, 72, 153, 0.1); border: 1px solid rgba(236, 72, 153, 0.2); border-radius: 50%; color: var(--accent-pink); margin-bottom: 24px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <h2 style="font-size: 24px; font-weight: 700; color: #ffffff; margin-bottom: 12px;">No results found</h2>
            <p style="color: var(--text-secondary); font-size: 15px; margin-bottom: 24px; line-height: 1.6;">
                We couldn't find any videos matching &ldquo;<span style="color: var(--accent-cyan); font-weight: 600;"><?php echo esc_html($s); ?></span>&rdquo;.
            </p>
            <div style="background: rgba(0, 0, 0, 0.2); border-radius: 12px; padding: 24px; text-align: left; border: 1px solid rgba(255, 255, 255, 0.03);">
                <h3 style="font-size: 14px; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Search Tips</h3>
                <ul style="color: var(--text-secondary); font-size: 13px; line-height: 1.8; padding-left: 20px; list-style-type: disc; margin: 0;">
                    <li>Check your spelling for any typos.</li>
                    <li>Try using more general keywords (e.g., instead of "extreme blonde compilation", try "blonde").</li>
                    <li>Search for tags or category names directly (e.g. "milf", "amateur", "lesbian").</li>
                    <li>Browse our popular categories, stars, or latest releases.</li>
                </ul>
            </div>
        </div>
    <?php else : ?>
        <!-- Results found state -->
        <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 10px; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Search Results for &ldquo;<?php echo esc_html(ucfirst($s)); ?>&rdquo;
        </h1>
        
        <div style="margin-bottom: 30px; font-size: 14px; color: var(--text-secondary); display: flex; align-items: center; gap: 8px;">
            <span>Showing results for</span>
            <span style="color: var(--accent-cyan); font-weight: 600; padding: 2px 8px; background: rgba(0, 240, 255, 0.05); border: 1px solid rgba(0, 240, 255, 0.15); border-radius: 6px;">&ldquo;<?php echo esc_html($s); ?>&rdquo;</span>
            <span style="color: var(--text-muted);">&bull; <?php echo esc_html($total_results); ?> videos found</span>
        </div>

        <div class="video-grid">
            <?php 
            while ($search_query->have_posts()) : $search_query->the_post(); 
                get_template_part('template-parts/video-card');
            endwhile; 
            wp_reset_postdata();
            ?>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper" style="margin-top: 40px; display: flex; justify-content: center; gap: 8px;">
            <?php
            echo paginate_links(array(
                'total' => $search_query->max_num_pages,
                'current' => $paged,
                'prev_text' => __('&laquo; Prev', 'hexmy'),
                'next_text' => __('Next &raquo;', 'hexmy'),
                'type' => 'plain',
            ));
            ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
