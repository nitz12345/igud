<?php
if ( isset( $_POST['update-company'] ) && isset( $_POST['submit'] ) && ( $_POST['submit'] == "submit" ) ) {
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	wp_update_post( array( 'ID' => get_the_ID(), 'post_title' => $_POST['company_name'] ) );
	wp_set_post_terms( get_the_ID(), $_POST['category'], 'company_category' ); // Update category
	wp_set_post_terms( get_the_ID(), $_POST['sub-category'], 'company_category', true ); // Update sub category
	wp_set_post_terms( get_the_ID(), $_POST['location'], 'company_area' ); // Update location
	for ( $i = 1, $j = 0; $i < 5; $i ++ ) {
		if ( isset( $_POST[ 'staff_name_' . $i ] ) && ! empty( $_POST[ 'staff_name_' . $i ] ) ) {
			
			$staff[ $j ] = array(
				"staff_name"  => $_POST[ 'staff_name_' . $i ],
				"staff_title" => str_replace( '"', '״', $_POST[ 'staff_title_' . $i ] )
			);
			
			update_field( 'staff_' . ( $j + 1 ), $staff[ $j ] ); // Update name and title
			
			// Update image
			if ( $_POST[ "staff_image_" . $i . "_change" ] == '1' ) {
				if ( $_FILES[ 'staff_image_' . $i ]['error'] == 0 ) {
					$img_id = media_handle_upload( 'staff_image_' . $i, 0 );
					if ( ! is_wp_error( $img_id ) ) {
						update_field( 'staff_' . ( $j + 1 ), array( 'staff_image' => $img_id ) );
					}
				} else {
					update_field( 'staff_' . ( $j + 1 ), array( 'staff_image' => 0 ) );
				}
			}
			$j ++;
		}
	}
	for ($i = 1; $i <= 7; $i ++) {
		$galleryImage = get_field('gallery')["gallery_item_$i"];
		if ( isset( $_FILES[ 'gallery-item-' . $i ] ) && $_FILES[ 'gallery-item-' . $i ]['error'] == 0 ) {
			$img_id = media_handle_upload( 'gallery-item-' . $i, get_the_ID() );
			if ( ! is_wp_error( $img_id ) ) {
				update_field( 'gallery', array('gallery_item_'.$i => $img_id) );
			}
		} elseif($galleryImage && $_FILES[ 'gallery-item-' . $i ]['error'] > 0){
			wp_delete_attachment( $galleryImage, true);
			update_field( 'gallery', array('gallery_item_'.$i => 0));
		}
	}
	
	if ( $_POST['company-video'] ) {
		$videos = "";
		foreach ( $_POST['company-video'] as $video ) {
			$videos .= $video.',';
		}
		update_field( 'youtube_videos', $videos );
	}
	
	if(isset($_POST['background_image'])){
		set_post_thumbnail( get_the_ID(), $_POST['background_image'] );
	}
	
	$fields = $_POST;
	foreach ( $fields as $field_name => $field ) {
		if($field_name != 'company-video')
			update_field( $field_name, $field );
	}
	
	// Let WordPress handle the upload.
	$img_id = media_handle_upload( 'logo_file', 0 );
	
	if ( ! is_wp_error( $img_id ) ) {
		update_field( 'field_5a81c416c9616', $img_id, get_the_ID() );
	} elseif($_FILES['logo_file']['error'] === 4){
		wp_delete_attachment( get_field('field_5a81c416c9616'), true);
		update_field( 'field_5a81c416c9616', 0, get_the_ID() );
	}
	
	if(!get_field('mail_after_publish')){
		update_field('mail_after_publish', 1);
		$subject = "הלקוח סיים לעדכן את הדף וממתין לאישור";
		$to = "ipca.users@gmail.com";
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$messageBody = "<html dir='rtl'><body>";
		$messageBody .= "<p>הלקוח <a href='".get_permalink()."'>".get_the_title()."</a>"." סיים לערוך את הדף וממתין לאישור";
		$messageBody .= "</body></html>";
		wp_mail( $to, $subject, $messageBody, $headers ); ?>
		<script>
			window.location.replace("<?php echo get_permalink(1427) ?>");
		</script>
		<?php
	}
}
$terms         = get_terms( array(
	'taxonomy'   => 'company_category',
	'hide_empty' => false,
	'parent'     => 0,
) );
$current_terms = array_filter( array_map( function ( $term ) {
	if ( $term->parent == 0 ) {
		return $term;
	}
}, get_the_terms( get_the_ID(), 'company_category' ) ) );
$current_terms = current($current_terms);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'edit' ); ?>>
	<div class="choose-background-image">
		<div class="container">
			<div class="row">
				<?php if(count($current_terms) > 0){
					$images = get_field('background_images_options', $current_terms);
					foreach($images as $img){ ?>
							<div class="col-md-3">
								<?php echo wp_get_attachment_image( $img['ID'], 'medium', false, array(
										"data-img_id" => $img['ID'],
										"data-full_size" => $img['url']
								) ); ?>
							</div>
						<?php } ?>
					<?php } else{ ?>
					<div class="col-md-12">אנא בחר קטגוריה</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<form action="#" method="post" enctype="multipart/form-data" class="edit-company">
		<button name="submit" type="submit" value="submit" class="update-company elementor-button elementor-size-sm">
			<?php echo get_field('mail_after_publish') ? 'עדכון' : 'פרסום'; ?>
		</button>
		<header>
			<div class="company-top-image-wrapper">
				<div class="company-choose-image-overlay">בחר תמונת רקע</div>
				<?php if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'full' );
				} else{ ?>
					<img src="http://igud.s271.upress.link/wp-content/uploads/2018/03/companies-top-img.jpg">
				<?php } ?>
			</div>
			<?php if ( pojo_is_show_page_title() ) : ?>
				<div class="page-title">
					<div class="container">
						<h1 class="entry-title"><input type="text" name="company_name" value="<?php the_title() ?>"
																					 style="max-width: 600px;margin: 0px auto;"></h1>
						<h2><input type="text" name="company_name_en"
											 value="<?php acf_field_placeholder( 'company_name_en' ) ?>"
											 placeholder="<?php acf_field_placeholder( 'company_name_en', 'English Company Name' ) ?>"
											 style="max-width: 600px;margin: 0px auto;"></h2>
						<input type="file" name="logo_file" id="logo-file-input" style="position: absolute;right: 0;bottom: 40%;">
						<div id="company-logo">
							<?php if ( get_field( 'logo' ) ) { ?>
								<a href="#" class="remove-logo"><i class="fa fa-times" aria-hidden="true"></i></a>
								<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium'); ?>
							<?php } else { ?>
								<span>לחץ כאן להוספת לוגו</span>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</header>
		<div class="company-top-info">
			<div class="container">
				<div class="pull-left">
					<div class="company-type"
							 style="background-color: <?php echo get_field( 'main_color', $current_terms ) ?>">
						<a href="#choose-company">
							<?php if ( count( $current_terms ) > 0 ) { ?>
								<?php echo wp_get_attachment_image( get_field( 'icon', $current_terms ), 'thumbnail' ); ?>
								<span><?php echo $current_terms->name ?></span>
							<?php } else { ?>
								<span>אנא בחר קטגוריה</span>
							<?php } ?>
						</a>
					</div>
					<div class="company-id">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-id.png">
						<span><input <?php echo get_field('mail_after_publish') ? "disabled" : '' ?> class="required" type="text" name="company_id" value="<?php acf_field_placeholder( 'company_id' ) ?>"
												 placeholder="<?php acf_field_placeholder( 'company_id', 'ח.פ. (חובה)' ) ?>"
												 style="max-width: 190px;display: inline;"></span>
					</div>
					<div class="company-date">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-date.png">
						<span>שנת יסוד: <input type="number" name="founded_date"
																	 value="<?php acf_field_placeholder( 'founded_date' ) ?>"
																	 placeholder="<?php acf_field_placeholder( 'founded_date', '1983' ) ?>"
																	 style="max-width: 120px;display: inline;"></span>
					</div>
				</div>
				<div class="pull-right company-social-share">
					<a href="https://waze.com/ul?q=<?php echo urlencode( get_field( 'address' ) ); ?>" target="_blank"><span><img
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-waze.png"></span></a>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank"><span><img
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-facebook.png"></span></a>
					<a href="whatsapp://send?text=<?php the_permalink() ?>" data-action="share/whatsapp/share"><span><img
									src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-whatsapp.png"></span></a>
				</div>
			</div>
		</div>
		<div class="company-menu-info">
			<div class="container">
				<div class="pull-left">
					<ul class="company-menu">
						<li><a href="#company-section-one">פרופיל החברה</a></li>
						<li><a href="#company-section-two">אודות</a></li>
						<li><a href="#company-section-three">המנהלים</a></li>
						<li><a href="#company-section-four">גלרייה</a></li>
						<!--                            <li><a href="#company-section-five">צור קשר</a></li>-->
					</ul>
				</div>
				<div class="pull-right">
					<span><a href="<?php the_permalink( 63 ) ?>" target="_blank">מצאת טעות?</a></span>
				</div>
			</div>
		</div>
		<div id="company-section-one" class="company-section">
			<div class="container">
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-notebook.png">
					<h2>פרופיל החברה</h2>
					<hr>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="details-row">
							<div class="detail-title">
								שם נוסף
							</div>
							<div class="detail-content">
								<input type="text" name="company_sec_name"
											 value='<?php acf_field_placeholder( "company_sec_name" ) ?>'
											 placeholder="ככל שקיים שם נוסף לחברה אנא הזן אותו בשדה זה">
							</div>
						</div>
						
						<div class="details-row">
							<div class="detail-title">
								אתר החברה
							</div>
							<div class="detail-content">
								<input type="text" name="company_url"
											 value="<?php acf_field_placeholder( 'company_url' ) ?>"
											 placeholder='אנא הזן את כתובת אתר האינטרנט של החברה'>
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								דואר אלקטרוני
							</div>
							<div class="detail-content">
								<input type="email" name="company_email"
											 value="<?php acf_field_placeholder( 'company_email' ) ?>"
											 placeholder="אנא הזן כתובת דואר אלקטרוני">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								טלפון
							</div>
							<div class="detail-content">
								<input type="tel" name="phone" value="<?php acf_field_placeholder( 'phone' ) ?>"
											 placeholder="אנא הזן מס' טלפון">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								פקס
							</div>
							<div class="detail-content">
								<input type="tel" name="company_fax"
											 value="<?php acf_field_placeholder( 'company_fax' ) ?>"
											 placeholder="אנא הזן מספר פקס">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								כתובת
							</div>
							<div class="detail-content">
								<input type="text" name="address" value="<?php the_field( 'address' ) ?>"
											 placeholder="אנא הזן את כתובת החברה" style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								מיקוד
							</div>
							<div class="detail-content">
								<input type="text" name="postcode" value="<?php the_field( 'postcode' ) ?>"
											 placeholder="אנא הזן מיקוד"
											 style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								שעות פעילות (לא חובה)
							</div>
							<div class="detail-content">
								<input type="text" name="working_hours" value="<?php the_field( 'working_hours' ) ?>"
											 placeholder="אנא הזן שעות פעילות - א'-ה' 00:00-00:00 ו' 00:00-00:00"
											 style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								בעלי מניות (לא חובה ולא יוצג באתר)
							</div>
							<div class="detail-content">
								<input type="text" name="options_details" value="<?php the_field( 'options_details' ) ?>"
											 placeholder="אנא הזן שמות בעלי המניות"
											 style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								פרטי דירקטורים (לא חובה ולא יוצג באתר)
							</div>
							<div class="detail-content">
								<input type="text" name="directors" value="<?php the_field( 'directors' ) ?>"
											 placeholder="אנא הזן שמות הדירקטורים בחברה"
											 style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								חברות קשורות (לא חובה ולא יוצג באתר)
							</div>
							<div class="detail-content">
								<input type="text" name="companies_connected" value="<?php the_field( 'companies_connected' ) ?>"
											 placeholder="אנא הזן חברות הקשורות לחברה"
											 style="width: 100%;">
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								רשתות חברתיות
							</div>
							<div class="detail-content">
								<a href="<?php the_field( 'social_youtube' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-youtube.png"></a><input
										type="text" name="social_youtube" value="<?php acf_field_placeholder( 'social_youtube' ) ?>"
										placeholder='אנא הזן את כתובת ערוץ ה-youtube של החברה'>
								<a href="<?php the_field( 'social_twitter' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-twitter.png"></a><input
										type="text" name="social_twitter" value="<?php acf_field_placeholder( 'social_twitter' ) ?>"
										placeholder='אנא הזן את כתובת דף החברה ב- twitter'>
								<a href="<?php the_field( 'social_google' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-google.png"></a><input
										type="text" name="social_google" value="<?php acf_field_placeholder( 'social_google' ) ?>"
										placeholder='אנא הזן את כתובת דף החברה ב-google+'>
								<a href="<?php the_field( 'social_linkedin' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-linkedin.png"></a><input
										type="text" name="social_linkedin" value="<?php acf_field_placeholder( 'social_linkedin' ) ?>"
										placeholder='אנא הזן את כתובת דף החברה ב-linkedin'>
								<a href="<?php the_field( 'social_facebook' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-facebook.png"></a><input
										type="text" name="social_facebook" value="<?php acf_field_placeholder( 'social_facebook' ) ?>"
										placeholder='אנא הזן כתובת דף החברה ב-facebook'>
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								איזור
							</div>
							<div class="detail-content">
								<?php $locations  = get_terms( array(
									'taxonomy'   => 'company_area',
									'hide_empty' => false,
								) );
								$current_location = array_column( get_the_terms( get_the_ID(), 'company_area' ), 'term_id' ); ?>
								<select name="location">
									<?php foreach ( $locations as $location ) {
										$selected = ( $location->term_id == $current_location[0] ) ? "selected" : ""; ?>
										<option
												value="<?php echo $location->term_id ?>" <?php echo $selected ?>><?php echo $location->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title" id="choose-company">
								קטגוריה
							</div>
							<div class="detail-content">
								<select name="category" id="category-select">
									<option value="-1" selected>אנא בחר קטגוריה</option>
									<?php foreach ( $terms as $term ) {
										$selected = ( $term->term_id == $current_terms->term_id ) ? "selected" : "";
										echo $term->term_id . " " . $current_terms->term_id; ?>
										<option value="<?php echo $term->term_id ?>" <?php echo $selected ?>><?php echo $term->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								תחומי פעילות
							</div>
							<div class="detail-content company-sub-cat">
								<?php if ( count( $current_terms ) > 0 ) {
									getSubCategories( $current_terms->term_id, true );
								} ?>
							</div>
						</div>
						<div class="details-row">
							<div class="detail-title">
								תגיות (הפרד בפסיקים)
							</div>
							<div class="detail-content company-tags">
								<input type="text" name="company_tags"
											 value='<?php acf_field_placeholder( "company_tags" ) ?>'
											 placeholder='<?php acf_field_placeholder( "company_tags", "תגית, עוד תגית" ) ?>'>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<?php if ( get_field( 'address' ) ) { ?>
							<iframe
									width="600"
									height="450"
									frameborder="0" style="border:0"
									src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDCak6eNkyRfbBLD9dPGncEDC6Mmt-WjUk
    &q=<?php echo urlencode( get_field( 'address' ) ); ?>&language=iw" allowfullscreen>
							</iframe>
						<?php } ?>
					</div>
				
				</div>
			</div>
		</div>
		<div id="company-section-two" class="company-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="company-section-title">
							<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-about.png">
							<h2>אודות <?php the_title() ?></h2>
							<hr>
						</div>
						<?php $about = get_field( 'about_content' );
						$settings    = array(
							'textarea_rows' => 5,
							'media_buttons' => false,
							'quicktags'     => false,
						); ?>
						<?php wp_editor( $about, 'about_content', $settings ); ?>
					</div>
					<div class="col-md-4">
						<?php if ( get_field( 'facebook_page' ) ) {
							$facebook_page = get_field( 'facebook_page' );
						} else {
							$facebook_page = 'https://www.facebook.com/%D7%90%D7%99%D7%92%D7%95%D7%93-%D7%94%D7%97%D7%91%D7%A8%D7%95%D7%AA-%D7%94%D7%A4%D7%A8%D7%98%D7%99%D7%95%D7%AA-%D7%91%D7%99%D7%A9%D7%A8%D7%90%D7%9C-1740003899646094/';
						} ?>
						<div style="margin-bottom: 20px;">
							<label for="facebook_page">עמוד הפייסבוק</label>
							<input type="url" name="facebook_page" value="<?php echo $facebook_page ?>" placeholder="אנא הוסף את כתובת עמוד הפייסבוק של החברה">
						</div>
						<div id="fb-root"></div>
						<script>(function (d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s);
								js.id = id;
								js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=560212117513867&autoLogAppEvents=1';
								fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-page" data-href="<?php echo $facebook_page; ?>" data-tabs="timeline"
								 data-small-header="false" data-adapt-container-width="true" data-hide-cover="true"
								 data-show-facepile="false">
							<blockquote cite="<?php echo $facebook_page; ?>" class="fb-xfbml-parse-ignore"><a
										href="<?php echo $facebook_page; ?>"></a></blockquote>
						</div>
					</div>
				
				</div>
			</div>
		</div>
		<div id="company-section-three" class="company-section">
			<div class="container">
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-managers.png">
					<h2>מנהלים</h2>
					<hr>
					<span class="upload-notice">(אין אפשרות לסובב את התמונה. גודל תמונה אופטימלי הינו 295 על 295 פיקסלים)</span>
				</div>
				<div class="row managers">
					<?php
					for ( $i = 1; $i < 5; $i ++ ) {
						$staff = get_field( 'staff_' . $i );
						if ( $staff['staff_name'] ) { ?>
							<div class="col-md-3">
								<div class="staff-placeholders">
									<input class="staff_image_change" type="hidden" name="staff_image_<?php echo $i ?>_change"
												 value="0">
									<label for="staff_image_<?php echo $i ?>">בחר תמונה</label>
									<input type="file" id="staff_image_<?php echo $i ?>" name="staff_image_<?php echo $i ?>"
												 style="visibility: hidden;">
									<div class="staff-image-wrapper edit-mode">
										<?php if ( $staff['staff_image'] ) { ?>
											<a href="#" class="remove-staff-image"><i class="fa fa-times" aria-hidden="true"></i></a>
											<?php echo wp_get_attachment_image( $staff['staff_image'], 'medium' ); ?>
										<?php } ?>
										<div class="pu-image-title">
                        <span class="name-title">
                          <input type="text"
																 id="staff_name_<?php echo $i ?>"
																 name="staff_name_<?php echo $i ?>"
																 placeholder="שם המנהל"
																 value="<?php echo $staff['staff_name'] ?>">
                        </span>
											<span class="job-description">
                          <input type="text" id="staff_title_<?php echo $i ?>"
																 name="staff_title_<?php echo $i ?>"
																 placeholder="תפקיד המנהל"
																 value="<?php echo $staff['staff_title'] ?>">
                        </span>
										</div>
									</div>
								</div>
							</div>
						<?php } else {
							break;
						}
					}
					for ( ; $i < 5; $i ++ ) { ?>
						<div class="col-md-3">
							<div class="staff-placeholders edit-mode">
								<input class="staff_image_change" type="hidden" name="staff_image_<?php echo $i ?>_change" value="0">
								<label for="staff_image_<?php echo $i ?>">בחר תמונה</label>
								<input type="file" id="staff_image_<?php echo $i ?>" name="staff_image_<?php echo $i ?>"
											 style="visibility: hidden;">
								<div class="staff-image-wrapper">
									<div class="pu-image-title">
                    <span class="name-title"><input type="text" id="staff_name_<?php echo $i ?>"
																										name="staff_name_<?php echo $i ?>" placeholder="שם המנהל"></span>
										<span class="job-description"><input type="text" id="staff_title_<?php echo $i ?>"
																												 name="staff_title_<?php echo $i ?>"
																												 placeholder="תפקיד המנהל"></span>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				
				</div>
			</div>
		</div>
		<div id="company-section-four" class="company-section">
			<div class="container">
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-camera.png">
					<h2>גלרייה</h2>
					<hr>
				</div>
				<div class="row company-gallery">
					<div class="col-md-12">
<!--						<input style="visibility: hidden;" type="file" name="gallery[]" id="gallery" multiple>-->
						<div class="gallery-images row">
							<?php $gallery = get_field('gallery'); ?>
							<?php for($i = 1; $i <= 7; $i++){ ?>
								<div class="col-md-<?php echo $i==6 ? 6 : 3; ?>">
									<div class="gallery-placeholder <?php echo !$gallery["gallery_item_$i"] ? 'no-img' : '' ?>" data-number="<?php echo $i ?>">
										<?php if($gallery["gallery_item_$i"]){ ?>
											<?php echo wp_get_attachment_image( $gallery["gallery_item_$i"], 'large' );
										} else{ ?>
											בחר תמונה
										<?php } ?>
									</div>
									<?php if(!$gallery["gallery_item_$i"]){ ?>
										<input type="file" name="gallery-item-<?php echo $i ?>" class="gallery-items-input" />
									<?php } else{ ?>
										<a href='#' class='remove-gallery-image'><i class='fa fa-times'></i></a>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-camera.png">
					<h2>סרטונים</h2>
					<hr>
				</div>
				<?php $videos = explode( ',', get_field( 'youtube_videos' ) ); ?>
				<div class="row company-videos">
					<div class="col-md-12">
						<?php if($videos) {
							foreach ( $videos as $video ) {
								if ( $video ) { ?>
									<div class="company-video-text-wrapper">
										<a href="#" class="remove-video"><i class="fa fa-times"></i></a>
										<input type="text" class="company-video" name="company-video[]"
													 placeholder="הכנס מזהה סרטון מיוטיוב"
													 value="<?php echo $video ?>">
									</div>
								<?php }
							}
						} else{ ?>
							<div class="company-video-text-wrapper">
								<a href="#" class="remove-video"><i class="fa fa-times"></i></a>
								<input type="text" class="company-video" name="company-video[]" placeholder="הכנס סרטון מיוטיוב">
							</div>
						<?php }?>
					</div>
				</div>
				<a href="#" id="add-video">הוסף סרטון</a>
				<div class="row">
					<?php foreach ( $videos as $video ) {
						if ( $video ) { ?>
							<div class='col-md-3'>
								<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $video ?>"
												frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
							</div>
						<?php }
					}?>
				</div>
			</div>
		</div>
		<?php /* ?>
            <div id="company-section-five" class="company-section">
                <div class="container">
                    <div class="company-section-title">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-contact.png">
                        <h2>צור קשר עם החברה</h2>
                        <hr>
                    </div>
                    <div class="row">
                        <?php echo do_shortcode('[contact-form-7 id="458"]') ?>
                    </div>
                </div>
            </div>
            <?php */ ?>
		<div id="company-section-footer" class="company-section">
			<div class="container">
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-more.png">
					<h2>אולי יעניין אותך</h2>
					<hr>
				</div>
				<div class="pu-more-companies row">
					
					<?php
					// WP_Query arguments
					$args = array(
						'post_type'      => array( 'companies' ),
						'posts_per_page' => '4',
						'post_status' => array('publish'),
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
							} ?>
							<div class="col-md-3">
								<a href="<?php the_permalink() ?>">
									<div class="company-container" style="background-image:url(<?php echo $thumbnail; ?>)">
										<?php echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('class' => 'company-logo')); ?>
										<div class="company-details">
											<span class="company_name"><?php the_title() ?></span>
											<span class="company_phone"><?php the_field( 'phone' ) ?></span>
											<span class="company_address"><?php the_field( 'address' ) ?></span>
											<div class="company_bottom-bar">
												<div class="pull-right">
													<a href="<?php the_field( 'twitter' ) ?>" class="company-social-icon"><img
																src="<?php echo get_stylesheet_directory_uri() . "/assets/images/twitter.png" ?>">
													</a>
													<a href="<?php the_field( 'whatsapp' ) ?>"
														 class="company-social-icon"><img
																src="<?php echo get_stylesheet_directory_uri() . "/assets/images/whatsapp.png" ?>">
													</a>
													<a href="<?php the_field( 'facebook' ) ?>"
														 class="company-social-icon"><img
																src="<?php echo get_stylesheet_directory_uri() . "/assets/images/facebook.png" ?>">
													</a>
													<a href="<?php the_field( 'google' ) ?>"
														 class="company-social-icon"><img
																src="<?php echo get_stylesheet_directory_uri() . "/assets/images/google.png" ?>">
													</a>
													<a href="<?php the_field( 'linkedin' ) ?>"
														 class="company-social-icon"><img
																src="<?php echo get_stylesheet_directory_uri() . "/assets/images/linkedin.png" ?>">
													</a>
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
			
			</div>
		</div>
		<input type="hidden" name="update-company" value="1">
		<input type="hidden" name="background_image">
	</form>
</article>
