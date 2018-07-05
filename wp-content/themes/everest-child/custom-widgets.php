<?php
/**
 * Created by PhpStorm.
 * User: nitzan
 * Date: 08/03/2018
 * Time: 19:23
 */

// Register and load the widget
function benner_load_widget() {
	register_widget( 'benner_widget' );
	register_widget( 'ContractsHomepageWidget' );
	register_widget( 'ConventionsHomepageWidget' );
	register_widget( 'ConventionsArchive' );
}

add_action( 'widgets_init', 'benner_load_widget' );

// Creating the widget
class benner_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(

// Base ID of your widget
			'contracts_widget',

// Widget name will appear in UI
			__( 'Contracts List Widget', 'benner_widget_domain' ),

// Widget description
			array( 'description' => __( 'Contracts List', 'benner_widget_domain' ), )
		);
	}

// Creating widget front-end
	
	public function widget( $args, $instance ) {

// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

// This is where you run the code and display the output
		buildContractsList();
		echo $args['after_widget'];
	}

// Widget Backend
	public function form( $instance ) {
	
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}
} // Class benner_widget ends here

// Creating the widget
class ContractsHomepageWidget extends WP_Widget {
	
	function __construct() {
		parent::__construct(

// Base ID of your widget
			'contracts_homepage_widget',

// Widget name will appear in UI
			__( 'Contracts homepage Widget', 'benner_widget_domain' ),

// Widget description
			array( 'description' => __( 'Contracts Homepage Widget', 'benner_widget_domain' ), )
		);
	}

// Creating widget front-end
	
	public function widget( $args, $instance ) {

// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

// This is where you run the code and display the output
		contractsHomepageList();
		echo $args['after_widget'];
	}

// Widget Backend
	public function form( $instance ) {
	
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}
} // Class benner_widget ends here

class ConventionsHomepageWidget extends WP_Widget {
	
	function __construct() {
		parent::__construct(

// Base ID of your widget
			'conventions_homepage_widget',

// Widget name will appear in UI
			__( 'Conventions homepage Widget', 'benner_widget_domain' ),

// Widget description
			array( 'description' => __( 'Conventions Homepage Widget', 'benner_widget_domain' ), )
		);
	}

// Creating widget front-end
	
	public function widget( $args, $instance ) {

// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

// This is where you run the code and display the output
		conventionsHomepageList();
		echo $args['after_widget'];
	}

// Widget Backend
	public function form( $instance ) {
	
	}

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}
} // Class benner_widget ends here

// Creating the widget
class ConventionsArchive extends WP_Widget {

    function __construct() {
        parent::__construct(

// Base ID of your widget
            'conventions_archive',

// Widget name will appear in UI
            __( 'Conventions Archive Widget', 'benner_widget_domain' ),

// Widget description
            array( 'description' => __( 'Conventions Archive', 'benner_widget_domain' ), )
        );
    }

// Creating widget front-end

    public function widget( $args, $instance ) {

// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

// This is where you run the code and display the output
        conventionsArchive();
        echo $args['after_widget'];
    }

// Widget Backend
    public function form( $instance ) {

    }

// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }
} // Class benner_widget ends here

function conventionsArchive(){
    $args      = array(
        'post_type'      => 'conventions',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC'
    );

    $the_query = new WP_Query( $args ); ?>
    <div class="conventions-archive-wrapper">
        <?php while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $page_field = get_fields(); ?>
            <div class="elementor-grid elementor-grid-3">
                <div class="elementor-grid-item convention-details">
                    <div class="convention-end-date"><?php echo $page_field['convention_date'] ?></div>
                    <div class="convention-dates"><?php echo $page_field['convention_dates'] ?></div>
                    <div class="convention-location"><?php echo $page_field['convention_location'] ?></div>
                </div>
                <div class="elementor-grid-item convention-text">
                    <h2><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title(); ?></a></h2>
                    <div class="convention-excerpt">
                        <?php echo bennerExcerpt(30); ?>
                    </div>
                </div>
                <div class="elementor-grid-item convention-image">
                    <div class="convention-image"><?php the_post_thumbnail('medium') ?></div>
                </div>
            </div>
            <?php
        } ?>
    </div>
    <?php
}

function conventionsHomepageList() {
	$now       = date( 'Y-m-d' );
	$args      = array(
		'post_type'      => 'conventions',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'ASC'
	);
	$the_query = new WP_Query( $args ); ?>
	<div class="elementor-grid elementor-grid-3 homepage-list-grid conventions-list-grid">
		<?php while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$contractDate = get_field('contract_finish'); ?>
			<div class="elementor-grid-item">
				<div class="elementor-post__text">
					<div class="conventions-homepage-list-header" style="background-image: url(<?php the_post_thumbnail_url() ?>">
						<div class="elementor-post__meta-data">
							<span class="elementor-post-date"><?php echo date('d.m.Y', strtotime($contractDate)); ?></span>
						</div>
					</div>
                    <h4><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
					<div class="elementor-post__excerpt">
						<?php echo bennerExcerpt(10); ?>
					</div>
					<a href="<?php the_permalink() ?>" title="למידע נוסף" class="elementor-post__read-more">למידע נוסף</a>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php
}

function contractsHomepageList() {
	$now       = date( 'Y-m-d' );
	$args      = array(
		'post_type'      => 'contracts',
		'posts_per_page' => 3,
		'meta_query'     => array(
			array(
				'key'     => 'contract_finish',
				'value'   => $now,
				'type'    => 'DATE',
				'compare' => '>='
			),
		),
		'orderby'        => 'date',
		'order'          => 'ASC'
	);
	$the_query = new WP_Query( $args ); ?>
	<div class="elementor-grid elementor-grid-3 homepage-list-grid">
		<?php while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$contractDate = get_field('contract_finish'); ?>
			<div class="elementor-grid-item">
				<div class="elementor-post__text">
					<h4><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
					<div class="elementor-post__meta-data">
						<span class="elementor-post-date"><?php echo date('d.m.Y', strtotime($contractDate)); ?></span>
					</div>
					<div class="elementor-post__excerpt contracts-excerpt">
						<?php echo bennerExcerpt(20); ?>
					</div>
					<a href="<?php the_permalink() ?>" title="למידע נוסף" class="elementor-post__read-more">למידע נוסף</a>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php
}

function buildContractsList() {
	ob_start(); ?>
	<div id="contracts">
		<div class="contracts-header contracts-row hide-on-mobile">
			<div class="contract-publisher contract-column">מפרסם</div>
			<div class="contract-field contract-column">תחום</div>
			<div class="contract-name contract-column">שם המכרז</div>
			<div class="contract-number contract-column">מספר</div>
			<div class="contract-close contract-column">מכרז ייסגר</div>
		</div>
		<?php
		$now       = date( 'Y-m-d' );
		$args      = array(
			'post_type'      => 'contracts',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => 'contract_finish',
					'value'   => $now,
					'type'    => 'DATE',
					'compare' => '>='
				),
			)
		);
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$contract_fields = get_fields(); ?>
			<div class="contracts-content contracts-row">
				<div class="contract-publisher contract-column"><span class="hide-on-desktop">מפרסם: </span><?php echo $contract_fields['publisher']; ?></div>
				<div class="contract-field contract-column"><span class="hide-on-desktop">תחום: </span><?php echo $contract_fields['contract_field']; ?></div>
				<div class="contract-name contract-column">
					<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
						<span class="hide-on-desktop">שם המכרז: </span><?php the_title(); ?>
					</a>
				</div>
				<div class="contract-number contract-column"><span class="hide-on-desktop">מספר: </span><?php echo $contract_fields['contract_number']; ?></div>
				<div class="contract-close contract-column"><span class="hide-on-desktop">מכרז ייסגר: </span><?php echo $contract_fields['contract_finish']; ?></div>
			</div>
		<?php }
		wp_reset_postdata(); ?>
	</div>
	<?php echo ob_get_clean();
}

