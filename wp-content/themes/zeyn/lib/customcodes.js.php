<?php
@header('Content-Type: application/x-javascript;');
$plugin_path=str_replace(basename(dirname(__FILE__))."/".basename(__FILE__),"",$_SERVER['PHP_SELF']);
?>
(function($) {
'use strict';

	tinymce.PluginManager.add( 'dtshortcode', function( editor, url ) {

		editor.addCommand("dtPopup", function ( a, params )
		{
		var popup = params.identifier;
			tb_show("Insert DT Shortcode", url+"/shortcode.php?type="+popup+"&height=400&TB_iframe=true");
		});

		editor.addButton( 'dtshortcode', {
		    type: 'splitbutton',
		    icon: 'dt_code',
			title: 'DT Shortcode',
			onclick : function(e) {},
				menu: [
				{text: 'Icon',icon: 'dt_icon',onclick:function(){
				editor.execCommand("dtPopup", false, {title: 'Icon',icon: 'dt_icon',identifier: 'icon'})
				}},
				{text: 'Buttons',icon: 'dt_button',onclick:function(){
				editor.execCommand("dtPopup", false, {title: 'Buttons',identifier: 'button'})
				}},
				{text: 'Count To',icon: 'dt_counto',onclick:function(){
				editor.execCommand("dtPopup", false, {title: 'Count To',icon: 'dt_counto',identifier: 'counto'})
				}}
				]
	         });
	         
	});
	         
 
})(jQuery);
