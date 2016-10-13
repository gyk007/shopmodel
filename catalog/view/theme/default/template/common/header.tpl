<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
 <meta name = “site-created” content = “02.07.2014”>
	 <meta name = “author” content = “Жук Андрей”>
	 <meta name = “reply-to” content = ”Gyk088@gmail.com”>
<meta name="msvalidate.01" content="53CC2AA3F6F21574477534526B0A1DFD" />
<meta name="openstat-verification" content="a8876fc8586fbf8d5b29832c6df99f998bc81da8" />
<meta name='yandex-verification' content='59631b537f6f0a28' />

<meta name="google-site-verification" content="OcMbITYz4hFZkSxW0mMHfs7SnBrm8KxYw0peA1LTg1Y" />
<meta name="google-translate-customization" content="62ae622d203becb2-d17a7e45ee079502-g2a6bb9ae28908d85-d"></meta>
<base href="<?php echo $base; ?>" />
 
<meta name="description" content="<?php if( $description){echo $description;} else {echo "магазин женской одежды от прозводителей белорусского трикотажа";} ?>" />
 
 
<meta name="keywords" content="<?php if($keywords){echo $keywords;}else{ echo "белорусский трикотаж, магазин белорусский трикотаж, белорусский трикотаж интернет, белорусский трикотаж оптом, женская одежда, магазин женской одежды, большая женская одежда, купить женскую одежду, платья купить женские, женские платья оптом  ";} ?>" />
 
 
<link href="ico.ico" rel="icon" />
 
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/fast_order.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/cloud-zoom.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/prettyPhoto/prettyPhoto.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/poshytip/src/tip-twitter/tip-twitter.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/fast_order.js"></script>
<script type="text/javascript" src="catalog/view/javascript/cloud-zoom.1.0.2.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/prettyPhoto/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/poshytip/src/jquery.poshytip.min.js"></script>
<?php if ($quick_search) { ?>
<script type="text/javascript" src="catalog/view/javascript/quick_search.js"></script>
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]--> 
<?php echo $google_analytics; ?>
<?php
if ( (MyGetOS($_SERVER['HTTP_USER_AGENT'])  == 'Windows 7') || (MyGetOS($_SERVER['HTTP_USER_AGENT'])  == 'Windows XP') || (MyGetOS($_SERVER['HTTP_USER_AGENT'])  == 'Macintosh') || (MyGetOS($_SERVER['HTTP_USER_AGENT'])  == 'Windows 8') ){
?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.sticky.js"></script>
		<script type="text/javascript">        
		$(document).ready(function() {
		$("#menu").sticky({ 
		className: "mysticky"
		});
		});
		</script>
        <?php }; ?>
		<style type="text/css"> .mysticky{z-index:9999; box-shadow: 1px 1px 15px 2px #000 !important; border-radius: 0px 8px 8px 8px !important;} </style>
<style type="text/css"> .mysticky{z-index:9999; box-shadow: 1px 1px 15px 2px #000 !important; border-radius: 0px 8px 8px 8px !important;} </style>
<script type="text/javascript" src="catalog/view/javascript/ajax_product_loader.js"></script>
		</head>
<body>
<div id="top-bg">
  <div id="container">
    <div id="header">
     
    <a href="/contact-us" > <div id='header_contact'>
    <ul >
  <li style=" ">Телефон в Бресте:<span style="font-size: 13px;">  +375 (29)</span><span style="font-weight: bold;"> 521 99 16</span></li>
  <!--  <li style="">Телефон в Москве: <span style="font-size: 13px;">8965</span><span style="font-weight: bold;"> 334-28-92</span></li> -->
    <li style=" ">Skype:<span style="font-weight: bold;"> shopmodelby</span></li>
    <li style=" ">E-mail:<span style="font-weight: bold;"> shopmodelby@mail.ru</span></li>
    <li style=" ">Принимаем заказы <span style="font-weight: bold;">24 часа в сутки</span></li> 
     
    </ul>  
    </div></a>
     <?php /* echo $currency; */ ?>
       
     <div id="val"><img   src = "webpay.png" width="180px" height="50px" alt="Скидки Белорусского трикотажа"/></div> 
<?php /*echo $currency; */?>
	  <?php if ($logo) { ?>
	    <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
	  <?php } ?>
	  <div id="search">
		<div class="button-search"></div>
		<input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
	  </div>
	  <div id="welcome">
		<?php if ($logaf) {
			if($trecaf != $_COOKIE["tracking"]){ 
			         setcookie("tracking", '', time()-1, '/');
                       SetCookie("tracking", $trecaf ); 
                        }
		
				  }?>
		<?php if (!$logged) { ?>
		  <div class="dropdown-login"><span><?php echo $text_login; ?></span></div>
		  <div class="dropdown-box">
			<div class="header-login-box"><?php echo $text_welcome_user; ?></div>
			<div class="content-login-box">
			  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<input type="text" name="email" placeholder="<?php echo $text_email; ?>" value="<?php echo $email; ?>" />
				<input type="password" name="password"  placeholder="<?php echo $text_password; ?>" value="<?php echo $password; ?>" />
				<input type="submit" value="<?php echo $button_login; ?>" class="button" /><br /><br />
				<a class="forgotten" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
				<?php if ($redirect) { ?>
				  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
				<?php } ?>
			  </form>
			</div>
		  </div>
		
		<?php } else { ?>
		  <div class="dropdown">
		    <span class="dropdown-account"><a href="/index.php?route=account/account">Вход в личный кабинет</a></span>
		</div>
		<?php } ?>
	</div>	 
</div>
 <div id="scroll">  
<div id="menu">
		<ul>
		  <li class="myhome"><a class="home" href="<?php echo $home; ?>"></a></li>		   
		   <li><a   href="/about_us">О компании</a></li>
		 <!--  <li><a   href="/menedjer">Наши менеджеры</a></li> -->
		   <li><a   href="/dostavka">Доставка</a></li>		    
		   <li><a   href="/oplata">Оплата</a></li>
		   <li><a   href="/news">Новости</a></li>
		   <li><a   href="/opt">Оптовые продажи</a></li>
		   <li><a   href="/brands">Производители</a></li> 
		   <a class = "mycheckout" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
           <?php echo $cart; ?>
		    
		</ul>
	  </div>
		<div class="clear"></div>
        </div>
	<div id="notification"></div>
	<div id="wrapper">
