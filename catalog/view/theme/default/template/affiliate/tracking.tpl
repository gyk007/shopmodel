<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" style="position: relative;"><?php echo $content_top; ?>
  <h1>Партнерские ссылки</h1>
  <div class="main-content">
  <p style="font-size: 15px; font-weight: bold; text-align: center;">Оставляйте Ваши ссылки в социальных сетях, на форумах и везде где это возможно.</p>
<p style="font-size: 15px; font-weight: bold; text-align: justify;">Любой человек, который перешел на наш сайт через вашу ссылку становиться Вашим покупателем. Теперь за все его покупки вы получаете <span style="color: red;">4$</span> даже если он совершит покупку через год.</p>
 <p style="font-size: 15px; font-weight: bold; text-align: justify;">Если человек, который перешел по Вашей ссылке захочет зарегистрироваться в партнерской программе у него будет сразу введен Ваш e-mail. И после регистрации он станет Вашим партнером 1 уровня</p>
 
<br />
  <p><?php echo $text_code; ?><br />
    <textarea cols="40" rows="5"><?php echo $code; ?>
    
     
    
    
    </textarea>
  </p>
  
  <p><?php echo $text_generator; ?><br />
    <input type="text" name="product" value="" />
  </p>
  <p><?php echo $text_link; ?><br />
    <textarea name="link" cols="40" rows="5"></textarea>
  </p>
  <div style="font-size: 16px; margin-left: 15px; margin-top: 10px; font-weight:bold; margin-bottom: 15px;"> 
    Главная страница сайта:<br /><br /> http://shopmodel.by/?tracking=<?php echo $code; ?><br /><br />
    Страница с описанием партнерки:<br /><br /> http://shopmodel.by/welcometopartner?tracking=<?php echo $code; ?><br /><br />
    Сирнаица с описанием партнерки при покупки скидочного пакета:<br /><br /> http://shopmodel.by/forpartner?tracking=<?php echo $code; ?>
    </div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
   
  </div>
    
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=affiliate/tracking/autocomplete&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.link
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'product\']').attr('value', ui.item.label);
		$('textarea[name=\'link\']').attr('value', ui.item.value);
						
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});
//--></script> 
<?php echo $footer; ?>