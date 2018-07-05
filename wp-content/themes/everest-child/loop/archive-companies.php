<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
$display_type = po_get_display_type();
$uploadDir    = wp_upload_dir(); ?>
<div id="page-header" class="page-header-style-custom_bg"
		 style="background-image: url(<?php echo $uploadDir['baseurl'] ?>/2018/03/Header.png)">
	<div class="page-header-title <?php echo WRAP_CLASSES; ?>">
		<div class="title-primary custom-title">
			<h1 style="color: #333333;">חברות מובילות</h1>
		</div>
	</div><!-- /.page-header-title -->
</div><!-- /#page-header -->
<?php if ( have_posts() ) : ?>
	<?php do_action( 'pojo_before_content_loop', $display_type ); ?>
	<div class="companies-archive-wrapper" style="margin-top: 20px">
		<div class="row">
			<?php
			$notPaidCount = 0;
			while ( have_posts() ) : the_post();
				$paid = get_field( 'company_user' );
				$colClass = $paid ? 'col-pu-5' : 'not-paid clearfix';
				$term = get_top_category();
				if(!$paid && $notPaidCount%2 == 0){ ?>
					<div class='col-pu-5'>
				<?php }
				if(!$paid){
					$notPaidCount++;
				}
				get_template_part('content/company', 'card');
				if(!$paid && $notPaidCount%2 == 0){ ?>
					</div>
				<?php } ?>
			<?php endwhile; ?>
		</div>
		<div class="text-center"><a href="#" class="load-more-companies" data-archive="true">טען עוד</a></div>
	</div>
	<?php do_action( 'pojo_after_content_loop', $display_type ); ?>
<?php else : ?>
	<?php pojo_get_content_template_part( 'content', 'none' ); ?>
<?php endif; ?>
