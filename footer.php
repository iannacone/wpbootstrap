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
					
					<div class="row">
						<div class="col-xs-12">
							<?php get_template_part('template-parts/footer/footer', 'sidebars'); ?>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12">
							<?php get_template_part('template-parts/footer/site', 'info'); ?>
						</div>
					</div>
					
				</div>
				
			</footer>
		</div><?php /* #page */ ?>
		<div id="to-top"><a href="#page" title="<?php esc_attr_e('Scroll to top'); ?>"><span class="fa fas fa-chevron-up"></span></a></div>
		<?php wp_footer(); ?>
	</body>
</html>