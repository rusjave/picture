<?php

/**
 * The default template for displaying content quote
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */
?>

<?php 
	$bgstyle = '';
	$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full',false); 
	if (isset($featured_image[0])) {
		$bgstyle = ' style="background: url(\''.esc_url($featured_image[0]).'\') no-repeat; background-size: cover;"';
	} //if (isset($featured_image[0]))
?>		

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="col-xs-12">
					<div class="postcontent postcontent-quote primary_color_bg" <?php echo $bgstyle; ?>>
						<?php the_content(); ?>
						<div class="iconquote"><i class="icon-quote-right-1"></i></div>
					</div>
				</div>
			</article>
		</div><!--div class="row"-->