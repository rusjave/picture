<?php

/**
 * The default template for displaying content video post format
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */
?>

<?php 
	global $more, $dt_revealData, $detheme_config;
	$more = 1;

	$colsm = 'col-sm-11';
	//$nohead = 'nohead';
	$nohead = '';

	$imageurl = $alt_image = "";
	$sharepos = 'sharepos';

	/* Get Image from featured image */
	if (isset($post->ID)) {
		$thumb_id=get_post_thumbnail_id($post->ID);
		$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
		if (isset($featured_image[0])) {
			$imageurl = $featured_image[0];
		}

		$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	}

	$hasvideoshortcode = false;
	//Find video shotcode in content
	$pattern = get_shortcode_regex();
	$found = preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );

	/* find first video shortcode */
	$i = 0;
	$shortcodepos = -1;
	if ($found>0) {
		foreach ($matches[2] as $shortcodetype) {
			if ($shortcodetype=='video') {
				$hasvideoshortcode = true;
				$shortcodepos = strpos(get_the_content(),$matches[0][0]);
				break;
			}
		    $i++;
		}
	}

	//Find youtube/vimeo link in content
	$hasyoutubelink = false;
	$youtubepos = -1;
	$found = preg_match('@https?://(www.)?(youtube|vimeo)\.com/(watch\?v=)?([a-zA-Z0-9_-]+)@im', get_the_content(), $urls);
    if (isset($urls[0])) {
    	$youtubepos = strpos(get_the_content(),$urls[0]);
    	$hasyoutubelink = true;
    } //if isset($urls[0])
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
										<a class="md-trigger btn icon-zoom-in secondary_color_button" data-modal="modal_post_<?php echo get_the_ID(); ?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
										<a class="btn icon-link secondary_color_button " href="<?php the_permalink(); ?>"></a>
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

							<div class="postcontent gray_border_bottom">
								<p class="blog-author"><?php printf(__('by %s','detheme'),get_the_author_link()); ?></p>
								<?php the_content(); ?>
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
							
<?php if(comments_open()):?>
							
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

			<?php  if ($hasvideoshortcode or $hasyoutubelink) { ?>											
				<div class="col-xs-12">
					<div class="postimage">
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>
                		<?php
                			//Display first video 
                			if ($hasvideoshortcode and $hasyoutubelink) {
                				if ($shortcodepos<$youtubepos) {
                					echo do_shortcode($matches[0][$i]);
                				} else {
	                				echo '<div class="flex-video">';
	                				echo wp_oembed_get($urls[0]);
	                				echo '</div>';
                				}
                			} elseif ($hasyoutubelink) {
                				echo '<div class="flex-video">';

                				echo wp_oembed_get($urls[0]);
                				echo '</div>';
                			} else {
                				echo do_shortcode($matches[0][$i]);
                			} 
                		?>
					</div>
				</div>
			<?php
					//$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
					$colsm = 'col-md-push-0';
					} elseif ($imageurl!="") { //if ($hasvideoshortcode or $hasyoutubelink)
?>
				<div class="col-xs-12">
					<div class="postimagecontent">
						<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>"></a>

						<div class="imgcontrol tertier_color_bg_transparent">
							<div class="imgbuttons">
								<a class="md-trigger btn icon-zoom-in secondary_color_button" data-modal="modal_post_<?php echo get_the_ID(); ?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
								<a class="btn icon-link secondary_color_button " href="<?php the_permalink(); ?>"></a>
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

						$colsm = 'col-sm-10 col-sm-push-2 col-md-5 col-md-push-0 col-lg-6 margin_top_40_max_sm';
					} //if ($hasvideoshortcode or $hasyoutubelink) ?>						

				<div class="col-xs-12 <?php echo $colsm;?>">
					<div class="postcontent">

					<?php if (!($hasvideoshortcode or $hasyoutubelink)) : ?>
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>
					<?php endif; //if ($hasvideoshortcode or $hasyoutubelink) ?>

						<p class="blog-author"><?php echo __('By ','detheme'); the_author_link(); ?></p>
						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
						<?php
							$more = 0;

							add_filter('embed_oembed_html', 'removeVideo', 91, 3 );
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
							<div class="col-xs-4">
								<?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>
						</div>
					</div>
				</div> 
			</article>
		</div><!--div class="row"-->

<?php endif; //if (is_single()) :?>