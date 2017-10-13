<?php
defined('ABSPATH') or die();

/**
 * this template purpose demo only
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

$detheme_config['dt-header-type']="right";

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}

get_header();?>
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
?>
<div <?php post_class('content'); ?>>
<div class="<?php echo $class_sidebar;?>">
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-xs-12">
<?php	} else { ?>
			<div class="col-xs-12 col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php 
while ( have_posts() ) : 
the_post();
?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="postcontent">
<?php 
	the_content();
?>
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


					</article>
<?php endwhile; ?>
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
	</div><!-- .container -->
</div>
</div><!-- .page -->
</div>
<?php
get_footer();
?>