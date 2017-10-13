<?php

/**
 *
 * this part from portfolio layout
 *
 * @package WordPress
 * @subpackage Zeyn
 * @since Zeyn 1.0
 */
global $dt_revealData,$detheme_config;
$terms = get_the_terms(get_the_ID(), 'portcat' );
$cssitem=array();
$term_lists=array();
$attachment_id=get_post_thumbnail_id(get_the_ID());
$featured_image = wp_get_attachment_image_src($attachment_id ,'full',false); 
$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

$modal_effect = (empty($detheme_config['dt-select-modal-effects'])) ? 'md-effect-15' : $detheme_config['dt-select-modal-effects'];

$column=get_query_var('column');
$imageSize=($column <=4)?640:400;
$show_link=get_query_var('show_link',true);


if($featured_image){

	$image=aq_resize($featured_image[0], $imageSize, $imageSize, true, true, true);
}

if ( !empty( $terms ) ) {
      
      foreach ( $terms as $term ) {
        $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
        $term_lists[]="<a href=\"".get_term_link( $term)."\">".$term->name."</a>";
      }

}



$modalcontent='<div id="modal_portfolio_'.get_the_ID().'" class="popup-gallery md-modal '.$modal_effect.'">
	<div class="md-content">'.($featured_image?'<img src="#" rel="'.esc_url($featured_image[0]).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>':"").'		
		<div class="md-description secondary_color_bg">'.get_the_excerpt().'</div>
		<button class="secondary_color_button md-close"><i class="icon-cancel"></i></button>
	</div>
</div>';

array_push($dt_revealData,$modalcontent);
?>
<div id="port-<?php print get_the_ID();?>" <?php post_class('portfolio-item '.@implode(' ',$cssitem),get_the_ID()); ?>>
<div class="post-image-container">
	<?php if ($featured_image) : ?>
	<div class="post-image">
		<img class="img-responsive" src="<?php print esc_url(($image)?$image:$featured_image[0]); ?>" alt="<?php print esc_attr($alt_image);?>" />
	</div>
	<?php endif;?>
	<div class="imgcontrol tertier_color_bg_transparent">
		<div class="portfolio-termlist"><?php print (count($term_lists))?@implode(', ',$term_lists):"";?></div>
		<div class="portfolio-title"><?php the_title();?></div>
		<div class="imgbuttons">
			<a class="md-trigger btn icon-zoom-in secondary_color_button btn skin-light" data-modal="modal_portfolio_<?php print get_the_ID();?>" onclick="return false;" href="<?php the_permalink(); ?>"></a>
			<?php if($show_link):?><a class="btn icon-link-1 secondary_color_button btn skin-light" href="<?php the_permalink(); ?>"></a><?php endif;?>
		</div>
	</div>
</div>
</div>