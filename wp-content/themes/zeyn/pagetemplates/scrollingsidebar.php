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

if (isset($detheme_config['dt_scrollingsidebar_on']) && $detheme_config['dt_scrollingsidebar_on']) :
	$the_sidebars = wp_get_sidebars_widgets();
	if (count($the_sidebars['detheme-scrolling-sidebar'])>0) :
?>
<div id="floatMenu">
  <?php 
    dynamic_sidebar('detheme-scrolling-sidebar');
  ?>
</div>
<?php 
	endif;
endif; ?>