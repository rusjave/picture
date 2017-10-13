<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */

global $detheme_config;

get_header();
?>

 	<div class="centered">
<?php 
	$logo = $detheme_config['dt-404-image']['url'];
	if(!empty($logo)) :
?>
	  	<p><a href="<?php echo home_url(); ?>" title=""><img src="<?php echo $logo; ?>" alt="" /></a></p>
<?php
	endif;
?>
 		<p class="biggest"><?php _e('404','detheme');?></p>
 		<p class="big"><?php _e('Page not found','detheme');?></p>
 		<p class="message"><?php echo $detheme_config['dt-404-text']; ?></p>
 		<div class="button">
 			<a href="<?php echo home_url(); ?>" class="btn-back secondary_color_button btn skin-light"><?php _e('Go back to Our Homepage','detheme');?></a>
 		</div>
 	</div>
<?php wp_footer(); ?>
</body>
</html>