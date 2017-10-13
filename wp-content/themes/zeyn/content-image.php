<?php

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */
?>
<?php 
	global $more, $dt_revealData, $detheme_config;
	$more = 1;

	$imageurl = "";

	/* Get Image from featured image */
	$thumb_id=get_post_thumbnail_id($post->ID);
	$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
	$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	if (isset($featured_image[0])) {
		$imageurl = $featured_image[0];
	} else {
		$imageurl = get_first_image_url_from_content();
	}
	
	/* Get Image from content image */
	$pattern = get_shortcode_regex();
	preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );
	/* find first caption shortcode */


	$i = 0;
	$hascaption = false;
	foreach ($matches[2] as $shortcodetype) {
		if ($shortcodetype=='caption') {
			$hascaption = true;
			break;
		}
	    $i++;
	}

	if ($hascaption and empty($imageurl)) {
		preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $matches[5][$i], $m);
		$imageurl = $m[2];
	}
?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
	if ($imageurl!="") {
?>											
				<div class="col-xs-12">
					<div class="postimagecontent">
						<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>"></a>

						<div class="imgcontrol tertier_color_bg_transparent">
							<div class="imgbuttons">
								<a class="md-trigger btn icon-zoom-in secondary_color_button skin-light" data-modal="modal_post_<?php echo get_the_ID(); ?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
								<a class="btn icon-link secondary_color_button skin-light" href="<?php the_permalink(); ?>"></a>
							</div>
						</div>
					</div>
				</div>
<?php
		$modal_effect = (empty($detheme_config['dt-select-modal-effects'])) ? 'md-effect-15' : $detheme_config['dt-select-modal-effects'];
		$modalcontent = '<div id="modal_post_'.get_the_ID().'" class="md-modal '.$modal_effect.'">
			<div class="md-content"><img src="#" rel="'.esc_url($imageurl).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>		
				<div class="md-description secondary_color_bg">'.get_the_title().'</div>
				<button class="md-close secondary_color_button"><i class="icon-cancel"></i></button>
			</div>
		</div>';

		array_push($dt_revealData,$modalcontent);
	} //if ($imageurl!="")
?>

<?php if (is_single()) : ?>
				<div class="col-xs-12">
					<div class="postmetabottom">
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-11">
								<?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>
						</div>
					</div>
				</div> 
<?php endif; //if (is_single())?>
											

<?php if (is_single()) : ?>
				<div class="col-xs-12">

					<div class="comment-count">
						<h3><?php comments_number(__('No Comments','detheme'),__('1 Comment','detheme'),__('% Comments','detheme')); ?></h3>
					</div>

				<?php 	if(comments_open()):?>
					<div class="section-comment">
						<?php comments_template('/comments.php', true); ?>
					</div><!-- Section Comment -->
				<?php 	endif;?>

				</div>

<?php endif; //if (is_single())?>

			</article>
		</div><!--div class="row"-->
