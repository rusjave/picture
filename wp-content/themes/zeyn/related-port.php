<?php
defined('ABSPATH') or die();

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */
global $dt_revealData,$detheme_config;

$imageId=get_post_thumbnail_id(get_the_ID());
$featured_image = wp_get_attachment_image_src( $imageId,'full',false);
$alt_image = get_post_meta($imageId, '_wp_attachment_image_alt', true);

if ($featured_image) {
	$imgurl = aq_resize($featured_image[0], 400, 400,true);


     if ($detheme_config['dt-select-modal-effects']=='') { 
        $md_effect = 'md-effect-15';
      } else {
        $md_effect = $detheme_config['dt-select-modal-effects'];
      } 

   


	 $output_popup="";


      $output_popup = '<div id="modal_related_port_'.$imageId.'" class="popup-gallery md-modal '.$md_effect.'">
        <div class="md-content secondary_color_bg">
          <img src="#" rel="'. esc_url($featured_image[0]) .'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>';
      if(has_excerpt()):
      
      $output_popup.='<div class="md-description secondary_color_bg">'."
        " . get_the_excerpt() . '
          </div>';
      endif;

      $output_popup.='<button class="secondary_color_button md-close"><i class="icon-cancel"></i></button>
        </div>
      </div>'."\n";

      array_push($dt_revealData, $output_popup);



}

?>
<div class="col-xs-3 related-port portfolio-item">
	<figure>
		<?php if($featured_image!=''):?>
		<div class="top-image">
			<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php print esc_url(($imgurl)?$imgurl:$featured_image[0]);?>" title="" />
		</div>
	<?php endif;?>
		<figcaption class="tertier_color_bg_transparent">
<?php if(get_the_tags()):?>
			<div class="related-tag"><?php the_tags('',', ');?></div>
<?php endif;?>
			<h2 class="related-title"><?php the_title();?></h2>
		<div class="nav-slide">
			<?php if(!empty($output_popup)):?>
			<a onclick="return false;" data-modal="modal_related_port_<?php print $imageId;?>" class="secondary_color_button md-trigger btn icon-zoom-in skin-light"></a>
			<?php endif;?>

			<a href="<?php the_permalink();?>" class="secondary_color_button btn btn-primary icon-link-1 skin-light"></a>
		</div>
		</figcaption>
		
	</figure>
</div>
