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

$menu=$detheme_config['dt-left-top-bar-menu'];

if(!empty($menu)):

      $menuParams=array(
                  'menu'=>$menu,
                  'echo' => false,
                  'container_id'=>'dt-topbar-menu-left',
                  'menu_class'=>'topbar-menu',
                  'container'=>'div',
                  'before' => '',
                  'after' => '',
                  'fallback_cb'=>false,
                  'walker'  => new dt_topbarmenuleft_walker()
                  );

      $menuParamsNoSubmenu=array(
                  'menu'=>$menu,
                  'echo' => false,
                  'container_id'=>'dt-topbar-menu-nosub',
                  'menu_class'=>'nav navbar-nav topbar-menu-nosub',
                  'container'=>'div',
                  'before' => '',
                  'after' => '',
                  'fallback_cb'=>false
                  );

      $menu=wp_nav_menu($menuParams);

      $found = preg_match_all('/menu\-item\-has\-children/s', $menu, $matches);

      // if one of menu items has children
      if ($found>0) {
?>
      <div class="left-menu">
            <input type="checkbox" name="nav-top-left" id="main-nav-check-top-left">
            <?php print ($menu)?$menu:"";?>
            <div id="mobile-header-top-left" class="visible-sm-min visible-xs">
                  <label for="main-nav-check-top-left" class="toggle" onclick="" title="<?php _e('Menu','detheme');?>"><i class="icon-menu"></i></label>
            </div><!-- closing "#header" -->
      </div>
<?php
      } else {
            $menu=wp_nav_menu($menuParamsNoSubmenu);
?>
      <div class="left-menu"><?php print ($menu)?$menu:"";?></div>
<?php
      }
      //print $menu;
?>

<?php endif;?>
