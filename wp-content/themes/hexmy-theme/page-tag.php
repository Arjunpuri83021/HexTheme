<?php
/**
 * Template Name: Tags Page
 * File: page-tag.php
 */

get_header(); 

$tags = get_terms('video_tag', array(
    'hide_empty' => false,
    'orderby' => 'name',
    'order' => 'ASC'
));
$tag_count = (!empty($tags) && !is_wp_error($tags)) ? count($tags) : 0;
?>

<div class="container page-container">
    <header class="page-header">
        <h1 class="page-title">Explore Video Tags</h1>
        <p class="page-subtitle">Find your favorite videos by browsing our highly curated selection of <?php echo number_format($tag_count); ?> tags.</p>
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
                background: rgba(247, 0, 35, 0.1);
                border-color: var(--accent-color);
                color: #ffffff;
                box-shadow: 0 0 10px rgba(247, 0, 35, 0.2);
            }
            .alphabet-btn.active {
                background: rgba(247, 0, 35, 0.15);
                border-color: var(--accent-color);
                color: #ffffff;
                box-shadow: 0 0 10px rgba(247, 0, 35, 0.3);
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
        if (!empty($tags) && !is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $first_char = strtoupper(substr($tag->name, 0, 1));
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

    <?php if (!empty($tags) && !is_wp_error($tags)) : ?>
        <div class="tags-grid" id="tags-list-grid">
            <?php foreach ($tags as $tag) : 
                $term_link = get_term_link($tag);
                if (is_wp_error($term_link)) continue;
                $video_count = $tag->count;
                $first_char = strtoupper(substr($tag->name, 0, 1));
                $letter_group = is_numeric($first_char) ? '#' : $first_char;
            ?>
                <a href="<?php echo esc_url($term_link); ?>" class="tag-card" data-letter="<?php echo esc_attr(strtolower($letter_group)); ?>" style="<?php echo (strtolower($letter_group) === $first_active_letter) ? 'display: block; opacity: 1; transform: scale(1);' : 'display: none; opacity: 0; transform: scale(0.95);'; ?>">
                    <div class="tag-card-content">
                        <svg class="tag-card-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/>
                        </svg>
                        <span class="tag-card-name"><?php echo esc_html($tag->name); ?></span>
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
                const cards = document.querySelectorAll('#tags-list-grid .tag-card');
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
            <p>No video tags found. Videos uploaded from the scraper panel will dynamically populate tag clouds here.</p>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
