<?php
/**
 * The template for displaying the footer.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
			</div><!-- #content -->
		</div><!-- .container -->
		<?php if(is_tax('company_category') || is_post_type_archive('companies')){
			echo do_shortcode('[elementor-template id="956"]');
			echo do_shortcode('[elementor-template id="481"]');
		} ?>
	</div><!-- #primary -->

	<?php po_change_loop_to_parent( 'change' ); ?>
	<?php if ( ! pojo_is_blank_page() ) : ?>
		<footer id="footer">
			<?php get_sidebar( 'footer' ); ?>
		</footer>

		<div id="copyright" role="contentinfo">
			<div class="<?php echo WRAP_CLASSES; ?>">
				<div class="footer-text-left pull-left">
					<?php echo nl2br( pojo_get_option( 'txt_copyright_left' ) ); ?>
				</div>
				<div class="footer-text-right pull-right">
					<?php echo nl2br( pojo_get_option( 'txt_copyright_right' ) ); ?>
				</div>
			</div><!-- .<?php echo WRAP_CLASSES; ?> -->
		</div>
	<?php endif; // end blank page ?>
	<?php po_change_loop_to_parent(); ?>

</div><!-- #container -->
<?php wp_footer(); ?>

<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>
</body>
</html>