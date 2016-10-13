<?php echo $header; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="contentes">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'c.name') { ?>
                <a href="<?php echo $sort_country; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_country; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_country; ?>"><?php echo $column_country; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'z.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'z.code') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($zones) { ?>
            <?php foreach ($zones as $zone) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($zone['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $zone['zone_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $zone['zone_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $zone['country']; ?></td>
              <td class="left"><?php echo $zone['name']; ?></td>
              <td class="left"><?php echo $zone['code']; ?></td>
              <td class="right">
			    <?php foreach ($zone['action'] as $action) { ?>
				  <?php if ($this->config->get('config_buttons_apply') == 0) { ?>
					[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
				  <?php } else { ?>
				    <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
				  <?php } ?>
                <?php } ?>
			  </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
		  <tfoot>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'c.name') { ?>
                <a href="<?php echo $sort_country; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_country; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_country; ?>"><?php echo $column_country; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'z.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'z.code') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </tfoot>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
	<div class="foot_heading">
      <h1><img src="view/image/country.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$("span.tooltip").tooltip({
	track: true, 
    delay: 0, 
    showURL: false, 
    showBody: " - ", 
    fade: 250 
});
//--></script>
<?php echo $footer; ?>