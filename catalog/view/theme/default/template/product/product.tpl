<?php echo $header; ?>
<div class="breadcrumb">
   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
   <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" itemscope itemtype="http://schema.org/Product" ><?php echo $content_top; ?>
  <h1 itemprop="name"><?php echo $heading_title; ?></h1>
  <div class="main-content">
  <div class="product-info">
    <?php if ($config_zoom) { ?>
	  <div class="left">
        <?php if ($thumb) { ?>
          <?php foreach ($images as $image) { ?>
            <div class="view-images"><a itemprop="image" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" data-gal="prettyPhoto[gallery]"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
          <?php } ?>
          <?php if ($thumb) { ?>
            <div class="image"> 
              <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class = 'cloud-zoom' id='zoom1' rel=" zoomHeight: 'auto' , zoomWidth: 'auto', position: 'right' ,showTitle:false, adjustX:-0, adjustY:-4"  data-gal="prettyPhoto[gallery]"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"  /></a>
              <?php echo $sale; ?><?php echo $new; ?><?php echo $popular; ?>
			</div>
          <?php } ?>
		<?php } ?>
		
        <?php if ($images) { ?>
          <div class="image-additional">
            <?php foreach ($images as $image) { ?>
              <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom-gallery" rel="useZoom: 'zoom1', smallImage: '<?php echo $image['thumb_zoom']; ?>' "><img src="<?php echo $image['small']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
            <?php } ?>
          </div>
        <?php } ?>    
      </div>
	<?php } else { ?>
	  <div class="left">
		<?php if ($thumb) { ?>
		  <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" data-gal="prettyPhoto[gallery]"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a><?php echo $sale; ?><?php echo $new; ?><?php echo $popular; ?></div>
		<?php } ?>
		<div class="cart">
		  <div>
		    <div class="cart-box-bottom">
			  <div class="quantity-input">
			    <span class="minus"></span>
			    <input id="cont" type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
			    <span class="plus"></span>
			    <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
			  </div>			   
			  <a onclick="addToWishList('<?php echo $product_id; ?>');" class="poshytips button-wishlists" title="<?php echo $button_wishlist; ?>" /></a> 
			  <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="poshytips button-carts" title="<?php echo $button_cart; ?>" />
                		 
		    </div>
		    <?php if ($minimum > 1) { ?>
			  <div class="minimum"><?php echo $text_minimum; ?></div>
		    <?php } ?>
		  </div>
	    </div>
		<?php if ($images) { ?>
		  <div class="image-additional">
			<?php foreach ($images as $image) { ?>
			  <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" data-gal="prettyPhoto[gallery]"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
			<?php } ?>
		  </div>
		<?php } ?>
	  </div>
	<?php } ?>
    <div class="right">
      <div class="description" >
        <?php if ($manufacturer) { ?>
		  <div class="manufacturer-image"><a   href="<?php echo $manufacturers; ?>"><img src="<?php echo $brand_image; ?>" title="<?php echo $manufacturer; ?>" alt="<?php echo $manufacturer; ?>" /></a></div>
		  <span><?php echo $text_manufacturer; ?></span>  <a itemprop="brand" href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
		<span><?php echo $text_model; ?></span><span itemprop="model"><?php echo $model; ?></span> <br />
		<?php if ($sku) { ?>
		  <span><?php echo $text_sku; ?></span> <?php echo $sku; ?><br />
        <?php } ?>
		<?php if ($upc) { ?>
		  <span><?php echo $text_upc; ?></span> <?php echo $upc; ?><br />
        <?php } ?>
		<?php if ($ean) { ?>
		  <span><?php echo $text_ean; ?></span> <?php echo $ean; ?><br />
        <?php } ?>
		<?php if ($jan) { ?>
		  <span><?php echo $text_jan; ?></span> <?php echo $jan; ?><br />
        <?php } ?>
		<?php if ($isbn) { ?>
		  <span><?php echo $text_isbn; ?></span> <?php echo $isbn; ?><br />
        <?php } ?>
		<?php if ($mpn) { ?>
		  <span><?php echo $text_mpn; ?></span> <?php echo $mpn; ?><br />
        <?php } ?>
		<?php if ($display_weight) { ?>
		  <?php if ($weight) { ?>
		    <span><?php echo $text_weight; ?> </span> <?php echo $weight; ?><br />
		  <?php } ?>
		<?php } ?>
		<?php if ($location) { ?>
		  <span><?php echo $text_location; ?></span> <?php echo $location; ?><br />
        <?php } ?>
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        <span><?php echo $text_stock; ?></span> <?php echo $stock; ?>
        <br />
       <div class = "border_availability"> <span class = "title_availability">Таблица наличия:</span> <div class = "availability"> <?php echo $colorAndSize; ?> </div></div>
	  </div>
      <?php if ($price) { ?>
      <div class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer"><?php echo $text_price; ?>
        <?php if (!$special) { ?>
        <?php $isBYRprice = strpos($price, "BYR");
        if($isBYRprice){
            
            $MYprice = $price * 1;
            $newPrice = $price / 10000;
             echo "<span itemprop='price'>".$MYprice."</span><span itemprop='priceCurrency'>BYR</span> (".$newPrice." BYN)";
            
            
             
        }
        else{
           echo $price; 
        }
           ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        <br />
        <?php if ($tax) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
        <?php } ?>
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
        <br />
        <div class="discount">         
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
             
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      <a class="basic"><?php echo $text_table_size; ?></a>
				<div id="basic-modal-content">
				  <?php echo $table_size; ?>
				</div>
      <?php if ($review_status) { ?>
      <div class="review">
         <div class="share"><!-- AddThis Button BEGIN -->
          <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_odnoklassniki_ru"></a> <a class="addthis_button_vk"></a></div>
<script type="text/javascript">
var addthis_config = {
   services_custom:
   [{name: "myyaru",
   url: "http://my.ya.ru/posts_add_link.xml?URL={{URL}}&title={{TITLE}}&body=",
   icon: "http://favicon.yandex.net/favicon/clubs.ya.ru"
   },   {name: "shopmodel",
      url: "http:///shopmodel.by.php?action=n_add&cnurl={{URL}}&cntitle={{TITLE}}",
      
      } ]
}
</script>          
<script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script>

          <!-- AddThis Button END --> 
        </div>
      </div>
      <?php } ?>
	  <div class="cart">
		  <div>
		    <div class="cart-box-bottom">
			  <div class="quantity-input">
			    <span class="minus"></span>
			    <input id="quantity" type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
			    <span class="plus"></span>
			    <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
			  </div>
			    
			  
              <a id="fast_order" class="button" />Быстрый заказ</a>
				<div style="display:none">
          <div id="fast_order_form">        
            <input id="product_name" type="hidden" value="<?php echo $heading_title; ?>">
            <input id="product_model" type="hidden" value="<?php echo $model; ?>">
            <input id="product_price" type="hidden" value="<?php echo ($special ? $special : $price); ?>">
            <div class="fast_order_title">Заполните форму и наш менеджер свяжется с Вами</div><br />
             
            <div class="fast_order_right">
              <p><label class="customer_name">Имя: <input type="text" id="customer_name"/></label></p>
              <p><label class="customer_phone">Телефон:<input type="text" id="customer_phone"/></label></p>
              <p><label class="customer_message">Комментарий:<input type="text" id="customer_message"/></label></p>
            </div>
             
            <div class="fast_order_center">
              <p id="fast_order_result">Пожалуйста, укажите ваше имя и телефон, чтобы мы могли связаться с вами</p>
              <button class="fast_order_button"><span>Оформить заказ</span></button>
            </div>
          </div>
          
        </div>
        <input type="button" value="Купить" id="button-cart" class="poshytips button-carts"   title="<?php echo $button_cart; ?>" />
		    </div>
		    <?php if ($minimum > 1) { ?>
			  <div class="minimum"><?php echo $text_minimum; ?></div>
		    <?php } ?>
		  </div>
	    </div>
    </div>
  </div>
  <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>   
    <?php if ($review_status) { ?>
    <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    <?php if ($products) { ?>
    <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>
  </div>
  <div id="tab-description" class="tab-content" itemprop="description"><?php echo $description; ?></div>   
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <?php if ($guest_review) { ?>
	<b><?php echo $entry_name; ?></b><br />
	<input type="text" name="name" value="<?php echo $customer_name; ?>" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
    <br />
    <div class="buttons">
      <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
    </div>
	<?php } else { ?>
	  <?php echo $text_login_write; ?>
	<?php } ?>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="related-box-product">
	  <?php foreach ($products as $product) { ?>
		<div>
		  <?php if ($product['thumb']) { ?>
			<div class="image-related"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
		  <?php } else { ?>
			<div class="image-related"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['no_image']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
		  <?php } ?>
		  <div class="name-related"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
		  <?php if ($product['price']) { ?>
			<div class="price-related">
			  <?php if (!$product['special']) { ?>
			  <?php echo $product['price']; ?>
			  <?php } else { ?>
			  <span class="price-old-related"><?php echo $product['price']; ?></span> <span class="price-new-related"><?php echo $product['special']; ?></span>
			  <?php } ?>
			</div>
		  <?php } ?>
		  <div class="cart-related">
			<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a>
		  
          
          
          </div>
          <a id="fast_order" class="button" />Быстрый заказ</a>
				<div style="display:none">
          <div id="fast_order_form">       
            <input id="product_name" type="hidden" value="<?php echo $heading_title; ?>">
            <input id="product_price" type="hidden" value="<?php echo ($special ? $special : $price); ?>">
            <div class="fast_order_center"><?php echo $heading_title; ?> — ваш заказ</div>
            <div class="fast_order_left">
              <p>Имя:</p>
              <p>Телефон:</p>
              <p>Комментарий:</p>
            </div>
            <div class="fast_order_right">
              <p><input type="text" id="customer_name"/></p>
              <p><input type="text" id="customer_phone"/></p>
              <p><input type="text" id="customer_message"/></p>
            </div>
            <div class="fast_order_center">
              <p id="fast_order_result">Пожалуйста, укажите ваше имя и телефон, чтобы мы могли связаться с вами</p>
              <button class="fast_order_button"><span>Оформить заказ</span></button>
            </div>
          </div>
        </div>
		</div>
	  <?php } ?>
	</div>
  </div>
  <?php } ?>
  <?php if ($tags) { ?>
  <div class="tags"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script> 
<script type="text/javascript" ><!--
$(document).ready(function() {
    $('.minus').click(function () {
        var $input = $(this).parent().find('#quantity');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('#quantity');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
});
//--></script>
	<script type="text/javascript" ><!--
				$(document).ready(function() {
					$('.basic').click(function (e) {
						$('#basic-modal-content').modal(
                        {
                            overlayClose:true
                        });
						return false;
					});
				});
				//--></script>
<?php echo $footer; ?>