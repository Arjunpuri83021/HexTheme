<?php
/**
 * Template Name: Categories Page
 * File: page-category.php
 */

get_header(); 

$categories = get_terms('video_tag', array(
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));
$cat_count = (!empty($categories) && !is_wp_error($categories)) ? count($categories) : 0;
?>

<div class="container page-container">
    <header class="page-header">
        <h1 class="page-title">Explore Tags</h1>
        <p class="page-subtitle">Browse through our highly organized collections of <?php echo number_format($cat_count); ?> adult streaming tags.</p>
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
            .tags-grid {
                transition: all 0.3s ease;
            }
            .tag-card {
                transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            }
        </style>
        
        <?php 
        $alphabet = range('A', 'Z');
        array_unshift($alphabet, '#');
        
        $letters_with_tags = array();
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $cat) {
                $first_char = strtoupper(substr($cat->name, 0, 1));
                if (is_numeric($first_char)) {
                    $letters_with_tags['#'] = true;
                } else {
                    $letters_with_tags[$first_char] = true;
                }
            }
        }
        
        $first_active_letter = '';
        foreach ($alphabet as $letter) {
            if (isset($letters_with_tags[$letter])) {
                $first_active_letter = strtolower($letter);
                break;
            }
        }
        
        foreach ($alphabet as $letter) {
            $letter_lower = strtolower($letter);
            $has_tags = isset($letters_with_tags[$letter]);
            $classes = array('alphabet-btn');
            if (!$has_tags) {
                $classes[] = 'disabled';
            } elseif ($letter_lower === $first_active_letter) {
                $classes[] = 'active';
            }
            echo '<button class="' . implode(' ', $classes) . '" data-letter="' . $letter_lower . '">' . $letter . '</button>';
        }
        ?>
    </div>

    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
        <div class="tags-grid" id="categories-list-grid">
            <?php foreach ($categories as $cat) : 
                $term_link = get_term_link($cat, 'video_tag');
                if (is_wp_error($term_link)) continue;
                $video_count = $cat->count;
                $first_char = strtoupper(substr($cat->name, 0, 1));
                $letter_group = is_numeric($first_char) ? '#' : $first_char;
            ?>
                <a href="<?php echo esc_url($term_link); ?>" class="tag-card" data-letter="<?php echo esc_attr(strtolower($letter_group)); ?>" style="<?php echo (strtolower($letter_group) === $first_active_letter) ? 'display: block; opacity: 1; transform: scale(1);' : 'display: none; opacity: 0; transform: scale(0.95);'; ?>">
                    <div class="tag-card-content">
                        <svg class="tag-card-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 11h6V5H4v6zm0 8h6v-6H4v6zm8-8h6V5h-6v6zm0 8h6v-6h-6v6z"/>
                        </svg>
                        <span class="tag-card-name"><?php echo esc_html($cat->name); ?></span>
                        <span class="tag-card-count"><?php echo number_format($video_count); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
            
            <!-- Dynamic No Match Fallback Message -->
            <div class="no-match-message" id="no-match-message">
                <p>No tags starting with "<span id="selected-letter-display"></span>" found.</p>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('.alphabet-btn');
                const cards = document.querySelectorAll('#categories-list-grid .tag-card');
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
            <p>No video tags found. Video tags enqueued in posts will display here.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
