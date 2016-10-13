<form action="https://test.paysec.by/pay/order.cfm" method="post" id="payment">
 <input type="hidden" name="Merchant_ID" value="<?php echo $shop_idp; ?>" />
 <input type="hidden" name="OrderNumber" value="<?php echo $order_idp; ?>" />
 <input type="hidden" name="OrderAmount" value="<?php echo $total; ?>" />
 <input type="hidden" name="OrderCurrency" value="<?php echo $currency; ?>" />
 <input type="hidden" name="FirstName" value="<?php echo $first_name; ?>" />
 <input type="hidden" name="LastName" value="<?php echo $last_name; ?>" />
 <input type="hidden" name="Email" value="<?php echo $email; ?>" />
 <input type="hidden" name="Comment" value="<?php echo $comment; ?>" />
 <input type="hidden" name="Language" value="RU" />
 <input type="hidden" name="MobilePhone" value="<?php echo $phone; ?>" />
 <input type="hidden" name="Country" value="<?php echo $country; ?>" />
 <input type="hidden" name="Zip" value="<?php echo $zip; ?>" />
 <input type="hidden" name="City" value="<?php echo $city; ?>" />
 <input type="hidden" name="Address" value="<?php echo $street_address; ?>" />
 <input type="hidden" name="URL_RETURN_OK" value="http://shopmodel.by/index.php?route=checkout/success" />
 <input type="hidden" name="URL_RETURN_NO" value="http://shopmodel.by/index.php?route=checkout/notsuccess" />
 <div class="buttons">
  <div class="right"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></div>
 </div>
</form>