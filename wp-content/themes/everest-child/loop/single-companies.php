<?php
/**
 * Companies Single
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( have_posts() ) :

	while ( have_posts() ) : the_post();
        if (get_field('company_user') && get_field('company_user') == get_current_user_id()) {
	        get_template_part( 'content/content-single-companies-edit' );
        } else {
        	$viewsCount = get_field('views_count');
        	if($viewsCount){
		        $viewsCount++;
		        update_field('views_count', $viewsCount);
	        } else {
		        update_field('views_count', 1);
	        }
	        get_template_part( 'content/content-single-companies-view' );
        }

	endwhile;
else :
	pojo_get_content_template_part( 'content', 'none' );
endif;