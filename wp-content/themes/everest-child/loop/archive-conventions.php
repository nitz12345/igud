<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$display_type = po_get_display_type();
?>
<div id="wrapper">
    <main id="main">
        <div class="banner-wrap" style="background-image: url('/wp-content/themes/everest-child/assets/images/img02.jpg');">
            <h1>כנסים</h1>
        </div>
        <div class="post-wrap">
            <div class="holder">
                <a href="#" class="btn btn-outline">+ הוסף כנס</a>
                <ul class="post-list">
	                <?php if ( have_posts() ) : ?>
	                <?php while ( have_posts() ) : the_post(); ?>
                    <li>
                        <div class="time-wrap">
                            <strong class="time"><?php the_field('convention_date') ?></strong>
                            <span class="time-range">יום ג’ | <?php the_field('convention_time') ?></span>
                            <address><?php the_field('convention_location') ?><br><?php the_field('convention_building') ?></address>
                        </div>
                        <div class="txt">
                            <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                            <p><?php the_content() ?></p>
                        </div>
                        <div class="img"><a href="<?php the_permalink() ?>"><img src="<?php the_post_thumbnail_url() ?>" alt="image description"></a></div>
                    </li>
                    <?php
                    endwhile;endif;
                    ?>
                </ul>
            </div>
        </div>
    </main>
</div>
<?php
the_widget('pu__leading_companies');
echo do_shortcode('[elementor-template id="481"]');
?>