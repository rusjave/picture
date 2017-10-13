<?php
defined('ABSPATH') or die();

global $post,$detheme_config;

$content=get_post($post->id);

        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(gallery)"                     // 2: Shortcode name
        . '(?![\\w-])'                       // Not followed by word character or hyphen
        . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
        .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
        .     '(?:'
        .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
        .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
        .     ')*?'
        . ')'
        . '(?:'
        .     '(\\/)'                        // 4: Self closing tag ...
        .     '\\]'                          // ... and closing bracket
        . '|'
        .     '\\]'                          // Closing bracket
        .     '(?:'
        .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
        .             '[^\\[]*+'             // Not an opening bracket
        .             '(?:'
        .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
        .                 '[^\\[]*+'         // Not an opening bracket
        .             ')*+'
        .         ')'
        .         '\\[\\/\\2\\]'             // Closing shortcode tag
        .     ')?'
        . ')'
        . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]



preg_match_all( '/'. $regexshortcodes .'/s', $content->post_content, $matches );
?>
<?php   

if (''!==$matches[3]) { 

$gallery_shortcode_attr = shortcode_parse_atts($matches[3][0]);
$attachment_image_ids = @explode(',',$gallery_shortcode_attr['ids']);
$thumb_size=$post->grid_thumb_size;

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
?>											
<div id="gallery-carousel-<?php echo $post->id; ?>" class="carousel slide post-gallery-carousel" data-ride="carousel" data-interval="3000">
       <div class="carousel-inner">
                        <?php
                            $i = 0;
                            foreach ($attachment_image_ids as $attachment_id) {


                                if($thumb_size){

                                    $p_img = wpb_resize($attachment_id, null, $thumb_size[0], $thumb_size[1], true);

                                    $thumbnail = '<img src="'.$p_img['url'].'" class="img-responsive" alt="" />';
                                }
                                else{
                                    $thumbnail = wp_get_attachment_image( $attachment_id, 'large', false, array('class' => 'img-responsive') );
                                }

                                $active_class = ($i==0) ? 'active' : '';
                        ?>
                                        <div class="item <?php echo $active_class; ?>"><?php print $thumbnail;?></div>
                        <?php
                                $i++;
                            }
                        ?>
                                    </div><!--div class="carousel-inner"-->
        <div class="post-gallery-carousel-nav">
        <div class="post-gallery-carousel-buttons">
            <a class="btn secondary_color_button skin-light" href="#gallery-carousel-<?php echo $post->id; ?>" data-slide="prev">
              <span><i class="icon-left-open-big"></i></span>
            </a>
            <a class="btn secondary_color_button skin-light" href="#gallery-carousel-<?php echo $post->id; ?>" data-slide="next">
              <span><i class="icon-right-open-big"></i></span>
            </a>
        </div>
    </div>
</div>  
<?php 
} 
?>							

<div class="post-info">
	<span class="author"><?php print $post->author;?></span>
    <?php if ( comments_open($post->id)) : ?><span> / <?php print $post->comment_count;?> Comments</span><?php endif; //if ( comments_open()) ?>
	<h4><a href="<?php echo $post->link ?>" class="vc_read_more" title="<?php echo esc_attr(sprintf(__( 'Detail to %s', 'detheme' ), $post->title_attribute)); ?>"<?php echo " target=\"".$post->link_target."\""; ?>><?php print $post->title;?></a></h4>
	<div class="post-content">
		<?php print $post->excerpt;?>
	</div>
</div>
<div class="postmetabottom">
	<div class="col-xs-7">
		<?php if (!empty($post->post_tags)) : ?>
		<i class="icon-tags-2"></i><?php echo $post->post_tags; ?>
		<?php endif; //if ($tags!='') : ?>
	</div>
	<div class="col-xs-5">
		<i class="icon-clock-circled"></i><?php print $post->post_date;?>
	</div>
</div>
