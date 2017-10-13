
jQuery.noConflict();
jQuery(document).ready(function($){
	'use strict';
  var $select = $('select#dt-left-top-bar-select'),
  $showtopbar=$('#detheme_config-showtopbar .cb-enable,#detheme_config-showtopbar .cb-disable'),
  $menusource = $('#detheme_config-dt-left-top-bar-menu').parents('.form-table tr'),
  $textsource = $('#detheme_config-dt-left-top-bar-text').parents('.form-table tr'),
  $rselect = $('select#dt-right-top-bar-select'),
  $rmenusource = $('#detheme_config-dt-right-top-bar-menu').parents('.form-table tr'),
  $rtextsource = $('#detheme_config-dt-right-top-bar-text').parents('.form-table tr'),
  $devider1 = $('#detheme_config-devider-1').closest('.form-table tr'),
  $devider2 = $('#detheme_config-devider-2').closest('.form-table tr'),
  $headersetting=$('#detheme_config-dt-show-header'),
  $backgroundImage = $('#detheme_config-dt-banner-image').parents('.form-table tr'),
  $backgroundColor = $('#detheme_config-banner-color').parents('.form-table tr'),
  $background=$('select#dt-show-banner-page-select'),
  $sequenceslide=$('#detheme_config-homeslide').parents('.form-table tr'),
  $showslide=$('#detheme_config-showslide .cb-enable,#detheme_config-showslide .cb-disable'),
  $homebackground=$('select#homepage-background-type-select'),
  $homebackgroundColor = $('#detheme_config-homepage-header-color').parents('.form-table tr'),
  $pagebackground=$('select#header-background-type-select'),
  $pagebackgroundColor = $('#detheme_config-header-color').parents('.form-table tr'),
  $usefeaturedimage = $('#detheme_config-use-featured-image').parents('.form-table tr'),
  $shopbackgroundColor = $('#detheme_config-dt-shop-banner-image').parents('.form-table tr'),
  $showfooterwidget=$('#detheme_config-showfooterwidget .cb-enable,#detheme_config-showfooterwidget .cb-disable'),
  $footerwidget=$('#detheme_config-dt-footer-widget-column').parents('.form-table tr');

  var $dtshowheader =$('#detheme_config-dt-show-header .cb-enable,#detheme_config-dt-show-header .cb-disable'),
  $dtshowheader_child=$('#detheme_config-dt-show-header').closest('.form-table tr');

  var $showbannerarea =$('#detheme_config-show-banner-area .cb-enable,#detheme_config-show-banner-area .cb-disable'),
  $showbannerarea_child=$('#detheme_config-show-banner-area').closest('.form-table tr');

  var $headerlayout=$('input[name="detheme_config[dt-header-type]"]'),
  $bgmenuimage=$('#detheme_config-dt-menu-image').parents('.form-table tr'),
  $bgmenuimagehorizontal=$('#detheme_config-dt-menu-image-horizontal').parents('.form-table tr'),
  $bgmenuimagesize=$('#detheme_config-dt-menu-image-size').parents('.form-table tr'),
  $bgmenuimagevertical=$('#detheme_config-dt-menu-image-vertical').parents('.form-table tr');

  var $scrollingsidebar =$('#detheme_config-dt_scrollingsidebar_on .cb-enable,#detheme_config-dt_scrollingsidebar_on .cb-disable'),
  $scrollingsidebar_position=$('#detheme_config-dt_scrollingsidebar_position').closest('.form-table tr'),
  $scrollingsidebar_margin=$('#detheme_config-dt_scrollingsidebar_margin').closest('.form-table tr');

  var $boxed_layout_activate =$('#detheme_config-boxed_layout_activate .cb-enable,#detheme_config-boxed_layout_activate .cb-disable'),
  $boxed_layout_boxed_background_image=$('#detheme_config-boxed_layout_boxed_background_image').closest('.form-table tr'),
  $boxed_layout_boxed_background_color=$('#detheme_config-boxed_layout_boxed_background_color').closest('.form-table tr');

  var $lightbox_1st_on =$('#detheme_config-lightbox_1st_on .cb-enable,#detheme_config-lightbox_1st_on .cb-disable'),
  $lightbox_1st_title=$('#detheme_config-lightbox_1st_title').closest('.form-table tr'),
  $lightbox_1st_delay=$('#detheme_config-lightbox_1st_delay').closest('.form-table tr'),
  $lightbox_1st_cookie=$('#detheme_config-lightbox_1st_cookie').closest('.form-table tr'),
  $lightbox_1st_content=$('#detheme_config-lightbox_1st_content').closest('.form-table tr');


  if ($('input[name="detheme_config[dt-header-type]"]:checked').val()=="leftbar") {

    $bgmenuimage.fadeIn('slow');
    $bgmenuimagehorizontal.fadeIn('slow');
    $bgmenuimagevertical.fadeIn('slow');
    $bgmenuimagesize.fadeIn('slow');
  } else {
    $bgmenuimage.fadeOut('slow');
    $bgmenuimagehorizontal.fadeOut('slow');
    $bgmenuimagevertical.fadeOut('slow');
    $bgmenuimagesize.fadeOut('slow');

  }

  $headerlayout.live('change',function(){

    if ($(this).val()=='leftbar') {
    $bgmenuimage.fadeIn('slow');
    $bgmenuimagehorizontal.fadeIn('slow');
    $bgmenuimagevertical.fadeIn('slow');
    $bgmenuimagesize.fadeIn('slow');
    } else {
    $bgmenuimagesize.fadeOut('slow');
    $bgmenuimage.fadeOut('slow');
    $bgmenuimagehorizontal.fadeOut('slow');
    $bgmenuimagevertical.fadeOut('slow');
    }
  });

  $background.live('change',function(){

    var background = $(this).val();
    switch ( background ) {
      case 'image':
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeIn('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeIn('slow');
        }
        break;
      case 'featured':
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeIn('slow');
        $usefeaturedimage.fadeIn('slow');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeIn('slow');
        }
        break;
      case 'color':
        $backgroundColor.fadeIn('fast');
        $backgroundImage.fadeOut('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeOut('fast');
        }

        break;
      default:
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeOut('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeOut('fast');
        }

      }

  });


  $select.live('change',function(){

    var this_value = $(this).val();

    switch ( this_value ) {
      case 'text':
        $menusource.fadeOut('fast');
        $textsource.fadeIn('slow');
        break;
      case 'menu':
      case 'icon':
        $textsource.fadeOut('fast');
        $menusource.fadeIn('slow');
        break;
      default:
        $textsource.fadeOut('fast');
        $menusource.fadeOut('slow');

    }


   });

  $homebackground.live('change',function(){

     var this_value = $(this).val();

     var $homepageHeaderColorTransparent = $('#detheme_config-homepage-header-color-transparent').parents('.form-table tr'),
     $homepageHeaderFontColorTransparent = $('#detheme_config-homepage-header-font-color-transparent').parents('.form-table tr'),
     $homepageDTLogoImageTransparent = $('#detheme_config-homepage-dt-logo-image-transparent').parents('.form-table tr');
     
    switch ( this_value ) {
      case 'transparent':
        $homebackgroundColor.fadeOut('fast');
        $homepageHeaderColorTransparent.fadeIn('slow');
        $homepageHeaderFontColorTransparent.fadeIn('slow');
        $homepageDTLogoImageTransparent.fadeIn('slow');
        break;
      case 'solid':
      default:
        $homebackgroundColor.fadeIn('slow');
        $homepageHeaderColorTransparent.fadeOut('fast');
        $homepageHeaderFontColorTransparent.fadeOut('fast');
        $homepageDTLogoImageTransparent.fadeOut('fast');
    }

  });

  $pagebackground.live('change',function(){

     var this_value = $(this).val();

     var $headerColorTransparent = $('#detheme_config-header-color-transparent').parents('.form-table tr'),
     $headerFontColorTransparent = $('#detheme_config-header-font-color-transparent').parents('.form-table tr'),
     $dtLogoImageTransparent = $('#detheme_config-dt-logo-image-transparent').parents('.form-table tr');

    switch ( this_value ) {
      case 'transparent':
        $pagebackgroundColor.fadeOut('fast');
        $headerColorTransparent.fadeIn('slow');
        $headerFontColorTransparent.fadeIn('slow');
        $dtLogoImageTransparent.fadeIn('slow');
        break;
      case 'solid':
      default:
        $pagebackgroundColor.fadeIn('slow');
        $headerColorTransparent.fadeOut('fast');
        $headerFontColorTransparent.fadeOut('fast');
        $dtLogoImageTransparent.fadeOut('fast');
    }

  });

  $rselect.live('change',function(){

    var this_value = $(this).val();

    switch ( this_value ) {
      case 'text':
        $rmenusource.fadeOut('fast');
        $rtextsource.fadeIn('slow');
        break;
      case 'menu':
      case 'icon':
        $rtextsource.fadeOut('fast');
        $rmenusource.fadeIn('slow');
        break;
      default:
        $rtextsource.fadeOut('fast');
        $rmenusource.fadeOut('slow');

    }


   });

  $showslide.live('click',function(e){

    e.preventDefault();

    if($(this).hasClass('cb-enable')){

      if($(this).hasClass('selected')){

          $sequenceslide.fadeIn('fast');

      }

    }else{
      if($(this).hasClass('selected')){

          $sequenceslide.fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $sequenceslide.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){

          $sequenceslide.fadeOut('fast');
      }
    }

  });

  $showfooterwidget.live('click',function(e){


    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $footerwidget.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){

          $footerwidget.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $footerwidget.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){

          $footerwidget.fadeOut('fast');
      }
    }

  });

  $showtopbar.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){

        $menusource.fadeIn('fast');
        $textsource.fadeIn('fast');
        $rselect.closest('.form-table tr').fadeIn('fast');
        $select.closest('.form-table tr').fadeIn('fast');
        $rmenusource.fadeIn('fast');
        $rtextsource.fadeIn('fast');
        $devider1.fadeIn('fast');
        $devider2.fadeIn('fast');

        $select.trigger('change');
        $rselect.trigger('change');

      }

    }else{
      if($(this).hasClass('selected')){
        $menusource.fadeOut('fast');
        $textsource.fadeOut('fast');
        $rselect.closest('.form-table tr').fadeOut('fast');
        $select.closest('.form-table tr').fadeOut('fast');
        $rmenusource.fadeOut('fast');
        $rtextsource.fadeOut('fast');
        $devider1.fadeOut('fast');
        $devider2.fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $menusource.fadeIn('fast');
        $textsource.fadeIn('fast');
        $rselect.closest('.form-table tr').fadeIn('fast');
        $select.closest('.form-table tr').fadeIn('fast');
        $rmenusource.fadeIn('fast');
        $rtextsource.fadeIn('fast');
        $devider1.fadeIn('fast');
        $devider2.fadeIn('fast');
        $select.trigger('change');
        $rselect.trigger('change');

      }
    }else{
      if($(this).hasClass('selected')){

        $menusource.fadeOut('fast');
        $textsource.fadeOut('fast');
        $rselect.closest('.form-table tr').fadeOut('fast');
        $select.closest('.form-table tr').fadeOut('fast');
        $rmenusource.fadeOut('fast');
        $rtextsource.fadeOut('fast');
        $devider1.fadeOut('fast');
        $devider2.fadeOut('fast');
      }
    }

  });

 
  $dtshowheader.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
         $dtshowheader_child.siblings().fadeIn('fast');
         $homebackground.trigger('change');
         $pagebackground.trigger('change');
      }

    }else{
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeIn('fast');
         $homebackground.trigger('change');
         $pagebackground.trigger('change');
      }
    }else{
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeOut('fast');
      }
    }

  });
 
  $showbannerarea.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeIn('fast');
        $background.trigger('change');
      }

    }else{
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeIn('fast');
        $background.trigger('change');
      }
    }else{
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeOut('fast');
      }
    }

  });

$lightbox_1st_on.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeIn('fast');
          $lightbox_1st_delay.fadeIn('fast');
          $lightbox_1st_cookie.fadeIn('fast');
          $lightbox_1st_content.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeOut('fast');
          $lightbox_1st_delay.fadeOut('fast');
          $lightbox_1st_cookie.fadeOut('fast');
          $lightbox_1st_content.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeIn('fast');
          $lightbox_1st_delay.fadeIn('fast');
          $lightbox_1st_cookie.fadeIn('fast');
          $lightbox_1st_content.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeOut('fast');
          $lightbox_1st_delay.fadeOut('fast');
          $lightbox_1st_cookie.fadeOut('fast');
          $lightbox_1st_content.fadeOut('fast');
      }
    }

  });

  $scrollingsidebar.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeIn('fast');
        $scrollingsidebar_margin.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeOut('fast');
        $scrollingsidebar_margin.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeIn('fast');
        $scrollingsidebar_margin.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeOut('fast');
        $scrollingsidebar_margin.fadeOut('fast');
      }
    }

  });

  $boxed_layout_activate.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeIn('fast');
        $boxed_layout_boxed_background_color.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeOut('fast');
        $boxed_layout_boxed_background_color.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeIn('fast');
        $boxed_layout_boxed_background_color.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeOut('fast');
        $boxed_layout_boxed_background_color.fadeOut('fast');
      }
    }

  });

   $showtopbar.trigger('change');
   $showbannerarea.trigger('change');
   $dtshowheader.trigger('change');
   $showslide.trigger('change');
   $showfooterwidget.trigger('change');
   $lightbox_1st_on.trigger('change');
   $scrollingsidebar.trigger('change');
   $boxed_layout_activate.trigger('change');

 });
