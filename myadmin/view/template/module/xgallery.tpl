<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="vtabs">
          <?php $module_row = 1; ?>
          <?php foreach ($modules as $module) { ?>
          <a href="#tab-module-<?php echo $module_row; ?>" id="module-<?php echo $module_row; ?>"><?php echo $tab_module . ' ' . $module_row; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$('.vtabs a:first').trigger('click'); $('#module-<?php echo $module_row; ?>').remove(); $('#tab-module-<?php echo $module_row; ?>').remove(); return false;" /></a>
          <?php $module_row++; ?>
          <?php } ?>
          <span id="module-add"><?php echo $button_add_module; ?>&nbsp;<img src="view/image/add.png" alt="" onclick="addModule();" /></span> </div>
          <?php $module_row = 1; ?>
        <?php foreach ($modules as $module) { ?>
        <div id="tab-module-<?php echo $module_row; ?>" class="vtabs-content">
			  <table class="form">
				<tr>
				  <td><span class="required">* </span><?php echo $entry_banner_id; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][banner_id]">
					  <option value=""></option>
					  <?php foreach ($banners as $banner) { ?>
					  <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
					  <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
					<?php if (isset($error_banner_id[$module_row])) { ?>
					<span class="error"><?php echo $error_banner_id[$module_row]; ?></span>
					<?php } ?></td>
				</tr>
				<tr>
					<td class="left"><span class="required">* </span><?php echo $entry_image_dimension; ?></td>
					<td class="left">
						<input type="text" name="xgallery_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="5" />
						<input type="text" name="xgallery_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="5" />
					<?php if (isset($error_image_dimension[$module_row])) { ?>
					<span class="error"><?php echo $error_image_dimension[$module_row]; ?></span>
					<?php } ?>
					</td>
				</tr>
				<tr>
				  <td><?php echo $entry_show_thumbnail; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][show_thumbnail]">
					  <?php if ($module['show_thumbnail']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
					<td class="left"><span class="required">* </span><?php echo $entry_thumbnail_dimension; ?></td>
					<td class="left">
						<input type="text" name="xgallery_module[<?php echo $module_row; ?>][thumbnail_width]" value="<?php echo $module['thumbnail_width']; ?>" size="5" />
						<input type="text" name="xgallery_module[<?php echo $module_row; ?>][thumbnail_height]" value="<?php echo $module['thumbnail_height']; ?>" size="5" />
					<?php if (isset($error_thumbnail_dimension[$module_row])) { ?>
					<span class="error"><?php echo $error_thumbnail_dimension[$module_row]; ?></span>
					<?php } ?>
					</td>
				</tr>
				<tr>
				  <td><?php echo $entry_preset; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][preset]">
					  <?php if ($module['preset'] == 'centralExpand') { ?>
					  <option value="centralExpand" selected="selected"><?php echo $text_preset_central_expand; ?></option>
					  <?php } else { ?>
					  <option value="centralExpand"><?php echo $text_preset_central_expand; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'zoomer') { ?>
					  <option value="zoomer" selected="selected"><?php echo $text_preset_zoomer; ?></option>
					  <?php } else { ?>
					  <option value="zoomer"><?php echo $text_preset_zoomer; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'fadeThree') { ?>
					  <option value="fadeThree" selected="selected"><?php echo $text_preset_fade_three; ?></option>
					  <?php } else { ?>
					  <option value="fadeThree"><?php echo $text_preset_fade_three; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'simpleFade') { ?>
					  <option value="simpleFade" selected="selected"><?php echo $text_preset_simple_fade; ?></option>
					  <?php } else { ?>
					  <option value="simpleFade"><?php echo $text_preset_simple_fade; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'gSlider') { ?>
					  <option value="gSlider" selected="selected"><?php echo $text_preset_gslider; ?></option>
					  <?php } else { ?>
					  <option value="gSlider"><?php echo $text_preset_gslider; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'vSlider') { ?>
					  <option value="vSlider" selected="selected"><?php echo $text_preset_vslider; ?></option>
					  <?php } else { ?>
					  <option value="vSlider"><?php echo $text_preset_vslider; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'slideFromLeft') { ?>
					  <option value="slideFromLeft" selected="selected"><?php echo $text_preset_slide_from_left; ?></option>
					  <?php } else { ?>
					  <option value="slideFromLeft"><?php echo $text_preset_slide_from_left; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'slideFromTop') { ?>
					  <option value="slideFromTop" selected="selected"><?php echo $text_preset_slide_from_top; ?></option>
					  <?php } else { ?>
					  <option value="slideFromTop"><?php echo $text_preset_slide_from_top; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'diagonalFade') { ?>
					  <option value="diagonalFade" selected="selected"><?php echo $text_preset_diagonal_fade; ?></option>
					  <?php } else { ?>
					  <option value="diagonalFade"><?php echo $text_preset_diagonal_fade; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'diagonalExpand') { ?>
					  <option value="diagonalExpand" selected="selected"><?php echo $text_preset_diagonal_expand; ?></option>
					  <?php } else { ?>
					  <option value="diagonalExpand"><?php echo $text_preset_diagonal_expand; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'fadeFromCenter') { ?>
					  <option value="fadeFromCenter" selected="selected"><?php echo $text_preset_fade_from_center; ?></option>
					  <?php } else { ?>
					  <option value="fadeFromCenter"><?php echo $text_preset_fade_from_center; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'zabor') { ?>
					  <option value="zabor" selected="selected"><?php echo $text_preset_zabor; ?></option>
					  <?php } else { ?>
					  <option value="zabor"><?php echo $text_preset_zabor; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'vertivalLines') { ?>
					  <option value="vertivalLines" selected="selected"><?php echo $text_preset_vertival_lines; ?></option>
					  <?php } else { ?>
					  <option value="vertivalLines"><?php echo $text_preset_vertival_lines; ?></option>
					  <?php } ?>
					  <?php if ($module['preset'] == 'gorizontalLines') { ?>
					  <option value="gorizontalLines" selected="selected"><?php echo $text_preset_gorizontal_lines; ?></option>
					  <?php } else { ?>
					  <option value="gorizontalLines"><?php echo $text_preset_gorizontal_lines; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
					<td class="left"><span class="required">* </span><?php echo $entry_duration; ?></td>
					<td class="left"><input type="text" name="xgallery_module[<?php echo $module_row; ?>][duration]" value="<?php echo $module['duration']; ?>" size="5" />
					<?php if (isset($error_duration[$module_row])) { ?>
					<span class="error"><?php echo $error_duration[$module_row]; ?></span>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td class="left"><span class="required">* </span><?php echo $entry_slideshow; ?></td>
					<td class="left"><input type="text" name="xgallery_module[<?php echo $module_row; ?>][slideshow]" value="<?php echo $module['slideshow']; ?>" size="5" />
					<?php if (isset($error_slideshow[$module_row])) { ?>
					<span class="error"><?php echo $error_slideshow[$module_row]; ?></span>
					<?php } ?>
					</td>
				</tr>
				<tr>
				  <td><?php echo $entry_pag_nums; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][pag_nums]">
					  <?php if ($module['pag_nums']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_num_status; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][num_status]">
					  <?php if ($module['num_status']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_banners; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][banners]">
					  <?php if ($module['banners'] == 'disabled') { ?>
					  <option value="deisabled" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="disabled"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					  <?php if ($module['banners'] == 'fromLeft') { ?>
					  <option value="fromLeft" selected="selected"><?php echo $text_banner_preset_from_left; ?></option>
					  <?php } else { ?>
					  <option value="fromLeft"><?php echo $text_banner_preset_from_left; ?></option>
					  <?php } ?>
					  <?php if ($module['banners'] == 'fromRight') { ?>
					  <option value="fromRight" selected="selected"><?php echo $text_banner_preset_from_right; ?></option>
					  <?php } else { ?>
					  <option value="fromRight"><?php echo $text_banner_preset_from_right; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_pause_on_hover; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][pause_on_hover]">
					  <?php if ($module['pause_on_hover']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_wait_banner_animation; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][wait_banner_animation]">
					  <?php if ($module['wait_banner_animation']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_layout; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][layout_id]">
					  <?php foreach ($layouts as $layout) { ?>
					  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
					  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_position; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][position]">
					  <?php if ($module['position'] == 'content_top') { ?>
					  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
					  <?php } else { ?>
					  <option value="content_top"><?php echo $text_content_top; ?></option>
					  <?php } ?>
					  <?php if ($module['position'] == 'content_bottom') { ?>
					  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
					  <?php } else { ?>
					  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
					  <?php } ?>
					  <?php if ($module['position'] == 'column_left') { ?>
					  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
					  <?php } else { ?>
					  <option value="column_left"><?php echo $text_column_left; ?></option>
					  <?php } ?>
					  <?php if ($module['position'] == 'column_right') { ?>
					  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
					  <?php } else { ?>
					  <option value="column_right"><?php echo $text_column_right; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_status; ?></td>
				  <td><select name="xgallery_module[<?php echo $module_row; ?>][status]">
					  <?php if ($module['status']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><?php echo $entry_sort_order; ?></td>
				  <td><input type="text" name="xgallery_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
				</tr>
			  </table>
			  
		</div>	  
        <?php $module_row++; ?>
        <?php } ?>
      </form>
    </div>
  </div>
</div>



<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<div id="tab-module-' + module_row + '" class="vtabs-content">';
	html += '  <table class="form">';
	html += '   <tr>';
	html += '      <td><?php echo $entry_banner_id; ?></td>';
	html += '      <td><select name="xgallery_module[' + module_row + '][banner_id]">';
	html += '           <option value=""></option>';
	<?php foreach ($banners as $banner) { ?>
	html += '           <option value="<?php echo $banner['banner_id']; ?>"><?php echo addslashes($banner['name']); ?></option>';
	<?php } ?>
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '		<td class="left"><?php echo $entry_image_dimension; ?></td>';
	html += '		<td class="left">';
	html += '			<input type="text" name="xgallery_module[' + module_row + '][image_width]"  size="5" />';
	html += '			<input type="text" name="xgallery_module[' + module_row + '][image_height]"  size="5" />';
	html += '		</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_show_thumbnail; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][show_thumbnail]">';
	html += '				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '				<option value="0"><?php echo $text_disabled; ?></option>';
	html += '		</select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left"><?php echo $entry_thumbnail_dimension; ?></td>';
	html += '		<td class="left">';
	html += '			<input type="text" name="xgallery_module[' + module_row + '][thumbnail_width]"  value="70" size="5" />';
	html += '			<input type="text" name="xgallery_module[' + module_row + '][thumbnail_height]" value="70" size="5" />';
	html += '		</td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_preset; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][preset]">';
	html += '				  <option value="centralExpand"><?php echo $text_preset_central_expand; ?></option>';
	html += '				  <option value="zoomer" selected="selected"><?php echo $text_preset_zoomer; ?></option>';
	html += '				  <option value="fadeThree"><?php echo $text_preset_fade_three; ?></option>';
	html += '				  <option value="simpleFade"><?php echo $text_preset_simple_fade; ?></option>';
	html += '				  <option value="gSlider"><?php echo $text_preset_gslider; ?></option>';
	html += '				  <option value="vSlider"><?php echo $text_preset_vslider; ?></option>';
	html += '				  <option value="slideFromLeft"><?php echo $text_preset_slide_from_left; ?></option>';
	html += '				  <option value="slideFromTop"><?php echo $text_preset_slide_from_top; ?></option>';
	html += '				  <option value="diagonalFade"><?php echo $text_preset_diagonal_fade; ?></option>';
	html += '				  <option value="diagonalExpand"><?php echo $text_preset_diagonal_expand; ?></option>';
	html += '				  <option value="fadeFromCenter"><?php echo $text_preset_fade_from_center; ?></option>';
	html += '				  <option value="zabor"><?php echo $text_preset_zabor; ?></option>';
	html += '				  <option value="vertivalLines"><?php echo $text_preset_vertival_lines; ?></option>';
	html += '				  <option value="gorizontalLines"><?php echo $text_preset_gorizontal_lines; ?></option>';
	html += '			</select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left"><?php echo $entry_duration; ?></td>';
	html += '		<td class="left"><input type="text" name="xgallery_module[' + module_row + '][duration]" value="10000" size="5" /></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td class="left"><?php echo $entry_slideshow; ?></td>';
	html += '		<td class="left"><input type="text" name="xgallery_module[' + module_row + '][slideshow]" value="7000" size="5" /></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_pag_nums; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][pag_nums]">';
	html += '				<option value="1"><?php echo $text_enabled; ?></option>';
	html += '				<option value="0"  selected="selected"><?php echo $text_disabled; ?></option>';
	html += '			</select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_num_status; ?></td>';
	html += '	    <td><select name="xgallery_module[' + module_row + '][num_status]">';
	html += '				  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '				  <option value="0"><?php echo $text_disabled; ?></option>';
	html += '			</select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_banners; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][banners]">';
	html += '				<option value="disabled"><?php echo $text_disabled; ?></option>';
	html += '				<option value="fromLeft"><?php echo $text_banner_preset_from_left; ?></option>';
	html += '				<option value="fromRight" selected="selected"><?php echo $text_banner_preset_from_right; ?></option>';
	html += '			</select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_pause_on_hover; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][pause_on_hover]">';
	html += '				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html += '				<option value="0"><?php echo $text_disabled; ?></option>';
	html += '		    </select></td>';
	html += '	</tr>';
	html += '	<tr>';
	html += '		<td><?php echo $entry_wait_banner_animation; ?></td>';
	html += '		<td><select name="xgallery_module[' + module_row + '][wait_banner_animation]">';
	html += '				<option value="1"><?php echo $text_enabled; ?></option>';
	html += '				<option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
	html += '			</select></td>';
	html += '	</tr>';
	html += '   <tr>';
	html += '      <td><?php echo $entry_layout; ?></td>';
	html += '      <td><select name="xgallery_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '           <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_position; ?></td>';
	html += '      <td><select name="xgallery_module[' + module_row + '][position]">';
	html += '        <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '        <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '        <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '        <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_status; ?></td>';
	html += '      <td><select name="xgallery_module[' + module_row + '][status]">';
	html += '        <option value="1"><?php echo $text_enabled; ?></option>';
	html += '        <option value="0"><?php echo $text_disabled; ?></option>';
	html += '      </select></td>';
	html += '    </tr>';
	html += '    <tr>';
	html += '      <td><?php echo $entry_sort_order; ?></td>';
	html += '      <td><input type="text" name="xgallery_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    </tr>';
	html += '  </table>'; 
	html += '</div>';
	
	$('#form').append(html);
	
	$('#module-add').before('<a href="#tab-module-' + module_row + '" id="module-' + module_row + '"><?php echo $tab_module; ?> ' + module_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module-' + module_row + '\').remove(); $(\'#tab-module-' + module_row + '\').remove(); return false;" /></a>');
	
	$('.vtabs a').tabs();
	
	$('#module-' + module_row).trigger('click');
	
	module_row++;
}
//--></script> 

<script type="text/javascript"><!--
$('.vtabs a').tabs();
//--></script> 
<?php echo $footer; ?>