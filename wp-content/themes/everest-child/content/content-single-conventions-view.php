<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="banner-wrap" style="background-image: url('/wp-content/themes/everest-child/assets/images/img03.jpg');">
		<h1><?php the_title() ?> \ <?php the_field( 'convention_dates' ) ?></h1>
	</div>
	
	<div class="two-cols">
		<div class="txt">
			<ul class="listing">
				<li>
					<strong class="title">מידע נוסף</strong>
					<div class="data">
						<p><span><?php the_content() ?></span></p>
					</div>
				</li>
				<li>
					<strong class="title">מיקום הכנס</strong>
					<div class="data">
						<p><?php the_field( 'convention_location' ) ?></p>
					</div>
				</li>
				<li>
					<strong class="title">תאריך <br>שעות פעילות</strong>
					<div class="data">
						<p><?php the_field( 'convention_dates' ) ?> <br><?php the_field( 'convention_time' ) ?></p>
					</div>
				</li>
				<li>
					<strong class="title">אתר הכנס</strong>
					<div class="data">
						<p><a href="<?php the_field( 'convention_website' ) ?>"><?php the_field( 'convention_website' ) ?></a></p>
					</div>
				</li>
				<li>
					<strong class="title">טלפון</strong>
					<div class="data">
						<p><a href="tel:<?php the_field( 'convention_tel' ) ?>"><?php the_field( 'convention_tel' ) ?></a></p>
					</div>
				</li>
				<li>
					<strong class="title">פקס</strong>
					<div class="data">
						<p><a href="tel:<?php the_field( 'convention_fax' ) ?>"><?php the_field( 'convention_fax' ) ?>-3333-3378</a>
						</p>
					</div>
				</li>
				<li>
					<strong class="title">רשתות חברתיות</strong>
					<div class="data">
						<?php echo do_shortcode( '[elementor-template id="889"]' ); ?>
					</div>
				</li>
			</ul>
		</div>
		<div class="img">
			<img src="<?php the_post_thumbnail_url() ?>">
		</div>
	</div>
	<?php the_widget( 'pu__leading_companies' ) ?>

</article>
