<?php
defined('ABSPATH') or die();

global $post,$dt_revealData, $detheme_config;

$thumb_size=$post->grid_thumb_size;
$attachment_id=get_post_thumbnail_id($post->id);

if ( is_string($thumb_size) ) {
            preg_match_all('/\d+/', $thumb_size, $thumb_matches);
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

if($thumb_size){

    $p_img = wpb_resize($attachment_id, null, $thumb_size[0], $thumb_size[0], true);

   $post->thumbnail = '<img src="'.$p_img['url'].'" class="img-responsive" alt="" />';
}
else{
   $post->thumbnail = wp_get_attachment_image( $attachment_id, 'large', false, array('class' => 'img-responsive') );
}

$modal_effect = (empty($detheme_config['dt-select-modal-effects'])) ? 'md-effect-15' : $detheme_config['dt-select-modal-effects'];
$modalcontent = '<div id="modal_post_'.$post->id.'" class="md-modal '.$modal_effect.'">
	<div class="md-content"><img src="#" rel="'.$post->thumbnail_data['p_img_large'][0].'" class="img-responsive" alt=""/>		
		<div class="md-description secondary_color_bg">'.$post->title.'</div>
		<button class="md-close secondary_color_button"><i class="icon-cancel"></i></button>
	</div>
</div>';

array_push($dt_revealData,$modalcontent);


?>
<div class="post-image-container">
<?php 
if(!empty($post->thumbnail)):;?>
<div class="post-image">
	<?php print $post->thumbnail;?>	
</div>
<?php endif;?>
<div class="imgcontrol tertier_color_bg_transparent">
	<div class="imgbuttons">
		<a class="md-trigger btn icon-zoom-in secondary_color_button skin-light" data-modal="modal_post_<?php echo $post->id; ?>" onclick="return false;" href="<?php print $post->link; ?>"></a>
		<a class="btn icon-link secondary_color_button skin-light" target="<?php echo $post->link_target;?>" href="<?php print $post->link; ?>"></a>
	</div>
</div>
</div>