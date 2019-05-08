<?php
/**
 * Template part for displaying front page video.
 *
 * @package Moral
 */
// Get default  mods value.
$default = blog_lover_get_default_mods();

// Get the content type.
$video = get_theme_mod( 'blog_lover_video', 'custom' );

// Bail if the section is disabled.
if ( 'disable' === $video ) {
	return;
}

// Query if the content type is either post or page.
if (  in_array( $video, array( 'post' ) ) ) {

	if ( 'post' === $video ) {
		$id = get_theme_mod( 'blog_lover_video_post' );
	} 

	$query = new WP_Query( array( 'post_type' => $video, 'p' => absint( $id ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$img_url     = get_the_post_thumbnail_url( $id, 'large' );
			$title   = get_the_title();
			$btn_url     = get_permalink(); 
			$video_link = get_theme_mod( 'blog_lover_video_link', '' );
			?>

			<div id="latest-video" style="background-image: url('<?php echo esc_url( $img_url );?>');">
				<div class="overlay"></div>
			    <div class="wrapper">
					<div class="video-content-wrapper">
						<?php blog_lover_cats(); ?>
					    <header class="entry-header">
					        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					    </header>

					    <div class="entry-meta">
							<?php blog_lover_posted_on(); ?>
					    </div><!-- .entry-meta -->

					    <div class="icon-play">
					        <a class="popup-video" href="<?php the_permalink(); ?>">
					            <?php echo blog_lover_get_icon_svg( 'play' ); ?>
					        </a>
					    </div><!-- .icon-play -->

					    <?php if ( ! empty( $video_link ) ) { ?>
						    <div class="video-popup">
				    			<div class="pop-wrapper">
						    		<?php echo do_shortcode( '[video src="' . esc_url( $video_link ) . '"]' ); ?>
						    	</div>
						    </div>
					    <?php } ?>
					</div> <!-- .video-content-wrapper -->
			 	</div><!-- .wrapper -->
			</div><!-- #latest-video -->
		<?php	
		}
		wp_reset_postdata();
	}
}
