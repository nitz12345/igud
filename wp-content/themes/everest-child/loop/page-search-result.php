<?php
/**
 * Template Name: search
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
get_header();
$search_term = $_GET['search_term'];
$search_type = $_GET['search_type'];
$search_area = $_GET['search_area'];
// WP_Query arguments
$args = array(
	'post_type'              => array( 'companies' ),
	'post_status'            => array( 'publish' ),
);
if ($search_type == 'company'){
    $args['tax_query']= array(
		    array(
			    'taxonomy' => 'company_category',
			    'field'    => 'name',
			    'terms'    => $search_term,
		    ),
    );
} else{
    $args['s']=$search_term;
}
if (!$search_area==0) {
	if ( $search_type == 'company' ) {
		$args['tax_query'][] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'company_area',
				'field'    => 'term_id',
				'terms'    => $search_area,
			),
		);
	} else {
		$args['tax_query'] = array(
				array(
					'taxonomy' => 'company_area',
					'field'    => 'term_id',
					'terms'    => $search_area,
				),
		);
	}
}
// The Query
$search = new WP_Query( $args );

// The Loop
if ( $search->have_posts() ) {
	while ( $search->have_posts() ) {
		$search->the_post(); ?>
        <div class="col-md-3">
            <a href="<?php the_permalink() ?>">
                <div class="company-container" style="background-image:url(<?php the_post_thumbnail_url() ?>)">
	                	<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
                    <div class="company-details">
                        <span class="company_name"><?php the_title() ?></span>
                        <span class="company_phone"><?php the_field('phone') ?></span>
                        <span class="company_address"><?php the_field('address') ?></span>
                        <div class="company_bottom-bar">
                            <div class="pull-right">
                                <a href="<?php the_field('twitter') ?>" class="company-social-icon"><img src="<?php echo get_stylesheet_directory_uri()."/assets/images/twitter.png" ?>"> </a>
                                <a href="<?php the_field('whatsapp') ?>" class="company-social-icon"><img src="<?php echo get_stylesheet_directory_uri()."/assets/images/whatsapp.png" ?>"> </a>
                                <a href="<?php the_field('facebook') ?>" class="company-social-icon"><img src="<?php echo get_stylesheet_directory_uri()."/assets/images/facebook.png" ?>"> </a>
                                <a href="<?php the_field('google') ?>" class="company-social-icon"><img src="<?php echo get_stylesheet_directory_uri()."/assets/images/google.png" ?>"> </a>
                                <a href="<?php the_field('linkedin') ?>" class="company-social-icon"><img src="<?php echo get_stylesheet_directory_uri()."/assets/images/linkedin.png" ?>"> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
	<?php }
} else {
	echo "לא נמצאו תוצאות התואמות את החיפוש";
}

// Restore original Post Data
wp_reset_postdata();

get_footer();