<?php
defined('ABSPATH') or die();

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */

global $detheme_config, $post;

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}


get_header();

do_action('dt_portfolio_loaded');

?>
<?php 

$sidebar_position = get_post_meta( get_the_ID(), '_sidebar_position', true );


if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){
	switch ($detheme_config['layout']) {
		case 1:
			$sidebar_position = "nosidebar";
			break;
		case 2:
			$sidebar_position = "sidebar-left";
			break;
		case 3:
			$sidebar_position = "sidebar-right";
			break;
		default:
			$sidebar_position = "sidebar-left";
	}


}

if(!$sidebar){
	$sidebar_position = "nosidebar";
}

set_query_var('sidebar',$sidebar);

$class_sidebar = $sidebar_position;
$vertical_menu_container_class = ($detheme_config['dt-header-type']=='leftbar')?" vertical_menu_container":"";

?>
<div <?php post_class('content'.$vertical_menu_container_class); ?>>
<div class="<?php echo $class_sidebar;?>">
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php 
while ( have_posts() ) : 


the_post();

$content = apply_filters( 'the_content', do_shortcode(get_the_content()));

global $carouselGallery;

?>	

		<?php if($detheme_config['dt-show-title-page']):?>
		<h1 class="page-title"><?php print $detheme_config['page-title'];?></h1>
		<?php endif;?>

			<div class="row">
					<div class="col-sm-12">
<?php if($detheme_config['dt-show-title-page']):?>
						<h2 class="page-title"><?php the_title();?></h2>
		<?php if($subtitle = get_post_meta( get_the_ID(), '_subtitle', true )):?>
						<h3 class="page-sub-title"><?php print $subtitle;?></h3>
		<?php endif;?>				
<?php endif;?>
					<div class="port-article">
						<?php 
							if(isset($carouselGallery) && !empty($carouselGallery)){
								print $carouselGallery;
							} else {
								/* Get Image from featured image */
								if (isset($post->ID)) {
									$attachment_id=get_post_thumbnail_id($post->ID);
									$featured_image = wp_get_attachment_image_src($attachment_id,'full',false); 
									$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

									if (isset($featured_image[0])) {
										$imageurl = $featured_image[0];
									}
								}

								if ($imageurl!="") {
?>
									<div class="postimagecontent">
										<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" />
									</div>
<?php
								} //if ($imageurl!="")

							}
						?>
<?php
$linklabel = get_post_meta( get_the_ID(), 'project button label', true );
$linkproject = get_post_meta( get_the_ID(), 'project link', true );

$custom_field_keys = get_post_custom_keys();

$rightContent=array();

foreach ( $custom_field_keys as $key => $value ) {

	if(is_protected_meta($value,'port') || in_array($value,array('project button label','project link')))
        continue;
    $rightContent[]='<li><div class="col-xs-5"><label>'.$value.'</label></div><div class="col-xs-7">'.get_post_meta( get_the_ID(),$value,true).'</div></li>'."\n";

}

?>
<?php if(get_the_tags()):
	$rightContent[]='<li><div class="col-xs-5"><label>'.__('Tags','detheme').'</label></div><div class="col-xs-7">'.get_the_tag_list('',', ').'</div></li>';
endif;

?>

						<div class="row">
						<?php if(count($rightContent) || !empty($linklabel) || !empty($linkproject)): ?>
							<div class="col-md-8 col-sm-7">
								<h2 class="port-heading"><?php _e('Project Description','detheme');?></h2>
								<div class="port-decription">
							<?php the_content();
							//print $content;
							 ?>
								 </div>
							</div>
							<div class="col-md-4 col-sm-5">
								<h2 class="port-heading"><?php _e('Project Detail','detheme');?></h2>
								<?php if(count($rightContent)): ?>
								<ul class="port-meta">
									<?php print @implode("\n",$rightContent);?>
									<li class="bottom-line clearfix"></li>
								</ul>
								<?php endif;?>

							<div class="row bottom-meta">
								<div class="col-xs-8">
	<?php
	        if(!empty($linklabel) || !empty($linkproject)):
	?>
	<a class="btn btn-primary link-project primary_color_button" href="<?php print ($linkproject)?esc_url($linkproject):"#";?>" target="_blank"><?php print ($linklabel)?$linklabel:__('launch project','detheme');?></a>
	<?php endif;?>
								</div>
								<div class="col-xs-4">
									<?php locate_template('pagetemplates/social-share.php',true,false); ?>
								</div>
							</div>


							</div>
								


						<?php else:?>
							<div class="col-md-12 col-sm-12">
								<h2 class="port-heading"><?php _e('Project Description','detheme');?></h2>
								<div class="port-decription">
							<?php the_content();
							//print $content;
							 ?>
								 </div>
								 <?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>

						<?php endif;?>
						</div>

						<div class="row">
							<div class="col-xs-12">
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
						</div>
<?php

	$related_args=array(
		'posts_per_page' => 4,
		'post_type' => 'port',
		'no_found_rows' => false,
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'orderby' => 'rand',
		'post__not_in'=>array(get_the_ID())
	);


	$related = new WP_Query($related_args);

	if ($related->have_posts()) :?>
<div id="related-port" class="portfolio">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="port-heading"><?php _e('Related Project','detheme');?></h2>
					<div class="portfolio-container"  data-col="4" data-type="image">
					<?php while ( $related->have_posts() ) : 
						$related->the_post();
						locate_template('related-port.php',true,false);
					?>
					<?php endwhile;?>
					</div>
				</div>
			</div>
</div>
	<?php endif;?>


					</div>

					</div>
				</div>
<?php endwhile; 
	wp_reset_postdata();
?>
</div>

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 col-md-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 col-md-3 sidebar col-sm-pull-8 col-md-pull-9">
				<?php get_sidebar(); ?>
			</div>
<?php }?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .blog-single-post -->
</div>
<?php
get_footer();
?>