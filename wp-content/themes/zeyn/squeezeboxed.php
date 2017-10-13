<?php
defined('ABSPATH') or die();
/**
 * Template Name: Blank - Default
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

global $detheme_config;

set_query_var('sidebar','nosidebar');
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php locate_template('lib/page-options.php',true);?>
<head>
<?php wp_head(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
</head>
<body <?php body_class(is_detheme_home(get_post())?"home dt_custom_body":"dt_custom_body"); print $detheme_config['body_tag']; ?>>
<?php if($detheme_config['page_loader']):?>
<div class="modal_preloader"></div>
<?php endif;?>
<!-- start content -->
<div <?php post_class('content'); ?>>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">

<?php 
while ( have_posts() ) : 
the_post();
?>
	<div class="post-article">
<?php 
	the_content();
?>
	</div>
<?php endwhile; ?>
				</div>
			</div>
	</div>
</div>

<!-- end content -->
<?php wp_footer(); ?>
</body>
</html>