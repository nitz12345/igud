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
				<?php } ?>
				<div class="<?php echo $colClass; ?>">
					<?php $backgroundImg = ($paid && has_post_thumbnail()) ? get_the_post_thumbnail_url() : wp_get_attachment_image_src( get_field("company_cat_img", $term), 'large' )[0]; ?>
					<div class="company-container company-container-full"
							 style="background-image:url(<?php echo $backgroundImg ?>)">
						<?php if (!$paid) {
							$notPaidCount++; ?>
							<div class="company-archive-overlay"></div>
						<?php } ?>
						<?php if ( $paid ) { ?>
							<a href="<?php the_permalink() ?>">
								<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
							</a>
						<?php } ?>
						<div class="company-details">
							<a href="<?php the_permalink() ?>"><span class="company_name"><?php the_title() ?></span></a>
							<span class="company_phone"><?php the_field( 'phone' ) ?></span>
							<span class="company_address"><?php the_field( 'address' ) ?></span>
							<div class="company_bottom-bar">
								<div class="pull-right">
									<?php if ( ! $paid ) { ?>
										<a href="#" class="open-sharing-options"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/share.png" ?>"></a>
									<?php } ?>
									<div class="sharing-options">
										<a href="https://twitter.com/home?status=<?php the_permalink() ?>" class="company-social-icon"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/twitter.png" ?>"> </a>
										<a href="whatsapp://send?text=<?php the_permalink(); ?>" class="company-social-icon"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/whatsapp.png" ?>"> </a>
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="company-social-icon"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/facebook.png" ?>"> </a>
										<a href="https://plus.google.com/share?url=<?php the_permalink() ?>" class="company-social-icon"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/google.png" ?>"> </a>
										<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=&summary=&source=" class="company-social-icon"><img
													src="<?php echo get_stylesheet_directory_uri() . "/assets/images/linkedin.png" ?>"> </a>
										<a href="mailto:?body=<?php the_permalink() ?>" class="company-social-icon">
											<img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/email.png" ?>">
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if(!$paid && $notPaidCount%2 == 0){ ?>
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
