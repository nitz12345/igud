<?php
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
$paid          = get_field( 'company_user' );
$isMobile = wp_is_mobile();
$current_terms = current($current_terms);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'full' );
		} else {
			$bgImg = get_field('bg_img',$current_terms); ?>
			<img src="<?php echo $bgImg ?>" alt="" />
		<?php } ?>
		<?php if ( pojo_is_show_page_title() ) : ?>
			<div class="page-title">
				<div class="container">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php if ( get_field( 'company_name_en' ) ) { ?><h2><?php the_field( 'company_name_en' ) ?></h2> <?php } ?>
					<?php if ( get_field( 'logo' ) && $paid ) {
						echo wp_get_attachment_image(get_field( 'logo' ), 'medium', false, array('id' => 'company-logo'));
					} ?>
				</div>
			</div>
		<?php endif; ?>
	</header>
	<div class="company-top-info">
		<div class="container">
			<div class="pull-left">
				<div class="company-type" style="background-color: <?php echo get_field( 'main_color', $current_terms ) ?>">
					<?php echo wp_get_attachment_image( get_field( 'icon', $current_terms ), 'thumbnail' ); ?>
					<span><?php echo $current_terms->name ?></span>
				</div>
				<div class="company-id">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-id.png">
					<?php if ( get_field( 'company_id' ) ) { ?><span><?php the_field( 'company_id' ) ?></span><?php } ?>
				</div>
				<div class="company-date">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-date.png">
					<?php if ( get_field( 'founded_date' ) ) { ?><span>שנת
						יסוד: <?php the_field( 'founded_date' ) ?></span><?php } ?>
				</div>
			</div>
			<div class="pull-right company-social-share">
				<?php if(get_field( 'address' ) && $isMobile){ ?>
				<a href="https://waze.com/ul?q=<?php echo urlencode( get_field( 'address' ) ); ?>" target="_blank"><span><img
								src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-waze.png"></span></a>
				<?php } ?>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank"><span><img
								src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-facebook.png"></span></a>
				<?php if($isMobile){ ?>
				<a href="whatsapp://send?text=<?php the_permalink() ?>" data-action="share/whatsapp/share"><span><img
								src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-whatsapp.png"></span></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="company-menu-info">
		<div class="container">
			<?php if ( $paid ) { ?>
				<div class="pull-left">
					<ul class="company-menu">
						<li><a href="#company-section-one">פרופיל החברה</a></li>
						<li><a href="#company-section-two">אודות</a></li>
						<li><a href="#company-section-three">המנהלים</a></li>
						<li><a href="#company-section-four">גלרייה</a></li>
						<li><a href="#company-section-five">צור קשר</a></li>
					</ul>
				</div>
			<?php } ?>
			<div class="pull-right">
				<?php $text = $paid ? 'מצאת טעות?' : 'עדכן את פרטי בית העסק'; ?>
				<span><a href="<?php the_permalink( 63 ) ?>" target="_blank"><?php echo $text ?></a></span>
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
					<?php if ( $paid ) { ?>
						<?php if ( get_field( 'company_sec_name' ) ) { ?>
							<div class="details-row">
								<div class="detail-title">
									שם נוסף
								</div>
								<div class="detail-content">
									<?php the_field( 'company_sec_name' ) ?>
								</div>
							</div>
						<?php } ?>
						<?php if ( get_field( 'company_url' ) ) { ?>
							<div class="details-row">
								<div class="detail-title">
									אתר החברה
								</div>
								<div class="detail-content">
									<?php the_field( 'company_url' ) ?>
								</div>
							</div>
						<?php } ?>
						<?php if ( get_field( 'company_email' ) ) { ?>
							<div class="details-row">
								<div class="detail-title">
									דואר אלקטרוני
								</div>
								<div class="detail-content">
									<?php the_field( 'company_email' ) ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
					<?php if ( get_field( 'phone' ) ) { ?>
						<div class="details-row">
							<div class="detail-title">
								טלפון
							</div>
							<div class="detail-content">
								<?php the_field( 'phone' ) ?>
							</div>
						</div>
					<?php } ?>
					<?php if ( get_field( 'company_fax' ) ) { ?>
						<div class="details-row">
							<div class="detail-title">
								פקס
							</div>
							<div class="detail-content">
								<?php the_field( 'company_fax' ) ?>
							</div>
						</div>
					<?php } ?>
					<?php if(get_field( 'address' ) ){ ?>
						<div class="details-row">
							<div class="detail-title">
								כתובת
							</div>
							<div class="detail-content">
								<?php the_field( 'address' ) ?>
							</div>
						</div>
					<?php } ?>
					<?php if(get_field( 'postcode' ) ){ ?>
						<div class="details-row">
							<div class="detail-title">
								מיקוד
							</div>
							<div class="detail-content">
								<?php the_field( 'postcode' ) ?>
							</div>
						</div>
					<?php } ?>
					<div class="details-row">
						<div class="detail-title">
							תחומי פעילות
						</div>
						<div class="detail-content">
							<?php if ( $current_terms ) {
								getSubCategories( $current_terms->term_id );
							} ?>
						</div>
					</div>
					<div class="details-row">
						<div class="detail-title">
							שעות פעילות
						</div>
						<div class="detail-content">
							<?php the_field( 'working_hours' ) ?>
						</div>
					</div>
					<?php if ( $paid ) { ?>
						<div class="details-row">
							<div class="detail-title">
								רשתות חברתיות
							</div>
							<div class="detail-content">
								<?php if ( get_field( 'social_youtube' ) ) { ?><a href="<?php the_field( 'social_youtube' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-youtube.png">
									</a><?php } ?>
								<?php if ( get_field( 'social_twitter' ) ) { ?> <a href="<?php the_field( 'social_twitter' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-twitter.png">
									</a><?php } ?>
								<?php if ( get_field( 'social_google' ) ) { ?> <a href="<?php the_field( 'social_google' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-google.png"></a><?php } ?>
								<?php if ( get_field( 'social_linkedin' ) ) { ?> <a href="<?php the_field( 'social_linkedin' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-linkedin.png">
									</a><?php } ?>
								<?php if ( get_field( 'social_facebook' ) ) { ?> <a href="<?php the_field( 'social_facebook' ) ?>"><img
											src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/company-facebook.png">
									</a><?php } ?>
							</div>
						</div>
						<?php if ( get_field( 'company_area' ) ) { ?>
							<div class="details-row">
								<div class="detail-title">
									תחומי פעילות
								</div>
								<div class="detail-content">
									<?php the_field( 'company_area' ) ?>
								</div>
							</div>
						<?php } ?>
						<?php if ( get_field( 'company_tags' ) ) { ?>
							<div class="details-row">
								<div class="detail-title">
									תגיות
								</div>
								<div class="detail-content company-tags">
									<?php the_field('company_tags'); ?>
								</div>
							</div>
						<?php } ?>
					<?php } ?>
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
	<?php if ( $paid ) {
		$about = get_field( 'about_content' ); ?>
		<div id="company-section-two" class="company-section">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<div class="company-section-title">
							<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-about.png">
							<h2>אודות <?php the_title() ?></h2>
							<hr>
						</div>
						<?php echo get_field( 'about_content' ); ?>
					</div>
					<div class="col-md-4">
						<?php $facebook_page = get_field( 'social_facebook' );
						if ( $facebook_page ) { ?>
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
											href="<?php echo $facebook_page; ?>">‎‎</a></blockquote>
							</div>
						<?php } ?>
					</div>
				
				</div>
			</div>
		</div>
		<?php $hasManagers = false;
		for ( $i = 1; $i < 5; $i ++ ) {
			if ( get_field( 'staff_' . $i )['staff_name'] )
				$hasManagers = true;
		}
		if($hasManagers){ ?>
			<div id="company-section-three" class="company-section">
				<div class="container">
					<div class="company-section-title">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-managers.png">
						<h2>מנהלים</h2>
						<hr>
					</div>
					<div class="row managers">
						<?php
						for ( $i = 1; $i < 5; $i ++ ) {
							$staff = get_field( 'staff_' . $i );
							if ( $staff['staff_name'] ) { ?>
								<div class="col-md-3">
									<div class="staff-placeholders view-mode <?php echo $staff['staff_image'] ? '' : 'no-image' ?>">
										<?php echo wp_get_attachment_image( $staff['staff_image'], 'medium' ); ?>
										<div class="pu-image-title">
													<span class="name-title">
														<?php echo $staff['staff_name'] ?>
													</span>
											<span class="job-description">
													<?php echo $staff['staff_title'] ?>
												</span>
										</div>
									</div>
								</div>
							<?php } else {
								break;
							}
						}
						?>
					
					</div>
				</div>
			</div>
		<?php }
		$gallery = get_field('gallery');
		$hasGallery = false;
		foreach($gallery as $item){
			if(!empty($item)) $hasGallery = true;
		}
		if($hasGallery) { ?>
			<div id="company-section-four" class="company-section">
				<div class="container">
					<div class="company-section-title">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-camera.png">
						<h2>גלרייה</h2>
						<hr>
					</div>
					<div class="gallery-images row">
						<?php for($i = 1; $i <= 7; $i++){ ?>
							<div class="col-md-<?php echo $i==6 ? 6 : 3; ?>">
								<div class="gallery-placeholder" data-number="<?php echo $i ?>">
									<?php if($gallery["gallery_item_$i"]){ ?>
										<?php echo wp_get_attachment_image( $gallery["gallery_item_$i"], 'large' );
									} ?>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php $videos = explode( ',', get_field( 'youtube_videos' ) );
					if($videos[0]) { ?>
						<div class="company-section-title">
							<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-camera.png">
							<h2>סרטונים</h2>
							<hr>
						</div>
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
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<div id="company-section-five" class="company-section">
			<div class="container">
				<div class="company-section-title">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-contact.png">
					<h2>צור קשר עם החברה</h2>
					<hr>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php echo do_shortcode( '[contact-form-7 id="458"]' ) ?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
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
												<a href="<?php the_field( 'social_twitter' ) ?>" class="company-social-icon"><img
															src="<?php echo get_stylesheet_directory_uri() . "/assets/images/twitter.png" ?>">
												</a>
												<a href="<?php the_field( 'social_whatsapp' ) ?>" class="company-social-icon"><img
															src="<?php echo get_stylesheet_directory_uri() . "/assets/images/whatsapp.png" ?>">
												</a>
												<a href="<?php the_field( 'social_facebook' ) ?>" class="company-social-icon"><img
															src="<?php echo get_stylesheet_directory_uri() . "/assets/images/facebook.png" ?>">
												</a>
												<a href="<?php the_field( 'social_google' ) ?>" class="company-social-icon"><img
															src="<?php echo get_stylesheet_directory_uri() . "/assets/images/google.png" ?>"> </a>
												<a href="<?php the_field( 'social_linkedin' ) ?>" class="company-social-icon"><img
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
	<?php if(!$paid){ ?>
		<div class="company-section">
			<?php echo do_shortcode('[elementor-template id="481"]'); ?>
		</div>
	<?php } ?>

</article>
