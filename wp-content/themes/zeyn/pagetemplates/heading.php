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

$headerType=$detheme_config['dt-header-type'];

switch ($headerType) {
    case 'center':
    	$classmenu = 'dt-menu-center';
        break;
    case 'right' :
        $classmenu = 'dt-menu-left';
        break;
    case 'leftbar' :
        $classmenu = 'dt-menu-leftbar';
        break;
    default:
        $classmenu = 'dt-menu-right';
}


$menuParams=array(
    'theme_location' => 'primary',
    'echo' => false,
    'container_class'=>$classmenu,
    'container_id'=>'dt-menu',
    'menu_class'=>'',
    'container'=>'div',
    'before' => '',
    'after' => '',
    'fallback_cb'=>false,
    'walker'  => new dt_mainmenu_walker()
);


if($detheme_config['dt-main-menu']!=''){
    $menuParams['menu'] =$detheme_config['dt-main-menu'];
}

$menu=wp_nav_menu($menuParams);

if(!$menu){
    $menuParams['fallback_cb']='wp_page_menu';
    $menuParams['theme_location']='';
    $menu=wp_nav_menu($menuParams);
}

global $detheme_config;

$logo = $detheme_config['dt-logo-image']['url'];
$logo_transparent = $detheme_config['dt-logo-image-transparent']['url'];

$logoContent="";
$logoContentMobile="";


$logoContent='<a href="'.home_url().'" style=""><img id="logomenu" src="'.esc_url(maybe_ssl_url($logo)).'" rel="'.esc_url(maybe_ssl_url($logo_transparent)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';
$logoContent.='<a href="'.home_url().'" style=""><img id="logomenureveal" src="'.esc_url(maybe_ssl_url($logo_transparent)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';

$logoContentMobile='<a href="'.home_url().'" style=""><img id="logomenumobile" src="'.esc_url(maybe_ssl_url($logo)).'" rel="'.esc_url(maybe_ssl_url($logo_transparent)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';
$logoContentMobile.='<a href="'.home_url().'" style=""><img id="logomenurevealmobile" src="'.esc_url(maybe_ssl_url($logo_transparent)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';

$sticky_menu = "";
if (isset($detheme_config['dt-sticky-menu']) && $detheme_config['dt-sticky-menu']) {
    //$sticky_menu = "sticky";
    $sticky_menu = "alt reveal";
}

$hasTopBar = "notopbar";
if (isset($detheme_config['showtopbar']) && $detheme_config['showtopbar']) {
    $hasTopBar = "hastopbar";
}

if(is_front_page() || is_detheme_home(get_post())){
    $backgroundType = "transparent";
    if (isset($detheme_config['homepage-background-type'])) {
        $backgroundType = $detheme_config['homepage-background-type'];
    }
} else {
    $backgroundType = "transparent";
    if (isset($detheme_config['header-background-type'])) {
        $backgroundType = $detheme_config['header-background-type'];
    }
}


?>
<div id="head-page" class="head-page<?php  print is_admin_bar_showing()?" adminbar-is-here":" adminbar-not-here";?> <?php print($sticky_menu); ?> <?php print($hasTopBar); ?> <?php print($backgroundType); ?>">
	<div class="container">
        <!--input type="checkbox" name="nav" id="main-nav-check"-->
        <?php if ($menu):
        print $menu;
        else:
            wp_nav_menu();
        endif;
        ?>
	</div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 hidden-sm-max">
                <div id="mobile-header">
                    <label for="main-nav-check" class="toggle" onclick="" title="<?php _e('Menu','detheme');?>"><i class="icon-menu"></i></label>
                    <?php echo $logoContentMobile ?>
                </div><!-- closing "#header" -->
            </div>
        </div>
    </div>
</div>


