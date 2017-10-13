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

	$imageurl = $alt_image = "";

	/* Get Image from featured image */
	if (isset($post->ID)) {
		$thumb_id=get_post_thumbnail_id($post->ID);
		$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
		if (isset($featured_image[0])) {
			$imageurl = $featured_image[0];
		} else {
			//$imageurl = get_first_image_url_from_content();
		}

		$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

	}


	/* Get Image from content image */
	
	/*
	$pattern = get_shortcode_regex();
	preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );
	*/

	/* find first caption shortcode */
	/*
	$i = 0;
	$hascaption = false;
	foreach ($matches[2] as $shortcodetype) {
		if ($shortcodetype=='caption') {
			$hascaption = true;
			break;
		}
	    $i++;
	}

	if ($hascaption and empty($imageurl) ) {
		preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $matches[5][$i], $m);
		$imageurl = $m[2];
	}
	*/

	$colsm = '';
	//$nohead = 'nohead';
	$nohead = '';
	$sharepos = 'sharepos';
?>

<?php if (is_single()) : ?>

				<div class="row">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="col-xs-12">

<?php	if ($imageurl!="") { ?>											
							<div class="postimagecontent">
								<div class="postdate primary_color_bg">
									<div class="day"><?php print get_the_date('d');?></div>
									<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
								</div>

								<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>"></a>

								<div class="imgcontrol tertier_color_bg_transparent">
									<div class="imgbuttons">
										<a class="md-trigger btn icon-zoom-in secondary_color_button btn skin-light" data-modal="modal_post_<?php echo get_the_ID(); ?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
										<a class="btn icon-link secondary_color_button btn skin-light" href="<?php the_permalink(); ?>"></a>
									</div>
								</div>
							</div>
<?php
		$modal_effect = (empty($detheme_config['dt-select-modal-effects'])) ? 'md-effect-15' : $detheme_config['dt-select-modal-effects'];
		$modalcontent = '<div id="modal_post_'.get_the_ID().'" class="md-modal '.$modal_effect.'">
			<div class="md-content secondary_color_bg"><img src="#" rel="'.esc_url($imageurl).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>		
				<div class="md-description secondary_color_bg">'.trim(get_the_title()).'</div>
				<button class="md-close secondary_color_button"><i class="icon-cancel"></i></button>
			</div>
		</div>';

		array_push($dt_revealData,$modalcontent);
			$nohead = '';
			$sharepos = '';
		} //if ($imageurl!="")
?>											

							<div class="singlepostmetatop <?php echo $nohead; ?>">
								<div class="row">
									<div class="col-xs-9 col-sm-12 col-md-9">
										<ul class="list-inline">
											<?php $tags = get_the_tag_list(' ',', ',''); ?>
											<?php if (!empty($tags)) : ?>
											<li><i class="icon-tags-2"></i><?php echo $tags; ?></li>
											<?php endif; //if ($tags!='') : ?>

											<?php if ( comments_open()) : ?>
											<li><i class="icon-comment-alt-1"></i><?php echo(get_comments_number())?get_comments_number():'0'; ?></li>
											<?php endif; //if ( comments_open()) ?>
										</ul>
									</div>
									<div class="col-xs-3 col-sm-12 col-md-3 text-right <?php echo $sharepos; ?>">
										<?php locate_template('pagetemplates/social-share.php',true,false); ?>
										<?php if ($imageurl=="") : ?>
											<div class="postdate primary_color_bg">
												<div class="day"><?php print get_the_date('d');?></div>
												<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
											</div>
										<?php endif; //if ($imageurl=="") ?>

									</div>
								</div>
							</div>

							<div class="postcontent">
								<p class="blog-author"><?php printf(__('by %s','detheme'),get_the_author_link()); ?></p>
		                		<?php
									the_content();
								?>
							</div>

							<div class="about-author bg_gray_3">
								<div class="media">
									<div class="pull-left text-center">
										<?php 

											$avatar_url = get_avatar_url(get_the_author_meta( 'ID' ),array('size'=>130)); 
											if (isset($avatar_url)) {
										?>					
										<img src="<?php echo esc_url($avatar_url); ?>" class="author-avatar img-responsive" alt="<?php echo get_the_author_meta( 'nickname' ); ?>">
										<?php 
											} //if (isset($avatar_url))
										?>											
									</div>
									<div class="media-body">
										<h5><?php printf(__('About %s','detheme'),get_the_author_meta( 'nickname' )); ?></h5>
										<?php echo get_the_author_meta( 'description' ); ?>
									</div>
								</div>
							</div>

<?php 
if(comments_open()):?>
							<div class="comment-count">
								<h3><?php comments_number(__('No Comments','detheme'),__('1 Comment','detheme'),__('% Comments','detheme')); ?></h3>
							</div>

							<div class="section-comment">
								<?php comments_template('/comments.php', true); ?>
							</div><!-- Section Comment -->
<?php endif;?>

						</div>

					</article>
				</div><!--div class="row"-->

<?php else : //if (is_single()) :?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ($imageurl!="") {
?>											
				<div class="col-xs-12">
					<div class="postimagecontent">
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>

						<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>"></a>

						<div class="imgcontrol tertier_color_bg_transparent">
							<div class="imgbuttons">
								<a class="md-trigger btn icon-zoom-in secondary_color_button btn skin-light" data-modal="modal_post_<?php echo get_the_ID(); ?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
								<a class="btn icon-link secondary_color_button btn skin-light" href="<?php the_permalink(); ?>"></a>
							</div>
						</div>
					</div>
				</div>
<?php
		$modal_effect = (empty($detheme_config['dt-select-modal-effects'])) ? 'md-effect-15' : $detheme_config['dt-select-modal-effects'];
		$modalcontent = '<div id="modal_post_'.get_the_ID().'" class="md-modal '.$modal_effect.'">
			<div class="md-content secondary_color_bg"><img src="#" rel="'.esc_url($imageurl).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>		
				<div class="md-description secondary_color_bg">'.trim(get_the_title()).'</div>
				<button class="md-close secondary_color_button"><i class="icon-cancel"></i></button>
			</div>
		</div>';

		array_push($dt_revealData,$modalcontent);

		//$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
		$colsm = 'col-md-push-0';
	} //if ($imageurl!="")
?>											

				<div class="col-xs-12 <?php echo $colsm;?>">
					<div class="postcontent">
					<?php if ($imageurl=="") : ?>
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>
					<?php endif; //if ($imageurl=="") ?>

						<p class="blog-author"><?php echo __('By ','detheme'); the_author_link(); ?></p>

						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
						<?php 
							$more = 0;

							$content=get_the_content("&nbsp;&nbsp;".__('Read more', 'detheme').'<i class="icon-right-dir"></i>');
							$content = apply_filters( 'the_content', remove_shortcode_from_content($content));
							$content = str_replace( ']]>', ']]&gt;', $content );

							print $content;

						?>
					</div>

					<div class="postmetabottom">
						<div class="row">
							<div class="col-xs-8">
								<?php $tags = get_the_tag_list(' ',', ',''); ?>
								<?php if (!empty($tags)) : ?>
								<i class="icon-tags-2"></i><?php echo $tags; ?>
								<?php endif; //if ($tags!='') : ?>

								<?php if ( comments_open()) : ?>
								<i class="icon-comment-alt-1"></i><?php echo(get_comments_number())?get_comments_number():'0'; ?>
								<?php endif; //if ( comments_open()) ?>
							</div>
							<div class="col-xs-4 text-right">
								<?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>
						</div>
					</div>

				</div> 
			</article>
		</div><!--div class="row"-->

<?php endif; //if (is_single()) :?>
