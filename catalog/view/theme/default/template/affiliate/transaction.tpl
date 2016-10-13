<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
   <p style=" text-align: justify; font-size: 16px; font-weight: bold; margin-left:15px; margin-right:15px;">Если вы хотите покупать нашу продукцию за Ваши кредиты - просто нажмите кнопку "Перевести в кредиты для пользования". За кредиты магазина Вы можете покупать любую продукцию нашей компании. Таким же образом вы можете перевести кредиты обратно для вывода.</p>        
  <div id="Perevod">Перевести в кредиты для пользования</div>
  <div class="main-content">
   
  <p>Вы можите вывести <b> <?php echo $balance; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <b>Один кредит (KR) нашего магазина равен 1 USD</b></p>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_description; ?></td>
        <td class="right"><?php echo "Кредиты магазина (KR)"; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php
      $countsumm = 0;
      
       if ($transactions) { ?>
      <?php foreach ($transactions  as $transaction) { ?>
      <tr>
        <td class="left"><?php echo $transaction['date_added']; ?></td>
        <td class="left"><?php echo $transaction['description']; ?></td>
        <td class="right"><?php echo $transaction['amount']." KR"; 
        $countsumm = $countsumm + $transaction['amount'];
        
        ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td class="center" colspan="5"><?php echo $text_empty; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="pagination"><?php echo $pagination; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
<script>
$('#Perevod').live('click', function() {
	$.ajax({
		url: '/index.php?route=affiliate/transaction/perevod&summ=<?php echo $countsumm; ?>',
		type: 'post',		
	    data: "summ = <?php echo $countsumm; ?> ",  
		 beforeSend: function() {
		  if('<?php echo $countsumm; ?>' <= 0){
		      alert ('На Вашем счету  нет кредитов');
              return false;
		  }
           
            return true;
           
          
		 },		
		success: function(data) {
			 
              
				 alert ('Ваши кредиты перешли в кредиты для пользования');		
                  location.reload();
		 
			
			 
		}
	});
     
});







</script>


