<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpbootstrap
 */

?>
			</div><?php /* #content */ ?>
			<footer id="colophon" class="site-footer" role="contentinfo">
			
				<div class="container-fluid">
					
					<div>
						<?php get_template_part('template-parts/footer/footer-sidebars'); ?>
					</div>
					
					<div>
						<?php get_template_part('template-parts/footer/site-info'); ?>
					</div>
					
				</div>
				
			</footer>
		</div><?php /* #page */ ?>
		<div id="to-top"><a href="#" title="<?php esc_attr_e('Scroll to top'); ?>"><span class="fa fas fa-chevron-up"></span></a></div>
		<?php get_template_part('template-parts/footer/fixed-bottom-right-widget'); ?>
		<div class="clearfix"></div><?php /* remove the side effect of a margin of the last body elemnet that can apply a distance between the body and the html elements */ ?>
		<?php wp_footer(); ?>
	</body>
</html>