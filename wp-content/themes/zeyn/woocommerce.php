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

global $detheme_config,$post;


$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['shop-sidebar']) && count($sidebars['shop-sidebar'])){
	$sidebar='shop-sidebar';

}

get_header();?>
<?php 

if(function_exists('is_shop') && is_shop()){

	 $post_id=get_option( 'woocommerce_shop_page_id');
	$sidebar_position = get_post_meta( $post_id, '_sidebar_position', true );	
}
else{

	$sidebar_position = get_post_meta( get_the_ID(), '_sidebar_position', true );
}

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
<?php 
		do_action( 'woocommerce_before_main_content' );
?>
		<div class="row">
		<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
		<?php	} else { ?>
			<div class="col-xs-12 col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
		<?php	} ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="postcontent">
							<?php woocommerce_content(); ?>
						</div>
					</div>
				</div>

			</article>
			</div>

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
<?php
		do_action( 'woocommerce_after_main_content' );
?>
	</div><!-- .container -->
	</div>
</div><!-- .woocommerce -->
</div>
<?php
get_footer();
?>