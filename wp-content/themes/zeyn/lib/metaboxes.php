<?php
defined('ABSPATH') or die();

add_action( 'save_post', 'save_detheme_metaboxes' );
add_action( 'save_post', 'save_seo_metaboxes' );

function save_seo_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if(!wp_verify_nonce( isset($_POST['detheme_seo_metaboxes'])?$_POST['detheme_seo_metaboxes']:"", 'detheme_seo_metaboxes'))
    return;

     $old = get_post_meta( $post_id, '_meta_description', true );
     $new = (isset($_POST['meta_description']))?strip_tags($_POST['meta_description']):'';
     
     update_post_meta( $post_id, '_meta_description', $new,$old );

     $old = get_post_meta( $post_id, '_meta_keyword', true );
     $new = (isset($_POST['meta_keyword']))?strip_tags($_POST['meta_keyword']):'';
     
     update_post_meta( $post_id, '_meta_keyword', $new,$old );

     $old = get_post_meta( $post_id, '_meta_author', true );
     $new = (isset($_POST['meta_author']))?strip_tags($_POST['meta_author']):'';
     
     update_post_meta( $post_id, '_meta_author', $new,$old );
}

function save_detheme_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if(!wp_verify_nonce( isset($_POST['detheme_page_metaboxes'])?$_POST['detheme_page_metaboxes']:"", 'detheme_page_metaboxes'))
    return;

     $old = get_post_meta( $post_id, '_sidebar_position', true );
     $new = (isset($_POST['_sidebar_position']))?$_POST['_sidebar_position']:'';
     
     update_post_meta( $post_id, '_sidebar_position', $new,$old );

     $old = get_post_meta( $post_id, '_portfoliocolumn', true );
     $new = (isset($_POST['portfoliocolumn']))?$_POST['portfoliocolumn']:'';
     
     update_post_meta( $post_id, '_portfoliocolumn', $new,$old );

     $old = get_post_meta( $post_id, '_portfoliotype', true );
     $new = (isset($_POST['portfoliotype']))?$_POST['portfoliotype']:'';
     
     update_post_meta( $post_id, '_portfoliotype', $new,$old );

     $old = get_post_meta( $post_id, '_hide_lightbox', true );
     $new = (isset($_POST['hide_lightbox']))?$_POST['hide_lightbox']:'';
     
     update_post_meta( $post_id, '_hide_lightbox', $new,$old );

     $old = get_post_meta( $post_id, '_hide_title', true );
     $new = (isset($_POST['hide_title']))?$_POST['hide_title']:'';

     update_post_meta( $post_id, '_hide_title', $new,$old );

     $old = get_post_meta( $post_id, '_hide_loader', true );
     $new = (isset($_POST['hide_loader']))?$_POST['hide_loader']:'';

     update_post_meta( $post_id, '_hide_loader', $new,$old );

     $old = get_post_meta( $post_id, '_hide_popup', true );
     $new = (isset($_POST['hide_popup']))?$_POST['hide_popup']:'';

     update_post_meta( $post_id, '_hide_popup', $new,$old );

     if('page'==get_post_type()){

       $old = get_post_meta( $post_id, '_background_style', true );
       $new = (isset($_POST['background_style']))?$_POST['background_style']:'';

       update_post_meta( $post_id, '_background_style', $new,$old );

       $old = get_post_meta( $post_id, '_page_background', true );
       $new = (isset($_POST['page_background']))?$_POST['page_background']:'';

       update_post_meta( $post_id, '_page_background', $new,$old );
    }


     if(isset($_POST['page_banner'])){

       $old = get_post_meta( $post_id, '_page_banner', true );
       $new = $_POST['page_banner'];
       update_post_meta( $post_id, '_page_banner', $new,$old );
     }    
}


function dt_page_metaboxes() {

  $defaultpost=array(
    'page'=>__('Page Attributes','detheme'),
    'post'=>__('Page Attributes','detheme'),
    'port'=>__('Page Attributes','detheme'),
    'product'=>__('Page Attributes','detheme')
  );

  $posttypes=apply_filters('dt_page_metaboxes',$defaultpost);

  if(count($posttypes)){
    foreach ($posttypes as $posttype => $title) {
      remove_meta_box('pageparentdiv', $posttype,'side');
      add_meta_box('dtpageparentdiv',  ($title==""?__('Page Attributes','detheme'):$title), 'dt_page_attributes_meta_box', $posttype, 'side', 'core');
    }

  }
}

function dt_seo_metaboxes(){

  $defaultpost=array(
    'page'=>__('Page SEO','detheme'),
    'post'=>__('Post SEO','detheme'),
    'port'=>__('Portfolio SEO','detheme'),
    'product'=>__('Product SEO','detheme')
  );

  $posttypes=apply_filters('dt_seo_metaboxes',$defaultpost);

  if(count($posttypes)){
    foreach ($posttypes as $posttype => $title) {
      add_meta_box('dtseometa',  ($title==""?__('SEO','detheme'):$title), 'dt_page_seo_meta_box', $posttype, 'side', 'core');
    }

  }
}

add_action( 'admin_menu' , 'dt_page_metaboxes');
add_action( 'admin_menu' , 'dt_seo_metaboxes');

function dt_page_seo_meta_box($post){
  wp_nonce_field( 'detheme_seo_metaboxes','detheme_seo_metaboxes');
  $meta_description=get_post_meta( $post->ID, '_meta_description', true );
  $meta_keyword=get_post_meta( $post->ID, '_meta_keyword', true );
  $meta_author=get_post_meta( $post->ID, '_meta_author', true );
  ?>
<p><strong><?php _e('Meta Author', 'detheme');?> :</strong></p>
<p><input type="text" name="meta_author" id="meta-author" class="widefat" value="<?php print $meta_author;?>" /></p>
<p><strong><?php _e('Meta Keyword', 'detheme');?> :</strong></p>
<p><textarea name="meta_keyword" id="meta-keyword" class="widefat"><?php print $meta_keyword;?></textarea></p>
<p><?php _e('Type your meta keyword separed by comma. Googlebot loves it if it\'s not exceeding 160 characters or 20 words.', 'detheme');?></p>
<p><strong><?php _e('Meta Description', 'detheme');?> :</strong></p>
<p><textarea name="meta_description" id="meta-description" class="widefat"><?php print $meta_description;?></textarea></p>
<p><?php _e('Type your meta description. Googlebot loves it if it\'s not exceeding 160 characters or 20 words.', 'detheme');?></p>
<?php 

}

function dt_page_attributes_meta_box($post) {

  wp_register_script('detheme-media',get_template_directory_uri() . '/lib/js/media.min.js', array('jquery','media-views','media-editor'),'',false);
  wp_enqueue_script('detheme-media');

  wp_localize_script( 'detheme-media', 'dtb_i18nLocale', array(
      'select_image'=>__('Select Image','detheme'),
      'insert_image'=>__('Insert Image','detheme'),
      'insert_video'=>__('Insert Video','detheme'),
      'select_video'=>__('Select Video','detheme'),
  ));
  wp_nonce_field( 'detheme_page_metaboxes','detheme_page_metaboxes');

  do_action('dt_page_attribute_metaboxes',$post);
  do_action('after_dt_page_attribute');
}


function dt_page_attribute_post_parent($post){

  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {

    $dropdown_args = array(
      'post_type'        => $post->post_type,
      'exclude_tree'     => $post->ID,
      'selected'         => $post->post_parent,
      'name'             => 'parent_id',
      'show_option_none' => __('(no parent)','detheme'),
      'sort_column'      => 'menu_order, post_title',
      'echo'             => 0,
    );

    $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
    $pages = wp_dropdown_pages( $dropdown_args );

  if ( ! empty($pages) ) {?>
<p><strong><?php _e('Parent','detheme') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent','detheme') ?></label>
<?php echo $pages; 
    } // end empty pages check
  } // end hierarchical check.

}

function dt_page_attribute_checkbox($post){

  global $detheme_config;

?>
<p><input type="checkbox" name="hide_title" id="hide_title" value="1" <?php echo ($post->_hide_title)?'checked="checked"':""?>/> <?php _e('Hide title','detheme') ?></strong></p>
<p><input type="checkbox" name="hide_lightbox" id="hide_lightbox" value="1" <?php echo ($post->_hide_lightbox)?'checked="checked"':""?>/> <?php _e('Disable Lightbox 1st Visit','detheme') ?></strong></p>
<p><input type="checkbox" name="hide_loader" id="hide_loader" value="1" <?php echo ($post->_hide_loader)?'checked="checked"':""?>/> <?php _e('Disable Page Loader','detheme') ?></strong></p>
<p><input type="checkbox" name="hide_popup" id="hide_popup" value="1" <?php echo ($post->_hide_popup)?'checked="checked"':""?>/> <?php _e('Disable Exit Popup','detheme') ?></strong></p>
<?php 
}

function dt_page_attribute_page_template($post){

  if ( 'page' != $post->post_type )
      return true;

  $template = !empty($post->page_template) ? $post->page_template : false;
  $templates = get_page_templates();
  $sidebar_position=array('sidebar-left'=>__('Left','detheme'),'sidebar-right'=>__('Right','detheme'),'nosidebar'=>__('No Sidebar','detheme'));


  if (!is_plugin_active('detheme-portfolio/detheme_port.php')) {
    unset($templates['Portfolio Template']);
  }
  ksort( $templates );
   ?>
<p><strong><?php _e('Template','detheme') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template','detheme'); ?></label><select name="page_template" id="page_template">
<option value='default'><?php _e('Default Template','detheme'); ?></option>
<?php 

if(count($templates)):

foreach (array_keys( $templates ) as $tmpl )
    : if ( $template == $templates[$tmpl] )
      $selected = " selected='selected'";
    else
      $selected = '';
  echo "\n\t<option value='".$templates[$tmpl]."' $selected>".__($tmpl,'detheme')."</option>";
  endforeach;
  endif;?>
 ?>
</select>
<div id="custommeta">
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portfolio">
      <p><strong><?php esc_html_e( 'Select Layout Type', 'detheme' ); ?></strong><br/>
      <select name="portfoliotype" id="portfoliotype">
        <option value="image"<?php print ("image"==$post->_portfoliotype || empty($post->_portfoliotype) || !isset($post->_portfoliotype))?" selected":"";?>><?php _e('Squared Image (boxed)','detheme');?></option>;
        <option value="text"<?php print ("text"==$post->_portfoliotype)?" selected":"";?>><?php _e('Image and Text (boxed)','detheme');?></option>;
        <option value="imagefull"<?php print ("imagefull"==$post->_portfoliotype)?" selected":"";?>><?php _e('Squared Image(full)','detheme');?></option>;
        <option value="imagefixheightfull"<?php print ("imagefixheightfull"==$post->_portfoliotype)?" selected":"";?>><?php _e('Fix Height Image(full)','detheme');?></option>;
      </select>
</p>
</div>
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portcolumn">
      <p><strong><?php esc_html_e( 'Select Column', 'detheme' ); ?></strong>&nbsp;
      <select name="portfoliocolumn" id="portfoliocolumn">
<?php 
for($col=3;$col<7;$col++) {
  print "<option value='".$col."'".(($post->_portfoliocolumn==$col)?" selected":"").">".sprintf(__('%d Column','detheme'),$col)."</option>";
}
?>
</select>
</p>
</div>
<p id="sidebar_option">
  <strong><?php _e('Sidebar Position','detheme') ?></strong>&nbsp;
<select name="_sidebar_position" id="sidebar_position">
<option value='default'><?php _e('Default','detheme'); ?></option>
<?php foreach ($sidebar_position as $position=>$label) {
  print "<option value='".$position."'".(($post->_sidebar_position==$position)?" selected":"").">".ucwords($label)."</option>";

}?>
</select>
</p>
</div>
<p><strong><?php _e('Order','detheme') ?></strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php _e('Order','detheme') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
<p><?php _e( 'Need help? Use the Help tab in the upper right of your screen.','detheme' ); ?></p>
<script type="text/javascript">
jQuery(document).ready(function($) {
  'use strict'; 

  var $select = $('select#page_template'),$custommeta = $('#custommeta'),$portfoliotype = $('select#portfoliotype'),$background_style=$('#background_style');
    
  $select.live('change',function(){
    var this_value = $(this).val();
    switch ( this_value ) {
      case 'squeeze.php':
      case 'squeezeboxed.php':
            $custommeta.find('#sidebar_option').fadeOut('slow');
            $custommeta.find('.dt_portfolio').fadeOut('slow');
            $custommeta.find('.dt_portcolumn').fadeOut('slow');
        break;
      case 'fullwidth.php':
            $custommeta.find('#sidebar_option').fadeOut('slow');
            $custommeta.find('.dt_portfolio').fadeOut('slow');
            $custommeta.find('.dt_portcolumn').fadeOut('slow');
        break;
      case 'portfolio.php':
        $custommeta.find('#sidebar_option').fadeIn('slow');
        $custommeta.find('.dt_portfolio').fadeIn('slow');
        $custommeta.find('.dt_portcolumn').fadeIn('slow');
        $portfoliotype.trigger('change');
        break;
      default:
         $custommeta.find('.dt_portfolio').fadeOut('slow');
         $custommeta.find('.dt_portcolumn').fadeOut('slow');
         $custommeta.find('#sidebar_option').fadeIn('slow');
    }

  });
  
  $portfoliotype.live('change',function(){
    var this_value = $(this).val();

    switch ( this_value ) {
      case 'imagefull':
           $custommeta.find('.dt_portcolumn option[value="5"]').show();
           $custommeta.find('.dt_portcolumn option[value="6"]').show();
           $custommeta.find('.dt_portcolumn').fadeIn('slow');
           $custommeta.find('#sidebar_option').fadeOut('slow');
          break;
      case 'imagefixheightfull':
          $custommeta.find('.dt_portcolumn').fadeOut('slow');
          $custommeta.find('#sidebar_option').fadeOut('slow');
        break;
      default:
         $custommeta.find('.dt_portcolumn option[value="5"]').removeProp('selected').hide();
         $custommeta.find('.dt_portcolumn option[value="6"]').removeProp('selected').hide();
         $custommeta.find('.dt_portcolumn').fadeIn('slow');
         $custommeta.find('#sidebar_option').fadeIn('slow');
        break;
    }

  });

  $select.trigger('change');
});
</script>
<?php  
}

function dt_page_attribute_page_background($post){

if ( 'page' != $post->post_type )
  return true;

  $background_image=get_post_meta($post->ID, '_page_background', true);
  $background_style=get_post_meta( $post->ID, '_background_style', true );
  $image="";
  $styles = array(
      __("Cover", 'wpb') => 'cover',
      __("Cover All", 'wpb') => 'cover_all',
      __('Contain', 'wpb') => 'contain',
      __('No Repeat', 'wpb') => 'no-repeat',
      __('Repeat', 'wpb') => 'repeat',
      __("Parallax", 'detheme') => 'parallax',
      __("Parallax All", 'detheme') => 'parallax_all',
      __("Fixed", 'detheme') => 'fixed',
    );

  if($background_image){

    $image = wp_get_attachment_image( $background_image, array( 266,266 ));
  }

  ?>
<div class="detheme-field-image page-background">
  <p><strong><?php _e('Background Image','detheme');?></strong>
  <input type="hidden" name="page_background" value="<?php print $background_image;?>" />
  <p class="preview-image">
  <a title="<?php _e('Set background image','detheme');?>" href="#" id="set-page-background" class="add_detheme_image"><?php echo (""!==$image)?$image:__('Set background image','detheme');?></a>
  </p>
  <a title="<?php _e('Remove background image','detheme');?>" style="display:<?php echo (""==$image)?"none":"block";?>" href="#" id="clear-page-background" class="remove_detheme_image"><?php _e('Remove background image','detheme');?></a>
</div>
 <div  id="background_style"><strong><?php _e('Background Style','detheme');?></strong>&nbsp;
  <select name="background_style">
  <option value="default"><?php _e('Default','detheme');?></option>
  <?php 
  foreach ($styles as $name=>$style) {
    print "<option value='".$style."'".(($background_style==$style)?" selected":"").">".ucwords($name)."</option>";

  }
  ?>
  </select>
</div>
<?php   
}

function dt_page_attribute_page_banner($post){

  global $detheme_config;

  if($detheme_config['dt-show-banner-page']!='featured' || !$detheme_config['show-banner-area'])
    return true;

  $banner_image=get_post_meta($post->ID, '_page_banner', true);
  $banner_image_url="";

  if($banner_image){

    $banner_image_url = wp_get_attachment_image( $banner_image, array( 266,266 ));
  }
?>
<div class="detheme-field-image page-banner">
  <p><strong><?php _e('Banner Image','detheme');?></strong>
  <input type="hidden" name="page_banner" value="<?php print $banner_image;?>" />
  <p class="preview-image">
  <a title="<?php _e('Set Page Banner','detheme');?>" href="#" id="set-page-banner" class="add_detheme_image"><?php echo (""!==$banner_image_url)?$banner_image_url:__('Set Page Banner','detheme','detheme');?></a>
  </p>
  <a title="<?php _e('Remove Page Banner','detheme');?>" style="display:<?php echo (""==$banner_image_url)?"none":"block";?>" href="#" id="clear-page-banner" class="remove_detheme_image"><?php _e('Remove Page Banner','detheme');?></a>
</div>
<?php
}

add_action ('dt_page_attribute_metaboxes','dt_page_attribute_checkbox');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_post_parent');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_template');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_banner');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_background');
?>