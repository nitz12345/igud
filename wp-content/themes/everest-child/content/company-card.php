<?php
$paid = get_field( 'company_user' );
$colClass = $paid ? 'col-pu-5' : 'not-paid clearfix';
if ( has_post_thumbnail() && $paid ) {
	$thumbnail = get_the_post_thumbnail_url();
} else {
	$term = get_top_category();
	$thumbnail = get_field( 'bg_img', $term );
}
?>
<div class="<?php echo $colClass; ?>">
	<div class="company-container company-container-full" data-href="<?php the_permalink() ?>" style="background-image:url(<?php echo $thumbnail ?>)">
		<?php if (!$paid) { ?>
			<div class="company-archive-overlay"></div>
		<?php } ?>
		<?php if ( $paid ) { ?>
			<a href="<?php the_permalink() ?>">
				<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
			</a>
		<?php } ?>
		<div class="company-details">
			<a href="<?php the_permalink() ?>">
				<span class="company_name"><?php the_title() ?></span>
				<span class="company_phone"><?php the_field( 'phone' ) ?></span>
				<span class="company_address"><?php the_field( 'address' ) ?></span>
			</a>
			<div class="company_bottom-bar">
				<div class="pull-right">
					<?php if ( ! $paid ) { ?>
						<a href="#" class="open-sharing-options"><img
									src="<?php echo get_stylesheet_directory_uri() . "/assets/images/share.png" ?>"></a>
					<?php } ?>
					<div class="sharing-options">
						<a href="whatsapp://send?text=<?php the_permalink(); ?>" class="company-social-icon whatsapp"><img
								src="<?php echo get_stylesheet_directory_uri() . "/assets/images/whatsapp.png" ?>"> </a>
						<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="company-social-icon"><img
									src="<?php echo get_stylesheet_directory_uri() . "/assets/images/facebook.png" ?>"> </a>
						<a href="mailto:?body=<?php the_permalink() ?>" class="company-social-icon">
							<img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/email.png" ?>">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>