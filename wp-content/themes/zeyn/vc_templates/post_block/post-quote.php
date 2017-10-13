<?php
defined('ABSPATH') or die();

global $post;
?>
<?php 

	$thumbnail_data=$post->thumbnail_data;

	$bgstyle = '';
	if ($thumbnail_data['p_img_large']) {
		$bgstyle = ' style="background: url(\''.$thumbnail_data['p_img_large'][0].'\') no-repeat; background-size: cover;"';
	} 

?>
<div class="post-quaote primary_color_bg"<?php print $bgstyle;?>>
<div class="post-info">
	<div class="post-content">
		<?php print $post->content;?>
		<div class="iconquote"><i class="icon-quote-right-1"></i></div>
	</div>
</div>
</div>