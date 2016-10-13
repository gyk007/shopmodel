<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1>Контактные данные интрнет магазина</h1>
  <div class="main-content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2>Реквизиты и схема проезда</h2>
    <div class="contact-info">
    <div class="content">
	  <div class="left">  
         <div itemscope itemtype="http://schema.org/Organization"  style="margin-top: 10px; border: solid 1px #555555; padding: 5px; font-size:15px; height: 275px;"> 
		 <h3 style="margin-top: 0px; margin-bottom: 2px;  text-align: center;">Реквизиты и схема проезда в Бресте</h3>
		<b>Наименование</b><br />
         <span itemprop="name">Итнернет-магазин женской одежды Shopmodel.by</span><br /> 
        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">         
        <b>Адрес в Бресте:</b><br />
        город<span itemprop="addressLocality"> Брест</span> <span itemprop="streetAddress">улица Октябрьской Революции</span> дом 37<br />		 
		<b>Владелец:</b><br />
        ИП Рабийчук Эдуард Сергеевич<br /> 		 
		<b>Телефоны в Бресте:</b><br />
        <span itemprop="telephone">+375295219916</span><br />         
        <b>Email:</b><br />
        <span itemprop="email">shopmodelby@mail.ru</span><br /> 
        <b>УНП:</b><br />
        291437478<br /> 
        <b>Расчетный счет:</b><br />
        3013213159009  в ЗАО «Альфа-Банк»<br /> 
        </div> 
        </div>
	  </div> 
      <div class="right">  
      <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=yOYrXBInHzxffpHDIIpoodZWmML7Gwk8&width=450&height=295"></script>     
      
      
    </div>
    </div>
    <h2><?php echo $text_contact; ?></h2>
    <div class="content">
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="<?php echo $name; ?>" />
    <br />
    <?php if ($error_name) { ?>
    <span class="error"><?php echo $error_name; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_email; ?></b><br />
    <input type="text" name="email" value="<?php echo $email; ?>" />
    <br />
    <?php if ($error_email) { ?>
    <span class="error"><?php echo $error_email; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_enquiry; ?></b><br />
    <textarea name="enquiry" cols="40" rows="10" style="width: 98%;"><?php echo $enquiry; ?></textarea>
    <br />
    <?php if ($error_enquiry) { ?>
    <span class="error"><?php echo $error_enquiry; ?></span>
    <?php } ?>
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="<?php echo $captcha; ?>" />
    <br />
    <img src="index.php?route=information/contact/captcha" alt="" />
    <?php if ($error_captcha) { ?>
    <span class="error"><?php echo $error_captcha; ?></span>
    <?php } ?>
<div style="margin-top: 10px;"><input type="submit" value="Отправить" class="button" /></div> 
     
    </div>
      
        
     
  </form>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>