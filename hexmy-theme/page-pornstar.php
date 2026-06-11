<?php
/**
 * Template Name: Pornstars Page
 * File: page-pornstar.php
 */

get_header(); 

$pornstars = get_terms('pornstar', array(
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));
$star_count = (!empty($pornstars) && !is_wp_error($pornstars)) ? count($pornstars) : 0;
?>

<div class="container page-container">
    <header class="page-header">
        <h1 class="page-title">Explore Pornstars</h1>
        <p class="page-subtitle">Browse through our directory of the world's most popular adult performers.</p>
    </header>

    <!-- A-Z Alphabet Filter Bar -->
    <div class="alphabet-filter-container glass" style="padding: 15px 20px; margin-bottom: 40px; border-radius: 12px; display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 8px;">
        <style>
            .alphabet-btn {
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 700;
                color: var(--text-secondary);
                background: rgba(255, 255, 255, 0.03);
                border: 1px solid rgba(255, 255, 255, 0.05);
                cursor: pointer;
                transition: var(--transition-fast);
            }
            .alphabet-btn:hover {
                background: rgba(255, 51, 153, 0.1);
                border-color: var(--accent-pink);
                color: #ffffff;
                box-shadow: 0 0 10px rgba(255, 51, 153, 0.2);
            }
            .alphabet-btn.active {
                background: rgba(0, 240, 255, 0.15);
                border-color: var(--accent-cyan);
                color: #ffffff;
                box-shadow: 0 0 10px rgba(0, 240, 255, 0.3);
            }
            .alphabet-btn.disabled {
                opacity: 0.3;
                cursor: not-allowed;
                pointer-events: none;
                background: transparent;
                border-color: transparent;
            }
            .no-match-message {
                display: none;
                text-align: center;
                padding: 40px;
                background: var(--bg-card);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                color: var(--text-secondary);
                font-size: 16px;
                width: 100%;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .pornstars-grid {
                transition: all 0.3s ease;
            }
            .pornstar-card {
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            }
        </style>
        
        <?php 
        $alphabet = range('A', 'Z');
        array_unshift($alphabet, '#');
        
        $letters_with_stars = array();
        if (!empty($pornstars) && !is_wp_error($pornstars)) {
            foreach ($pornstars as $star) {
                $first_char = strtoupper(substr($star->name, 0, 1));
                if (is_numeric($first_char)) {
                    $letters_with_stars['#'] = true;
                } else {
                    $letters_with_stars[$first_char] = true;
                }
            }
        }
        
        $first_active_letter = '';
        foreach ($alphabet as $letter) {
            if (isset($letters_with_stars[$letter])) {
                $first_active_letter = strtolower($letter);
                break;
            }
        }
        
        foreach ($alphabet as $letter) {
            $letter_lower = strtolower($letter);
            $has_stars = isset($letters_with_stars[$letter]);
            $classes = array('alphabet-btn');
            if (!$has_stars) {
                $classes[] = 'disabled';
            } elseif ($letter_lower === $first_active_letter) {
                $classes[] = 'active';
            }
            echo '<button class="' . implode(' ', $classes) . '" data-letter="' . $letter_lower . '">' . $letter . '</button>';
        }
        ?>
    </div>

    <?php if (!empty($pornstars) && !is_wp_error($pornstars)) : ?>
        <div class="pornstars-grid" id="pornstars-list-grid">
            <?php foreach ($pornstars as $star) : 
                $term_link = get_term_link($star);
                if (is_wp_error($term_link)) continue;
                $video_count = $star->count;
                $first_char = strtoupper(substr($star->name, 0, 1));
                $letter_group = is_numeric($first_char) ? '#' : $first_char;

                // Try to get cached performer image
                $random_image = get_term_meta($star->term_id, '_pornstar_image_url', true);
                if (empty($random_image)) {
                    // Query 1 random video to pick a random image URL for the performer
                    $videos = get_posts(array(
                        'post_type' => 'video',
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'pornstar',
                                'field' => 'term_id',
                                'terms' => $star->term_id,
                            )
                        ),
                        'fields' => 'ids',
                    ));

                    if (!empty($videos)) {
                        $random_image = get_post_meta($videos[0], '_video_image_url', true);
                        if (!empty($random_image)) {
                            update_term_meta($star->term_id, '_pornstar_image_url', $random_image);
                        }
                    }
                }
            ?>
                <a href="<?php echo esc_url($term_link); ?>" class="pornstar-card" data-letter="<?php echo esc_attr(strtolower($letter_group)); ?>" style="<?php echo (strtolower($letter_group) === $first_active_letter) ? 'display: block; opacity: 1; transform: scale(1);' : 'display: none; opacity: 0; transform: scale(0.95);'; ?>">
                    <?php if (!empty($random_image)) : ?>
                        <img src="<?php echo esc_url($random_image); ?>" alt="<?php echo esc_attr($star->name); ?>" class="pornstar-card-image" referrerpolicy="no-referrer">
                    <?php else : ?>
                        <div class="pornstar-placeholder-avatar">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="pornstar-card-overlay">
                        <h3 class="pornstar-card-name"><?php echo esc_html($star->name); ?></h3>
                        <span class="pornstar-card-count"><?php echo number_format($video_count); ?> videos</span>
                    </div>
                </a>
            <?php endforeach; ?>
            
            <!-- Dynamic No Match Fallback Message -->
            <div class="no-match-message" id="no-match-message">
                <p>No performers starting with "<span id="selected-letter-display"></span>" found.</p>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.alphabet-btn');
                const cards = document.querySelectorAll('#pornstars-list-grid .pornstar-card');
                const noMatchMsg = document.getElementById('no-match-message');
                const selectedLetterDisplay = document.getElementById('selected-letter-display');

                buttons.forEach(btn => {
                    if (btn.classList.contains('disabled')) return;
                    
                    btn.addEventListener('click', function() {
                        buttons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        const filter = this.getAttribute('data-letter');
                        let visibleCount = 0;

                        cards.forEach(card => {
                            const cardLetter = card.getAttribute('data-letter');
                            const isMatch = (filter === 'all' || cardLetter === filter);

                            if (isMatch) {
                                card.style.display = 'block';
                                setTimeout(() => {
                                    card.style.opacity = '1';
                                    card.style.transform = 'scale(1)';
                                }, 10);
                                visibleCount++;
                            } else {
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.95)';
                                setTimeout(() => {
                                    card.style.display = 'none';
                                }, 250);
                            }
                        });

                        setTimeout(() => {
                            if (visibleCount === 0) {
                                selectedLetterDisplay.textContent = filter.toUpperCase();
                                noMatchMsg.style.display = 'block';
                                setTimeout(() => noMatchMsg.style.opacity = '1', 10);
                            } else {
                                noMatchMsg.style.display = 'none';
                                noMatchMsg.style.opacity = '0';
                            }
                        }, 250);
                    });
                });
            });
        </script>
    <?php else : ?>
        <div class="no-tags-found">
            <p>No performers found. Performer tax terms enqueued in scrapers will display here.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
