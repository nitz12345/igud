<?php
/**
 * Template Name: search
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
get_header();
$search_term = $_GET['search_term'];
$search_type = $_GET['search_type'];
$search_area = $_GET['search_area'];
// WP_Query arguments
$args = array(
	'post_type'   => array( 'companies' ),
	'post_status' => array( 'publish' ),
);
if ( $search_area > 0 ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'company_area',
			'field'    => 'term_id',
			'terms'    => $search_area,
		),
	);
}
if ( $search_type == 'companyId' ) {
	$args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key'     => 'company_id',
			'value'   => $search_term,
			'compare' => '==',
		)
	);
} else {
	$termIds = array_map( function ( \WP_Term $term ) {
		return $term->term_id;
	}, get_terms( [
		'name__like' => $search_term,
	] ) );
	
	/*$results = $wpdb->get_results( "
			SELECT posts.ID
			FROM $wpdb->posts as posts
			WHERE ((posts.post_type IN ( 'companies' ))
			AND posts.post_status != 'trash'
			AND posts.post_title LIKE '%{$search_term}%')
			UNION
			SELECT terms.object_id
			FROM $wpdb->term_relationships as terms
			WHERE (terms.term_taxonomy_id IN ($termIds))",
		ARRAY_N
	);*/
	
	$termIds     = implode( ',', $termIds );
	$search_term = esc_sql( $search_term );
	$query       = "SELECT posts.ID
			FROM $wpdb->posts as posts
			WHERE (posts.post_title LIKE '%$search_term%'
			AND posts.post_type IN ( 'companies' )
			AND posts.post_status != 'trash')
			UNION
			SELECT postmeta.post_id
			FROM $wpdb->postmeta as postmeta
			WHERE (postmeta.meta_key = 'company_tags' AND postmeta.meta_value LIKE '%$search_term%')";
	
	if ( $termIds ) {
		$query .= "UNION
		SELECT terms.object_id
		FROM $wpdb->term_relationships as terms
		WHERE terms.term_taxonomy_id IN ($termIds)";
	}
	
	$results = $wpdb->get_results( $query, ARRAY_N );
	
	foreach ( $results as $id ) {
		$posts[] = current( $id );
	}
	
	$args['post__in'] = $posts;
}


$search = new WP_Query( $args );

if ( $search->have_posts() ) {
	$notPaidCount = 0;
	while ( $search->have_posts() ) {
		$search->the_post();
		$paid = get_field( 'company_user' );
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
	<?php }
} else {
	echo "לא נמצאו תוצאות התואמות את החיפוש";
}

// Restore original Post Data
wp_reset_postdata();

get_footer();