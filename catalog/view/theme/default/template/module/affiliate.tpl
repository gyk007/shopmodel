<div class="box_left_menu" style="margin-top : 20px">
  <div class="box-heading">Партнерский кабинет</div>
  <div class="box-content">
    <div class="box-module">
      <ul>
        <?php if (!$logged) { ?>
          <li><a class="payment" href="/welcometopartner">Дополнительный заработок</a></li>
		  <li><a class="login" href="<?php echo $login; ?>">Вход</a></li>
		  <li><a class="register" href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
		  <li><a class="forgotten" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></li>
        <?php } ?>
		 
		<?php if ($logged) { ?>
        	<li><a class="account" href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
        <li><a class="login" href="/forpartner">Информация для партнеров</a></li>
        <li><a class="partner" href="/mypartner">Мои партнеры</a></li>
        	 
		  <li><a class="edit" href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
		  <li><a class="register" href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
          <li><a class="payment" href="<?php echo $payment; ?>">Забрать деньги</a></li>
		<li><a class="tracking" href="<?php echo $tracking; ?>">Мои ссылки</a></li>
		<li><a class="transaction" href="<?php echo $transaction; ?>">Кредиты для вывода</a></li>
		<?php } ?>
		 
		<?php if ($logged) { ?>
		  <li><a class="logout" href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
		<?php } ?>
      </ul>
    </div>
  </div>
</div>
