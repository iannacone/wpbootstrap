<?php
/**
 * The layout file
 *
 * This is the structure of a basic site page/post/archive
 *
 * @package wpbootstrap
 */


$wpbs_default = [
	'header' => null,
	'footer' => null,
	'sidebar' => null,
	'template' => null,
	'header_pic' => null,
	'display_title' => true,
	'title' => null,
	'description' => null,
	'display_pagination' => null,
];
$GLOBALS['wpbs'] = $wpbs = wp_parse_args($wpbs, $wpbs_default);

$wpbs['has_sidebar'] = is_active_sidebar($wpbs['sidebar']);
$wpbs['has_header'] = !empty($wpbs['header_pic']) || !empty($wpbs['secondary_menu']) || !empty($wpbs['title']) || !empty($wpbs['description']);

get_header($wpbs['header']);
?>
<div id="primary" class="content-area row">
	<main id="main" class="site-main col-12<?php echo ($wpbs['has_sidebar'] ? ' col-sm-8 col-md-9' : ''); ?>" role="main">
		<?php if (have_posts()) { ?>
		
			<?php if ($wpbs['has_header']) { ?>
				<header class="page-header">
					
					<?php if (!empty($wpbs['header_pic'])) { ?>
						<figure class="wp-block-image alignfull">
							<?php echo wp_get_attachment_image($wpbs['header_pic'], 'full'); ?>
						</figure>
					<?php } ?>
					
					<?php if (!empty($wpbs['title'])) { ?>
						<h1 class="page-title screen-reader-text"><?php echo $wpbs['title']; ?></h1>
					<?php } ?>
					
					<?php if (!empty($wpbs['description'])) { ?>
						<h2 class="page-description <?php echo (empty($wpbs['template']) ? '' : $wpbs['template'] . '-description'); ?>screen-reader-text"><?php echo $wpbs['description']; ?></h2>
					<?php } ?>
					
				</header>
			<?php } ?>
			
			<?php
			while (have_posts()) {
				the_post();
				get_template_part('template-parts/content', $wpbs['template']);
			}
			?>
			
			<?php
			if (!empty($wpbs['display_pagination'])) {
				WPBootstrap\WPHelper::pageNavi();
			}
		} else
			get_template_part('template-parts/content', 'none');
		?>
	</main>
	<?php get_sidebar($wpbs['sidebar']); ?>
</div>
<?php get_footer($wpbs['footer']); ?>