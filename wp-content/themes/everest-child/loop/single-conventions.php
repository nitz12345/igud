<?php
/**
 * Conventions Single
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( have_posts() ) :

	while ( have_posts() ) : the_post();
		get_template_part( 'content/content-single-conventions-view' );

	endwhile;
else :
	pojo_get_content_template_part( 'content', 'none' );
endif;

echo do_shortcode('[elementor-template id="481"]');