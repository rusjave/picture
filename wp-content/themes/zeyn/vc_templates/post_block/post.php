<?php
defined('ABSPATH') or die();

global $post, $detheme_config;
?>
<?php 
if(!empty($post->thumbnail)):;?>
<div class="post-image">
	<?php print $post->thumbnail;?>	
</div>
<?php endif;?>
<div class="post-info<?php print (empty($post->thumbnail))?" no_image":"";?>">
	<span class="author"><?php print $post->author;?></span>
	<?php if ( comments_open($post->id)) : ?><span> / <?php print $post->comment_count;?> Comments</span><?php endif; //if ( comments_open()) ?>
	<h4><a href="<?php echo $post->link ?>" class="vc_read_more" title="<?php echo esc_attr(sprintf(__( 'Detail to %s', 'detheme' ), $post->title_attribute)); ?>"<?php echo " target=\"".$post->link_target."\""; ?>><?php print $post->title;?></a></h4>
	<div class="post-content"><?php print $post->excerpt;?>
		<a href="<?php echo $post->link ?>" class="vc_read_more" title="<?php echo esc_attr(sprintf(__( 'Detail to %s', 'detheme' ), $post->title_attribute)); ?>"<?php echo " target=\"".$post->link_target."\""; ?>><?php _e('Read more', 'detheme') ?> <i class="icon-right-dir"></i></a>
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
