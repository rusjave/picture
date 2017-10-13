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

global $detheme_config,$wp_query,$paged;

get_header(); 

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}

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


<div  <?php post_class('blog single-post content '.$class_sidebar.$vertical_menu_container_class); ?>>
<div class="container">
		<div class="row">
	<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-xs-12">
<?php	} else { ?>
			<div class="col-xs-12 col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php

//$commentopen=(isset($detheme_config))?$detheme_config['dt-comment-open']:true;

$i = 0;
$reveal_area_class = '';
while ( have_posts() ) : 
	$i++;
	$reveal_area_class = ($i==1) ? 'blank-reveal-area' : '';
	
	if ($i==1) :
	?>

	<div class="<?php echo $reveal_area_class; ?>"></div>

	<?php endif; //if ($i==1)

	the_post();

	$hideSocial = get_post_meta( $post->ID, 'show_social', true );
	$hideComment = get_post_meta( $post->ID, 'show_comment', true );
	dt_set_post_views(get_the_ID()); 

	get_template_part( 'content', get_post_format() );
?>

<?php endwhile;?>
</div><!-- content area col-9 -->

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-xs-12 col-sm-4 col-md-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-xs-12 col-sm-4 col-md-3 sidebar col-sm-pull-8 col-md-pull-9">
				<?php get_sidebar(); ?>
			</div>
<?php }?>
	

		</div><!-- .row -->

	</div><!-- .container -->

</div>
<?php
get_footer();
?>