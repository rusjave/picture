<?php
defined('ABSPATH') or die();

global $detheme_Style;

if(version_compare(WPB_VC_VERSION,'4.4.0','<')){
$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = $css = '';

extract(shortcode_atts(array(
    'title' => '',
    'image' => $image,
    'img_size'  => 'thumbnail',
    'img_link_large' => false,
    'img_link' => '',
    'img_link_target' => '_self',
    'alignment' => 'left',
    'el_class' => '',
    'css_animation' => '',
    'style' => '',
    'border_color' => '',
    'css' => '',
    'link' => '',
    'image_hover'=>'',
    'image_hover_src'=>'',
    'image_hover_text'=>'',
    'image_hover_pre_text'=>'',
    'image_hover_type'=>''
), $atts));

$style = ($style!='') ? $style : '';
$border_color = ($border_color!='') ? ' vc_box_border_' . $border_color : '';

$img_id = preg_replace('/[^\d]/', '', $image);
$hover_content="";
if($image_hover!='none'){

    if($image_hover=='image'){
        if($image_hover_content = wpb_getImageBySize(array( 'attach_id' => $image_hover_src, 'thumb_size' => $img_size, 'class' => "image-hover ".$style ))){
            $hover_content=$image_hover_content['thumbnail'];
        }
    }
    else{

         if(""!=$image_hover_text || ""!=$image_hover_pre_text ){
            $hover_content="<div class=\"text-hover\"><div class=\"text-hover-container\"><span class=\"text-hover-pre-title\">".$image_hover_pre_text."</span><h3 class=\"text-hover-title\">".do_shortcode(rawurldecode($image_hover_text))."</h3></div></div>";
        }


    }

    $style.=" image-active";

}

$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => $style.($image_hover!='none'?" hover-type-".$image_hover:"").$border_color ));
if ( $img == NULL ) $img['thumbnail'] = '<img class="'.$style.$border_color.'" src="'.$this->assetUrl('vc/no_image.png').'" />';//' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';

$el_class = $this->getExtraClass($el_class);

$a_class = '';
if ( $el_class != '' ) {
    $tmp_class = explode(" ", strtolower($el_class));
    $tmp_class = str_replace(".", "", $tmp_class);
    if ( in_array("prettyphoto", $tmp_class) ) {
        wp_enqueue_script( 'prettyphoto' );
        wp_enqueue_style( 'prettyphoto' );
        $a_class = ' class="prettyphoto"';
        $el_class = str_ireplace(" prettyphoto", "", $el_class);
    }
}

$link_to = '';
if ( $img_link_large == true ) {
    $link_to = wp_get_attachment_image_src( $img_id, 'large' );
    $link_to = $link_to[0];
} else if ( strlen($link) > 0 ) {
    $link_to = $link;
} else if ( ! empty( $img_link ) ) {
    $link_to = $img_link;
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) $link_to = 'http://' . $link_to;
}

if($hover_content){

    $img['thumbnail'].=$hover_content;
}

 if ( is_string($img_size) && preg_match('/dt_vc_box_diamond/',$style)){

    global $_wp_additional_image_sizes;

    if(in_array($img_size, array('thumbnail','thumb', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' || $img_size == 'thumbnail' ) {
            $thumb_size[] = intval(get_option('thumbnail_size_w'));
        }
        elseif ( $img_size == 'medium' ) {
            $thumb_size[] = intval(get_option('medium_size_w'));
        }
        elseif ( $img_size == 'large' ) {
            $thumb_size[] = intval(get_option('large_size_w'));
        }else{

            $thumb_size[]=$img['p_img_large'][1];
        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){
        $thumb_size[]=$_wp_additional_image_sizes[$img_size]['width'];
    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }
    }
 }

$img_output = preg_match('/vc_box_shadow_3d/',$style) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : 
(preg_match('/dt_vc_box_diamond/',$style)?"<div class=\"ketupat0\"".($thumb_size?" style=\"width:".($thumb_size[0] -($thumb_size[0]*10/100) )."px;height:".($thumb_size[0] -($thumb_size[0]*10/100) )."px\"":"")."><div class=\"ketupat1\"><div class=\"ketupat2\">".$img['thumbnail']."</div></div></div>":$img['thumbnail']);

$image_string = !empty($link_to) ? '<a'.$a_class.' href="'.$link_to.'"'.($img_link_target!='_self' ? ' target="'.$img_link_target.'"' : '').'>'.$img_output.'</a>' : $img_output;
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element'.$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);

$css_class .= ' vc_align_'.$alignment;

$output .= "\n\t".'<div class="'.$css_class." ".$image_hover_type.'">';
$output .= "\n\t\t".'<div class="wpb_wrapper">';
$output .= "\n\t\t\t".wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_singleimage_heading'));
$output .= "\n\t\t\t".$image_string;
$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_single_image');

echo $output;

if(!empty($css)){

    $detheme_Style[]=$css;
}

}
elseif(version_compare(WPB_VC_VERSION,'4.4.0','>=') && version_compare(WPB_VC_VERSION,'4.5.0','<')){

$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = $css = '';

extract( shortcode_atts( array(
    'title' => '',
    'image' => $image,
    'img_size' => 'thumbnail',
    'img_link_large' => false,
    'img_link' => '',
    'link' => '',
    'img_link_target' => '_self',
    'alignment' => 'left',
    'el_class' => '',
    'css_animation' => '',
    'style' => '',
    'border_color' => '',
    'css' => '',
    'image_hover'=>'',
    'image_hover_src'=>'',
    'image_hover_text'=>'',
    'image_hover_pre_text'=>'',
    'image_hover_type'=>''
), $atts ) );

$style = ( $style != '' ) ? $style : '';
$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';

$img_id = preg_replace( '/[^\d]/', '', $image );

$hover_content="";
if($image_hover!='none'){

    if($image_hover=='image'){
        if($image_hover_content = wpb_getImageBySize(array( 'attach_id' => $image_hover_src, 'thumb_size' => $img_size, 'class' => "image-hover ".$style ))){
            $hover_content=$image_hover_content['thumbnail'];
        }
    }
    else{

         if(""!=$image_hover_text || ""!=$image_hover_pre_text ){
            $hover_content="<div class=\"text-hover\"><div class=\"text-hover-container\"><span class=\"text-hover-pre-title\">".$image_hover_pre_text."</span><h3 class=\"text-hover-title\">".do_shortcode(rawurldecode($image_hover_text))."</h3></div></div>";
        }


    }

    $style.=" image-active";

}

$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => $img_size, 'class' => 'vc_single_image-img'.($image_hover!='none'?" hover-type-".$image_hover:"") ) );

if ( $img == NULL ) $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; //' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';

$el_class = $this->getExtraClass( $el_class );

$a_class = '';
if ( $el_class != '' ) {
    $tmp_class = explode( " ", strtolower( $el_class ) );
    $tmp_class = str_replace( ".", "", $tmp_class );
    if ( in_array( "prettyphoto", $tmp_class ) ) {
        wp_enqueue_script( 'prettyphoto' );
        wp_enqueue_style( 'prettyphoto' );
        $a_class = ' class="prettyphoto"' . ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
        $el_class = str_ireplace( " prettyphoto", "", $el_class );
    }
}

$link_to = '';
if ( $img_link_large == true ) {
    $link_to = wp_get_attachment_image_src( $img_id, 'large' );
    $link_to = $link_to[0];
} else if ( strlen($link) > 0 ) {
    $link_to = $link;
} else if ( ! empty( $img_link ) ) {
    $link_to = $img_link;
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) $link_to = 'http://' . $link_to;
}
//to disable relative links uncomment this..


if($hover_content){

    $img['thumbnail'].=$hover_content;
}

 if ( is_string($img_size) && preg_match('/dt_vc_box_diamond/',$style)){

    global $_wp_additional_image_sizes;

    if(in_array($img_size, array('thumbnail','thumb', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' || $img_size == 'thumbnail' ) {
            $thumb_size[] = intval(get_option('thumbnail_size_w'));
        }
        elseif ( $img_size == 'medium' ) {
            $thumb_size[] = intval(get_option('medium_size_w'));
        }
        elseif ( $img_size == 'large' ) {
            $thumb_size[] = intval(get_option('large_size_w'));
        }else{

            $thumb_size[]=$img['p_img_large'][1];
        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){
        $thumb_size[]=$_wp_additional_image_sizes[$img_size]['width'];
    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }
    }
 }


$img_output = ( $style == 'vc_box_shadow_3d' ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' :
(preg_match('/dt_vc_box_diamond/',$style)?"<div class=\"ketupat0\"".($thumb_size?" style=\"width:".($thumb_size[0] -($thumb_size[0]*10/100) )."px;height:".($thumb_size[0] -($thumb_size[0]*10/100) )."px\"":"")."><div class=\"ketupat1\"><div class=\"ketupat2\">".$img['thumbnail']."</div></div></div>":$img['thumbnail']);


$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"'. '><div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div></a>' : '<div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div>';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );

$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . $css_class . ' '.$image_hover_type.'">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );

echo $output;

if(!empty($css)){

    $detheme_Style[]=$css;
}

}
elseif(version_compare(WPB_VC_VERSION,'4.5.0','>=') && version_compare(WPB_VC_VERSION,'4.6.0','<')){


$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $alignment = $css_animation = $css = '';
$exact_size = false;
extract( shortcode_atts( array(
    'title' => '',
    'image' => $image,
    'img_size' => 'thumbnail',
    'img_link_large' => false,
    'img_link' => '',
    'link' => '',
    'img_link_target' => '_self',
    'alignment' => 'left',
    'el_class' => '',
    'css_animation' => '',
    'style' => '',
    'border_color' => '',
    'css' => '',
    'image_hover'=>'',
    'image_hover_src'=>'',
    'image_hover_text'=>'',
    'image_hover_pre_text'=>'',
    'image_hover_type'=>''
), $atts ) );

$style = ( $style != '' ) ? $style : '';
$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';
$img_id = preg_replace( '/[^\d]/', '', $image );
// Set rectangular.
if ( preg_match( '/_circle_2$/', $style ) ) {
    $style = preg_replace( '/_circle_2$/', '_circle', $style );
    $img_size = $this->getImageSquereSize( $img_id, $img_size );
}

$hover_content="";
if($image_hover!='none'){

    if($image_hover=='image'){
        if($image_hover_content = wpb_getImageBySize(array( 'attach_id' => $image_hover_src, 'thumb_size' => $img_size, 'class' => "image-hover ".$style ))){
            $hover_content=$image_hover_content['thumbnail'];
        }
    }
    else{

         if(""!=$image_hover_text || ""!=$image_hover_pre_text ){
            $hover_content="<div class=\"text-hover\"><div class=\"text-hover-container\"><span class=\"text-hover-pre-title\">".$image_hover_pre_text."</span><h3 class=\"text-hover-title\">".do_shortcode(rawurldecode($image_hover_text))."</h3></div></div>";
        }


    }

    $style.=" image-active";

}

$img = wpb_getImageBySize( array(
    'attach_id' => $img_id,
    'thumb_size' => $img_size,
    'class' => 'vc_single_image-img'.($image_hover!='none'?" hover-type-".$image_hover:"")
) );

if ( $img == null ) {
    $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
}//' <small>'.__('This is image placeholder, edit your page to replace it.', 'js_composer').'</small>';


if($hover_content){

    $img['thumbnail'].=$hover_content;
}


$el_class = $this->getExtraClass( $el_class );

$a_class = '';
if ( $el_class != '' ) {
    $tmp_class = explode( " ", strtolower( $el_class ) );
    $tmp_class = str_replace( ".", "", $tmp_class );
    if ( in_array( "prettyphoto", $tmp_class ) ) {
        wp_enqueue_script( 'prettyphoto' );
        wp_enqueue_style( 'prettyphoto' );
        $a_class = ' class="prettyphoto"' . ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
        $el_class = str_ireplace( " prettyphoto", "", $el_class );
    }
}

$link_to = '';
if ( $img_link_large == true ) {
    $link_to = wp_get_attachment_image_src( $img_id, 'large' );
    $link_to = $link_to[0];
} else if ( strlen( $link ) > 0 ) {
    $link_to = $link;
} else if ( ! empty( $img_link ) ) {
    $link_to = $img_link;
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) {
        $link_to = 'http://' . $link_to;
    }
}
//to disable relative links uncomment this..
if($hover_content){

    $img['thumbnail'].=$hover_content;
}

 if ( is_string($img_size) && preg_match('/dt_vc_box_diamond/',$style)){

    global $_wp_additional_image_sizes;

    if(in_array($img_size, array('thumbnail','thumb', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' || $img_size == 'thumbnail' ) {
            $thumb_size[] = intval(get_option('thumbnail_size_w'));
        }
        elseif ( $img_size == 'medium' ) {
            $thumb_size[] = intval(get_option('medium_size_w'));
        }
        elseif ( $img_size == 'large' ) {
            $thumb_size[] = intval(get_option('large_size_w'));
        }else{

            $thumb_size[]=$img['p_img_large'][1];
        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){
        $thumb_size[]=$_wp_additional_image_sizes[$img_size]['width'];
    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }
    }
 }

$img_output = ( $style == 'vc_box_shadow_3d' ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' :
(preg_match('/dt_vc_box_diamond/',$style)?"<div class=\"ketupat0\"".($thumb_size?" style=\"width:".($thumb_size[0] -($thumb_size[0]*10/100) )."px;height:".($thumb_size[0] -($thumb_size[0]*10/100) )."px\"":"")."><div class=\"ketupat1\"><div class=\"ketupat2\">".$img['thumbnail']."</div></div></div>":$img['thumbnail']);

$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"' . '><div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div></a>' : '<div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div>';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );

$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . $css_class . ' '.$image_hover_type.'">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.wpb_single_image' );

echo $output;

if(!empty($css)){

    $detheme_Style[]=$css;
}


}elseif(version_compare(WPB_VC_VERSION,'4.6.0','>=') && version_compare(WPB_VC_VERSION,'4.7.0','<')){


/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $image
 * @var $img_size
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $border_color
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 * Zeyn add on
 * @var $image_hover
 * @var $image_hover_src
 * @var $image_hover_text
 * @var $image_hover_pre_text
 * @var $image_hover_type
 */

$output = '';
$exact_size = false;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$style = ( '' !== $style ) ? $style : '';

$border_color = ( $border_color != '' ) ? ' vc_box_border_' . $border_color : '';
$img_id = preg_replace( '/[^\d]/', '', $image );


$hover_content="";
if($image_hover!='none'){

    if($image_hover=='image'){
        if($image_hover_content = wpb_getImageBySize(array( 'attach_id' => $image_hover_src, 'thumb_size' => $img_size, 'class' => "image-hover ".$style ))){
            $hover_content=$image_hover_content['thumbnail'];
        }
    }
    else{

         if(""!=$image_hover_text || ""!=$image_hover_pre_text ){
            $hover_content="<div class=\"text-hover\"><div class=\"text-hover-container\"><span class=\"text-hover-pre-title\">".$image_hover_pre_text."</span><h3 class=\"text-hover-title\">".do_shortcode(rawurldecode($image_hover_text))."</h3></div></div>";
        }


    }

    $style.=" image-active";

}

// Set rectangular.
if ( preg_match( '/_circle_2$/', $style ) ) {
    $style = preg_replace( '/_circle_2$/', '_circle', $style );
    $img_size = $this->getImageSquereSize( $img_id, $img_size );
}

$img = wpb_getImageBySize( array(
    'attach_id' => $img_id,
    'thumb_size' => $img_size,
    'class' => 'vc_single_image-img'.($image_hover!='none'?" hover-type-".$image_hover:"")
) );

if ( ! $img ) {
    $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
}

$el_class = $this->getExtraClass( $el_class );

$a_class = '';
if ( '' !== $el_class ) {
    $tmp_class = explode( ' ', strtolower( $el_class ) );
    $tmp_class = str_replace( '.', '', $tmp_class );
    if ( in_array( 'prettyphoto', $tmp_class ) ) {
        wp_enqueue_script( 'prettyphoto' );
        wp_enqueue_style( 'prettyphoto' );
        $a_class = ' class="prettyphoto"' . ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"';
        $el_class = str_ireplace( ' prettyphoto', '', $el_class );
    }
}

$link_to = '';
if ( $img_link_large ) {
    $link_to = wp_get_attachment_image_src( $img_id, 'large' );
    $link_to = $link_to[0];
} else if ( strlen( $link ) > 0 ) {
    $link_to = $link;
} else if ( ! empty( $atts['img_link'] ) ) {
    // backward compatibility. will be removed in 4.7+
    $link_to = $atts['img_link'];
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link_to ) ) {
        $link_to = 'http://' . $link_to;
    }
}
//to disable relative links uncomment this..

if($hover_content){

    $img['thumbnail'].=$hover_content;
}


if ( is_string($img_size) && preg_match('/dt_vc_box_diamond/',$style)){

    global $_wp_additional_image_sizes;

    if(in_array($img_size, array('thumbnail','thumb', 'medium', 'large','full'))){

        if ( $img_size == 'thumb' || $img_size == 'thumbnail' ) {
            $thumb_size[] = intval(get_option('thumbnail_size_w'));
        }
        elseif ( $img_size == 'medium' ) {
            $thumb_size[] = intval(get_option('medium_size_w'));
        }
        elseif ( $img_size == 'large' ) {
            $thumb_size[] = intval(get_option('large_size_w'));
        }else{

            $thumb_size[]=$img['p_img_large'][1];
        }

    }
    elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){
        $thumb_size[]=$_wp_additional_image_sizes[$img_size]['width'];
    }
    else{

        preg_match_all('/\d+/', $img_size, $thumb_matches);

        if(isset($thumb_matches[0])) {
            $thumb_size = array();
            if(count($thumb_matches[0]) > 1) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][1]; // height
            } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                $thumb_size[] = $thumb_matches[0][0]; // width
                $thumb_size[] = $thumb_matches[0][0]; // height
            } else {
                $thumb_size = false;
            }
        }
    }
 }

$img_output = ( 'vc_box_shadow_3d' === $style ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' :
(preg_match('/dt_vc_box_diamond/',$style)?"<div class=\"ketupat0\"".($thumb_size?" style=\"width:".($thumb_size[0] -($thumb_size[0]*10/100) )."px;height:".($thumb_size[0] -($thumb_size[0]*10/100) )."px\"":"")."><div class=\"ketupat1\"><div class=\"ketupat2\">".$img['thumbnail']."</div></div></div>":$img['thumbnail']);

$image_string = ! empty( $link_to ) ? '<a' . $a_class . ' href="' . $link_to . '"' . ' target="' . $img_link_target . '"' . '><div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div></a>' : '<div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $img_output . '</div>';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_single_image wpb_content_element' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );

$css_class .= ' vc_align_' . $alignment;

$output .= "\n\t" . '<div class="' . esc_attr( $css_class ) .' '.$image_hover_type.'">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) );
$output .= "\n\t\t\t" . $image_string;
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $this->getShortcode() );

echo $output;

if(!empty($css)){

    $detheme_Style[]=$css;
}


}
else{

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $onclick
 * @var $img_size
 * @var $external_img_size
 * @var $caption
 * @var $img_link_large
 * @var $link
 * @var $img_link_target
 * @var $alignment
 * @var $el_class
 * @var $css_animation
 * @var $style
 * @var $external_style
 * @var $border_color
 * @var $image_hover
 * @var $image_hover_src
 * @var $image_hover_text
 * @var $image_hover_pre_text
 * @var $image_hover_type
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Single_image
 */
$title = $source = $image = $custom_src = $onclick = $img_size = $external_img_size =
$caption = $img_link_large = $link = $img_link_target = $alignment = $el_class = $css_animation = $style = $external_style = $border_color = $css = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$default_src = vc_asset_url( 'vc/no_image.png' );

// backward compatibility. since 4.6
if ( empty( $onclick ) && isset( $img_link_large ) && 'yes' === $img_link_large ) {
    $onclick = 'img_link_large';
} else if ( empty( $atts['onclick'] ) && ( ! isset( $atts['img_link_large'] ) || 'yes' !== $atts['img_link_large'] ) ) {
    $onclick = 'custom_link';
}

if ( 'external_link' === $source ) {
    $style = $external_style;
}

$border_color = ( $border_color !== '' ) ? ' vc_box_border_' . $border_color : '';

$img = $thumb_size = false;
$hover_content="";
switch ( $source ) {
    case 'media_library':
    case 'featured_image':

        if ( 'featured_image' === $source ) {
            $post_id = get_the_ID();
            if ( $post_id && has_post_thumbnail( $post_id ) ) {
                $img_id = get_post_thumbnail_id( $post_id );
            } else {
                $img_id = 0;
            }
        } else {
            $img_id = preg_replace( '/[^\d]/', '', $image );
        }

        // set rectangular
        if ( preg_match( '/_circle_2$/', $style ) ) {
            $style = preg_replace( '/_circle_2$/', '_circle', $style );
            $img_size = $this->getImageSquareSize( $img_id, $img_size );
        }

        if ( ! $img_size ) {
            $img_size = 'medium';
        }



        
        if($image_hover!='none'){

            if($image_hover=='image'){
                if($image_hover_content = wpb_getImageBySize(array( 'attach_id' => $image_hover_src, 'thumb_size' => $img_size, 'class' => "image-hover ".$style ))){
                    $hover_content=$image_hover_content['thumbnail'];
                }
            }
            else{

                 if(""!=$image_hover_text || ""!=$image_hover_pre_text ){
                    $hover_content="<div class=\"text-hover\"><div class=\"text-hover-container\"><span class=\"text-hover-pre-title\">".$image_hover_pre_text."</span><h3 class=\"text-hover-title\">".do_shortcode(rawurldecode($image_hover_text))."</h3></div></div>";
                }

            }

            $style.=" image-active";

        }

        $img = wpb_getImageBySize( array(
            'attach_id' => $img_id,
            'thumb_size' => $img_size,
            'class' => 'vc_single_image-img'.($image_hover!='none'?" hover-type-".$image_hover:"")
        ) );

        // don't show placeholder in public version if post doesn't have featured image
        if ( 'featured_image' === $source ) {
            if ( ! $img && 'page' === vc_manager()->mode() ) {
                return;
            }
        }



        if ( is_string($img_size) && preg_match('/dt_vc_box_diamond/',$style)){

            global $_wp_additional_image_sizes;

            if(in_array($img_size, array('thumbnail','thumb', 'medium', 'large','full'))){

                if ( $img_size == 'thumb' || $img_size == 'thumbnail' ) {
                    $thumb_size[] = intval(get_option('thumbnail_size_w'));
                }
                elseif ( $img_size == 'medium' ) {
                    $thumb_size[] = intval(get_option('medium_size_w'));
                }
                elseif ( $img_size == 'large' ) {
                    $thumb_size[] = intval(get_option('large_size_w'));
                }else{

                    $thumb_size[]=$img['p_img_large'][1];
                }

            }
            elseif(!empty($_wp_additional_image_sizes[$img_size]) && is_array($_wp_additional_image_sizes[$img_size])){
                $thumb_size[]=$_wp_additional_image_sizes[$img_size]['width'];
            }
            else{

                preg_match_all('/\d+/', $img_size, $thumb_matches);

                if(isset($thumb_matches[0])) {
                    $thumb_size = array();
                    if(count($thumb_matches[0]) > 1) {
                        $thumb_size[] = $thumb_matches[0][0]; // width
                        $thumb_size[] = $thumb_matches[0][1]; // height
                    } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                        $thumb_size[] = $thumb_matches[0][0]; // width
                        $thumb_size[] = $thumb_matches[0][0]; // height
                    } else {
                        $thumb_size = false;
                    }
                }
            }
         }

        break;

    case 'external_link':
        $dimensions = vcExtractDimensions( $external_img_size );
        $hwstring = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

        $custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;

        $img = array(
            'thumbnail' => '<img class="vc_single_image-img" ' . $hwstring . ' src="' . $custom_src . '" />'
        );
        break;

    default:
        $img = false;
}

if ( ! $img ) {
    $img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . $default_src . '" />';
}

if($hover_content){

    $img['thumbnail'].=$hover_content;
}


$el_class = $this->getExtraClass( $el_class );

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
    $onclick = 'link_image';
}

// backward compatibility. will be removed in 4.7+
if ( ! empty( $atts['img_link'] ) ) {
    $link = $atts['img_link'];
    if ( ! preg_match( '/^(https?\:\/\/|\/\/)/', $link ) ) {
        $link = 'http://' . $link;
    }
}

// backward compatibility
if ( in_array( $link, array( 'none', 'link_no' ) ) ) {
    $link = '';
}

$a_attrs = array();

switch ( $onclick ) {
    case 'img_link_large':

        if ( 'external_link' === $source ) {
            $link = $custom_src;
        } else {
            $link = wp_get_attachment_image_src( $img_id, 'large' );
            $link = $link[0];
        }

        break;

    case 'link_image':
        wp_enqueue_script( 'prettyphoto' );
        wp_enqueue_style( 'prettyphoto' );

        $a_attrs['class'] = 'prettyphoto';
        $a_attrs['rel'] = 'prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']';

        // backward compatibility
        if ( vc_has_class( 'prettyphoto', $el_class ) ) {
            // $link is already defined
        } else if ( 'external_link' === $source ) {
            $link = $custom_src;
        } else {
            $link = wp_get_attachment_image_src( $img_id, 'large' );
            $link = $link[0];
        }

        break;

    case 'custom_link':
        // $link is already defined
        break;

    case 'zoom':
        wp_enqueue_script( 'vc_image_zoom' );

        if ( 'external_link' === $source ) {
            $large_img_src = $custom_src;
        } else {
            $large_img_src = wp_get_attachment_image_src( $img_id, 'large' );
            if ( $large_img_src ) {
                $large_img_src = $large_img_src[0];
            }
        }

        $img['thumbnail'] = str_replace( '<img ', '<img data-vc-zoom="' . $large_img_src . '" ', $img['thumbnail'] );

        break;
}

// backward compatibility
if ( vc_has_class( 'prettyphoto', $el_class ) ) {
    $el_class = vc_remove_class( 'prettyphoto', $el_class );
}

$html = ( 'vc_box_shadow_3d' === $style ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' :
(preg_match('/dt_vc_box_diamond/',$style)?"<div class=\"ketupat0\"".($thumb_size?" style=\"width:".($thumb_size[0] -($thumb_size[0]*10/100) )."px;height:".($thumb_size[0] -($thumb_size[0]*10/100) )."px\"":"")."><div class=\"ketupat1\"><div class=\"ketupat2\">".$img['thumbnail']."</div></div></div>":$img['thumbnail']);



//$html = ( 'vc_box_shadow_3d' === $style ) ? '<span class="vc_box_shadow_3d_wrap">' . $img['thumbnail'] . '</span>' : $img['thumbnail'];
$html = '<div class="vc_single_image-wrapper ' . $style . ' ' . $border_color . '">' . $html . '</div>';

if ( $link ) {
    $a_attrs['href'] = $link;
    $a_attrs['target'] = $img_link_target;
    $html = '<a ' . vc_stringify_attributes( $a_attrs ) . '>' . $html . '</a>';
}

$class_to_filter = 'wpb_single_image wpb_content_element vc_align_' . $alignment . ' ' . $this->getCSSAnimation( $css_animation );
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if ( in_array( $source, array( 'media_library', 'featured_image' ) ) && 'yes' === $add_caption ) {
    $post = get_post( $img_id );
    $caption = $post->post_excerpt;
} else {
    if ( 'external_link' === $source ) {
        $add_caption = 'yes';
    }
}

if ( 'yes' === $add_caption && '' !== $caption ) {
    $html = '
        <figure class="vc_figure">
            ' . $html . '
            <figcaption class="vc_figure-caption">' . esc_html( $caption ) . '</figcaption>
        </figure>
    ';
}

$output = '
    <div class="' . esc_attr( trim( $css_class ) ) . '">
        <div class="wpb_wrapper">
            ' . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) ) . '
            ' . $html . '
        </div>
    </div>
';

echo $output;
if(!empty($css)){

    $detheme_Style[]=$css;
}


}
?>