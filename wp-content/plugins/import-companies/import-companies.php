<?php
/**
 * Plugin Name: Custom Companies Import
 * Description: A custom made plugin to import companies
 * Version: 1.0
 * Author: Nitzan
 * License: A "Slug" license name e.g. GPL12
 */

class MySettingsPage
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;
	
	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		
		wp_enqueue_script( 'importCompanies', plugin_dir_url( __FILE__ ) . 'import-companies.js' , array(
			'jquery'
		), false );
		wp_localize_script( 'importCompanies', 'ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
			'Settings Admin',
			'ייבוא חברות',
			'manage_options',
			'import-companies-admin',
			array( $this, 'create_admin_page' )
		);
	}
	
	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'my_option_name' );
		?>
		<style>
			.import-companies-text{
				display: none;
				text-align: center;
				font-size: 50px;
			}
			.import-companies-spinner {
				margin: 50px auto 0;
				width: 70px;
				text-align: center;
				display: none;
			}
			
			.import-companies-spinner > div {
				width: 18px;
				height: 18px;
				background-color: #333;
				
				border-radius: 100%;
				display: inline-block;
				-webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
				animation: sk-bouncedelay 1.4s infinite ease-in-out both;
			}
			
			.import-companies-spinner .bounce1 {
				-webkit-animation-delay: -0.32s;
				animation-delay: -0.32s;
			}
			
			.import-companies-spinner .bounce2 {
				-webkit-animation-delay: -0.16s;
				animation-delay: -0.16s;
			}
			
			@-webkit-keyframes sk-bouncedelay {
				0%, 80%, 100% { -webkit-transform: scale(0) }
				40% { -webkit-transform: scale(1.0) }
			}
			
			@keyframes sk-bouncedelay {
				0%, 80%, 100% {
					-webkit-transform: scale(0);
					transform: scale(0);
				} 40% {
					  -webkit-transform: scale(1.0);
					  transform: scale(1.0);
				  }
			}
		</style>
		<div class="wrap">
			<h1>ייבוא חברות</h1>
			<form method="post" action="#" id="import-companies">
				<input type="hidden" name="action" value="import_companies_handler">
				<p>אנא בחר קובץ
					<input type="file" id="csv_file" name="csv_file" value="" />
				</p>
				<p class="import-companies-text">טוען קובץ</p>
				<div class="import-companies-spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
				<?php $terms         = get_terms( array(
					'taxonomy'   => 'company_category',
					'hide_empty' => false,
					'parent'     => 0,
				) ); ?>
				<p>אנא בחר קטגוריה ראשית
					<select name="category" id="category-select">
						<option value="-1" selected>אנא בחר קטגוריה</option>
						<?php foreach ( $terms as $term ) {
							$selected = ( $term->term_id == $current_terms->term_id ) ? "selected" : "";
							echo $term->term_id . " " . $current_terms->term_id; ?>
							<option value="<?php echo $term->term_id ?>" <?php echo $selected ?>><?php echo $term->name ?></option>
						<?php } ?>
					</select>
				</p>
				<button class="button button-primary" type="submit">טען קובץ</button>
			</form>
		</div>
		<?php
	}
}

if( is_admin() )
	$my_settings_page = new MySettingsPage();

function import_companies_handler(){
	$csvFile = $_FILES['csv_file']['tmp_name'];
	$companies = [];
	$row = 0;
	if (($handle = fopen($csvFile, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($row > 0) {
				$num = count( $data );
				for ( $c = 0; $c < $num; $c ++ ) {
					$companies[$row-1][] = $data[ $c ];
				}
			}
			$row ++;
		}
		fclose($handle);
	}
//	echo json_encode($result);
	$count = 0;
	foreach($companies as $company){
		$company_id = $company[0];
		$company_name_en = $company[2];
		$address = $company[4];
		$postcode = $company[5];
		$area = explode('/', $company[6]);
		$phone = $company[7];
		$company_fax = $company[9];
		$founded_date = $company[10];
		$category = explode('/', $company[11]);
		$termIds[] = (int)$_POST['category'];
		
		$result[$count] = $id = wp_insert_post(array(
			'post_title' => $company[1],
			'post_type' => 'companies',
			'post_status' => 'publish',
			'post_content' => '',
			'comment_status' => 'closed',
			'ping_status' => 'closed'
		));
		$count++;
		
		update_post_meta( $id, '_visibility', 'visible' );
		$result[$count]['visibility'] = get_post_meta($id, '_visibility', true);
		update_field( 'company_id', $company_id, $id );
		update_field( 'company_name_en', $company_name_en, $id );
		update_field( 'address', $address, $id );
		update_field( 'postcode', $postcode, $id );
		update_field( 'phone', $phone, $id );
		update_field( 'company_fax', $company_fax, $id );
		update_field( 'founded_date', $founded_date, $id );
		update_field( 'company_user', 0, $id );
		
		if(!empty($category[0])) {
			foreach($category as $sub_cat) {
				foreach(array_map( function ( \WP_Term $term ) {
					return $term->term_id;
				}, get_terms( [
					'name__like' => $sub_cat,
					'hide_empty' => false,
					'taxonomy' => 'company_category',
				] ) ) as $term){
					$termIds[] = $term;
				}
			}
		}
		
		wp_set_post_terms( $id, $termIds, 'company_category' );
		
		$termIds = [];
		
		if(!empty($area[0])) {
			foreach($area as $item) {
				foreach(array_map( function ( \WP_Term $term ) {
					return $term->term_id;
				}, get_terms( [
					'name__like' => $item,
					'hide_empty' => false,
					'taxonomy' => 'company_area',
				] ) ) as $term){
					$termIds[] = $term;
				}
			}
		}
		
		wp_set_post_terms( $id, $termIds, 'company_area' );
	}
	echo json_encode($result);
	die();
}
add_action( 'wp_ajax_import_companies_handler', 'import_companies_handler' );
add_action( 'wp_ajax_nopriv_import_companies_handler', 'import_companies_handler' );