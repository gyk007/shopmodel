<div class="content">
<p><?php echo $sub_text_info; ?></p>
<form action="<?php echo $action; ?>" method="post"  id="payments">
	<input type="hidden" name="*scart">  
	<input type="hidden" name="wsb_language_id" value="russian">  
	<input type="hidden" name="wsb_storeid" value="<?php echo $shop_id; ?>" >  
	<input type="hidden" name="wsb_store" value="<?php echo $shop_name; ?>" >  
	<input type="hidden" name="wsb_order_num" value="<?php echo $order_id; ?>" >  
	<input type="hidden" name="wsb_currency_id" value="BYR" >  
	<input type="hidden" name="wsb_seed" value="<?php echo $seed; ?>">  
	<input type="hidden" name="wsb_signature" value="<?php echo $hash; ?>">  
	<input type="hidden" name="wsb_invoice_item_name[0]" value="Заказ в магазине ShopModel">
	<input type="hidden" name="wsb_invoice_item_quantity[0]" value="1">
	<input type="hidden" name="wsb_invoice_item_price[0]" value="<?php echo $summ;?> ">
	<input type="hidden" name="wsb_return_url" value="<?php echo $success_url; ?>">  
	<input type="hidden" name="wsb_cancel_return_url" value="<?php echo $cancel_url; ?>">
	<input type="hidden" name="wsb_notify_url" value="<?php echo $notify_url; ?>"> 

	<input type="hidden" name="wsb_email" value="<?php echo $wsb_email; ?>" >  
	<input type="hidden" name="wsb_phone" value="<?php echo $wsb_phone; ?>" >  

	<input type="hidden" name="wsb_test" value="<?php echo $wsb_test; ?>" >  

	<table width=100% border=0>
	<tr>
		<td align=right colspan=4><textarea style="width: 100%;" name="webpay_shop_mes" ><?php echo $shop_mes; ?></textarea></td>
	</tr>
	<tr>
		<td align=right><?php echo $total_text; ?></td>
		<td width=10></td>  
		<td width=10><input type="text" name="wsb_total" value="<?php echo $summ; ?>" ></td>
		<td width=10>BYR</td>
	</tr>
	</table>

</form>
</div>
<div class="buttons">
    <div class="right"> <a id="payment" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>


<script type="text/javascript">


$(document).ready(function(){
   $("#payment").click(function(event){
$.ajax({
 type: 'GET',
		url: 'index.php?route=payment/webpay/confirm',
success: function () {
     $('#payments').submit();
},

   });

return false;
});
 });


 </script>

