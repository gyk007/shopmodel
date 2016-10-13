<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="main-content">
   
  <p style="font-size: 15px; text-align: justify; font-weight:bold;">Перед тем как зарегистрироваться в партнерской программе Вам необходимо зарегистрировать <a href = '/register' target='_blank' style="font-size: 16px; text-align: justify; font-weight:bold; color: green;">ЛИЧНЫЙ КАБИНЕТ</a>. Ваш e-mail в личном кабинете должен совпадать с Вашим e-mail в партнерском кабинете!</p>
  <br />
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content" style="position: relative;">
     <?php  if(isset($_COOKIE['tracking'])) { 
        
        
        $mail = $this->model_affiliate_affiliate->getAffiliateByTracking($_COOKIE['tracking']);
        
           ?> 
           
            <div class="registertext" style = "text-align: center;">E-mail Вашего партнера: </br></br> <?php echo $mail['email'];  ?></br></br>Но вы можете  указать e-mail другого партнера</div>
           <?php
        
     } else{  ?>
    
    <div class="registertext">Если Вы не знаете e-mail партнера - вы можете выбрать e-mail одного из <a href="/allpartner" title="продажа женской одежды оптом и в розницу" target="_blank">ПАРТНЁРОВ</a></div>
      <?php } ?>
      
      <table class="form">
       
       
        <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
         
        <tr>
          <td><span class="required">*</span><?php echo $entry_fax; ?></td>
          <td><input type="text" id="fax" name="fax" value="<?php echo $mail['email']; ?>" />        
             <?php if ($error_fax) { ?>
            <span class="error"><?php echo $error_fax; ?></span>
            <?php } ?></td>   
        </tr>
        <tr>
          <td>Skype</td>
          <td><input type="text" name="company" value="<?php echo $company; ?>" /></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_address; ?></h2>
    <div class="content" style="position: relative;" >
    <div class="registertext">В поле "ГОРОД" просто укажите название Вашего населенного пункта (города, деревни и др.). Тип населенного пункта НЕ УКАЗЫВАТЬ! </div>
      <table class="form">         
         
         
          <td><span class="required">*</span> <?php echo $entry_city; ?></td>
          <td><input type="text" name="city" value="<?php echo $city; ?>" />
            <?php if ($error_city) { ?>
            <span class="error"><?php echo $error_city; ?></span>
            <?php } ?></td>
        </tr>
        
         
      </table>
    </div>
   
    <h2><?php echo $text_your_password; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } ?>
  </form>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=affiliate/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('input[name=\'payment\']').bind('change', function() {
	$('.payment').hide();
	
	$('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		width: 640,
		height: 480
	});    
});
//--></script> 
<?php echo $footer; ?>