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
		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 
	global $more;
?>											

				<div class="col-xs-12">
					<div class="postcontent">
						<?php 
							$more = 1;

							add_filter('the_content', 'remove_shortcode_from_content');
							//the_content(__('&nbsp;&nbsp;Read more', 'detheme').'<i class="icon-right-dir"></i>');
							the_content();
							remove_filter('the_content', 'remove_shortcode_from_content');
						?>
					</div>

					<div class="postmetabottom">
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-11">
								<?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>
						</div>
					</div>
				</div> 
			</article>
		</div><!--div class="row"-->
