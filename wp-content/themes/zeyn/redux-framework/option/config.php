<?php
if (!function_exists('redux_init')) :
	function redux_init() {


	global $wp_filesystem;

	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
		WP_Filesystem();
	}  		

	/* internationalise */

    $domain = 'redux-framework';
    $locale = get_locale();
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    load_textdomain( $domain, dirname(dirname( __FILE__ )) . '/ReduxCore/languages/' . $domain . '-' . $locale . '.mo' );


	/**
		ReduxFramework Sample Config File
		For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
	**/


	/**
	 
		Most of your editing will be done in this section.

		Here you can override default values, uncomment args and change their values.
		No $args are required, but they can be overridden if needed.
		
	**/
	$args = array();


	// For use with a tab example below
	$tabs = array();

	ob_start();

	$ct = wp_get_theme();
	$theme_data = $ct;
	$item_name = $theme_data->get('Name'); 
	$tags = $ct->Tags;
	$screenshot = $ct->get_screenshot();
	$class = $screenshot ? 'has-screenshot' : '';

	$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework' ), $ct->display('Name') );



	?>
	<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
		<h4>
			<?php echo $ct->display('Name'); ?>
		</h4>

		<div>
			<ul class="theme-info">
				<li><?php printf( __('By %s','redux-framework'), $ct->display('Author') ); ?></li>
				<li><?php printf( __('Version %s','redux-framework'), $ct->display('Version') ); ?></li>
				<li><?php echo '<strong>'.__('Tags', 'redux-framework').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
			</ul>
			<p class="theme-description"><?php echo __($ct->display('Description'),'redux-framework'); ?></p>
			<?php if ( $ct->parent() ) {
				printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
					__( 'http://codex.wordpress.org/Child_Themes','redux-framework' ),
					$ct->parent()->display( 'Name' ) );
			} ?>
			
		</div>

	</div>

	<?php
	$item_info = ob_get_contents();
	    
	ob_end_clean();

	$sampleHTML = '';
	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		/** @global WP_Filesystem_Direct $wp_filesystem  */

		global $wp_filesystem;
		if (!empty($wp_filesystem)) {
			$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
		}  		
	}



	$icon_info='';

	// BEGIN Sample Config

	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['dev_mode_icon_class'] = '';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'detheme_config';

	// Setting system info to true allows you to view info useful for debugging.
	// Default: false
	//$args['system_info'] = true;


	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

	// If you want to use Google Webfonts, you MUST define the api key.
	$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
	    'link' => 'http://twitter.com/detheme',
	    'title' => 'Follow me on Twitter', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Twitter.png'
	);
	$args['share_icons']['facebook'] = array(
	    'link' => 'https://www.facebook.com/detheme',
	    'title' => 'Find me on Facebook', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Facebook.png'
	);

	// Enable the import/export feature.
	// Default: true
	$args['show_import_export'] = true;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['import_icon_class'] = '';

	/**
	 * Set default icon class for all sections and tabs
	 * @since 3.0.9
	 */
	//$args['default_icon_class'] = '';


	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Theme Options', 'redux-framework');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Options', 'redux-framework');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'redux_options';

	$args['default_show'] = false;
	$args['default_mark'] = '';

	// Set a custom page capability.
	// Default: manage_options
	//$args['page_cap'] = 'manage_options';

	// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
	// Default: menu
	//$args['page_type'] = 'submenu';

	// Set the parent menu.
	// Default: themes.php
	// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$args['page_parent'] = 'options-general.php';
	//$args['page_parent'] = 'themes.php';

	// Set a custom page location. This allows you to place your menu where you want in the menu order.
	// Must be unique or it will override other items!
	// Default: null
	//$args['page_position'] = null;

	// Set a custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

	// Disable the panel sections showing as submenu items.
	// Default: true
	//$args['allow_sub_menu'] = false;
	    
	// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
/*
	$args['help_tabs'][] = array(
	    'id' => 'redux-opts-1',
	    'title' => __('Theme Information 1', 'redux-framework'),
	    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework')
	);
	$args['help_tabs'][] = array(
	    'id' => 'redux-opts-2',
	    'title' => __('Theme Information 2', 'redux-framework'),
	    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework')
	);

	// Set the help sidebar for the options page.                                        
	$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework');
*/

	// Add HTML before the form.
	$args['intro_text'] = $args['menu_title'];


	// Add content after the form.
//	$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework');

	// Set footer/credit line.
	//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'redux-framework');


	$sections = array();              

	//Background Patterns Reader
	$sample_patterns_path = DethemeReduxFramework::$_dir . '../sample/patterns/';
	$sample_patterns_url  = DethemeReduxFramework::$_url . '../sample/patterns/';
	$sample_patterns      = array();

	if ( is_dir( $sample_patterns_path ) ) :
		
	  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
	  	$sample_patterns = array();

	    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

	      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
	      	$name = explode(".", $sample_patterns_file);
	      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
	      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
	      }
	    }
	  endif;
	endif;

	$dt_theme_images  = substr_replace(DethemeReduxFramework::$_url,'images',strpos(DethemeReduxFramework::$_url,'redux-framework'));

	$sections[] = array(
		'title' => __('Top Bar Settings', 'redux-framework'),
		'icon' => 'el-icon-tasks',
		'fields' => array(	
			array(
				'id'=>'showtopbar',
				'type' => 'switch', 
				'title' => __('Show Top Bar', 'redux-framework'),
				'subtitle'=> __('Allow show/hide top bar', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'devider-1',
				'type' => 'divider', 
				'title' => __('Left Section', 'redux-framework'),
				'subtitle'=> __('Select element to be displayed on left top bar', 'redux-framework')
				),	
			array(
				'id'=>'dt-left-top-bar',
				'type' => 'select',
				'title' => __('Type of Element', 'redux-framework'), 
				'options'=>array(
					'text'=>__('Custom Text','redux-framework'),
					'menu'=>__('Menu','redux-framework'),
					'icon'=>__('Icon from Menu','redux-framework')
					)
				),

			array(
				'id'=>'dt-left-top-bar-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'), 
				),
			array(
				'id'=>'dt-left-top-bar-text',
				'type' => 'text',
				'title' => __('Custom Text', 'redux-framework'),
				'default' => __('Left topbar custom text','redux-framework')
				),				
			array(
				'id'=>'devider-2',
				'type' => 'divider', 
				'title' => __('Right Section', 'redux-framework'),
				'subtitle'=> __('Select element to be displayed on right top bar', 'redux-framework')
				),	
			array(
				'id'=>'dt-right-top-bar',
				'type' => 'select',
				'title' => __('Type of Element', 'redux-framework'), 
				'options'=>array(
					'text'=>__('Custom Text','redux-framework'),
					'menu'=>__('Menu','redux-framework'),
					'icon'=>__('Icon from Menu','redux-framework')
					)
				),

			array(
				'id'=>'dt-right-top-bar-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'), 
				),
			array(
				'id'=>'dt-right-top-bar-text',
				'type' => 'text',
				'title' => __('Custom Text', 'redux-framework'),
				'default' => __('Right topbar custom text','redux-framework')
				),					)
	);

	$sections[] = array(
		'title' => __('Main Navigation Settings', 'redux-framework'),
		'icon' => 'el-icon-lines',
		'fields' => array(
			array(
				'id'=>'dt-show-header',
				'type' => 'switch', 
				'title' => __('Navigation Bar', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),
			array(
				'id'=>'dt-main-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'),
				'placeholder'=>__('Select Main Menu','redux-framework') 
				),
			array(
				'id'=>'dt-header-type',
				'type' => 'image_select', 
				'title' => __('Layout Type', 'redux-framework'),
				'options' => array(
						'left' => array('title' => __('Logo on Left', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-1.png'),
						'center' => array('title' => __('Logo on Center', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-2.png'),
						'right' => array('title' => __('Logo on Right', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-3.png'),
						'leftbar' => array('title' => __('Vertical Menu on Left', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-4.png')
					),
				"default"=> 'left'
				),
			array(
				'id'=>'dt-menu-image-size',
				'type' => 'radio',
				'title' => __('Background Size', 'redux-framework'), 
				'options'=>array('cover'=>__('Cover', 'redux-framework'),
					'contain'=>__('Contain', 'redux-framework'),
					'default'=>__('Default', 'redux-framework'),
					),
				'default'=>'default'
				),
			array(
				'id'=>'dt-menu-image',
				'compiler' => true,
				'type' => 'media', 
				'title' => __('Background Image', 'redux-framework'),
				"default"=> ''
				),
			array(
				'id'=>'dt-menu-image-horizontal',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Horizontal Position(%)', 'redux-framework'),
				'default'=> '50',
				),
			array(
				'id'=>'dt-menu-image-vertical',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Vertical Position(%)', 'redux-framework'),
				'default'=> '100',
				),

			array(
				'id'=>'dt-logo-top-padding',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Menu Top Margin (Logo type centered)', 'redux-framework'),
				'subtitle' => sprintf(__('Using to adjust menu top margin in pixel when layout type is "Logo on center" (Default: %dpx)', 'redux-framework'),100),
				'default'=> 100,
				),
			array(
				'id'=>'dt-logo-top-margin-reveal',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin (Reveal)', 'redux-framework'),
				'subtitle' => sprintf(__('is used to adjust logo top margin in pixel when layout type is center when menu is revealed (Default: %dpx)', 'redux-framework'),0),
				'default'=> 0,
				),
			array(
				'id'=>'show-header-searchmenu',
				'type' => 'switch', 
				'title' => __('Search Bar', 'redux-framework'),
				'subtitle' => sprintf(__('is used to show/hide Search Bar on Main Menu (Default: %s)', 'redux-framework'),__('Show', 'redux-framework')),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'show-header-shoppingcart',
				'type' => 'switch', 
				'title' => __('Show Shopping Cart on Menu ?', 'redux-framework'),
				'subtitle' => sprintf(__('is used to show/hide Shopping Cart on Main Menu (Default: %s)', 'redux-framework'),__('Show', 'redux-framework')),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'dt-sticky-menu',
				'type' => 'switch', 
				'title' => __('Sticky Menu', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", menu will sticky on top when the browser is scrolled down. Default is "%s"', 'redux-framework'),__('On', 'redux-framework'),__('On', 'redux-framework')),
				"default" => 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'dt-menu-height',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Menu Height', 'redux-framework'),
				'subtitle' => sprintf(__('Using to adjust menu height in em (Default: %dem)', 'redux-framework'),6),
				'default'=> 5,
				),
			array(
				'id'=>'dt-logo-width',
				'type' => 'text', 
				'title' => __('Logo Width', 'redux-framework'),
				'subtitle' => __('Maximum logo width in pixel', 'redux-framework'),
				'class'=>'width_100',
				'desc'=>__('leave blank to display original size', 'redux-framework'),
				'default'=>'',
				),
			array(
				'id'=>'dt-logo-text',
				'type' => 'text', 
				'title' => __('Text Logo', 'detheme'),
				'subtitle' => __('Will be displayed as image alt', 'redux-framework'),
				'default'=>'Zeyn',
				),
			array(
				'id'=>'dt-logo-margin',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from top in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'dt-logo-margin-mobile',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin for Mobile', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from top for mobile in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'dt-logo-leftmargin',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Left Margin', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from left in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'devider-3',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Homepage', 'redux-framework').'</h2>',
				),	

			array(
				'id'=>'homepage-background-type',
				'type' => 'select',
				'title' => __('Background Type', 'redux-framework'), 
				'options'=>array(
					'solid'=>__('Solid','redux-framework'),
					'transparent'=>__('Transparent','redux-framework')
					),
				'default'=>'solid'
				),
			array(
				'id'=>'homepage-header-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-header-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-dt-logo-image',
				'type' => 'media', 
				'title' => __('Desktop Logo', 'redux-framework'),
				'compiler' => true,
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),
			array(
				'id'=>'homepage-header-color-transparent',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-header-font-color-transparent',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-dt-logo-image-transparent',
				'type' => 'media', 
				'title' => __('Desktop Logo (reveal)', 'redux-framework'),
				'compiler' => true,
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),


			array(
				'id'=>'devider-4',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Subpage','redux-framework').'</h2>',
				),	
			array(
				'id'=>'header-background-type',
				'type' => 'select',
				'title' => __('Background Type', 'redux-framework'), 
				'options'=>array(
					'solid'=>__('Solid','redux-framework'),
					'transparent'=>__('Transparent','redux-framework')
					),
				'default'=>'solid'
				),
			array(
				'id'=>'header-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'header-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-logo-image',
				'type' => 'media', 
				'title' => __('Desktop Logo', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),

			array(
				'id'=>'header-color-transparent',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'header-font-color-transparent',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-logo-image-transparent',
				'type' => 'media', 
				'title' => __('Desktop Logo (reveal)', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),


			)
	);

	$sections['page-banner'] = array(
		'icon' => 'el-icon-picture',
		'title' => __('Banner Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'show-banner-area',
				'type' => 'switch', 
				'title' => __('Banner Section', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'dt-show-title-page',
				'type' => 'switch', 
				'title' => __('Page Title', 'redux-framework'),
				"default" => 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'title-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Page Title Color', 'redux-framework'), 
				'default' => '#000000',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-show-banner-page',
				'type' => 'select', 
				'title' => __('Background Banner', 'redux-framework'),
				"default" =>'none',
				'options' => array(
					'featured' => __('Page Banner Image','redux-framework'),
					'image' => __('Image','redux-framework'),
					'color' => __('Color','redux-framework'),
					'none' => __('None','redux-framework'),
					),
				),	
			array(
				'id'=>'use-featured-image',
				'type' => 'switch', 
				'title' => __('Used Featured image as default page banner image', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'dt-banner-image',
				'type' => 'media', 
				'title' => __('Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('select banner image.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/header_subpage_bg.jpg'),
				),
			array(
				'id'=>'banner-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the theme.', 'redux-framework'),
				'default' => '',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-banner-height',
				'type' => 'text',
				'title' => __('Banner Height', 'redux-framework'),
				'class'=>'width_100',
				'default' => '82px'
				),				
			array(
				'id'=>'banner-darkend',
				'type' => 'switch',
				'title' => __('Banner Darken', 'redux-framework'),
				"default" 		=> 0,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				)				
			)
	);

			if (is_plugin_active('woocommerce/woocommerce.php')) {
				array_push($sections['page-banner']['fields'], 
				array(
					'id'=>'dt-shop-banner-image',
					'type' => 'media', 
					'title' => __('Shop Banner Image', 'redux-framework'),
					'compiler' => true,
					'default'=>array('url'=>$dt_theme_images.'/header_subpage_bg.jpg'),
					)
			);
	}

	$sections['general'] = array(
		'icon' => 'el-icon-cogs',
		'title' => __('General Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'devider-5',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Main Layout', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'layout',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Choose Layout', 'redux-framework'), 
				'subtitle' => __('Select main content and sidebar alignment.', 'redux-framework'),
				'options' => array(
						'1' => array('alt' => '1 Column', 'img' => DethemeReduxFramework::$_url.'assets/img/1col.png'),
						'2' => array('alt' => '2 Column Left', 'img' => DethemeReduxFramework::$_url.'assets/img/2cl.png'),
						'3' => array('alt' => '2 Column Right', 'img' => DethemeReduxFramework::$_url.'assets/img/2cr.png')
					),
				'default' => '2'
				),
			array(
				'id'=>'devider-42',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Boxed Layout', 'redux-framework').'</h2>',
			),	
			array(
				'id'		=> 'boxed_layout_activate',
				'title' 	=> __('Enable Boxed Layout ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
			),
			array(
				'id'=>'boxed_layout_boxed_background_image',
				'type' => 'media', 
				'title' => __('Boxed Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Boxed Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'boxed_layout_boxed_background_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Boxed Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Boxed Background Color.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				)
				)
			);	
		

			if(!function_exists('wp_site_icon')){
				array_push(
					$sections['general']['fields'],
					array(
						'id'=>'devider-6',
						'type' => 'divider', 
						'title' => '<h2 class="redux-title">'.__('Favicon', 'redux-framework')."</h2>",
						),	
					array(
						'id'=>'dt-favicon-image',
						'type' => 'media', 
						'title' => __('Favicon Image', 'redux-framework'),
						'compiler' => true,
						//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'=> __('Set favicon image. Upload your image (.png,.ico, .jpg) with size 16x16 pixel', 'redux-framework'),
						'default'=>array('url'=>$dt_theme_images.'/favicon.png'),
						)
					);
			}


			$sections['general']['fields']=array_merge($sections['general']['fields'],array(
			array(
				'id'=>'devider-7',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Lightbox Popup', 'redux-framework')."</h2>",
				),	
			array(
				'id'		=> 'lightbox_1st_on',
				'title' 	=> __('Enable Lightbox 1st Visit ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'		=> 'lightbox_1st_title',
				'type' 		=> 'text',
				'title' 	=> __('The Title of the Lightbox', 'redux-framework'), 
				'default' 	=> __('Connect with us on Facebook','redux-framework')
				),
			array(
				'id'		=> 'lightbox_1st_content',
				'type' 		=> 'textarea',
				'title' 	=> __('The Content of the Lightbox ( HTML Allowed )', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Content of Lightbox 1st Visit here. You can paste Facebook like box, optinform or anything.', 'redux-framework'),
				'default' 	=> '',
				'validate' 	=> 'html'
				),
			array(
				'id'		=> 'lightbox_1st_delay',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Lightbox Delay', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Delay (only number) in Seconds. e.g. 10, 15, 20.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 10
				),
			array(
				'id'		=> 'lightbox_1st_cookie',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Cookie Expiry', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Cookie expiry (only number) in Hours. e.g. 2, 4, 24. For example you enter 24, it means the Lightbox will show again in next 24 hours.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 1
				),
			array(
				'id'=>'devider-8',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Page Loader', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'page_loader',
				'title' 	=> __('Enable Page Loader', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'=>'devider-9',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Sticky Sidebar', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'dt_scrollingsidebar_on',
				'title' 	=> __('Enable Sticky Sidebar ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'		=> 'dt_scrollingsidebar_position',
				'type' 		=> 'select', 
				'title' 	=> __('Sticky Sidebar Position', 'redux-framework'),
				'default' 	=> 'right',
				'options' 	=> array(
					'right' => __('Right','redux-framework'),
					'left' => __('Left','redux-framework'),
					),
				),	
			array(
				'id'		=> 'dt_scrollingsidebar_margin',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Sticky Sidebar Margin', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Sticky Sidebar Margin (only number) in pixel. For example: 20.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 20
				),
			array(
				'id'=>'devider-10',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Exit Popup', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'exitpopup',
				'type' 		=> 'textarea',
				'title' 	=> __( 'Content ( HTML Allowed )', 'redux-framework' ), 
				'subtitle' 	=> __('Enter the Content of exit popup.', 'redux-framework'),
				'default' 	=> '',
				'validate' 	=> 'html'
				),
			array(
				'id'=>'devider-11',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Comments', 'redux-framework').'</h2>',
				)
			)
		);	

	$post_types = get_post_types( array());
      foreach ( $post_types as $post_type ) {
          if (!in_array($post_type, dt_post_use_comment())) {
              

	        $post_type_object=get_post_type_object($post_type);
	        $label = $post_type_object->labels->singular_name;

          	array_push($sections['general']['fields'],
			array(
				'id'=>'comment-open-'.$post_type,
				'type' => 'switch', 
				'title' => sprintf(__('%s Comment', 'redux-framework'),ucfirst($label)),
				'subtitle'=> sprintf(__('If "%s", comment disable for all %s', 'redux-framework'),__('Off', 'redux-framework'),$label),
				"default" => 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				));
          }
      }

		$sections['general']['fields']=array_merge($sections['general']['fields'],array(

			array(
				'id'=>'devider-11',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('404 Page', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'dt-404-text',
				'type' => 'textarea',
				'title' => __('404 Error Text', 'redux-framework'), 
				'default' => __('It\'s looking like you may have taken a wrong turn. Don\'t worry...it happens to the most of us.','redux-framework'),
				'validate' => 'html'
				),
			array(
				'id'=>'dt-404-image',
				'type' => 'media', 
				'title' => __('404 Error Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set 404 Error Image.', 'redux-framework'),
				),
			array(
				'id'=>'devider-12',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Gallery', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'dt-select-modal-effects',
				'type' => 'select',
				'title' => __('Modal Effects Option', 'redux-framework'), 
				'options'=>array('md-effect-1'=>__('Effect 1: Fade in and scale up','redux-framework'),
					'md-effect-2'=>__('Effect 2: Slide from the right','redux-framework'),
					'md-effect-3'=>__('Effect 3: Slide from the bottom','redux-framework'),
					'md-effect-4'=>__('Effect 4: Newspaper','redux-framework'),
					'md-effect-5'=>__('Effect 5: Fall','redux-framework'),
					'md-effect-6'=>__('Effect 6: Side fall','redux-framework'),
					'md-effect-7'=>__('Effect 7: Slide and stick to top','redux-framework'),
					'md-effect-8'=>__('Effect 8: 3D flip horizontal','redux-framework'),
					'md-effect-9'=>__('Effect 9: 3D flip vertical','redux-framework'),
					'md-effect-10'=>__('Effect 10: 3D sign','redux-framework'),
					'md-effect-11'=>__('Effect 11: Super scaled','redux-framework'),
					'md-effect-12'=>__('Effect 12: Just me','redux-framework'),
					'md-effect-13'=>__('Effect 13: 3D slit','redux-framework'),
					'md-effect-14'=>__('Effect 14: 3D Rotate from bottom','redux-framework'),
					'md-effect-15'=>__('Effect 15: 3D Rotate in from left (Default)','redux-framework'),
					'md-effect-16'=>__('Effect 16: Blur','redux-framework'),
					'md-effect-17'=>__('Effect 17: Slide in from bottom with perspective on container','redux-framework'),
					'md-effect-18'=>__('Effect 18: Slide from right with perspective on container','redux-framework'),
					'md-effect-19'=>__('Effect 19: Slip in from the top with perspective on container','redux-framework')
					)
			),

		)
	);

	$sections[] = array(
		'title' => __('Footer Settings', 'redux-framework'),
		'icon' => 'el-icon-fork',
		'fields' => array(
			array(
				'id'=>'footer-text',
				'type' => 'editor',
				'title' => __('Footer Text', 'redux-framework'), 
				'subtitle' => __('You can use the following shortcodes in your footer text','redux-framework').': [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]',
				'default' => '© [current-year] '.sprintf(__('%s, The Awesome Theme. All right reserved.','redux-framework'),get_template()),
				'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => false)
				),
			array(
				'id'=>'showfooterwidget',
				'type' => 'switch', 
				'title' => __('Show Footer Widget', 'redux-framework'),
				'subtitle'=> __('Allow show/hide footer widget', 'redux-framework'),
				"default"=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'dt-footer-widget-column',
				'type' => 'radio',
				'title' => __('Number of Footer Widget Columns', 'redux-framework'), 
				'options'=>array(1=>__('One Column', 'redux-framework'),
					2=>__('Two Columns', 'redux-framework'),
					3=>__('Three Columns', 'redux-framework'),
					4=>__('Four Columns', 'redux-framework')
					),
				'default'=>3
				),
			array(
				'id'=>'footer-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Footer Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for footer section', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'footer-background-image',
				'type' => 'media', 
				'title' => __('Footer Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Footer Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'footer-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Footer Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color for Footer Text', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			)
		);

	$sections[] = array(
		'icon' => 'el-icon-website',
		'title' => __('Styling Options', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'primary-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Primary Color', 'redux-framework'), 
				'subtitle' => sprintf(__('Pick a primary color for the theme (default: %s)', 'redux-framework'),'#f16338'),
				'default' => '#f16338',
				'validate' => 'color',
				),		

			array(
				'id'=>'secondary-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Secondary Color', 'redux-framework'), 
				'subtitle' => sprintf(__('Pick a secondary color for the theme (default: %s)', 'redux-framework'),'#f16338'),
				'default' => '#f16338',
				'validate' => 'color',
				),		
			array(
				'id'=>'body_text_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Body Text Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Body Text Color.', 'redux-framework'),
				'default' => '#222222',
				'validate' => 'color',
				),	
			array(
				'id'=>'body_background_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Body Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Body Background Color.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'body_background_image',
				'type' => 'media', 
				'title' => __('Body Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Body Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'primary-font',
				'type' => 'typography',
				'title' => __('Body Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the body text font properties. Default : "%s"', 'redux-framework'),'Istok Web'),
				'font-style'=>false,
				'font-weight'=>false,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Istok Web',
					'google'=>true
					),
				),
			array(
				'id'=>'secondary-font',
				'type' => 'typography',
				'title' => __('Heading Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the heading text font properties. Default : "%s"', 'redux-framework'),'Dosis'),
				'font-style'=>false,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Dosis',
					'google'=>true,
					),
				),
			array(
				'id'=>'section-font',
				'type' => 'typography',
				'title' => __('Section Heading Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the heading text font properties. Default : "%s"', 'redux-framework'),'Dosis'),
				'font-style'=>false,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Dosis',
					'google'=>true
					),
				),
			array(
				'id'=>'tertiary-font',
				'type' => 'typography',
				'title' => __('Quote Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the quote text font properties. Default : "%s"', 'redux-framework'),'Merriweather'),
				'font-style'=>true,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Merriweather',
					'google'=>true
					),
				),
			array(
				'id'=>'heading-style',
				'type' => 'select',
				'title' => __('Heading Text Style', 'redux-framework'),
				'options'=>array(
					'uppercase'=>__('Uppercase', 'redux-framework'),
					'capitalize'=>__('Capitalize', 'redux-framework'),
					'none'=>__('None', 'redux-framework')
					),
				'default'=>'none'
				)
		)
	);

	$sections[] = array(
		'icon' => 'el-icon-wrench',
		'title' => __('Advanced Settings', 'redux-framework'),
		'fields' => array(
	        array(
				'id'=>'css-code',
				'type' => 'ace_editor',
				'title' => __('CSS Code', 'redux-framework'), 
				'subtitle' => __('Paste your CSS code here', 'redux-framework'),
				'mode' => 'css',
	            'theme' => 'monokai',
				'desc' => sprintf(__('Your css code will saving at %s','redux-framework'),'/css/customstyle.css'),
	            'default' => "body{height: 100%;}"
				),
	        array(
				'id'=>'js-code',
				'type' => 'ace_editor',
				'title' => __('JS Code', 'redux-framework'), 
				'subtitle' => __('Paste your JS code here. JS Code loaded on end of page', 'redux-framework'),
				'mode' => 'javascript',
	            'theme' => 'chrome',
				'desc' => __('Be careful!','redux-framework'),
	            'default' => "jQuery(document).ready(function(){});"
				)
	        )
	);

	$sections['seo'] = array(
		'icon' => 'el-icon-laptop',
		'title' => __('SEO', 'redux-framework'),
		'fields' => array(
	        array(
				'id'=>'meta-author',
				'type' => 'text',
				'title' => __('Meta Author', 'redux-framework'), 
				'subtitle' => __('Type your meta author', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => "Detheme Team"
				),
	        array(
				'id'=>'meta-description',
				'type' => 'textarea',
				'title' => __('Meta Description', 'redux-framework'), 
				'subtitle' => __('Type your meta description. Googlebot loves it if it\'s not exceeding 160 characters or 20 words', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => sprintf(__("%s is Perfect Wordpress Template For Any Website",'redux-framework'),ucwords(get_template()))
				),
	        array(
				'id'=>'meta-keyword',
				'type' => 'textarea',
				'title' => __('Meta Keyword', 'redux-framework'), 
				'subtitle' => __('Type your meta keyword separed by comma. Googlebot loves it if it\'s not exceeding 160 characters or 20 words', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => sprintf(__("%s , wordpress template, template, wordpress",'redux-framework'),get_template())
				),
	        array(
				'id'=>'footer-code',
				'type' => 'textarea',
				'title' => __('Custom Code', 'redux-framework'), 
				'subtitle' => __('Paste your html code here. It will be added before the closing &lt;/body&gt; tag', 'redux-framework'),
	            'validate' => 'html',
	            'default' => ""
				),
			array(
				'id'=>'meta-og',
				'type' => 'switch', 
				'title' => __('Meta Open Graph', 'redux-framework'),
				'subtitle'=> __('Allow show/hide Meta Open Graph', 'redux-framework'),
				"default"=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				)	
	        )
	);

	global $wp_filesystem;

	$sections['info'] = array(
		'icon' => 'el-icon-info-sign',
		'title' => __('Theme Information & Update', 'redux-framework'),
		'desc' => '<p class="description">'.__('The Awesome Wordpress Theme by detheme', 'redux-framework').'</p>',
		'fields' => array(
			array(
				'title' => __('Item Purchase Number', 'redux-framework'),
				'id'=>'detheme_license',
				'type' => 'text',
				'validate_callback'=>'check_for_update',
				'default'=>get_option("detheme_license_".get_template()),
				'desc' => sprintf(__('purchase number from %s. ex:xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'redux-framework'),"themeforest.net")
				),
			array(
				'id'=>'raw_new_info',
				'type' => 'raw',
				'content' => $item_info,
				)
			),   
		);

	if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
	    $tabs['docs'] = array(
			'icon' => 'el-icon-book',
			    'title' => __('Documentation', 'redux-framework'),
	        'content' => nl2br($wp_filesystem->get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
	    );
	}

	global $DethemeReduxFramework;
	$DethemeReduxFramework = new DethemeReduxFramework ();
	$DethemeReduxFramework->__render($sections, $args, $tabs);

	// END Sample Config
	}
	add_action('init', 'redux_init');
endif;

if(!function_exists('darken')){
	function darken($colourstr, $procent=0) {
	  $colourstr = str_replace('#','',$colourstr);
	  $rhex = substr($colourstr,0,2);
	  $ghex = substr($colourstr,2,2);
	  $bhex = substr($colourstr,4,2);

	  $r = hexdec($rhex);
	  $g = hexdec($ghex);
	  $b = hexdec($bhex);

	  $r = max(0,min(255,$r - ($r*$procent/100)));
	  $g = max(0,min(255,$g - ($g*$procent/100)));  
	  $b = max(0,min(255,$b - ($b*$procent/100)));

	  return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
	}
}

if(!function_exists('lighten')){

    function lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

if(!function_exists('get_redux_custom_primary_font')){

function get_redux_custom_primary_font($primary_font_family='') {

	if(empty($primary_font_family) && ''!==$primary_font_family)
		return '';

	ob_start();
?>
body { font-family: <?php print $primary_font_family;?>; }
.woocommerce.widget_product_tag_cloud li {
  font-family: <?php print $primary_font_family;?>;
}
.postdate .year {
  font-family: <?php print $primary_font_family;?>;
}
.postmetatop ul li {
  font-family: <?php print $primary_font_family;?>;
}
.singlepostmetatop ul li {
  font-family: <?php print $primary_font_family;?>;
}
.dt-comment-date {
  font-family: <?php print $primary_font_family;?>;
}
.dt-comment-comment {
  font-family: <?php print $primary_font_family;?>;
}
.footer-right {
  font-family: <?php print $primary_font_family;?>;
}
footer#footer .widget_tag_cloud .tagcloud .tag {
  font-family: <?php print $primary_font_family;?>;
}
footer#footer .widget_categories {
  font-family: <?php print $primary_font_family;?>;
}
footer#footer .widget_archive {
  font-family: <?php print $primary_font_family;?>;
}
.sidebar .widget_tag_cloud .tagcloud .tag {
  font-family: <?php print $primary_font_family;?>;
}
.sidebar .widget_categories {
  font-family: <?php print $primary_font_family;?>;
}
.sidebar .widget_archive {
  font-family: <?php print $primary_font_family;?>;
}
section#banner-section .breadcrumbs {
  font-family: <?php print $primary_font_family;?>;
}
.dt-contact-form input[type="text"], 
.dt-contact-form input[type="email"], 
.dt-contact-form input[type="password"], 
.dt-contact-form input[type="number"], 
.dt-contact-form input[type="tel"],
.dt-contact-form input[type="submit"], 
.dt-contact-form textarea {
  font-family: <?php print $primary_font_family;?>;
}

#dt-menu li a {	font-family: <?php print $primary_font_family;?>; }
#mobile-header label { font-family: <?php print $primary_font_family;?>; }
#dt-menu label { font: 3.125em/1.375em <?php print $primary_font_family;?>; }
#dt-menu .sub-nav label { font: 2em/2em <?php print $primary_font_family;?>; }
#dt-menu a, #dt-menu .sub-nav a{ font-family: <?php print $primary_font_family;?>; }
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}

if(!function_exists('get_redux_custom_section_font')){

	function get_redux_custom_section_font($font_family=''){

	if(empty($font_family) && ''!==$font_family)
		return '';

	ob_start();
?>
.dt-section-head h1,
.dt-section-head h2,
.dt-section-head h3,
.dt-section-head h4,
.dt-section-head h5,
.dt-section-head h6 {
  font-family: <?php print $font_family['font-family'];?>;
<?php if(''!=$font_family['font-weight']):?>
  font-weight: <?php print $font_family['font-weight'];?>;
<?php endif;?>
<?php if(''!=$font_family['font-style']):?>
  font-style: <?php print $font_family['font-style'];?>;
<?php endif;?>
}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;


	}
}
if(!function_exists('get_redux_custom_secondary_font')){

function get_redux_custom_secondary_font($font_family='') {

	if(empty($font_family) && ''!==$font_family)
		return '';

$secondary_font_family=$font_family['font-family'];
$font_weight=$font_family['font-weight'];
$font_style=$font_family['font-style'];
	ob_start();
?>
h1,
h2,
h3,
h4,
h5,
h6, 
.btn{
  font-family: <?php print $secondary_font_family;?>;
<?php if(''!=$font_weight):?>
  font-weight: <?php print $font_weight;?>;
<?php endif;?>
<?php if(''!=$font_style):?>
  font-style: <?php print $font_style;?>;
<?php endif;?>
}

input.secondary_color_button {
  font-family: <?php print $secondary_font_family;?>;
}
.btn {
  font-family: <?php print $secondary_font_family;?>;
}
.social-share-link {
  font-family: <?php print $secondary_font_family;?>;
}
.postdate .day {
  font-family: <?php print $secondary_font_family;?>;
}
.postmetabottom {
  font-family: <?php print $secondary_font_family;?>;
}
.postcontent-quote {
  font-family: <?php print $secondary_font_family;?>;
}
.dt-comment-author {
  font-family: <?php print $secondary_font_family;?>;
}
#mobile-header label {
  font-family: <?php print $secondary_font_family;?>;
}

.dt-contact-form input[type="submit"] {
  font-family: <?php print $secondary_font_family;?>;
}


#dt-menu label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}

#mobile-header-top-left label {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left .sub-nav label {
  font: 2em/2em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left,
#dt-topbar-menu-left .sub-nav {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left .toggle-sub {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left ul li a:after {
    font: 1.5em <?php print $secondary_font_family;?>;
}
#mobile-header-top-right label {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right .sub-nav label {
  font: 2em/2em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right,
#dt-topbar-menu-right .sub-nav {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right .toggle-sub {
  font-family: <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right ul li a:after {
    font: 1.5em <?php print $secondary_font_family;?>;
}
#top-bar {
  font-family: <?php print $secondary_font_family;?>;
}
#footer-right .widget .widget-title {
  font-family: <?php print $secondary_font_family;?>;
}
.share-button.float-right.sharer-0 label span {
  font-family: <?php print $secondary_font_family;?>!important;
}
.carousel-content .carousel-inner a.inline-block {
  font-family: <?php print $secondary_font_family;?>;
}
.box-main-color .iconbox-detail h3,
.box-secondary-color .iconbox-detail h3 {
  font-family: <?php print $secondary_font_family;?>;
}
.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button {
  font-family: <?php print $secondary_font_family;?>;
}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}

if(!function_exists('get_redux_custom_tertiary_font')){

function get_redux_custom_tertiary_font($tertiary_font_family='') {

	if(empty($tertiary_font_family) && ''!==$tertiary_font_family)
		return '';

	ob_start();
?>
blockquote { font-family: <?php print $tertiary_font_family;?> !important; }
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}


if(!function_exists('get_redux_custom_primary_color')){
function get_redux_custom_primary_color($color='') {

	if(empty($color) && ''!==$color)
		return '';

	ob_start();

	$mainColor=$color;

    @list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
    $rgbcolor=$r.','.$g.','.$b;

    @list($r50d, $g50d, $b50d) = sscanf(darken($mainColor,50), "#%02x%02x%02x");
    $rgb50dcolor=$r50d.','.$g50d.','.$b50d;
?>
		.primary_color_text, .paging-nav a:hover,
		 footer#footer .widget_calendar thead th,
		 footer#footer .dt_widget_accordion .opened,
		 .sidebar .widget_calendar a,
		 .dt_team_custom_item .profile-position,
		.dt-iconboxes-4:hover .dt-section-icon i:hover,
		.dt-iconboxes.layout-6 i,
		.no-touch .dt-iconboxes-4:hover .hi-icon-effect-5 .hi-icon
		{ color: <?php print $mainColor;?>; }

		.primary_color_border,
		.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon { border-color: <?php print $mainColor;?>; }

		.primary_color_bg, .paging-nav span.current,
		.primary_color_button,footer#footer .widget_calendar #today,
		footer#footer .widget_tag_cloud .tagcloud .tag:hover,
		footer#footer .dt_widget_tabs .nav-tabs li a:hover,
		footer#footer .dt_widget_tabs .nav-tabs li:hover,
		footer#footer .dt_widget_tabs .nav-tabs li.active a,
		footer#footer .dt_widget_tabs .nav-tabs li.active a:hover,
		footer#footer .dt_widget_tabs .nav-tabs li.active a:focus,
		footer#footer .dt_widget_accordion .btn-accordion,
		footer#footer .dt_widget_accordion .openedup,
		.sidebar .owl-theme .owl-controls .owl-page span,
		.woocommerce.widget_product_tag_cloud li,
		.sidebar .widget_calendar #today,
		.sidebar .widget_tag_cloud .tagcloud .tag:hover,
		.sidebar .dt_widget_tabs li.active a,
		.sidebar .dt_widget_accordion .btn-accordion,
		.sidebar .dt_widget_accordion .openedup,
		.dt-timeline .time-item .center-line.circle i,
		.dt-timeline .time-item .center-line.square,
		.dt-iconboxes span:hover,
		.dt-iconboxes-2:hover .dt-section-icon i.hi-icon,
		.dt-iconboxes-2:hover i,
		.dt-iconboxes.layout-3 span:hover,
		.dt-iconboxes-4:hover .dt-section-icon,
		.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon,
		.dt-iconboxes.layout-6:hover {
		  background-color: <?php print $mainColor;?>;
		}

		.btn-color-primary,
		.portfolio-navigation a.more-post, 
		.dt-contact-form.on-dark input[type="submit"], 
		.shipping-calculator-button,
		.woocommerce #content input.button,
		.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce-page #content input.button,
		.woocommerce-page #respond input#submit,
		.woocommerce-page a.button,
		.woocommerce-page button.button,
		.woocommerce-page input.button,
		.woocommerce.widget_product_search #searchsubmit,
		.woocommerce #content input.button.alt,
		.woocommerce #respond input#submit.alt,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt,
		.woocommerce-page #content input.button.alt,
		.woocommerce-page #respond input#submit.alt,
		.woocommerce-page a.button.alt,
		.woocommerce-page button.button.alt,
		.woocommerce-page input.button.alt {
			background: <?php print $mainColor;?>;
		}

		footer#footer .widget_text ul.list-inline-icon li:hover { border: 1px solid <?php print $mainColor;?>; background: <?php print $mainColor;?>; }
		footer#footer .owl-theme .owl-controls .owl-page span { background-color: <?php print $mainColor;?>; border: 2px solid <?php print $mainColor;?>; }
		footer#footer .owl-theme .owl-controls .owl-page.active span { border: 2px solid <?php print $mainColor;?>; }

		footer#footer .dt_widget_tabs .nav-tabs li a:hover {
		  color: #ffffff;
		}


		footer#footer .dt_widget_accordion .opened {
		  background: #ffffff; 
		}
		.sidebar .owl-theme .owl-controls .owl-page.active span {
		  border: 2px solid <?php print $mainColor;?>;
		}

		.sidebar .widget_text ul.list-inline-icon li:hover {
		   border: 1px solid <?php print $mainColor;?>; background: <?php print $mainColor;?>; 
		}

		.sidebar .dt_widget_tabs li.active a {
		  border-top: 3px solid <?php print $mainColor;?>;
		}
		.sidebar .dt_widget_tabs li.active a:hover {
		  border-top: 3px solid <?php print $mainColor;?>;
		}
		.sidebar .dt_widget_tabs li.active a:focus {
		  border-top: 3px solid <?php print $mainColor;?>;
		}

		.sidebar .dt_widget_accordion .opened {
		  background: #ffffff;
		  color: <?php print $mainColor;?>;
		}

		h3.widget-title:after {
		  border-top: solid 2px <?php print $mainColor;?>;
		}
		#related-port .related-port figure figcaption .related-tag a {
		  color: <?php print $mainColor;?>;
		}

		.dt-timeline .time-item:hover .content-line:before,
		.dt-timeline .time-item:hover .content-line {
		  background-color: <?php print $mainColor;?>!important;
		}

		@media handheld, only screen and (max-width: 479px) {
		  .dt-timeline .time-item .center-line {
		    display: none !important;
		  }
		  .dt-timeline .time-item .content-line {
		    margin: 0!important;
		    left: 0!important;
		    margin-right: 0!important;
		    margin-left: 0!important;
		  }
		  .dt-timeline .time-item:hover .content-line:before,
		  .dt-timeline .time-item .content-line:before {
		    background: none!important;
		    border: none !important;
		  }
		}

		.dt_team_custom_item hr:after {
		  width: 50px !important;
		}
		.dt-iconboxes span:hover:after,
		.dt-iconboxes span:hover:before,
		.dt-iconboxes.layout-3 span:hover:after,
		.dt-iconboxes.layout-3 span:hover:before,
		.dt-iconboxes-4:hover .dt-section-icon:after,
		.dt-iconboxes-4:hover .dt-section-icon:before {
		  border-top-color: <?php print $mainColor;?> !important;
		}

		.dt_team_custom_item .profile-scocial a:hover,
		.dt_team_custom_item .profile-scocial i:hover {
		  color: <?php print $mainColor;?>;
		}
		.dt-pricing-table .featured ul li.plan-action,
		.dt-pricing-table .featured ul li.plan-action,
		.dt-pricing-table .featured ul li.plan-head,
		.dt-pricing-table .featured ul li.plan-head {
		  background: <?php print $mainColor;?> !important;
		}
		.mejs-container .mejs-controls .mejs-horizontal-volume-current,
		.mejs-container .mejs-controls .mejs-time-loaded {
		  background-color: <?php print $mainColor;?> !important;
		}

		#dt-menu li a:hover{
			color: <?php print $mainColor;?>;
		}
		
		@media (max-width: 991px) {
			#head-page #dt-menu > ul > li > a:hover {color:<?php print $mainColor;?>!important;}
		}
		@media (min-width: 991px) {
			#dt-menu ul li:hover > a {
				color: <?php print $mainColor;?>;
			}
		}
		#dt-menu ul.sub-nav li:hover > a {
		    color: <?php print $mainColor;?>;
		  }
		#dt-menu a.search_btn:hover {
		    color: <?php print $mainColor;?> !important;
		}
		#dt-topbar-menu-left ul li:hover > a {
		    color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left li a:hover {
		  background: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left .toggle-sub {
		  background: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left li:hover > .toggle-sub {
		  color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left ul li:first-child {
		    border-top: 3px solid <?php print $mainColor;?> !important;
		  }
		#dt-topbar-menu-left ul.sub-nav li:hover > a {
		    background: <?php print $mainColor;?>;
		  }

		#dt-topbar-menu-right ul li:hover > a {
		    color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-right li a:hover {
		  background: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-right .toggle-sub {
		  background: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-right li:hover > .toggle-sub {
		  color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-right ul.sub-nav li:hover > a {
		    background: <?php print $mainColor;?>;
		  }

		.select.select-theme-default .select-options .select-option:hover, .select.select-theme-default .select-options .select-option.select-option-highlight {background: <?php print $mainColor;?>;}

		footer#footer .dt_widget_portfolio_posts .post-item figure figcaption {
		  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
		}
		.sidebar .dt_widget_portfolio_posts .portfolio_wrapper .post-item figure figcaption {
		  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
		}
		.dt_widget_featured_posts .post-item figure figcaption {
		  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
		}
		.sidebar .widget_calendar a:hover {
		  color: <?php print darken($mainColor,30);?>;
		}

		.dt-iconboxes.layout-7:hover i,.dt-iconboxes.layout-8:hover i{
		  border-color: <?php print darken($mainColor,35);?> !important;	
		}
		.dt-iconboxes.layout-7 i,.dt-iconboxes.layout-8 i{
		  color: <?php print $mainColor;?>;	
		}

		@media (max-width: 768px) {
		  #footer-left {
		    border-bottom: solid 1px <?php print darken($mainColor,60);?>;
		  }
		}
		.dt-iconboxes-4:hover { 
			background-color: <?php print darken($mainColor,20);?>; 
		}

		.sidebar .woocommerce.widget_product_tag_cloud .tagcloud .tag:hover,
		footer#footer .woocommerce.widget_product_tag_cloud .tagcloud .tag:hover {
		  background-color: <?php print $mainColor;?>;
		}

		.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
		  background-color: <?php print $mainColor;?>;
		}

		.border-color-primary, 
		.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, 
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, 
		.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a, 
		.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a {
		  border-color: <?php print $mainColor;?>;
		}
		.box-main-color .img-blank {
		  background-color: <?php print $mainColor;?>;
		}
		.link-color-primary, 
		#dt-menu #menu-main-menu .current-menu-parent > a,
		#dt-menu #menu-main-menu .current-menu-item > a,
		#dt-menu #menu-main-menu .sub-nav .current-menu-item > a,  
		.woocommerce nav.woocommerce-pagination ul li a.prev:hover, 
		.woocommerce-page nav.woocommerce-pagination ul li a.prev:hover, 
		.woocommerce nav.woocommerce-pagination ul li a.next:hover, 
		.woocommerce-page nav.woocommerce-pagination ul li a.next:hover {
		  color: <?php print $mainColor;?>;
		}
		.background-color-primary, 
		.dt-icon-circle.primary-color, 
		.dt-icon-ghost.primary-color, 
		.sidebar .widget_text .social-circled li:hover, 
		#footer .container .widget_text .social-circled li:hover, 
		#featured-work-navbar #featured-filter.dt-featured-filter li.active a, 
		.owl-custom-pagination .owl-page.active i, 
		.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .ui-state-default .ui-icon:after, 
		.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-accordion-header-active,  
		.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, 
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active, 
		.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, 
		.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, 
		.woocommerce nav.woocommerce-pagination ul li span.current, 
		.woocommerce-page nav.woocommerce-pagination ul li span.current, 
		.woocommerce #content nav.woocommerce-pagination ul li span.current, 
		.woocommerce-page #content nav.woocommerce-pagination ul li span.current, 
		.woocommerce nav.woocommerce-pagination ul li a:hover, 
		.woocommerce-page nav.woocommerce-pagination ul li a:hover, 
		.woocommerce #content nav.woocommerce-pagination ul li a:hover, 
		.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, 
		.woocommerce nav.woocommerce-pagination ul li a:focus, 
		.woocommerce-page nav.woocommerce-pagination ul li a:focus, 
		.woocommerce #content nav.woocommerce-pagination ul li a:focus, 
		.woocommerce-page #content nav.woocommerce-pagination ul li a:focus, 
		#sequence ul li .btn-cta:after, .dt-iconboxes-4, .dt-iconboxes span:hover, 
		.dt-iconboxes-2:hover .dt-section-icon i.hi-icon, .dt-iconboxes-2:hover i, 
		.dt-iconboxes.layout-3 span:hover, .dt-iconboxes-4:hover .dt-section-icon, 
		.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon, 
		.dt-iconboxes.layout-6:hover,.bulat2, 
		.dt-iconboxes.layout-3 span:hover {
		  background: none repeat scroll 0 0 <?php print $mainColor;?>;
		}

		.dt-iconboxes.layout-3 span:hover:after, .dt-iconboxes.layout-3 span:hover:before {border-top-color: <?php print $mainColor;?> !important;}

		#featured-work-navbar #featured-filter.dt-featured-filter li.active {
		  border: 1px solid <?php print $mainColor;?> !important;
		}
		.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon {
		  background-color: <?php print $mainColor;?>;
		  border-color: <?php print $mainColor;?>;
		}
		.container .owl-theme .owl-controls .owl-page span {
		  background-color: <?php print $mainColor;?>;
		  border-color: <?php print $mainColor;?>; 
		}
		.owl-theme .owl-controls .owl-page.active span {
		  border-color: <?php print $mainColor;?>; 
		}
		.container .carousel-content .carousel-indicators li {
		  	background-color: <?php print $mainColor;?>;
		  	border-color: <?php print $mainColor;?>; 
		}
		.container .carousel-content .carousel-indicators .active {
		  	border-color: <?php print $mainColor;?>; 
		}
		.dt-iconboxes span:hover, .dt-iconboxes.layout-3 span:hover {
		  	border-color: <?php print $mainColor;?>;
		}
		.dt_vertical_tab .vertical-nav-tab > li > div i { color: <?php print $mainColor;?>; }
		.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .ui-state-active .ui-icon:after,
		.wpb_wrapper .vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-controls-icon::after{
			color: <?php print $mainColor;?>;
		}

		.wpb_wrapper .vc_tta-accordion .vc_tta-panel .vc_tta-controls-icon::after{
			background-color: <?php print $mainColor;?>;
		}
		.wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active {
			background: none repeat scroll 0 0 <?php print $mainColor;?>;
		}

		.wpb_wrapper .vc_tta-tabs-container li.vc_tta-tab a {
			background:#ecf0f1;
			border-top: 0;
			margin:0;
		}

		.wpb_wrapper .vc_tta-tabs-container li.vc_tta-tab.vc_active a {
			border:0!important;
			background:<?php print $mainColor;?>;
			color: #fff;
		}

		.wpb_wrapper .vc_tta-panels .vc_tta-panel.vc_active .vc_tta-panel-title > a {
			background:<?php print $mainColor;?>;
			color: #fff;
		}

		.btn.btn-link { color: <?php print $mainColor;?>; }
		.btn.btn-link:hover { color: <?php print $mainColor;?>; }
		#footer h3.widget-title:after { border-top: 2px solid <?php print $mainColor;?>; }
		.text-hover-pre-title {background-color:<?php print $mainColor;?>}
		input.wpcf7-submit[type="submit"],
		form.wpcf7-form .wpcf7-form-control-wrap .select-target.select-theme-default { background-color: <?php print $mainColor;?>; }

		.dt-shop-category .owl-carousel-navigation .btn-owl { background: <?php print $mainColor;?>; }
		.dt-shop-category .owl-carousel-navigation .btn-owl:hover { background: none repeat scroll 0 0 <?php print darken($mainColor,20);?> !important; }
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}
}
if(!function_exists('get_redux_custom_secondary_color')){
function get_redux_custom_secondary_color($color='') {

	if(empty($color) && ''!==$color)
		return '';

	ob_start();

	$mainColor=$color;

    @list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
    $rgbcolor=$r.','.$g.','.$b;
?>
		.secondary_color_bg { background-color: <?php print $mainColor;?>; }
		.secondary_color_text { color: <?php print $mainColor;?>; }
		.secondary_color_border { border-color: <?php print $mainColor;?>; }

		.secondary_color_button, .btn-color-secondary {
		  background-color: <?php print $mainColor;?>;
		}
		.background-color-secondary, .dt-icon-circle.secondary-color, .dt-icon-ghost.secondary-color, .dt-icon-square.secondary-color, #sequence ul.sequence-canvas li .slide-title:after {
			 background: <?php print $mainColor;?>;
		}
		:selection {
		  background: <?php print $mainColor;?>;
		}
		::selection {
		  background: <?php print $mainColor;?>;
		}
		::-moz-selection {
		  background: <?php print $mainColor;?>;
		}
		.woocommerce.widget_product_tag_cloud li:hover {
		  background-color: <?php print $mainColor;?>;
		}
		.woocommerce ul.products li.product .onsale:after,
		.woocommerce-page ul.products li.product .onsale:after,
		.woocommerce span.onsale:after,
		.woocommerce-page span.onsale:after {
		  border-bottom: 40px solid <?php print $mainColor;?>;
		}
		a {
		  color: <?php print $mainColor;?>;
		}
		a:hover, a:focus { border-color : <?php print $mainColor;?>; }
		a:hover, a:focus { color : <?php print darken($mainColor,20);?>; }
		h1 a:hover,
		h2 a:hover,
		h3 a:hover,
		h4 a:hover,
		h5 a:hover,
		h6 a:hover,
		h1 a:focus,
		h2 a:focus,
		h3 a:focus,
		h4 a:focus,
		h5 a:focus,
		h6 a:focus,
		.portfolio-type-text .portfolio-item .portfolio-termlist a
		 {
		  color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left li .toggle-sub:hover {
		  color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-left a.search_btn:hover {
		    color: <?php print $mainColor;?>;
		  }
		#dt-topbar-menu-right li .toggle-sub:hover {
		  color: <?php print $mainColor;?>;
		}
		#dt-topbar-menu-right a.search_btn:hover {
		    color: <?php print $mainColor;?>;
		  }
		footer#footer .widget_calendar a {
		  color: <?php print $mainColor;?>;
		}
		footer#footer .widget_recent_comments a:hover {
		  color: <?php print $mainColor;?>;
		}
		.sidebar a:hover {
		  color: <?php print $mainColor;?>;
		}
		.sidebar .dt-widget-twitter .sequence-twitter a {
		  color: <?php print $mainColor;?>;
		}
		.sidebar .widget_recent_comments a:hover {
		  color: <?php print $mainColor;?>;
		}
		.share-button label {
		  color: <?php print $mainColor;?> !important;
		}
		.share-button label span {
		  color: <?php print $mainColor;?> !important;
		}
		#top-bar a:hover {
		  color: <?php print $mainColor;?>;
		}
		.dt-section-head header i {
		  background: <?php print $mainColor;?>;
		}
		.progress_bars i {
		  background-color: <?php print $mainColor;?>;
		}
		.post-masonry li.isotope-item .isotope-inner .comment-count i:before {
		  color: <?php print $mainColor;?>;
		}
		.post-masonry li.isotope-item .post-info .author a {
		  color: <?php print $mainColor;?>;
		}

		.dt-pricing-table .price-4-col .btn-active,
		.dt-pricing-table .price-3-col .btn-active {
		  background-color: <?php print $mainColor;?>;
		}
		.dt-pricing-table .price-4-col .btn-active:hover,
		.dt-pricing-table .price-3-col .btn-active:hover {
		  background-color: <?php print darken($mainColor,20);?>;
		}
		.box-secondary-color .img-blank {
		  background-color: <?php print $mainColor;?>;
		}
		.bulat1 {
		  background: none repeat scroll 0 0 <?php print $mainColor;?>;
		}
		.woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price {
			color: <?php print $mainColor;?>;
		}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}
}

if(!function_exists('get_redux_custom_menu_height')){
	function get_redux_custom_menu_height($line_height='') {

		if (empty($line_height) && ''!==$line_height) return '';
			
		if (!is_numeric($line_height)) return '';

		ob_start();
		//767/768 991/992
	?>
		@media(min-width: 992px) {
			#dt-menu > ul > li { line-height: <?php print $line_height;?>em;}
		}
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_footer')){
	function get_redux_custom_footer($args){
		$footer_bg_color = $args['footer-color'];
		$footer_font_color = $args['footer-font-color'];
	
	    @list($r, $g, $b) = sscanf($footer_font_color, "#%02x%02x%02x");
	    $rgbcolor=$r.','.$g.','.$b;
		

		ob_start();

		if(!empty($footer_bg_color) && ''!==$footer_bg_color) {	?>
		.tertier_color_bg {background-color: <?php print $footer_bg_color;?>; }

		#footer { background-image: url("<?php print $args['footer-background-image']['url'];?>"); }
		#footer { background-repeat: no-repeat; }
		#footer { background-size: cover; }

<?php	} //if(!empty($footer_bg_color) && ''!==$footer_bg_color) ?>
		.footer-left { color: <?php print $footer_font_color;?>; }
		.footer-right { color: <?php print $footer_font_color;?>; }
		footer#footer a { color: <?php print $footer_font_color;?>; }
		#footer-right .widget .widget-title { color: <?php print $footer_font_color;?>; }

		#footer .container .widget_text .social-circled li,
		#footer .container .widget_text .social-circled li:last-child,
		#footer .woocommerce ul.cart_list li,
		#footer .woocommerce ul.product_list_widget li,
		#footer .woocommerce-page ul.cart_list li,
		#footer .woocommerce-page ul.product_list_widget li,
		#footer .woocommerce.widget_product_categories li,
		footer#footer .widget_tag_cloud .tagcloud .tag,
		footer#footer .dt_widget_tabs .nav-tabs li a,
		footer#footer .dt_widget_tabs .tab-pane .rowlist,
		footer#footer .dt_widget_accordion .panel-heading,
		footer#footer .dt_widget_accordion .panel-body,
		#footer .widget_categories ul li,
		#footer .widget_recent_entries ul li,
		#footer .widget_recent_comments ul li,
		#footer .widget_rss ul li,
		#footer .widget_meta ul li,
		#footer .widget_nav_menu ul li,
		#footer .widget_archive ul li,
		#footer .widget_text ul li,
		footer#footer .woocommerce.widget_product_tag_cloud .tagcloud .tag {
		  border-color: rgba(<?php print $rgbcolor;?>, 0.05);
		}

		footer#footer .widget_text ul.list-inline-icon li {
		  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.05);
		}

		footer#footer .widget_search {
		  color: <?php print $footer_font_color;?>;
		}

		footer#footer .widget_search #s {
		  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
		  color: <?php print $footer_font_color;?>;
		}

		footer#footer .select-target.select-theme-default {
	  		border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
		}

		footer#footer .dt_widget_accordion .panel-heading {
		  color: <?php print $footer_font_color;?>;
		}
		
		footer#footer .widget_recent_comments a {
		  color: rgba(<?php print $rgbcolor;?>, 0.4);
		}

		footer#footer .woocommerce.widget_product_search #s {
		  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
		}

	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

function get_redux_custom_header($args){

	$cssline="";

	if('transparent'==$args['homepage-background-type']){
		$cssline.=".home #head-page.reveal {background: ".$args['homepage-header-color-transparent'].";box-shadow:none;}";
		$cssline.=".home #head-page.reveal #dt-menu > ul > li > a{ color:".$args['homepage-header-font-color-transparent'].";}";
		$cssline.=".home #head-page.reveal #dt-menu a.search_btn { color:".$args['homepage-header-font-color-transparent'].";}";
		$cssline.="#mobile-header { color:".$args['homepage-header-font-color-transparent'].";}";

		$cssline.=".home #head-page.alt {background: transparent ;box-shadow:none;}";
		$cssline.=".home #head-page.alt #dt-menu > ul > li > a{ color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.alt #dt-menu a.search_btn { color:".$args['homepage-header-font-color'].";}";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color-transparent'].";}";

		$cssline.=".home #top-bar{background: transparent}";
		$cssline.=".top-head #top-bar{background: transparent}";
	}
	else{
 		$cssline.=('#ffffff'!==$args['homepage-header-color'])?".home #head-page {background:".$args['homepage-header-color']."}":"";
 		$cssline.=('#ffffff'!==$args['homepage-header-color'])?".home #head-page.alt {background:".$args['homepage-header-color']."}":"";
 		$cssline.=('#ffffff'!==$args['homepage-header-color'])?".home #head-page.reveal {background:".$args['homepage-header-color']."}":"";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color-transparent'].";}";

 		$cssline.=('#ffffff'!==$args['homepage-header-color'])?".home #top-bar{background:".$args['homepage-header-color']."}":"";
 		$cssline.=('#ffffff'!==$args['homepage-header-color'])?".top-head #top-bar{background:".$args['homepage-header-color']."}":"";
	}

	if('transparent'==$args['header-background-type']){
		$cssline.="#head-page.reveal {background: ".$args['header-color-transparent'].";box-shadow:none;}";
		$cssline.="#head-page.reveal #dt-menu > ul > li > a{ color:".$args['header-font-color-transparent'].";}";
		$cssline.="#head-page.reveal #dt-menu a.search_btn { color:".$args['header-font-color-transparent'].";}";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color-transparent'].";}";

		$cssline.="#head-page.alt {background: transparent ;box-shadow:none;}";
		$cssline.="#head-page.alt #dt-menu > ul > li > a{ color:".$args['header-font-color'].";}";
		$cssline.="#head-page.alt #dt-menu a.search_btn { color:".$args['header-font-color'].";}";

		$cssline.="#top-bar{background: transparent}";
	}
	else{
 		$cssline.=('#ffffff'!==$args['header-color'])?"#head-page {background:".$args['header-color']."}":"";
 		$cssline.=('#ffffff'!==$args['header-color'])?"#head-page.alt {background:".$args['header-color']."}":"";
 		$cssline.=('#ffffff'!==$args['header-color'])?"#head-page.reveal {background:".$args['header-color']."}":"";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color-transparent'].";}";

 		$cssline.=('#ffffff'!==$args['header-color'])?"#top-bar{background:".$args['header-color']."}":"";
	}

	if ('#222222'!==$args['homepage-header-font-color']) {
		$cssline.=".home #head-page,.home #head-page #dt-menu > ul > li > a{color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page #dt-menu a.search_btn {color:".$args['homepage-header-font-color'].";}";
	}

	if ('#222222'!==$args['header-font-color']) {
		$cssline.="#head-page,#head-page #dt-menu > ul > li > a {color:".$args['header-font-color'].";}";
		$cssline.="#head-page,#head-page #dt-menu a.search_btn {color:".$args['header-font-color'].";}";
	}

	if ('#222222'!==$args['header-font-color']) {
	    @list($r, $g, $b) = sscanf($args['header-font-color'], "#%02x%02x%02x");
	    $rgbcolor=$r.','.$g.','.$b;

		$cssline.="#top-bar a {color:".$args['header-font-color'].";}";	
		$cssline.="#top-bar { border-bottom: 1px solid rgba(".$rgbcolor.", 0.3) }";	
	}

	if ('#222222'!==$args['homepage-header-font-color']) {
	    @list($r, $g, $b) = sscanf($args['homepage-header-font-color'], "#%02x%02x%02x");
	    $rgbcolor=$r.','.$g.','.$b;

		$cssline.=".home #top-bar a {color:".$args['homepage-header-font-color'].";}";	
		$cssline.=".home #top-bar { border-bottom: 1px solid rgba(".$rgbcolor.", 0.3) }";	
	}

	// set warna garis dibawah menu utama ketika hover
	$cssline.="#head-page.reveal #dt-menu > ul > li > a span:after, #head-page.reveal #dt-menu > ul > li > a span:before { background: none repeat scroll 0 0 ".$args['header-font-color-transparent']."; }";
	$cssline.="#head-page.alt #dt-menu > ul > li > a span:after, #head-page.alt #dt-menu > ul > li > a span:before { background: none repeat scroll 0 0 ".$args['header-font-color']."; }";

	$cssline.=".home #head-page.reveal #dt-menu > ul > li > a span:after, .home #head-page.reveal #dt-menu > ul > li > a span:before { background: none repeat scroll 0 0 ".$args['homepage-header-font-color-transparent']."; }";
	$cssline.=".home #head-page.alt #dt-menu > ul > li > a span:after, .home #head-page.alt #dt-menu > ul > li > a span:before { background: none repeat scroll 0 0 ".$args['homepage-header-font-color']."; }";

	//set top margin logo for mobile
	if (isset($args['dt-logo-margin-mobile'])&&!empty($args['dt-logo-margin-mobile'])) {
		$cssline.="#head-page #logomenumobile { padding-top: ".$args['dt-logo-margin-mobile']."px; }";
		$cssline.="#head-page #logomenurevealmobile { padding-top: ".$args['dt-logo-margin-mobile']."px; }";
	}

	return $cssline;
}

function get_redux_boxed_layout($args){
	$cssline = "";

	if ($args['boxed_layout_activate'] && isset($args['boxed_layout_boxed_background_image']['url'])){
		$cssline.=".dt-boxed-container { background-image: url(".$args['boxed_layout_boxed_background_image']['url']."); }";
		$cssline.=".dt-boxed-container { background-color: ".$args['boxed_layout_boxed_background_color']."; }";

	}

	return $cssline;
}

if(!function_exists('get_redux_body_style')){
	function get_redux_body_style($args){
		$cssline = "";

		if(isset($args['body_background_image']['url'])){
			$cssline.="body.dt_custom_body { background-image: url(".$args['body_background_image']['url']."); }";
			$cssline.="body.dt_custom_body { background-attachment: fixed; }";
			$cssline.="body.dt_custom_body { background-repeat: no-repeat; }";
			$cssline.="body.dt_custom_body { background-size: cover; }";
		}

		if (isset($args['body_background_color'])&&!empty($args['body_background_color'])) {
			$cssline.="body.dt_custom_body { background-color: ".$args['body_background_color']."; }";	
		}

		if (isset($args['body_text_color'])&&!empty($args['body_text_color'])) {
			$cssline.="body.dt_custom_body { color: ".$args['body_text_color']."; }";
		}

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_menu_margin_top')){
	function get_redux_custom_menu_margin_top($margin_top='') {

		if (empty($margin_top) && ''!==$margin_top) return '';
			
		if (!is_numeric($margin_top)) return '';

		ob_start();
	?>
		#dt-menu.dt-menu-center > ul { margin-top: <?php print $margin_top;?>px; }
		.reveal.alt #dt-menu.dt-menu-center > ul { margin-top: <?php print $margin_top;?>px; }
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_logo_margin_top_reveal')){
	function get_redux_custom_logo_margin_top_reveal($margin_top='') {

		if (empty($margin_top) && ''!==$margin_top) return '';
			
		if (!is_numeric($margin_top)) return '';

		ob_start();
	?>
		#head-page.reveal .dt-menu-center #logomenureveal { margin-top: <?php print $margin_top;?>px;	}
		#head-page.reveal .dt-menu-center #logomenu { margin-top: <?php print $margin_top;?>px;	}
		#head-page.reveal.alt .dt-menu-center #logomenureveal { margin-top: auto;	}
		#head-page.reveal.alt .dt-menu-center #logomenu { margin-top: auto;	}
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_leftbar_menu')){
	function get_redux_leftbar_menu($image='',$horizontal="50",$vertical="100",$size="") {
		$backgroundImage=(isset($image['url']) && ''!=$image['url'])?$image['url']:"";
		$leftPosition=preg_replace('/%/',"",$horizontal)."%";
		$topPosition=preg_replace('/%/',"",$vertical)."%";

		if(!$backgroundImage)
			return "";

		ob_start();

		?>
		.vertical_menu #head-page.reveal{background-image:url(<?php print $backgroundImage;?>);background-repeat:no-repeat;background-position:<?php print $leftPosition." ".$topPosition;?>;<?php if($size!='' && $size!='default'):?>background-size:<?php print $size; endif;?>}
		<?php 

		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}


if(!function_exists('detheme_style_compile')){

function detheme_style_compile($detheme_config=array(),$css=""){

	global $wp_filesystem;

	if(function_exists('icl_register_string')){
		icl_register_string('detheme', 'left-top-bar-text', $detheme_config['dt-left-top-bar-text']);
		icl_register_string('detheme', 'right-top-bar-text', $detheme_config['dt-right-top-bar-text']);
		icl_register_string('detheme', 'footer-text', $detheme_config['footer-text']);
	}


	$cssline=(isset($detheme_config['primary-color']) && '#f16338'!=$detheme_config['primary-color'])?get_redux_custom_primary_color($detheme_config['primary-color']):"";
	$cssline.=(isset($detheme_config['secondary-color']) && '#f16338'!=$detheme_config['secondary-color'])?get_redux_custom_secondary_color($detheme_config['secondary-color']):"";
	$cssline.=(isset($detheme_config['primary-font']) && 'Istok Web'!=$detheme_config['primary-font']['font-family'] && ''!=$detheme_config['primary-font']['font-family'])?get_redux_custom_primary_font($detheme_config['primary-font']['font-family']):"";
	$cssline.=(isset($detheme_config['secondary-font']) && 'Dosis'!=$detheme_config['secondary-font']['font-family'] && ''!=$detheme_config['secondary-font']['font-family'])?get_redux_custom_secondary_font($detheme_config['secondary-font']):"";
	$cssline.=(isset($detheme_config['section-font']) && 'Dosis'!=$detheme_config['section-font']['font-family'] && ''!=$detheme_config['section-font']['font-family'])?get_redux_custom_section_font($detheme_config['section-font']):"";

	$cssline.=(isset($detheme_config['tertiary-font']) && 'Merriweather'!=$detheme_config['tertiary-font']['font-family'] && ''!=$detheme_config['tertiary-font']['font-family'])?get_redux_custom_tertiary_font($detheme_config['tertiary-font']['font-family']):"";
	$cssline.=get_redux_custom_footer($detheme_config);
	$cssline.=get_redux_custom_header($detheme_config);
	$cssline.=get_redux_body_style($detheme_config);
	$cssline.=get_redux_boxed_layout($detheme_config);


	$cssline.=(isset($detheme_config['dt-header-type']) && 'leftbar'==$detheme_config['dt-header-type'])?get_redux_leftbar_menu($detheme_config['dt-menu-image'],$detheme_config['dt-menu-image-horizontal'],$detheme_config['dt-menu-image-vertical'],$detheme_config['dt-menu-image-size']):"";
	$cssline.=(isset($detheme_config['dt-menu-height']))?get_redux_custom_menu_height($detheme_config['dt-menu-height']):"";
	//$cssline.=(isset($detheme_config['dt-menu-margin-top']))?get_redux_custom_menu_margin_top_ul($detheme_config['dt-menu-margin-top']):"";
	$cssline.=(isset($detheme_config['dt-logo-top-padding']))?get_redux_custom_menu_margin_top($detheme_config['dt-logo-top-padding']):"";
	$cssline.=(isset($detheme_config['dt-logo-top-margin-reveal']))?get_redux_custom_logo_margin_top_reveal($detheme_config['dt-logo-top-margin-reveal']):"";

	if(isset($detheme_config['heading-style']) && $detheme_config['heading-style']!=='none'){
		$cssline.="h1,h2,h3,h4,h5,h6{text-transform:".$detheme_config['heading-style']."}";
	}

	$cssline.=(isset($detheme_config['css-code']) && !empty($detheme_config['css-code']))?'
	/* custom css generate from your custom css code*/
	'.$detheme_config['css-code']:"";	

	$blog_id="";
	if ( is_multisite()){
		$blog_id="-site".get_current_blog_id();
	}

	$filename = get_template_directory() . '/css/customstyle'.$blog_id.'.css';

	ob_start();

	?>
/* ================================================ */
/* don't touch this style auto generating by system */
/* ================================================ */
<?php
	$notes=ob_get_contents();
	ob_end_clean();

	if ( !$wp_filesystem->put_contents( $filename, $notes.$cssline) ) {
		$error = $wp_filesystem->errors;

		if('empty_hostname'==$error->get_error_code()){
			$wp_filesystem=new WP_Filesystem_Direct(array());
			if($wp_filesystem){
				if(!$wp_filesystem->put_contents( $filename, $notes.$cssline)){
						$error = $wp_filesystem->errors;
						return new WP_Error('fs_error', __('Filesystem error.'), $error);
				}

			}else{
				return $css;
			}


		}else{

			return $css;
		}
	}
	return $css.$cssline;

}
}

if(!function_exists('detheme_save_license')){


function detheme_save_license($config=array()){

	$template=get_template();
	update_option("detheme_license_$template",$config['detheme_license']);
}

}

add_action( 'redux-saved-detheme_config' ,'detheme_save_license' ); 
add_action('redux-compiler-detheme_config','detheme_style_compile',2);

if(!function_exists('load_detheme_admin_script')){

function load_detheme_admin_script(){
	wp_enqueue_script('detheme-admin-script', DethemeReduxFramework::$_url. 'assets/js/dashboard.js',array('jquery'));
}
}
add_action( 'redux/page/detheme_config/enqueue','load_detheme_admin_script' );

add_action('theme_option_name_update','detheme_style_compile');

function zeyn_update_complete($theme,$hook_extra){

	if('theme'==$hook_extra['type'] && 'update'==$hook_extra['action'] && $theme->skin->theme == get_template()){
		$option_name=apply_filters('theme_option_name','detheme_config');
		$theme_config=get_option($option_name);
		do_action('theme_option_name_update',$theme_config);
	}
}

add_action('upgrader_process_complete','zeyn_update_complete',1,2);

?>