<?php
if ( ! isset( $content_width ) ) $content_width = 2000;

if ( !class_exists( 'DethemeReduxFramework' ) && file_exists( get_template_directory(). '/redux-framework/ReduxCore/framework.php' ) ) {

	locate_template('redux-framework/ReduxCore/framework.php',true);

}
if ( !isset( $detheme_config ) && file_exists( get_template_directory() . '/redux-framework/option/config.php' ) ) {
	locate_template('redux-framework/option/config.php',true);
}
?>