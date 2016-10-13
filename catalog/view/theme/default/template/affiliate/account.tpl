<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
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
  <h2><?php echo $text_my_account; ?></h2>
  <div class="content">
    <ul>
    
        <li><a class="password" href="/forpartner">Информация для партнеров</a></li>
        <li><a class="partner" href="/mypartner">Мои партнеры</a></li>
      <li><a class="edit" href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
      <li><a class="register" href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
       
    </ul>
  </div>
  <h2>Мои ссылки</h2>
  <div class="content">
    <ul>
      <li><a class="tracking" href="<?php echo $tracking; ?>">Мои ссылки</a></li>
    </ul>
  </div>
  <h2>Мои кредиты</h2>
  <div class="content">
    <ul>
      <li><a class="transaction" href="<?php echo $transaction; ?>">Кредиты для вывода</a></li>
      <li><a class="payment" href="<?php echo $payment; ?>">Забрать деньги</a></li>
    </ul>
  </div>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>