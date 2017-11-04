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

global $detheme_config;

$footertext=function_exists('icl_t') ? icl_t('detheme', 'footer-text', $detheme_config['footer-text']):$detheme_config['footer-text'];
?>
<footer id="footer" class="tertier_color_bg <?php print $detheme_config['dt-header-type']=='leftbar'?" vertical_menu_container":"";?>">
<section class="container footer-section">
		<?php if((!empty($footertext) || strlen(strip_tags($footertext)) > 1) && $detheme_config['showfooterwidget']){?> 
		<div class="col-md-12 col-sm-12 col-xs-12 footer-right equal-height">
			<div id="footer-right">
				<?php dynamic_sidebar('detheme-bottom');
				do_action('dynamic_sidebar_detheme-bottom');
				 ?>
			</div>
		</div>			
		<div class="col-md-12 col-sm-12 col-xs-12 footer-left equal-height">
			<div id="footer-left">
				<?php echo do_shortcode($footertext); ?>
			</div>
		</div>
		<?php }
		elseif((!empty($footertext) || strlen(strip_tags($footertext)) > 1) && !$detheme_config['showfooterwidget'])
		{
		?> 
		<div class="col-md-12 footer-left equal-height">
			<div id="footer-left">
				<?php echo do_shortcode($footertext); ?>
			</div>
		</div>	
		<?php }
		elseif($detheme_config['showfooterwidget']){
			?>
		<div class="col-md-12 footer-right equal-height">
			<div id="footer-right">
				<?php dynamic_sidebar('detheme-bottom');
				do_action('dynamic_sidebar_detheme-bottom');
				 ?>
			</div>
		</div>	
		<?php
		 }
		?>
</section>
</footer>
<?php
	/*** Boxed layout ***/
	$boxed_open_tag = "";
	$boxed_close_tag = "";
	$is_vertical_menu = false;
	$is_boxed = false;
	if($detheme_config['boxed_layout_activate']){
		$is_boxed = true;

		if ($detheme_config['dt-header-type']=='leftbar') {
			$is_vertical_menu = true;
			$boxed_open_tag = '<div class="vertical_menu_container"><div class="container dt-boxed-container">';
			$boxed_close_tag = '</div></div>';
		} else {
			$boxed_open_tag = '<div class="container dt-boxed-container">';
			$boxed_close_tag = '</div>';
		}
	}

	// write close tag when it's boxed. It can be </div> if NOT vertical menu or </div></div> if vertical menu.
	if ($is_boxed) echo $boxed_close_tag; 
?>
<?php wp_footer(); ?>
</body>
</html>