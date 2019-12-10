<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if (have_comments()) {
		?>
		<h2 class="comments-title">
			<?php
				printf(// WPCS: XSS OK.
					esc_html(_nx('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title')),
					number_format_i18n(get_comments_number()),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e('Comment navigation'); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments')); ?></div>
					<div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments')); ?></div>

				</div>
			</nav>
		<?php } ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(array(
					'style'      => 'ol',
					'short_ping' => true,
				));
			?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e('Comment navigation'); ?></h2>
				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link(esc_html__('Older Comments')); ?></div>
					<div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments')); ?></div>

				</div>
			</nav>
		<?php
		}

	}


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) { ?>
		<p class="no-comments"><?php esc_html_e('Comments are closed.'); ?></p>
	<?php }
	*/
	?>
	
	<div>
		<?php
		$commenter = wp_get_current_commenter();
		$req = get_option('require_name_email');
		$aria_req = ($req ? ' aria-required="true" required' : '');
		
		comment_form(array(
			'format' => 'xhtml',
			'fields' => array(
				'author' => '<div class="form-group comment-form-author">
						<label for="author">' . __('Name', 'domainreference') . ($req ? '<span class="required">*</span>' : '') . '</label>
						<input id="author" class="form-control" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />
					</div>',
				'email' => '<div class="form-group comment-form-email">
						<label for="email">' . __('Email', 'domainreference') . ($req ? '<span class="required">*</span>' : '') . '</label>' .
						'<input id="email" class="form-control" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />
					</div>',
					'cookies' => '<div class="checkbox comment-form-cookies-consent">
							<label for="wp-comment-cookies-consent">
								<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . (empty($commenter['comment_author_email']) ? '' : ' checked="checked"') . ' />' . __('Save my name, email, and website in this browser for the next time I comment.') . '
							</label>
						</div>',
			),
			'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as %1$s. <a href="%2$s" title="Log out of this account">Log out?</a>'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
			'comment_field' => '<div class="form-group comment-form-comment"><label for="comment">' . _x('Comment', 'noun') . '</label><textarea id="comment" class="form-control" name="comment" rows="8" aria-required="true"></textarea></div>',
			'class_submit' => 'btn btn-primary pull-right',
		));
		?>
	</div>
</div>