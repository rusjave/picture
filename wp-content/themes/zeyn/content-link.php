<?php

/**
 * The default template for displaying content link
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
	} 
?>		
<div class="row">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="col-xs-12">
			<div class="postcontent postcontent-link primary_color_bg" <?php echo $bgstyle; ?>>
				<h4 class="blog-post-title"><a href="<?php echo esc_url(get_the_content()); ?>" target="_blank"><?php the_title();?></a></h4>
				<?php the_content(); ?>
				<div class="iconlink"><a href="<?php echo esc_url(get_the_content()); ?>" title="<?php the_title();?>" target="_blank"><i class="icon-link"></i></a></div>
			</div>
		</div>
	</article>
</div>