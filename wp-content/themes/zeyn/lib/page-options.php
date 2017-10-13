<?php 
defined('ABSPATH') or die();

global $detheme_config;

$defaultsettings=array(
	'dt-header-type'=>'left',
	'show-banner-area'=>true,
	'dt-show-banner-page'=>'none',
	'dt-show-header'=>1,
	'homepage-dt-logo-image'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
	'homepage-dt-logo-image-transparent'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
	'dt-logo-width'=>'',
	'use-featured-image'=>'',
	'showtopbar'=>true,
	'dt-left-top-bar'=>'',
	'dt-right-top-bar'=>'',
	'meta-keyword'=>'',
	'meta-description'=>'',
	'meta-author'=>'',
	'primary-color'=>'#f16338',
	'dt-main-menu'=>'',
	'show-header-searchmenu'=>true,
	'show-header-shoppingcart'=>true,
	'boxed_layout_activate'=>false,
	'footer-code'=>'',
	'dt-sticky-menu'=>true,
	'showfooterwidget'=>true,
	'dt-show-title-page'=>false,
	'page_loader'=>true,
	'dt-footer-widget-column'=>3,
	'banner-darkend'=>0,
	'lightbox_1st_on'=>0,
	'footer-text'=>'© '.date('Y').' '.sprintf(__('%s, The Awesome Theme. All right reserved.','detheme'),get_template())

);

$detheme_config=wp_parse_args($detheme_config,$defaultsettings);
/* title */

$detheme_config['body_background']=$detheme_config['body_tag']="";
$post_id=get_the_id();
//$template=basename(get_page_template());


if(is_front_page()){

	$detheme_config['page-title']=get_bloginfo('name');

	if(get_post_meta( get_the_id(),'_hide_lightbox', true )){
		$detheme_config['lightbox_1st_on']=false;
	}

	if(get_post_meta( $post_id,'_hide_loader', true )){
		$detheme_config['page_loader']=false;
	}

	if(get_post_meta( $post_id,'_hide_popup', true )){
		$detheme_config['exitpopup']="";
	}

	$page_background=get_post_meta( $post_id,'_page_background', true );
	$background_style=get_post_meta( $post_id, '_background_style', true );

	if($page_background){

		$style=getBackgroundStyle($page_background,$background_style);

		$detheme_config['body_background']="body{".$style['css']."}";
		$detheme_config['body_tag']=$style['body'];

	}

}
elseif(is_page()){


	$detheme_config['page-title']=the_title('','',false);

	if(get_post_meta( $post_id,'_hide_lightbox', true )){
		$detheme_config['lightbox_1st_on']=false;
	}

	if(get_post_meta( $post_id,'_hide_loader', true )){
		$detheme_config['page_loader']=false;
	}

	if(get_post_meta( $post_id,'_hide_popup', true )){
		$detheme_config['exitpopup']="";
	}

	$page_background=get_post_meta( $post_id,'_page_background', true );
	$background_style=get_post_meta( $post_id, '_background_style', true );

	if($page_background){

		$style=getBackgroundStyle($page_background,$background_style);
		$detheme_config['body_background']="body{".$style['css']."}";
		$detheme_config['body_tag']=$style['body'];

	}

}
elseif(is_category()){

	$detheme_config['page-title']=sprintf(__('Category : %s','detheme'), single_cat_title( ' ', false ));

}
elseif(is_archive()){


	$title="";

	if(is_tag()){

		$title=sprintf(__('Tag : %s','detheme'), single_tag_title( ' ', false ));
	}
	elseif(is_tax()){
		$title=single_tag_title( ' ', false );
	}
	elseif(function_exists('is_shop') && is_shop()){

		$title=woocommerce_page_title(false);

		$post_id=get_option( 'woocommerce_shop_page_id');

		 $hide_title=get_post_meta( $post_id, '_hide_title', true );


		if(get_post_meta( $post_id,'_hide_lightbox', true )){
			$detheme_config['lightbox_1st_on']=false;
		}

		if(get_post_meta( $post_id,'_hide_loader', true )){
			$detheme_config['page_loader']=false;
		}

		if(get_post_meta( $post_id,'_hide_popup', true )){
			$detheme_config['exitpopup']="";
		}

		$page_background=get_post_meta( $post_id,'_page_background', true );
		$background_style=get_post_meta( $post_id, '_background_style', true );

		if($page_background){

			$style=getBackgroundStyle($page_background,$background_style);
			$detheme_config['body_background']="body{".$style['css']."}";
			$detheme_config['body_tag']=$style['body'];

		}


	}	
	else{
		$title=sprintf(__('Archive : %s','detheme'), single_month_title( ' ', false ));

	}

	$detheme_config['page-title']=$title;

}
elseif(is_search()){
		$detheme_config['page-title']=__('Search','detheme');
}
elseif(is_home()){


	 $post_id=get_option( 'page_for_posts');
	 $title=get_the_title($post_id);
	 $detheme_config['page-title']=$title;

	if(get_post_meta( $post_id,'_hide_lightbox', true )){
		$detheme_config['lightbox_1st_on']=false;
	}

	if(get_post_meta( $post_id,'_hide_loader', true )){
		$detheme_config['page_loader']=false;
	}

	if(get_post_meta( $post_id,'_hide_popup', true )){
		$detheme_config['exitpopup']="";
	}

	$page_background=get_post_meta( $post_id,'_page_background', true );
	$background_style=get_post_meta( $post_id, '_background_style', true );

	if($page_background){

		$style=getBackgroundStyle($page_background,$background_style);
		$detheme_config['body_background']="body{".$style['css']."}";
		$detheme_config['body_tag']=$style['body'];

	}


}
else{

	$detheme_config['page-title']=the_title('','',false);

	if(get_post_meta( get_the_id(),'_hide_lightbox', true )){
		$detheme_config['lightbox_1st_on']=false;
	}

	if(get_post_meta( $post_id,'_hide_loader', true )){
		$detheme_config['page_loader']=false;
	}

	if(get_post_meta( $post_id,'_hide_popup', true )){
		$detheme_config['exitpopup']="";
	}
}

if($meta_description = get_post_meta( $post_id, '_meta_description', true )){
	$detheme_config['meta-description']=$meta_description;
}

if($meta_keyword = get_post_meta( $post_id, '_meta_keyword', true )){
	$detheme_config['meta-keyword']=$meta_keyword;
}

if($meta_author = get_post_meta( $post_id, '_meta_author', true )){
	$detheme_config['meta-author']=$meta_author;
}


/* banner section */
if($detheme_config['show-banner-area']){
	
	$detheme_config['banner']="";
	$detheme_config['bannercolor']="";
	add_filter('woocommerce_show_page_title',create_function('','return false;'));

	switch ($detheme_config['dt-show-banner-page']) {
		case 'featured':


				if(function_exists('is_product')  && (is_product() || is_product_category())){

					$banner=$detheme_config['dt-shop-banner-image'];
					if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;

					}
					elseif($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )){

						$detheme_config['banner']=$image[0];
					}else{
						$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
					}
				}
				elseif(function_exists('is_shop') && is_shop()){

					$banner=$detheme_config['dt-shop-banner-image'];
					$post_id=get_option( 'woocommerce_shop_page_id');

					if($hide_title=get_post_meta( $post_id, '_hide_title', true )){
						$detheme_config['dt-show-title-page']=false;
					}


					if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;

					}

					elseif(!isset($detheme_config['use-featured-image']) && $featuredImage=get_post_thumbnail_id($post_id)){

						$featured_img_fullsize_url = wp_get_attachment_image_src( $featuredImage, 'full' );

						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;
					}
					elseif($detheme_config['use-featured-image'] && $featuredImage=get_post_thumbnail_id($post_id)) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $featuredImage, 'full' );

						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;
					}
					elseif($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )){

						$detheme_config['banner']=$image[0];
					}else{
						$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
					}
				}
				elseif(is_page() || is_single()){

					if($hide_title=get_post_meta( $post_id, '_hide_title', true )){
						$detheme_config['dt-show-title-page']=false;
					}

					if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );

						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;
					}
/*  handle for version below 1.0.7 */
					elseif(!isset($detheme_config['use-featured-image']) && $featuredImage=get_post_thumbnail_id($post_id)){

						$featured_img_fullsize_url = wp_get_attachment_image_src( $featuredImage, 'full' );

						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;
					}
					elseif($detheme_config['use-featured-image'] && $featuredImage=get_post_thumbnail_id($post_id)) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $featuredImage, 'full' );

						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
						if(!empty($banner)) $detheme_config['banner']=$banner;
					}
/*  handle for version below 1.0.7 */

					else {
						$banner=$detheme_config['dt-banner-image']['url'];
						if(!empty($banner)) {
							$detheme_config['banner']=$banner;
						} else {
							$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
						}
					}
				
				}
				elseif(is_home()){

					 $post_id=get_option( 'page_for_posts');
					 $hide_title=get_post_meta( $post_id, '_hide_title', true );

					 if($hide_title)
					 		$detheme_config['dt-show-title-page']=false;

					if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

						$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
						$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:$bannerdefault;
						if(!empty($banner)) $detheme_config['banner']=$banner;
					} else {
						$banner=$detheme_config['dt-banner-image'];
						if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) {
							$detheme_config['banner']=$image[0];
						} else {
							$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
						}
					}


				}
				elseif(is_category() || is_archive() || is_search() || is_front_page()){
					$banner=$detheme_config['dt-banner-image'];
					if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) {
							$detheme_config['banner']=$image[0];
					} else {
						$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
					}
				}
			break;
		case 'image':
	
				$banner=$detheme_config['dt-banner-image'];

				if(function_exists('is_product')  && (is_product() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_product_category())){
					$banner=$detheme_config['dt-shop-banner-image'];
				}
				elseif(is_page() || is_single()){

					if($hide_title=get_post_meta( $post->ID, '_hide_title', true )){

						$detheme_config['dt-show-title-page']=false;
					}

				}
				elseif(is_home()){

					 $post_id=get_option( 'page_for_posts');
					 $hide_title=get_post_meta( $post_id, '_hide_title', true );

					 if($hide_title)
					 		$detheme_config['dt-show-title-page']=false;
				}
				elseif(function_exists('is_shop') && is_shop()){

					$post_id=get_option( 'woocommerce_shop_page_id');
					$banner=$detheme_config['dt-shop-banner-image'];
					 $hide_title=get_post_meta( $post_id, '_hide_title', true );

					 if($hide_title){
					 		$detheme_config['dt-show-title-page']=false;
					 }
				}

			if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) { 
				$detheme_config['banner']=$image[0];
			} else {
				$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
			}
			break;
		case 'color':
			$detheme_config['bannercolor']=(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";
			break;
		case 'none':
		default:
				if(is_page()){

					if($hide_title=get_post_meta( $post->ID, '_hide_title', true )){
						$detheme_config['dt-show-title-page']=false;
					}


				}
				elseif(is_home()){

					 $post_id=get_option( 'page_for_posts');
					 $hide_title=get_post_meta( $post_id, '_hide_title', true );

					 if($hide_title)
					 		$detheme_config['dt-show-title-page']=false;
				}
				elseif(function_exists('is_shop') && is_shop()){

					$post_id=get_option( 'woocommerce_shop_page_id');
					 $hide_title=get_post_meta( $post_id, '_hide_title', true );

					 if($hide_title){
					 		$detheme_config['dt-show-title-page']=false;
					 }
				}
			break;
	}



	if($detheme_config['dt-show-title-page']){
		$detheme_config['dt-show-banner-title']=true;
		$detheme_config['dt-show-title-page']=false;
	}
}
else{

	if(is_page() && !is_front_page()){
			if($hide_title=get_post_meta( $post->ID, '_hide_title', true )){
				$detheme_config['dt-show-title-page']=false;
			}
	}
	elseif(is_front_page()){
		$detheme_config['dt-show-title-page']=false;
		add_filter('woocommerce_show_page_title',create_function('','return false;'));
	}
	elseif(is_home()){
		 $post_id=get_option( 'page_for_posts');
		 $hide_title=get_post_meta( $post_id, '_hide_title', true );

		 if($hide_title)
		 		$detheme_config['dt-show-title-page']=false;
	}

	elseif(is_category() || is_archive()){
		$detheme_config['dt-show-title-page']=true;
		if(function_exists('is_shop') && is_shop()){

				 $post_id=get_option( 'woocommerce_shop_page_id');

				 $hide_title=get_post_meta( $post_id, '_hide_title', true );

				 if($hide_title){
				 		add_filter('woocommerce_show_page_title',create_function('','return false;'));
				 		$detheme_config['dt-show-title-page']=false;
				 }
			}
	}
	$detheme_config['dt-show-banner-title']=false;
	$detheme_config['banner']="";
	$detheme_config['bannercolor']="";//(!empty($detheme_config['banner-color']))?$detheme_config['banner-color']:"";		
}

/* header section */
if($detheme_config['dt-show-header']){

	if(is_front_page() || is_detheme_home(get_post())){
		$detheme_config['dt-logo-image']=$detheme_config['homepage-dt-logo-image'];
		$detheme_config['dt-logo-image-transparent']=$detheme_config['homepage-dt-logo-image-transparent'];
;
	}

	$detheme_config['logo-width']=(!empty($detheme_config['dt-logo-image']['url']) && (int)$detheme_config['dt-logo-width'] > 0 )?$detheme_config['dt-logo-width']:"";
	$detheme_config['logo-top']=(!empty($detheme_config['dt-logo-margin']) && (int)$detheme_config['dt-logo-margin'] !== '0' )?(int)$detheme_config['dt-logo-margin']:"";
	$detheme_config['logo-left']=(!empty($detheme_config['dt-logo-leftmargin']) && (int)$detheme_config['dt-logo-leftmargin'] !== '0' )?(int)$detheme_config['dt-logo-leftmargin']:"";
}
else{
	$detheme_config['logo-width']="";
	$detheme_config['logo-top']="";
	$detheme_config['logo-left']="";
}

/* top-bar section */

if($detheme_config['showtopbar']){
	$detheme_config['showtopbar']=( 
		(
			(($detheme_config['dt-left-top-bar']=='menu' || $detheme_config['dt-left-top-bar']=='icon') && $detheme_config['dt-left-top-bar-menu']!='') ||
			$detheme_config['dt-left-top-bar']=='text' && $detheme_config['dt-left-top-bar-text']!=''
		)
		|| 
		(
			(($detheme_config['dt-right-top-bar']=='menu' || $detheme_config['dt-right-top-bar']=='icon') && $detheme_config['dt-right-top-bar-menu']!='') ||
			$detheme_config['dt-right-top-bar']=='text' && $detheme_config['dt-right-top-bar-text']!=''
		)

		)?true:false;
}

function getBackgroundStyle($image_id,$background_style=""){

	$featured_img_fullsize_url = wp_get_attachment_image_src( $image_id, 'full' );

	$css_background="";
	$backgroundattr="";

	if ( isset($featured_img_fullsize_url[0]) and !empty($featured_img_fullsize_url[0]) ) :

		$css_background="background-image:url('".$featured_img_fullsize_url[0]."') !important;";

		switch($background_style){
		    case'parallax':
		        $parallax=" data-speed=\"3\" data-type=\"background\" ";
		        $backgroundattr="background-position: 0% 0%; background-repeat: no-repeat; background-size: cover";
		        break;
		    case'parallax_all':
		        $parallax=" data-speed=\"3\" data-type=\"background\" ";
		        $backgroundattr="background-position: 0% 0%; background-repeat: repeat; background-size: cover";
		        break;
		    case'cover':
		        $parallax="";
		        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
		        break;
		    case'cover_all':
		        $parallax="";
		        $backgroundattr="background-position: center !important; background-repeat: repeat !important; background-size: cover!important";
		        break;
		    case'no-repeat':
		        $parallax="";
		        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
		        break;
		    case'repeat':
		        $parallax="";
		        $backgroundattr="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
		        break;
		    case'contain':
		        $parallax="";
		        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
		        break;
		    case 'fixed':
		        $parallax="";
		        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
		        break;
		    default:
		        $parallax=$backgroundattr="";
		        break;
		}

	endif; //if ( isset($featured_img_fullsize_url[0]) and !empty($featured_img_fullsize_url[0]) )

	return array('css'=>$css_background.$backgroundattr,'body'=>$parallax);
}

?>