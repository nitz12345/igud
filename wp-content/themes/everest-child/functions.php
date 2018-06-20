<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// Put your custom code here.
// Register Custom Post Type
if ( ! function_exists( 'conventions' ) ) {
	function pu_styles() {
		wp_enqueue_style( 'pu-style', get_stylesheet_directory_uri() . '/pu-style.css', array( 'pojo-style-rtl' ),
			filemtime( get_stylesheet_directory() . '/pu-style.css' ) );
		wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/assets/slick/slick.css', array(),
			filemtime( get_stylesheet_directory() . '/assets/slick/slick.css' ) );
		wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/assets/slick/slick-theme.css', array(),
			filemtime( get_stylesheet_directory() . '/assets/slick/slick-theme.css' ) );
		wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/slick/slick.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'loginForm', get_stylesheet_directory_uri() . '/assets/js/loginForm.js', array( 'jquery' ), '1' );
		wp_enqueue_script( 'editCompany', get_stylesheet_directory_uri() . '/assets/js/editCompany.js', array( 'jquery' ), '1' );
		wp_enqueue_script( 'companyTax', get_stylesheet_directory_uri() . '/assets/js/companyTax.js', array( 'jquery' ),
			filemtime( get_stylesheet_directory() . '/assets/js/companyTax.js' ) );
		wp_enqueue_script( 'hompageScripts', get_stylesheet_directory_uri() . '/assets/js/homepage.js', array(
			'jquery',
			'slick'
		), false );
		
		wp_localize_script( 'editCompany', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	}
	
	function my_scripts() {
		wp_enqueue_script( 'createCompany', get_stylesheet_directory_uri() . '/assets/js/createCompany.js', array(
			'jquery',
			'elementor-pro-frontend',
			'elementor-frontend'
		), false );
		wp_localize_script( 'createCompany', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
		wp_enqueue_script( 'scripts', get_stylesheet_directory_uri() . '/assets/js/functions.js', array( 'jquery' ),
			filemtime( get_stylesheet_directory() . '/assets/js/functions.js' ) );
		wp_localize_script( 'scripts', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	add_action( 'wp_enqueue_scripts', 'my_scripts', 999 );
	add_action( 'wp_enqueue_scripts', 'pu_styles' );
// Register Custom Post Type
	function conventions() {
		
		$labels = array(
			'name'                  => _x( 'Conventions', 'Post Type General Name', 'conventions' ),
			'singular_name'         => _x( 'Convention', 'Post Type Singular Name', 'conventions' ),
			'menu_name'             => __( 'כנסים', 'conventions' ),
			'name_admin_bar'        => __( 'Convention', 'conventions' ),
			'archives'              => __( 'Item Archives', 'conventions' ),
			'attributes'            => __( 'Item Attributes', 'conventions' ),
			'parent_item_colon'     => __( 'Parent Item:', 'conventions' ),
			'all_items'             => __( 'All Items', 'conventions' ),
			'add_new_item'          => __( 'Add New Item', 'conventions' ),
			'add_new'               => __( 'Add New', 'conventions' ),
			'new_item'              => __( 'New Item', 'conventions' ),
			'edit_item'             => __( 'Edit Item', 'conventions' ),
			'update_item'           => __( 'Update Item', 'conventions' ),
			'view_item'             => __( 'View Item', 'conventions' ),
			'view_items'            => __( 'View Items', 'conventions' ),
			'search_items'          => __( 'Search Item', 'conventions' ),
			'not_found'             => __( 'Not found', 'conventions' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'conventions' ),
			'featured_image'        => __( 'Featured Image', 'conventions' ),
			'set_featured_image'    => __( 'Set featured image', 'conventions' ),
			'remove_featured_image' => __( 'Remove featured image', 'conventions' ),
			'use_featured_image'    => __( 'Use as featured image', 'conventions' ),
			'insert_into_item'      => __( 'Insert into item', 'conventions' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'conventions' ),
			'items_list'            => __( 'Items list', 'conventions' ),
			'items_list_navigation' => __( 'Items list navigation', 'conventions' ),
			'filter_items_list'     => __( 'Filter items list', 'conventions' ),
		);
		
		$args = array(
			'label'               => __( 'Convention', 'conventions' ),
			'description'         => __( 'Post Type Description', 'conventions' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-businessman',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'Conventions', $args );
		
	}
	
	add_action( 'init', 'conventions', 0 );
	
}
if ( ! function_exists( 'companies_category' ) ) {

// Register Custom Taxonomy
	function companies_category() {
		
		$labels = array(
			'name'                       => _x( 'Company Categoreis', 'Taxonomy General Name', 'pojochild' ),
			'singular_name'              => _x( 'Company Category', 'Taxonomy Singular Name', 'pojochild' ),
			'menu_name'                  => __( 'Company Categoreis', 'pojochild' ),
			'all_items'                  => __( 'All Items', 'pojochild' ),
			'parent_item'                => __( 'Parent Item', 'pojochild' ),
			'parent_item_colon'          => __( 'Parent Item:', 'pojochild' ),
			'new_item_name'              => __( 'New Item Name', 'pojochild' ),
			'add_new_item'               => __( 'Add New Item', 'pojochild' ),
			'edit_item'                  => __( 'Edit Item', 'pojochild' ),
			'update_item'                => __( 'Update Item', 'pojochild' ),
			'view_item'                  => __( 'View Item', 'pojochild' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'pojochild' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'pojochild' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'pojochild' ),
			'popular_items'              => __( 'Popular Items', 'pojochild' ),
			'search_items'               => __( 'Search Items', 'pojochild' ),
			'not_found'                  => __( 'Not Found', 'pojochild' ),
			'no_terms'                   => __( 'No items', 'pojochild' ),
			'items_list'                 => __( 'Items list', 'pojochild' ),
			'items_list_navigation'      => __( 'Items list navigation', 'pojochild' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'rewrite'           => array( 'slug' => 'company_category' ),
		);
		register_taxonomy( 'company_category', array( 'Companies' ), $args );
		
	}
	
	add_action( 'init', 'companies_category', 0 );
	
}
if ( ! function_exists( 'company_area' ) ) {

// Register Custom Taxonomy
	function company_area() {
		
		$labels = array(
			'name'                       => _x( 'Company areas', 'Taxonomy General Name', 'pojochild' ),
			'singular_name'              => _x( 'Company area', 'Taxonomy Singular Name', 'pojochild' ),
			'menu_name'                  => __( 'Company area', 'pojochild' ),
			'all_items'                  => __( 'All Items', 'pojochild' ),
			'parent_item'                => __( 'Parent Item', 'pojochild' ),
			'parent_item_colon'          => __( 'Parent Item:', 'pojochild' ),
			'new_item_name'              => __( 'New Item Name', 'pojochild' ),
			'add_new_item'               => __( 'Add New Item', 'pojochild' ),
			'edit_item'                  => __( 'Edit Item', 'pojochild' ),
			'update_item'                => __( 'Update Item', 'pojochild' ),
			'view_item'                  => __( 'View Item', 'pojochild' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'pojochild' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'pojochild' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'pojochild' ),
			'popular_items'              => __( 'Popular Items', 'pojochild' ),
			'search_items'               => __( 'Search Items', 'pojochild' ),
			'not_found'                  => __( 'Not Found', 'pojochild' ),
			'no_terms'                   => __( 'No items', 'pojochild' ),
			'items_list'                 => __( 'Items list', 'pojochild' ),
			'items_list_navigation'      => __( 'Items list navigation', 'pojochild' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'company_area', array( 'companies' ), $args );
		
	}
	
	add_action( 'init', 'company_area', 0 );
	
}


// post type companies

if ( ! function_exists( 'companies' ) ) {

// Register Custom Post Type
	function companies() {
		
		$labels = array(
			'name'                  => _x( 'Companies', 'Post Type General Name', 'companies' ),
			'singular_name'         => _x( 'Companies', 'Post Type Singular Name', 'companies' ),
			'menu_name'             => __( 'חברות', 'companies' ),
			'name_admin_bar'        => __( 'Companies', 'companies' ),
			'archives'              => __( 'Item Archives', 'companies' ),
			'attributes'            => __( 'Item Attributes', 'companies' ),
			'parent_item_colon'     => __( 'Parent Item:', 'companies' ),
			'all_items'             => __( 'All Items', 'companies' ),
			'add_new_item'          => __( 'Add New Item', 'companies' ),
			'add_new'               => __( 'Add New', 'companies' ),
			'new_item'              => __( 'New Item', 'companies' ),
			'edit_item'             => __( 'Edit Item', 'companies' ),
			'update_item'           => __( 'Update Item', 'companies' ),
			'view_item'             => __( 'View Item', 'companies' ),
			'view_items'            => __( 'View Items', 'companies' ),
			'search_items'          => __( 'Search Item', 'companies' ),
			'not_found'             => __( 'Not found', 'companies' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'companies' ),
			'featured_image'        => __( 'Featured Image', 'companies' ),
			'set_featured_image'    => __( 'Set featured image', 'companies' ),
			'remove_featured_image' => __( 'Remove featured image', 'companies' ),
			'use_featured_image'    => __( 'Use as featured image', 'companies' ),
			'insert_into_item'      => __( 'Insert into item', 'companies' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'companies' ),
			'items_list'            => __( 'Items list', 'companies' ),
			'items_list_navigation' => __( 'Items list navigation', 'companies' ),
			'filter_items_list'     => __( 'Filter items list', 'companies' ),
		);
		
		$args = array(
			'label'               => __( 'Companies', 'companies' ),
			'description'         => __( 'Post Type Description', 'companies' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
			'taxonomies'          => array( 'company_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-store',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'Companies', $args );
		
	}
	
	add_action( 'init', 'companies', 1 );
	
}

// post type מכרזים

if ( ! function_exists( 'Contracts' ) ) {

// Register Custom Post Type
	function Contracts() {
		
		$labels = array(
			'name'                  => _x( 'Contracts', 'Post Type General Name', 'contracts' ),
			'singular_name'         => _x( 'Contracts', 'Post Type Singular Name', 'contracts' ),
			'menu_name'             => __( 'מכרזים', 'contracts' ),
			'name_admin_bar'        => __( 'Contracts', 'contracts' ),
			'archives'              => __( 'Item Archives', 'contracts' ),
			'attributes'            => __( 'Item Attributes', 'contracts' ),
			'parent_item_colon'     => __( 'Parent Item:', 'contracts' ),
			'all_items'             => __( 'All Items', 'contracts' ),
			'add_new_item'          => __( 'Add New Item', 'contracts' ),
			'add_new'               => __( 'Add New', 'contracts' ),
			'new_item'              => __( 'New Item', 'contracts' ),
			'edit_item'             => __( 'Edit Item', 'contracts' ),
			'update_item'           => __( 'Update Item', 'contracts' ),
			'view_item'             => __( 'View Item', 'contracts' ),
			'view_items'            => __( 'View Items', 'contracts' ),
			'search_items'          => __( 'Search Item', 'contracts' ),
			'not_found'             => __( 'Not found', 'contracts' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'contracts' ),
			'featured_image'        => __( 'Featured Image', 'contracts' ),
			'set_featured_image'    => __( 'Set featured image', 'contracts' ),
			'remove_featured_image' => __( 'Remove featured image', 'contracts' ),
			'use_featured_image'    => __( 'Use as featured image', 'contracts' ),
			'insert_into_item'      => __( 'Insert into item', 'contracts' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'contracts' ),
			'items_list'            => __( 'Items list', 'contracts' ),
			'items_list_navigation' => __( 'Items list navigation', 'contracts' ),
			'filter_items_list'     => __( 'Filter items list', 'contracts' ),
		);
		
		$args = array(
			'label'               => __( 'Contracts', 'contracts' ),
			'description'         => __( 'Post Type Description', 'contracts' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
			'taxonomies'          => array( 'category', 'post_tag' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 7,
			'menu_icon'           => 'dashicons-media-spreadsheet',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => 'Contracts',
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'Contracts', $args );
		
	}
	
	add_action( 'init', 'contracts', 0 );
	
}

/* Top Companies widget */

class top_companies extends WP_Widget {
	
	public function __construct() {
		
		parent::__construct(
			'top-companies',
			__( 'Top Companies slider', 'pojochild' ),
			array(
				'description' => __( 'Top Companies slider', 'pojochild' ),
				'classname'   => 'top-companies',
			)
		);
		
	}
	
	public function widget( $args, $instance ) { ?>
		<div class="pu-top-companies">
			
			<?php
			// WP_Query arguments
			$args = array(
				'post_type'      => array( 'companies' ),
				'posts_per_page' => '14',
				'post_status' => array('publish'),
				'orderby' => 'date',
				'order' => 'DESC',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'company_user',
						'value' => false,
						'compare' => '!=',
					),
					array(
							'key' => 'promoted',
							'value' => 1,
							'compare' => '=='
					)
				)
			);
			$i    = 0;
			// The Query
			$top_companies = new WP_Query( $args );
			
			// The Loop
			if ( $top_companies->have_posts() ) {
				while ( $top_companies->have_posts() ) {
					$top_companies->the_post();
					if(has_post_thumbnail()){
						$thumbnail = get_the_post_thumbnail_url();
					} else{
						$terms = get_the_terms(get_the_ID(), 'company_category');
						if($terms){
							foreach($terms as $term){
								if($term->parent === 0){
									$thumbnail = get_field('bg_img', $term);
									break;
								}
							}
						}
					}
					
					if ( $i == 0 || $i % 2 == 0 ) {
						echo "<div class='putc-slide'>";
					} ?>
					<a href="<?php the_permalink() ?>">
						<div class="company-container" style="background-image:url(<?php echo $thumbnail; ?>)">
							<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
							<div class="company-details">
								<span class="company_name"><?php the_title() ?></span>
								<span class="company_phone"><?php the_field( 'phone' ) ?></span>
								<span class="company_address"><?php the_field( 'address' ) ?></span>
								<div class="company_bottom-bar">
									<div class="pull-right">
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
					</a>
					<?php
					$i++;
					if ( $i % 2 == 0 || $i == $top_companies->post_count ) {
						echo "</div>";
					}
					
				}
			} else {
				// no posts found
				echo "no posts found";
			}
			
			// Restore original Post Data
			wp_reset_postdata(); ?>
		</div>
		<script>
			jQuery(function ($) {
				$(document).ready(function () {
					$('.pu-top-companies').slick({
						rtl: true,
						speed: 500,
						slidesToShow: 3,
						slidesToScroll: 1
					});
				})
			})
		</script>
		<?php
	}
	
	public function form( $instance ) {
	
	}
	
	public function update( $new_instance, $old_instance ) {
	
	}
	
}

function putc_register_widgets() {
	register_widget( 'top_companies' );
}

add_action( 'widgets_init', 'putc_register_widgets' );

class pu__leading_companies extends WP_Widget {
	
	public function __construct() {
		
		parent::__construct(
			'pu-leading-companies-widget',
			__( 'Leading Companies', 'pojochild' ),
			array(
				'description' => __( 'Shows leading companies', 'pojochild' ),
			)
		);
		
	}
	
	public function widget( $args, $instance ) { ?>
		
		<div id="pu-leading-companies">
			<div class="pu-leading-companies-title">
				<h2><span>חברות מובילות</span></h2>
			</div>
			<div class="pu-leading-companies-content">
				
				<?php
				// WP_Query arguments
				$args = array(
					'post_type'      => array( 'companies' ),
					'posts_per_page' => '5',
					'post_status'    => 'publish',
					'orderby' => 'date',
					'order' => 'DESC',
					'meta_query' => array(
						array(
							'key' => 'company_user',
							'value' => false,
							'compare' => '!=',
						)
					)
				);
				// The Query
				$leading_companies = new WP_Query( $args );
				
				// The Loop
				if ( $leading_companies->have_posts() ) {
					while ( $leading_companies->have_posts() ) {
						$leading_companies->the_post();
						if(has_post_thumbnail()){
							$thumbnail = get_the_post_thumbnail_url();
						} else{
							$terms = get_the_terms(get_the_ID(), 'company_category');
							if($terms){
								foreach($terms as $term){
									if($term->parent === 0){
										$thumbnail = get_field('bg_img', $term);
										break;
									}
								}
							}
						}
						?>
						<div class="col-pu-5">
							<a href="<?php the_permalink() ?>">
								<div class="company-container company-container-full" style="background-image:url(<?php echo $thumbnail ?>)">
									<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
									<div class="company-details">
										<span class="company_name"><?php the_title() ?></span>
										<span class="company_phone"><?php the_field( 'phone' ) ?></span>
										<span class="company_address"><?php the_field( 'address' ) ?></span>
										<div class="company_bottom-bar">
											<div class="pull-right">
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
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						<?php
					}
				} else {
					// no posts found
					echo "no posts found";
				}
				
				// Restore original Post Data
				wp_reset_postdata(); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
		
	}
	
	public function form( $instance ) {
	
	}
	
	public function update( $new_instance, $old_instance ) {
	
	}
	
}

function pulc_register_widgets() {
	register_widget( 'pu__leading_companies' );
}

add_action( 'widgets_init', 'pulc_register_widgets' );

include( 'custom-widgets.php' );

function acf_field_placeholder( $field, $placeholder = '' ) {
	if ( get_field( $field ) ) {
		the_field( $field );
	} else {
		echo $placeholder;
	}
}

add_role(
	'pending',
	__( 'pending' ),
	array(
		'read'         => true,  // true allows this capability
		'edit_posts'   => false,
		'delete_posts' => false, // Use false to explicitly deny
	)
);

function get_company_type() {
	$terms  = wp_get_post_terms( get_the_ID(), 'company_category' );
	$result = '';
	foreach ( $terms as $term ) {
		if ( $term->parent ) {
			$result = $term->name;
		}
	}
	
	return $result;
}

function the_company_type() {
	$terms  = wp_get_post_terms( get_the_ID(), 'company_category' );
	$result = '';
	foreach ( $terms as $term ) {
		if ( $term->parent ) {
			$result = $term->name;
		}
	}
	echo $result;
}

function matat_login() {
	$result = array(
		'success' => true,
	);
	$param = array();
	parse_str( $_POST['data'], $param );
	
	$creds                  = array();
	$creds['user_login']    = $param['username'];
	$creds['user_password'] = $param['password'];
	$creds['remember']      = true;
	$user                   = wp_signon( $creds, false );
	if ( is_wp_error( $user ) ) {
		$error_string = $user->get_error_message();
		$result['success'] = false;
		$result['message'] = $error_string;
	} else {
		$url = get_permalink( get_user_meta( $user->ID, 'companyId', true ) );
		$result['message'] = $url;
	}
	echo json_encode($result, JSON_UNESCAPED_UNICODE);
	die();
}

add_action( 'wp_ajax_matat_login', 'matat_login' );
add_action( 'wp_ajax_nopriv_matat_login', 'matat_login' );


function get_post_id_by_meta_key_and_value( $key, $value ) {
	global $wpdb;
	$meta = $wpdb->get_results( "SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $wpdb->escape( $key ) . "' AND meta_value='" . $wpdb->escape( $value ) . "'" );
	if ( is_array( $meta ) && ! empty( $meta ) && isset( $meta[0] ) ) {
		$meta = $meta[0];
	}
	if ( is_object( $meta ) ) {
		return $meta->post_id;
	} else {
		return false;
	}
}

if ( ! current_user_can( 'administrator' ) ) {
	show_admin_bar( false );
}

// ACF Contact form 7
add_action( 'wpcf7_init', 'wpcf7_add_custom_fields' );
function wpcf7_add_custom_fields() {
	wpcf7_add_form_tag( 'acf_email_to', 'wpcf7_add_acf_email_to_handler' );
	wpcf7_add_form_tag( 'acf_company_name', 'wpcf7_add_acf_company_name_handler' );
}

function wpcf7_add_acf_email_to_handler() {
	return "<input type='text' value='" . get_field( 'company_email' ) . "' name='acf_email_to'>";
}

function wpcf7_add_acf_company_name_handler() {
	return "<input type='text' value='" . get_the_title() . "' name='acf_company_name'>";
}

function in_assoc($needle, $arr)
{
	foreach($arr as $item){
		if($needle === $item->term_id)
			return true;
	}
	return false;
}

function getSubCategories( $current_term = false, $select = false ) {
	if ( $_POST['chosen_cat'] ) {
		$select = $_POST['select'];
		$current_term = $_POST['chosen_cat'];
	}
	$sub_terms = get_terms( array(
		'taxonomy'   => 'company_category',
		'hide_empty' => false,
		'parent'     => $current_term
	) );
	$current_sub_terms = array_filter( array_map( function ( $term ) {
		if ( $term->parent != 0 ) {
			return $term;
		}
	}, get_the_terms( get_the_ID(), 'company_category' ) ) );
	if($select) { ?>
			<?php foreach ( $sub_terms as $sub ) {
				$checked = in_assoc( $sub->term_id, $current_sub_terms ) ? "checked" : ""; ?>
				<span><input title="<?php echo $sub->name ?>" type="checkbox" name="sub-category[]" value="<?php echo $sub->term_id ?>" <?php echo $checked ?> /><?php echo $sub->name ?></span>
			<?php } ?>
	<?php } else{
		foreach ( $current_sub_terms as $sub ) {
			echo $sub->name;
			if($sub != end($current_sub_terms))
				echo ", ";
		}
	} ?>
	<?php if ( $_POST['action'] ) {
		die();
	}
}

add_action( 'wp_ajax_getSubCategories', 'getSubCategories' );
add_action( 'wp_ajax_nopriv_getSubCategories', 'getSubCategories' );

function my_handle_attachment( $file_handler, $post_id, $set_thu = false ) {
	// check to make sure its a successful upload
	if ( $_FILES[ $file_handler ]['error'] !== UPLOAD_ERR_OK ) {
		__return_false();
	}
	
	$attach_id = media_handle_upload( $file_handler, $post_id );
	if ( is_numeric( $attach_id ) ) {
		update_post_meta( $post_id, '_my_file_upload', $attach_id );
	}
	
	return $attach_id;
}

add_action( 'elementor_pro/forms/validation', function ( $record, $ajax_handler ) {
	$fields = $record->get_field( [
		'id' => 'form_id',
	] );
	
	$field = current( $fields );
	if ( $field['value'] == 'create_company' ) {
		$fields = $record->get_field( [
			'id' => 'email',
		] );
		
		$field = current( $fields );
		
		if ( email_exists( $field['value'] ) ) {
			$ajax_handler->add_error( $field['id'], 'כתובת האימייל קיימת במאגר. אנא בחר כתובת אימייל אחרת' );
		}
		
		$fields = $record->get_field([
			'id' => 'password'
		] );
		
		$pwd = current( $fields )['value'];
		
		if (strlen($pwd) < 8 || !preg_match("#[a-zA-Z]+#", $pwd)) {
			$ajax_handler->add_error( 'password', 'הסיסמה חייבת להכיל לפחות 8 תווים ולפחות אות אחת' );
		}
		
		$fields = $record->get_field([
			'id' => 'auth_pass'
		] );
		
		$authPwd = current( $fields )['value'];
		
		if ($authPwd != $pwd) {
			$ajax_handler->add_error( 'auth_pass', 'הסיסמאות אינן תואמות' );
		}
	}
}, 10, 2 );

add_action( 'elementor_pro/forms/webhooks/response', function ( $response ) {
	setcookie( 'userRegisteredID', serialize( wp_remote_retrieve_body( $response ) ), time() + 60 * 60, '/' );
	
	$nonce = wp_create_nonce( 'login_user' );
	
	setcookie( 'theNonce', $nonce, time() + 60 * 60, '/' );
}, 10, 2 );

function bennerExcerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}
	
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
	
	return $excerpt;
}

// Load our function when hook is set
add_action( 'pre_get_posts', 'company_category_query' );

// Create a function to excplude some categories from the main query
function company_category_query( $query ) {
	// Check if on frontend and main query is modified
	if ( ! is_admin() && $query->is_main_query() &&
	     ( $query->is_tax( 'company_category' ) || $query->is_post_type_archive( 'companies' ) ) ) {
		$companyFields = explode( ',', $_REQUEST['field'] );
		$companyAreas  = explode( ',', $_REQUEST['area'] );
		$taxRel        = array();
		if ( ! empty( $companyFields ) && ! empty( $companyFields[0] ) ) {
			$taxRel[] = array(
				'taxonomy' => 'company_category',
				'field'    => 'id',
				'terms'    => $companyFields
			);
		}
		if ( ! empty( $companyAreas ) && ! empty( $companyAreas[0] ) ) {
			$taxRel[] = array(
				'taxonomy' => 'company_area',
				'field'    => 'id',
				'terms'    => $companyAreas
			);
		}
		if ( ! empty( $taxRel[0] ) ) {
			$query->set( 'tax_query',
				array(
					'relation' => 'AND',
					$taxRel
				)
			);
		}
		$query->set( 'posts_per_page', 15 );
		$query->set( 'meta_key', 'company_user' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
	if($query->is_post_type_archive( 'companies' ) && !is_admin()){
		$query->set( 'meta_query', array(
			array(
				'key' => 'company_user',
				'value' => false,
				'compare' => '!=',
			)
		));
	}
}

// Apply filter
add_filter( 'body_class', 'bright_background_pages' );

function bright_background_pages( $classes ) {
	if ( get_field( 'bright_background' ) ) {
		$classes[] = 'bright-background';
	}
	
	return $classes;
}

// Remove buttons from wysiwyg

/**
 * Removes buttons from the first row of the tiny mce editor
 *
 * @link     http://thestizmedia.com/remove-buttons-items-wordpress-tinymce-editor/
 *
 * @param    array $buttons The default array of buttons
 *
 * @return   array                The updated array of buttons that exludes some items
 */
if(!is_admin()) {
	add_filter( 'mce_buttons', 'jivedig_remove_tiny_mce_buttons_from_editor' );
}
function jivedig_remove_tiny_mce_buttons_from_editor( $buttons ) {
	$remove_buttons = array(
		'bold',
		'italic',
		'strikethrough',
		'bullist',
		'numlist',
		'blockquote',
		'hr', // horizontal line
		'alignleft',
		'aligncenter',
		'alignright',
		'link',
		'unlink',
		'wp_more', // read more link
		'spellchecker',
		'dfw', // distraction free writing mode
		'wp_adv', // kitchen sink toggle (if removed, kitchen sink will always display)
	);
	foreach ( $buttons as $button_key => $button_value ) {
		if ( in_array( $button_value, $remove_buttons ) ) {
			unset( $buttons[ $button_key ] );
		}
	}
	
	return $buttons;
}

/**
 * Removes buttons from the second row (kitchen sink) of the tiny mce editor
 *
 * @link     http://thestizmedia.com/remove-buttons-items-wordpress-tinymce-editor/
 *
 * @param    array $buttons The default array of buttons in the kitchen sink
 *
 * @return   array                The updated array of buttons that exludes some items
 */
if(!is_admin()){
	add_filter( 'mce_buttons_2', 'jivedig_remove_tiny_mce_buttons_from_kitchen_sink' );
}
function jivedig_remove_tiny_mce_buttons_from_kitchen_sink( $buttons ) {
	$remove_buttons = array(
		'formatselect', // format dropdown menu for <p>, headings, etc
		'underline',
		'alignjustify',
		'forecolor', // text color
		'pastetext', // paste as text
		'removeformat', // clear formatting
		'charmap', // special characters
		'outdent',
		'indent',
		'undo',
		'redo',
		'wp_help', // keyboard shortcuts
	);
	foreach ( $buttons as $button_key => $button_value ) {
		if ( in_array( $button_value, $remove_buttons ) ) {
			unset( $buttons[ $button_key ] );
		}
	}
	
	return $buttons;
}

function loadMoreCompanies() {
	$archive = $_POST['archive'];
	$offset    = $_POST['offset'];
	$tax_id = $_POST['taxId'];
	$args = array(
		'post_type' => 'companies',
		'posts_per_page' => 15,
		'offset' => $offset,
		'meta_key' => 'company_user',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'post_status' => 'publish'
	);
	if($tax_id){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'company_category',
				'field'    => 'term_id',
				'terms'    => array($tax_id),
			),
		);
	}
	if($archive){
		$args['meta_query'] = array(
			array(
				'key' => 'company_user',
				'value' => false,
				'compare' => '!=',
			)
		);
	}
	$new_query = new WP_Query($args);
	ob_start();
	$notPaidCount = 0;
	if($new_query->have_posts()) {
		while ( $new_query->have_posts() ) : $new_query->the_post();
			$paid     = get_field( 'company_user' );
			$term     = get_top_category();
			$colClass = $paid ? 'col-pu-5' : 'not-paid clearfix';
			if ( ! $paid && $notPaidCount % 2 == 0 ) { ?>
				<div class='col-pu-5'>
			<?php } ?>
			<div class="<?php echo $colClass; ?>">
				<?php $backgroundImg = ( $paid && has_post_thumbnail() ) ? get_the_post_thumbnail_url() : wp_get_attachment_image_src( get_field( "company_cat_img", $term ), 'medium' )[0]; ?>
				<div class="company-container company-container-full"
						 style="background-image:url(<?php echo $backgroundImg ?>)">
					<?php if ( ! $paid ) {
						$notPaidCount ++; ?>
						<div class="company-archive-overlay"></div>
					<?php } ?>
					<?php if ( $paid ) { ?>
						<a href="<?php the_permalink() ?>">
							<?php echo wp_get_attachment_image( get_field( 'logo' ), 'medium', false, array( 'class' => 'company-logo' ) ); ?>
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
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>"
										 class="company-social-icon"><img
												src="<?php echo get_stylesheet_directory_uri() . "/assets/images/facebook.png" ?>"> </a>
									<a href="https://plus.google.com/share?url=<?php the_permalink() ?>" class="company-social-icon"><img
												src="<?php echo get_stylesheet_directory_uri() . "/assets/images/google.png" ?>"> </a>
									<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=&summary=&source="
										 class="company-social-icon"><img
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
			<?php if ( ! $paid && $notPaidCount % 2 == 0 ) { ?>
				</div>
			<?php } ?>
		<?php endwhile;
	} else{
		$ret['error'] = 'done';
	}
	$ret['result'] = ob_get_clean();
	ob_end_clean();
	echo json_encode($ret);
	die();
}

add_action( 'wp_ajax_loadMoreCompanies', 'loadMoreCompanies' );
add_action( 'wp_ajax_nopriv_loadMoreCompanies', 'loadMoreCompanies' );

function getBackgroundOptions(){
	$term_id = $_POST['chosen_cat'];
	$images = get_field('background_images_options', 'term_' . $term_id);
	echo json_encode($images, JSON_FORCE_OBJECT);
	die();
}
add_action( 'wp_ajax_getBackgroundOptions', 'getBackgroundOptions' );
add_action( 'wp_ajax_nopriv_getBackgroundOptions', 'getBackgroundOptions' );

function get_top_category() {
	global $post;
	$cats = get_the_terms($post, 'company_category'); // category object
	
	foreach($cats as $cat) {
		if ($cat->parent == 0) {
			return $cat;
		}
	}
	return false;
}

function removeEditLink( $string ) {
//	echo apply_filters( 'pojo_button_post_edit', '<a href="' . $edit_post_link . '" class="button size-small edit-link"><i class="fa fa-pencil"></i> ' . __( 'Edit', 'pojo' ) . '</a>', $edit_post_link, $id, $context );
	return;
}
add_filter( 'pojo_button_post_edit', 'removeEditLink', 10, 1 );
