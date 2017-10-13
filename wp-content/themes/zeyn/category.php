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

?>
<div <?php post_class('content '.$class_sidebar); ?>>
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>

			<?php if ( have_posts() ) : ?>

			<header class="archive-header">

<?php if($detheme_config['dt-show-title-page']):?>
						<h2 class="category-title"><?php print $detheme_config['page-title'];?></h2>
		<?php if($subtitle = get_post_meta( get_the_ID(), '_subtitle', true )):?>
						<h3 class="post-sub-title"><?php print $subtitle;?></h3>
		<?php endif;?>				
<?php endif;?>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>



			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>	

				<div class="clearfix"><div class="col-xs-12 postseparator"></div></div>
				<!-- Pagination -->
				<div class="row">
					<div class="paging-nav col-xs-12">
<?php
						global $wp_query;

						$big = 999999999; // need an unlikely integer


						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages,
							'prev_text'    => __('<i class="icon-angle-left"></i>'),
							'next_text'    => __('<i class="icon-angle-right"></i>'),

						) );

						wp_link_pages();
?>

					</div>
				</div>

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

		</div>
	</div>
	
</div>	
<?php get_footer(); ?>