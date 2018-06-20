<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
get_header( 'taxonomy' ); ?>
<?php po_change_loop_to_parent(); ?>
<?php pojo_print_titlebar(); ?>
<?php $term   = get_queried_object();
$activeFields = explode( ',', $_REQUEST['field'] );
$activeAreas  = explode( ',', $_REQUEST['area'] );
if ( ! empty( $activeFields[0] ) || ! empty( $activeAreas[0] ) ) {
	$subTitle = "מציג: ";
}
if ( ! empty( $activeFields[0] ) ) {
	foreach ( $activeFields as $field ) {
		$theTerm  = get_term_by( 'id', $field, 'company_category' );
		$subTitle .= $theTerm->name;
		if ( $field != end( $activeFields ) ) {
			$subTitle .= " + ";
		}
	}
}
if ( ! empty( $activeAreas[0] ) ) {
	foreach ( $activeAreas as $area ) {
		if ( ! empty( $activeFields[0] ) ) {
			$subTitle .= " + ";
		}
		$theTerm  = get_term_by( 'id', $area, 'company_area' );
		$subTitle .= $theTerm->name;
		if ( empty( $activeFields[0] ) ) {
			if ( $area != end( $activeAreas ) ) {
				$subTitle .= " + ";
			}
		}
	}
} ?>
	<style>
		.page-title.tax-page-title .container:before {
			content: "";
			width: 50px;
			height: 50px;
			background: <?php the_field('main_color',$term) ?>;
			position: absolute;
			top: -28px;
			border-right: 4px solid <?php the_field('border_color',$term) ?>;
			border-top: 4px solid <?php the_field('border_color',$term) ?>;
			transform: rotatez(-45deg);
			z-index: 100;
			right: 22.5%;
		}
		.not-paid .company-details{
			border-top: 2px solid <?php the_field('border_color',$term) ?>;
		}
	</style>
	<div id="tax-container">
		<img src="<?php the_field( 'bg_img', $term ) ?>" id="tax-img">
		<div class="page-title tax-page-title"
				 style="background: <?php the_field( 'main_color', $term ) ?>; border-top:4px solid <?php the_field( 'border_color', $term ) ?> ">
			<div class="container">
				<?php echo wp_get_attachment_image( get_field( 'icon', $term ), 'thumbnail', false, array( "id" => "tax-logo" ) ); ?>
				<h1 class="entry-title"><?php echo $term->name ?></h1>
				<h2><?php echo $subTitle ?></h2>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div id="primary">
<div class="<?php echo WRAP_CLASSES; ?>">
<div id="content" class="<?php echo CONTAINER_CLASSES; ?>">
<?php $display_type = po_get_display_type();
?>
<?php if ( po_breadcrumbs_need_to_show() ) : ?>
	<?php pojo_breadcrumbs(); ?>
<?php endif; ?>
<?php if ( ! is_home() && ! is_front_page() ) :
	$queried_object = $term;
	$queried_term_id = $queried_object->term_id;
	$queried_taxonomy_name = 'company_category';
	$term_children = get_term_children( $queried_term_id, $queried_taxonomy_name );
	if ( $term_children ) { ?>
		<div id="company-type" class="company-field-tax">
			<span class="type-header">תחום</span>
			<?php
			foreach ( $term_children as $child ) {
				$child_term = get_term_by( 'id', $child, $queried_taxonomy_name ); ?>
				<span class="company-type-span">
						<a href="#<?php echo $child ?>" class="<?php echo in_array( $child, $activeFields ) ? 'active' : '' ?>">
							<?php echo $child_term->name ?>
						</a>
					</span>
			<?php } ?>
		</div>
	<?php } ?>
	
	<div id="company-type" class="company-area-tax">
		<span class="type-header">איזור</span>
		<?php $areas = get_terms( array( 'taxonomy' => 'company_area' ) );
		foreach ( $areas as $area ) { ?>
			<span class="company-type-span">
				<a href="<?php echo $area->term_id ?>"
					 class="<?php echo in_array( $area->term_id, $activeAreas ) ? 'active' : '' ?>">
					<?php echo $area->name ?>
				</a>
			</span>
		<?php } ?>
	</div>
	
	<div id="pu-leading-companies">
	<div class="pu-leading-companies-content">
<?php endif; ?>
<?php if ( have_posts() ) : ?>
	<?php do_action( 'pojo_before_content_loop', $display_type ); ?>
	<div class="companies-archive-wrapper">
		<div class="row">
			<?php
			$notPaidCount = 0;
			while ( have_posts() ) : the_post();
				$paid = get_field( 'company_user' );
				$colClass = $paid ? 'col-pu-5' : 'not-paid clearfix';
				if(!$paid && $notPaidCount%2 == 0){ ?>
					<div class='col-pu-5'>
				<?php } ?>
				<div class="<?php echo $colClass; ?>">
					<?php $backgroundImg = ($paid && has_post_thumbnail()) ? get_the_post_thumbnail_url() : wp_get_attachment_image_src( get_field("company_cat_img", $term), 'medium' )[0]; ?>
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
			<?php endwhile;
			if($notPaidCount % 2 === 1){ ?>
				</div>
			<?php } ?>
		</div>
		<div class="text-center"><a href="#" class="load-more-companies" data-tax_id="<?php echo $term->term_id ?>">טען עוד</a></div>
	</div>
	<?php do_action( 'pojo_after_content_loop', $display_type ); ?>
	</div>
	<div class="clear"></div>
	</div>
<?php else : ?>
	<?php pojo_get_content_template_part( 'content', 'none' ); ?>
<?php endif; ?>
<?php get_footer() ?>