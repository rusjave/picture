<?php
defined('ABSPATH') or die();

global $post;

$content=get_post($post->id);
$hasyoutubelink=false;
$hasvideoshortcode=false;

        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(video)"                     // 2: Shortcode name
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



if(preg_match_all( '/'. $regexshortcodes .'/s', $content->post_content, $matches )){

    $hasvideoshortcode=true;   
    $shortcodepos = strpos($content->post_content,$matches[0][0]);

}

if(preg_match('@https?://(www.)?(youtube|vimeo)\.com/(watch\?v=)?([a-zA-Z0-9_-]+)@im', $content->post_content, $urls)){

    $youtubepos = strpos($content->post_content,$urls[0]);
    $hasyoutubelink=true;
}


?>
<?php   if ($hasvideoshortcode || $hasyoutubelink) { ?>											
		<div class="post-image">
            <?php 
            if($hasvideoshortcode and $hasyoutubelink){
                if ($shortcodepos < $youtubepos) {
                    echo do_shortcode($matches[0][$i]);
                } else {
                    echo '<div class="flex-video">';
                    echo wp_oembed_get($urls[0]);
                    echo '</div>';
                }

            } elseif ($hasyoutubelink) {
                echo '<div class="flex-video">';
                echo wp_oembed_get($urls[0]);
                echo '</div>';
            } else {
                echo do_shortcode($matches[0][$i]);
            } 
            ?>
		</div>
<?php } ?>							

<div class="post-info">
	<span class="author"><?php print $post->author;?></span>
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
