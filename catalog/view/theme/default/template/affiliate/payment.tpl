 <?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1>Вывод денег</h1>
  <h2 style="margin-left: 15px; text-align: center;">Чтобы получить деньги Вам необходимо выполнить минимум одну покупку (или продажу через ссылки) за календарный год.</h2>
 <div style="text-align: justify; font-size:14px; padding: 15px;font-weight: bold;">Для того чтобы вывести 
 деньги Вам необходимо отправить заявку, в котором вы должны указать: <br />
 1) Cвой E-mail по которому Вы регистрировались на нашем сайте<br />
 2) Cумму, которую Вы хотите забрать.<br />
 3) Номер вашего Яндекс кошелька или номер Карточки Visa или MasterCard<br />
 Деньги будут выведены в течении недели.   
   
  <div class="main-content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_your_payment; ?> - <a style="font-size: 16px; font-weight: bold; color: red;" href="https://money.yandex.ru/new/#1" title="ЯНДКС ДЕНЬГИ" target="_blank">ЗАРЕГЕСТРИРУЙТЕ ЯНДЕКС КОШЕЛЕК</a> </h2>
    <div class="content">
      <table class="form">
        <tbody>
           
          
        </tbody>
        <tbody id="payment-cheque" class="payment">
          <tr>
            <td><?php echo $entry_cheque; ?></td>
            <td><input type="text" name="cheque" value="<?php echo $cheque; ?>"  /></td>
            <td> - без комиссии   </td>
          </tr>
           <tr>
            <td>Номер карточки Visa или MasterCard</td>
            <td><input type="text" name="paypal" value="<?php echo $paypal; ?>"  /></td>
            <td> - комиссия за вывод 5% минимум 1$</td>
          </tr>
          <tr>
            <td>Ваш e-mail:</td>
            <td><input type="text" name="email" value="<?php echo $email; ?>"  /></td>
	    <td>e-mailпо которму Вы регистрировались на сайте</td>            
          </tr>
          <tr>
            <td>Сумма которую вы хотите вывести:</td>
            <td><input type="text" name="summ" value="<?php echo $summ; ?> KR"  /></td> 
            <td> - cумму укажите в кредитах (KR) магазиа.<br /> &nbsp;&nbsp;Максимум вы можете вывести - <?php echo $summ; ?> KR </td>           
          </tr>
          <tr>
            <td>Примечание:</td>
            <td><textarea name="prim" cols="40" rows="5"></textarea> </td>
            <td>В примечании укажите куда вы хотите вывести ваши кредиты (на Яндекс кошелек, или на карту Visa, или MasterCard) </td>            
          </tr>
          <tr  >
           
            <td colspan="3" style="text-align: center;padding-top: 15px;"><a style="font-size: 16px; font-weight: bold; color: red;" href="https://money.yandex.ru/ymc/promo.xml?from=isuglink" title="ЯНДКС ДЕНЬГИ MasterCard" target="_blank">Выпустить карту MasterCard Gold от ЯНДЕКС ДЕНЕГ</a></td>
          </tr>
        </tbody>
        
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
      <div class="right"><input type="submit" value="Отправить заявку" class="button"  style="background-color: green;"/></div>
    </div>
  </form>
  </div>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('input[name=\'payment\']').bind('change', function() {
	$('.payment').hide();
	
	$('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
//--></script> 
<?php echo $footer; ?> 