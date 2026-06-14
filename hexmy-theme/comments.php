<?php
/**
 * The template for displaying comments
 * File: comments.php
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(_x('1 Comment', 'comments title', 'hexmy'));
            } else {
                printf(
                    _nx(
                        '%1$s Comment',
                        '%1$s Comments',
                        $comments_number,
                        'comments title',
                        'hexmy'
                    ),
                    number_format_i18n($comments_number)
                );
            }
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'avatar_size' => 48,
                'style'       => 'ul',
                'short_ping'  => true,
            ));
            ?>
        </ul>

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments" style="color: var(--text-muted); font-size: 14px; text-align: center; margin-top: 20px;">
                <?php _e('Comments are closed.', 'hexmy'); ?>
            </p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply' => __('Leave a Comment', 'hexmy'),
        'label_submit' => __('Post Comment', 'hexmy'),
        'class_submit' => 'submit-btn',
    ));
    ?>

</div>
