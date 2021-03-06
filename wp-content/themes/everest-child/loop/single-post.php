<?php
/**
 * Default Single
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( have_posts() ) :
	
	while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('magazine-post-article'); ?>>
			<div class="entry-meta">
				<?php if ( po_single_metadata_show( 'date' ) ) : ?>
					<span><time datetime="<?php the_time('o-m-d'); ?>" class="entry-date date published updated"><?php echo get_the_date(); ?></time></span>
				<?php endif; ?>
				<?php if ( po_single_metadata_show( 'time' ) ) : ?>
					<span class="entry-time"><?php echo get_the_time(); ?></span>
				<?php endif; ?>
				<?php if ( po_single_metadata_show( 'comments' ) ) : ?>
					<span class="entry-comment"><?php comments_popup_link( __( 'No Comments', 'pojo' ), __( 'One Comment', 'pojo' ), __( '% Comments', 'pojo' ), 'comments' ); ?></span>
				<?php endif; ?>
				<?php if ( po_single_metadata_show( 'author' ) ) : ?>
					<span class="entry-user vcard author"><a class="fn" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php echo get_the_author(); ?></a></span>
				<?php endif; ?>
			</div>
			<div class="entry-content">
				<?php if ( ! Pojo_Core::instance()->builder->display_builder() ) : ?>
					<?php the_content(); ?>
					<?php echo do_shortcode('[elementor-template id="481"]'); ?>
					<?php pojo_link_pages(); ?>
				<?php endif; ?>
			</div>
			<?php $tags = get_the_tags(); if ( $tags ) : ?><div class="entry-tags"><?php the_tags( '', ' ' ); ?></div><?php endif; ?>
		</article>
	<?php endwhile;
else :
	pojo_get_content_template_part( 'content', 'none' );
endif;