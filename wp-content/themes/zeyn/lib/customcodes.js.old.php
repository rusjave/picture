<?php
@header('Content-Type: application/x-javascript;');
$plugin_path=str_replace(basename(dirname(__FILE__))."/".basename(__FILE__),"",$_SERVER['PHP_SELF']);
?>
(function() {
    tinymce.create('tinymce.plugins.dtshortcode', {
        init : function(ed, url) {
			ed.addCommand("dtPopup", function ( a, params )
			{
				var popup = params.identifier;
				// load thickbox
				tb_show("DT Shortcode", url+"/shortcode.php?type="+popup+"&height=400&TB_iframe=true");
			});
        },
		
		createControl: function ( btn, e )
		{
		
			if ( btn == "dtshortcode" )
			{	
			
				var a = this;				
				var btn = e.createSplitButton('dt_button', {
                    title: "DT Shortcode",
					image: "<?php print $plugin_path;?>lib/images/dt_icon.png",
					icons: true
                });
				
				 btn.onRenderMenu.add(function (c, b)
				{					
					a.addWithPopup( b, "Icon", "icon" );
					a.addWithPopup( b, "Buttons", "button" );
					a.addWithPopup( b, "Count To", "counto" );
				});
				return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("dtPopup", false, {
						title: title,
						identifier: id,
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		}
	});
    tinymce.PluginManager.add('dtshortcode', tinymce.plugins.dtshortcode);
})();
