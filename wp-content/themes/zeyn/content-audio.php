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
	$colsm = '';
	global $more, $detheme_config;
	$more = 1;

	$imageurl = $alt_image = "";
	$sharepos = 'sharepos';

	/* Get Image from featured image */
	$thumb_id=get_post_thumbnail_id($post->ID);
	$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
	if (isset($featured_image[0])) {
		$imageurl = $featured_image[0];

		$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	}

	$hasaudioshortcode = false;
	//Find audio shotcode in content
	$pattern = get_shortcode_regex();
	preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );

	/* find first video shortcode */
	$i = 0;
	foreach ($matches[2] as $shortcodetype) {
		if ($shortcodetype=='audio') {
			$hasaudioshortcode = true;
			break;
		}
	    $i++;
	}
?>

<?php if (is_single()) : ?>

				<div class="row">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="col-xs-12">

						<?php   if ($hasaudioshortcode) { ?>											
							<div class="postimage">
								<div class="postdate primary_color_bg">
									<div class="day"><?php print get_the_date('d');?></div>
									<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
								</div>

							<?php if ($imageurl!="") { ?>
								<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>">
							<?php } else { ?>
								<div class="postaudio tertier_color_bg">
									<i class="icon-note-beamed"></i>
								</div>
							<?php } ?>
		                		<?php
		                			//Display video 
		               				echo do_shortcode($matches[0][$i]);
		                		?>
							</div>
						<?php		$sharepos = '';
								} //if ($hasvideoshortcode or $hasyoutubelink) ?>							

							<div class="singlepostmetatop">
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
									<div class="col-xs-3 col-sm-12 col-md-3 text-right <?php echo sanitize_html_class($sharepos); ?>">
										<?php locate_template('pagetemplates/social-share.php',true,false); ?>
										<?php if (!$hasaudioshortcode) : ?>
											<div class="postdate primary_color_bg">
												<div class="day"><?php print get_the_date('d');?></div>
												<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
											</div>
										<?php endif; //if ($hasaudioshortcode) ?>
									</div>
								</div>
							</div>

							<div class="postcontent gray_border_bottom">
								<p class="blog-author"><?php printf(__('by %s','detheme'),get_the_author_link()); ?></p>

		                		<?php
									add_filter('the_content', 'remove_first_audio_shortcode_from_content');
									the_content();
									remove_filter('the_content', 'remove_first_audio_shortcode_from_content');
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

<?php if(comments_open()):?>
							<div class="comment-count">
								<h3><?php comments_number(__('No Comments','detheme'),__('1 Comment','detheme'),__('% Comments','detheme')); ?></h3>
							</div>
							<div class="section-comment">
								<?php comments_template('/comments.php', true); ?>
							</div><!-- Section Comment -->
							<strong>tracing 2</strong>
<?php endif;?>
						</div>

					</article>
				</div><!--div class="row"-->


<?php else : //if (is_single()) :?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php    if ($hasaudioshortcode) { ?>											
				<div class="col-xs-12">
					<div class="postimage">
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>

					<?php if ($imageurl!="") { ?>
						<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>">
					<?php } else { ?>
						<div class="postaudio tertier_color_bg">
							<i class="icon-note-beamed"></i>
						</div>
					<?php } ?>
                		<?php
                			//Display video 
               				echo do_shortcode($matches[0][$i]);
                		?>
					</div>
				</div>
<?php
			//$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
			$colsm = 'col-md-push-0';
		} //if ($hasvideoshortcode or $hasyoutubelink)
?>											

				<div class="col-xs-12 <?php echo $colsm;?>">
					<div class="postcontent">
					<?php if (!$hasaudioshortcode) : ?>
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>
					<?php endif; //if ($hasaudioshortcode) ?>

						<p class="blog-author"><?php echo __('By ','detheme'); the_author_link(); ?></p>
						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
						<?php
							$more = 0;

							add_filter('embed_oembed_html', 'removeVideo', 91, 3 );
							$content=get_the_content(__('&nbsp;&nbsp;Read more', 'detheme').'<i class="icon-right-dir"></i>');
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