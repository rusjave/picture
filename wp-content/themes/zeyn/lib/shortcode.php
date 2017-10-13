<?php
/**
 * @package WordPress
 * @subpackage Zeyn
 */
if ( ! isset( $_GET['inline'] ) )
	define( 'IFRAME_REQUEST' , true );

require_once('get_wp.php');

$fc="f"."c"."lose";

$type=trim( $_GET['type'] );


if(!function_exists('dt_exctract_DTicon')){

	function dt_exctract_DTicon($file="",$pref="icon"){

		global $wp_filesystem;

		if(!$wp_filesystem->is_file($file) || !$wp_filesystem->exists($file) || !$wp_filesystem)
			return false;


		if ($buffers=$wp_filesystem->get_contents_array($file)) {

			$icons=array();
			$headerDefault=array('name'=>'',
								'uri'=>'',
								'author'=>'',
								'license'=>''
								);


			foreach ($buffers as $line => $buffer) {

				if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( 'Icon Name', '/' ) . ':(.*)$/mi', $buffer, $match ) && $match[1] ){

					$icon=$headerDefault;
					$icon['name']=$match[1];
					$icon['icons']=array();

					$icons[$icon['name']]['name']=$icon['name'];


				}


				if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( 'Author', '/' ) . ':(.*)$/mi', $buffer, $match ) && $match[1] ){


					$icon['author']=$match[1];
					$icons[$icon['name']]['author']=$icon['author'];


				}


				if(preg_match("/(".$pref.")-([^:\]\"].*?):/i",$buffer,$out)){
					if($out[2]!=="")
						$icons[$icon['name']]['icons'][]="icon-".$out[2];
				}
			}
			return $icons;

		}else{

			return false;
		}
	}

}


$errors = array();
if ( !empty($_POST) ) {
	$return = configuration_form_handler($type);
	if ( is_string($return) )
		return $return;
	if ( is_array($return) )
		$errors = $return;
}

return dt_popup_configuration_form($type,$errors);



function configuration_form_handler($type){

	switch($type){
		case 'button':
		$text=$_POST['text'];
		$style=$_POST['style'];
		$url=$_POST['url'];
		$size=$_POST['size'];
		$target=$_POST['target'];
		$skin=$_POST['skin'];

		if(!empty($text)){
			
			$errors=dt_popup_send_to_editor(array('type'=>$type,'style'=>$style,'text'=>$text,'url'=>$url,'size'=>$size,'target'=>$target,'skin'=>$skin));
		}
		else{
			
			$errors=array('errors'=>array('style'=>$style,'text'=>$text,'url'=>$url,'size'=>$size,'target'=>$target,'skin'=>$skin));
		}
		break;	
		case 'icon':
		$icon=$_POST['icon'];
		$size=$_POST['size'];
		$color=$_POST['color'];
		$style=$_POST['style'];

		if(count($icon)){
			
			$errors=dt_popup_send_to_editor(array('type'=>$type,'icon'=>$icon,'size'=>$size,$icon,'color'=>$color,$icon,'style'=>$style));
		}
		else{
			
			$errors=array('errors'=>array('icon'=>$icon,'size'=>$size,$icon,'color'=>$color,$icon,'style'=>$style));
		}
		break;
		case 'counto':
		$number=$_POST['number'];

		if(!empty($number)){
			
			$errors=dt_popup_send_to_editor(array('type'=>$type,'number'=>$number));
		}
		else{
			
			$errors=array('errors'=>array('number'=>$number));
		}
		break;
		default:
		break;
	}
	return $errors;
}

function dt_popup_configuration_form($type,$errors=array()){

	global $wpdb, $wp_query, $wp_locale;


	wp_enqueue_style( 'popup-style',get_template_directory_uri() . '/lib/css/popup.css', array(), '', 'all' );
	wp_enqueue_script( 'icon-picker',get_template_directory_uri() . '/lib/js/icon_picker.js', array('jquery'));

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php wp_head();?>
	</head>
	<body>
		<div id="jayd-popup">
			<div id="jayd-shortcode-wrap">
				<div id="jayd-sc-form-wrap">
					<div id="jayd-sc-form-head"><h2>DT <?php print ucwords($type);?></h2></div>
					<form method="post" action="" id="jayd-sc-form">
						<table cellspacing="2" cellpadding="5" id="jayd-sc-form-table" class="form-table">
							<tbody>
								<?php 
								if($type=='button'){

									$styles=array(
										'color-primary'=>__('Primary','detheme'),
										'color-secondary' => __('Secondary','detheme'),
										'success' => __('Success','detheme'),
										'info' => __('Info','detheme'),
										'warning' => __('Warning','detheme'),
										'danger'=>__('Danger','detheme'),
										'ghost'=>__('Ghost Button','detheme'),
										'link'=>__('Link','detheme'),
										);

									$sizes = array(
										'btn-lg' => __('Large','detheme'),
										'btn-default' => __('Default','detheme'),
										'btn-sm' => __('Small','detheme'),
										'btn-xs' => __('Extra small','detheme')
										);

									$errors=wp_parse_args($errors,array('size'=>'','url'=>'','style'=>'','target'=>'','text'=>'','skin'=>'dark'));

									?>
									<tr>
										<td><label><?php _e('Button URL','detheme');?></label></td>
										<td><input class="form-control" type="text" maxlength="100" name="url" id="url" class="jayd-form-input" value="<?php print $errors['url'];?>" /> 
											<span class="child-clone-row-desc"><?php _e('Add the button\'s url eg http://example.com','detheme');?></span>
										</td>
									</tr>
									<tr>
										<td><label><?php _e("Button skin", 'detheme');?></label></td>
										<td>
										<select class="jayd-form-select form-control" name="skin" id="skin">
										<option value="dark" <?php echo(($errors['skin']=='dark')?" selected=\"selected\"":"");?>><?php _e('Dark (default)','detheme');?></option> 
										<option value="light" <?php echo(($errors['skin']=='light')?" selected=\"selected\"":"");?>><?php _e('Light','detheme');?></option> 
										</select>
										<span class="child-clone-row-desc"><?php _e('Select the button\'s skin','detheme');?></span> 
										</td>
									</tr>
									<tr>
										<td><label><?php _e("Button style", 'detheme');?></label></td>
										<td>
										<select class="jayd-form-select form-control" name="style" id="style">
											<?php 	
											if($styles){

												foreach ( $styles as $style=>$label ){

													echo "<option value=\"".$style."\" ".(($style==$errors['style'])?" selected=\"selected\"":"").">".$label."</option>"; 
												}
											}
											?>

										</select> 
										<span class="child-clone-row-desc"><?php _e('Select the button\'s style, ie the button\'s colour','detheme');?></span>
										</td>
									</tr>
								<tr>
									<td><label><?php _e("Button size", 'detheme');?></label></td>
									<td><select class="jayd-form-select form-control" name="size" id="size">
										<?php 	
										if($sizes){

											foreach ( $sizes as $size=>$label ){

												echo "<option value=\"".$size."\" ".(($size==$errors['size'])?" selected=\"selected\"":"").">".$label."</option>"; 
											}
										}
										?>

									</select> <span class="child-clone-row-desc">Select the icon's size</span></td>
								</tr>
								<tr>
									<td><label><?php _e('Button Target','detheme');?></label></td>
									<td><select class="jayd-form-select form-control" name="target" id="t	arget">
										<option value="_self" <?php echo(($errors['target']=='_self')?" selected=\"selected\"":"");?>><?php _e('Self','detheme');?></option> 
										<option value="_blank" <?php echo(($errors['target']=='_blank')?" selected=\"selected\"":"");?>><?php _e('Blank','detheme');?></option> 
									</select> <span class="child-clone-row-desc"><?php _e('Select the button\'s target','detheme');?></span></td>
								</tr>
								<tr>
									<td><label><?php _e('Button Text','detheme');?></label></td>
									<td><input class="form-control" type="text" name="text" maxlength="100" id="text" class="jayd-form-input" value="<?php print $errors['text'];?>"/> 
										<span class="child-clone-row-desc"><?php _e('Select the button\'s text','detheme');?></span></td>
									</tr>

									<?php }
									elseif($type=='counto'){
								
									$errors=wp_parse_args($errors,array('number'=>'100'));

								?>
								<tr>
									<td><label><?php _e('Number','detheme');?></label></td>
									<td><input class="form-control" type="text" name="number" maxlength="100" id="number" class="jayd-form-input" value="<?php print $errors['number'];?>"/> 
										<span class="child-clone-row-desc"><?php _e('The value must be numeric','detheme');?></span></td>
									</tr>

									<?php }
									elseif($type=='icon'){


										$iconFile=get_template_directory('css').'/css/fontello.css';

										$icons=dt_exctract_DTicon($iconFile);


										$sizes = array(
											'' => __('Default','detheme'),
											'size-sm' => __('Small','detheme'),
											'size-md' => __('Medium','detheme'),
											'size-lg' => __('Large','detheme')
											);

										$errors=wp_parse_args($errors,array('size'=>'','color'=>'','style'=>'square'));

										?>
										<tr>
											<td><label><?php _e('Icon Size','detheme');?></label></td>
											<td><select class="form-control jayd-form-select" name="size" id="size">
												<?php 

												if($sizes){

													foreach ( $sizes as $size=>$label ){

														echo "<option value=\"".$size."\" ".(($size==$errors['size'])?" selected=\"selected\"":"").">".$label."</option>"; 
													}
												}
												?>

											</select> <span class="child-clone-row-desc">Select the button's size</span></td>
										</tr>
										<tr>
											<td><label><?php _e('Icon Color','detheme');?></label></td>
											<td><select class="jayd-form-select form-control" name="color" id="color">
												<option value="" <?php echo(($errors['color']=='')?" selected=\"selected\"":"");?>><?php _e('Default','detheme');?></option> 
												<option value="primary" <?php echo(($errors['color']=='primary')?" selected=\"selected\"":"");?>><?php _e('Primary','detheme');?></option> 
												<option value="secondary" <?php echo(($errors['color']=='secondary')?" selected=\"selected\"":"");?>><?php _e('Secondary','detheme');?></option> 
											</select> <span class="child-clone-row-desc"><?php _e('Select the button\'s color','detheme');?></span></td>
										</tr>
										<tr>
											<td><label><?php _e('Icon Style','detheme');?></label></td>
											<td><select class="jayd-form-select form-control" name="style" id="style">
												<option value="">None</option> 
												<option value="circle" <?php echo(($errors['style']=='circle')?" selected=\"selected\"":"");?>><?php _e('Circle','detheme');?></option> 
												<option value="square" <?php echo(($errors['style']=='square')?" selected=\"selected\"":"");?>><?php _e('Square','detheme');?></option> 
												<option value="ghost" <?php echo(($errors['style']=='ghost')?" selected=\"selected\"":"");?>><?php _e('Ghost','detheme');?></option> 
												</select> <span class="child-clone-row-desc"><?php _e('Select the button\'s style','detheme');?></span></td>
											</tr>

											<tr>
											<td><label><?php _e('Icon','detheme');?></label></td>
											<td>
													<?php 

													$lisicons=array();
													if($icons){

														foreach ($icons as $icon) {
															 foreach($icon['icons'] as $ico):
															 	$lisicons[$ico]=$ico;
														endforeach;
														}

													}

													?>

													<script type="text/javascript">
													jQuery(document).ready(function($){

														var options={
															icons:new Array('<?php print implode("','",$lisicons);?>'),
															onUpdate:function(e){

																var input=this.closest('.input-group').find('input');
																input.val("icon-"+e);

															}
														};

														$(".icon-picker").iconPicker(options);
													});

													</script>
													<input type="text" class="icon-picker" id="icon" name="icon" value="" />
											</td>
										</tr>
										<?php }
										?>
									</tbody>
								</table>
								<br/>
								<center>
									<input type="submit" id="form-insert" class="btn btn-default content_jayd_button" value="Insert Shortcode">
								</center>
						</form>
					</div>
				</div>
			</div>
		</body>
		</html>
		<?php }

		function dt_popup_send_to_editor($options=array()) {

			$string="";

			switch ($options['type']){
				case 'button':	$string="[dt_button url=\"".$options['url']."\" style=\"".$options['style']."\" size=\"".$options['size']."\" skin=\"".$options['skin']."\" target=\"".$options['target']."\"]".$options['text']."[/dt_button]";
				break;
				case 'counto':	$string="[dt_counto to=\"".$options['number']."\"]".$options['number']."[/dt_counto]";
				break;
				case 'icon':
				$string.="[dticon ico=\"".$options['icon']."\"".
				((!empty($options['size']))?" size=\"".$options['size']."\"":"").
				((!empty($options['color']))?" color=\"".$options['color']."\"":"").
				((!empty($options['style']))?" style=\"".$options['style']."\"":"")."][/dticon]";
				break;

			}
			$string=preg_replace("/\r\n|\n|\r/","<br/>",$string);

			?>
			<script type="text/javascript">

			/* <![CDATA[ */
			var win = window.dialogArguments || opener || parent || top;
			if(win.tinyMCE)
			{

				win.send_to_editor('<?php echo addslashes($string); ?>');
//	win.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, '<?php echo addslashes($string); ?>');
win.tb_remove();
}
else if(win.send_to_editor)
{
	win.send_to_editor('<?php echo addslashes($string); ?>');
	win.tb_remove();
}


/* ]]> */
</script>
<?php
exit;
}
?>
