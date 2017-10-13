<?php
defined('ABSPATH') or die();

function add_font_selector($buttons) {    
    
    $buttons[] = 'fontselect';

    return $buttons;
}

add_filter('mce_buttons_2', 'add_font_selector');

function load_google_webfonts() {
    $font = 'http://fonts.googleapis.com/css?family=Share+Tech%7CDroid+Sans%7CLobster%7CFenix%7CUnkempt%7CFlavors%7CViga%7CDamion%7COleo+Script%7CRacing+Sans+One%7CNixie+One%7CFredoka+One%7COpen+Sans%7COverlock+SC%7CBubbler+One%7CContrail+One%7CGochi+Hand%7CRoboto+Condensed%7CRusso+One%7CCinzel+Decorative%7CNews+Cycle%7CMarcellus+SC%7CChewy%7CQuicksand%7CSanchez%7CSignika+Negative%7CGloria+Hallelujah%7CGrand+Hotel%7CDroid+Serif%7CEnglebert%7COswald%7CPacifico%7CTitan+One%7CShadows+Into+Light%7CDancing+Script%7CLuckiest+Guy%7CParisienne%7CComing+Soon%7CBaumans%7CBelgrano';
    add_editor_style( $font);
}

add_action( 'init', 'load_google_webfonts' );

function get_font_list($in){

    $font_formats=array(
       "Andale Mono"=>"Andale Mono=andale mono,times",
        "Arial"=>"Arial=arial,helvetica,sans-serif",
        "Arial Black"=>"Arial Black=arial black,avant garde",
        "Book Antiqua"=>"Book Antiqua=book antiqua,palatino",
        "Comic Sans MS"=>"Comic Sans MS=comic sans ms,sans-serif",
        "Courier New"=>"Courier New=courier new,courier",
        "Georgia"=>"Georgia=georgia,palatino",
        "Helvetica"=>"Helvetica=helvetica",
        "Impact"=>"Impact=impact,chicago",
        "Symbol"=>"Symbol=symbol",
        "Tahoma"=>"Tahoma=tahoma,arial,helvetica,sans-serif",
        "Terminal"=>"Terminal=terminal,monaco",
        "Times New Roman"=>"Times New Roman=times new roman,times",
        "Trebuchet MS"=>"Trebuchet MS=trebuchet ms,geneva",
        "Verdana"=>"Verdana=verdana,geneva",
        "Webdings"=>"Webdings=webdings",
        "Wingdings"=>"Wingdings=wingdings,zapf dingbats"
    );

    $font_formats=array();

    $fonts=@explode(";","Droid Sans;Open Sans;Tangerine;Josefin Slab;Arvo;Lato;Vollkorn;Abril Fatface;Ubuntu;PT Sans;PT Serif;Old Standard TT");

    foreach ($fonts as $value) {

        $value=trim($value);
        $font_formats[$value]=$value."=".$value;
    }
    @ksort($font_formats);
    $in['font_formats']=@implode(";", $font_formats);
 
 return $in;
}

add_filter('tiny_mce_before_init', 'get_font_list');

function load_google_font(){

    $font = 'http://fonts.googleapis.com/css?family=Droid+Sans%7COpen+Sans%7CTangerine%7CJosefin+Slab%7CArvo%7CLato%7CVollkorn%7CAbril+Fatface%7CUbuntu%7CPT+Sans%7CPT+Serif%7COld+Standard+TT';
    //wp_enqueue_style('google-font', $font); 
}

add_action('wp_enqueue_scripts','load_google_font');
?>