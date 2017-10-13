<?php

/**
 * The default template for displaying content post gallery
 *
 * Used for both single and index/archive/search.
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
	$sharepos = 'sharepos';
?>

<?php if (is_single()) : ?>

				<div class="row">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="col-xs-12">

						<?php	if ( has_shortcode( get_the_content(), 'gallery' ) ) { ?>
							<div class="postimage">
								<div class="postdate primary_color_bg">
									<div class="day"><?php print get_the_date('d');?></div>
									<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
								</div>
						<?php 						
							$pattern = get_shortcode_regex();
							preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );

							/* find first gallery shortcode */
							$i = 0;
							foreach ($matches[2] as $shortcodetype) {
								if ($shortcodetype=='gallery') {
									break;
								}
							    $i++;
							}

							$gallery_shortcode_attr = shortcode_parse_atts($matches[3][$i]);
							$attachment_image_ids = explode(',',$gallery_shortcode_attr['ids']);
						?>

								<div id="gallery-carousel-<?php echo get_the_ID(); ?>" class="carousel slide post-gallery-carousel" data-ride="carousel" data-interval="3000">
							        <div class="carousel-inner">
						<?php
							$i = 0;
							foreach ($attachment_image_ids as $attachment_id) {
    							$attached_img = wp_get_attachment_image_src($attachment_id,'large');
    							$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    							$active_class = ($i==0) ? 'active' : '';
						?>
										<div class="item <?php echo $active_class; ?>"><img src="<?php echo esc_url($attached_img[0]); ?>" alt="<?php print esc_attr($alt_image);?>" /></div>
						<?php
								$i++;
							}
						?>
					        		</div><!--div class="carousel-inner"-->

									<div class="post-gallery-carousel-nav">
										<div class="post-gallery-carousel-buttons">
									        <a class="secondary_color_button btn skin-light" href="#gallery-carousel-<?php echo get_the_ID(); ?>" data-slide="prev">
									          <span><i class="icon-left-open-big"></i></span>
									        </a>
									        <a class="secondary_color_button btn skin-light" href="#gallery-carousel-<?php echo get_the_ID(); ?>" data-slide="next">
									          <span><i class="icon-right-open-big"></i></span>
									        </a>
								    	</div>
							    	</div>
							    </div>			
							</div>
						<?php		$sharepos = '';
								} //if ( has_shortcode( get_the_content(), 'gallery' ) )?> 

							<div class="singlepostmetatop">
								<div class="row">
									<div class="col-xs-9 col-sm-12 col-md-9">
										<ul class="list-inline">
											<?php $tags = get_the_tag_list(' ',', ',''); ?>
											<?php if (!empty($tags)) : ?>
											<li><i class="icon-tags-2"></i><?php echo $tags; ?></li>
											<?php endif; //if ($tags!='') : ?>

											<?php if(comments_open()):?>
											<li><i class="icon-comment-alt-1"></i><?php echo(get_comments_number())?get_comments_number():'0'; ?></li>
											<?php endif; //if ( comments_open()) ?>
										</ul>
									</div>
									<div class="col-xs-3 col-sm-12 col-md-3 text-right <?php echo $sharepos; ?>">
										<?php locate_template('pagetemplates/social-share.php',true,false); ?>
										<?php if ( !has_shortcode( get_the_content(), 'gallery' ) ) : ?>
											<div class="postdate primary_color_bg">
												<div class="day"><?php print get_the_date('d');?></div>
												<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
											</div>
										<?php endif; //if ( has_shortcode( get_the_content(), 'gallery' ) ) ?>
									</div>
								</div>
							</div>

							<div class="postcontent">
								<p class="blog-author"><?php printf(__('by %s','detheme'),get_the_author_link()); ?></p>
		                		<?php
									add_filter('the_content', 'remove_first_gallery_shortcode_from_content');
									the_content();
									remove_filter('the_content', 'remove_first_gallery_shortcode_from_content');
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
<?php endif;?>

						</div>

					</article>
				</div><!--div class="row"-->


<?php else : //if (is_single()) :?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ( has_shortcode( get_the_content(), 'gallery' ) ) { 
?>
				<div class="col-xs-12">
					<div class="postimage">
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>

						<?php 						
							$pattern = get_shortcode_regex();
							preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );

							/* find first gallery shortcode */
							$i = 0;
							foreach ($matches[2] as $shortcodetype) {
								if ($shortcodetype=='gallery') {
									break;
								}
							    $i++;
							}
							$gallery_shortcode_attr = shortcode_parse_atts($matches[3][$i]);
							$attachment_image_ids = explode(',',$gallery_shortcode_attr['ids']);
?>

						<div id="gallery-carousel-<?php echo get_the_ID(); ?>" class="carousel slide post-gallery-carousel" data-ride="carousel" data-interval="3000">
					        <div class="carousel-inner">
<?php
							$i = 0;
							foreach ($attachment_image_ids as $attachment_id) {
    							$attached_img = wp_get_attachment_image_src($attachment_id,'large');
    							$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
?>
								<div class="item <?php echo ($i==0) ? 'active' : ''; ?>"><img src="<?php echo esc_url($attached_img[0]); ?>" alt="<?php print esc_attr($alt_image);?>" /></div>
<?php
								$i++;
							}
?>
					        </div>

							<div class="post-gallery-carousel-nav">
								<div class="post-gallery-carousel-buttons">
							        <a class="secondary_color_button btn skin-light" href="#gallery-carousel-<?php echo get_the_ID(); ?>" data-slide="prev">
							          <span><i class="icon-left-open-big"></i></span>
							        </a>
							        <a class="secondary_color_button btn skin-light" href="#gallery-carousel-<?php echo get_the_ID(); ?>" data-slide="next">
							          <span><i class="icon-right-open-big"></i></span>
							        </a>
						    	</div>
					    	</div>
					    </div>			
					</div>
				</div>
<?php
		//$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
		$colsm = 'col-md-push-0';
	} 
?> 
				<div class="col-xs-12 <?php echo $colsm;?>">
					<div class="postcontent">
					<?php if ( !has_shortcode( get_the_content(), 'gallery' ) ) : ?>
						<div class="postdate primary_color_bg">
							<div class="day"><?php print get_the_date('d');?></div>
							<div class="year"><?php print get_the_date('M');?>, <?php print get_the_date('Y');?></div>
						</div>
					<?php endif; //if ($imageurl=="") ?>

						<p class="blog-author"><?php echo __('By ','detheme'); the_author_link(); ?></p>
						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
<?php
						$more = 0;

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