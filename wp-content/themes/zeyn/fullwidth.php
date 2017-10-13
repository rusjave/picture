<?php
defined('ABSPATH') or die();
/**
 * Template Name: Fullwidth
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

get_header();
set_query_var('sidebar','nosidebar');
$vertical_menu_container_class = ($detheme_config['dt-header-type']=='leftbar')?" vertical_menu_container":"";
?>
<!-- start content -->
<div <?php post_class('content'.$vertical_menu_container_class); ?>>
<div class="nosidebar">
<?php 
$i = 0;
$reveal_area_class = 'blank-reveal-area';
while ( have_posts() ) :
	$i++;
	if ($i==1) :
	?>

	<div class="<?php echo $reveal_area_class; ?>"></div>

	<?php endif; //if ($i==1) 
the_post();
?>
<?php if($detheme_config['dt-show-title-page']):?>
						<h2 class="post-title"><?php the_title();?></h2>
		<?php if($subtitle = get_post_meta( get_the_ID(), '_subtitle', true )):?>
						<h3 class="post-sub-title"><?php print $subtitle;?></h3>
		<?php endif;?>				
<?php endif;?>
						<div class="post-article">
<?php 
	the_content();
 ?>
						</div>
<?php endwhile; ?>
			</div>
	</div>
<!-- end content -->
<?php
get_footer();
?>