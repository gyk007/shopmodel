<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { 
        if($product['price'] == 0){
            continue;
        }
        ?>
      <div>
        <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
        <?php } else { ?>
		  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['no_image']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
		<?php } ?>
		<div class="description-box"><?php echo $product['description']; ?></div>
		<?php if ($product['rating']) { ?>
          <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
        <div class="box-bottom">
		  <?php if ($product['price']) { ?>
			<div class="price">
			  <?php if (!$product['special']) { ?>
			  <?php echo $product['price']; ?>
			  <?php } else { ?>
			  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
			  <?php } ?>
			</div>
		  <?php } ?>
		  <div class="carts-box">		     
			<a onclick="addToWishList('<?php echo $product['product_id']; ?>');" class="poshytips button-wishlists" title="<?php echo $button_wishlist; ?>" /></a>
			<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="poshytips button-carts" title="<?php echo $button_cart; ?>" />Купить</a>
			
		  </div>
		</div>
        <div class="clear"></div>
		 <?php if($product['attribute_groups']) {
				
		  ?>
											<div class="atribute">
												<?php foreach($product['attribute_groups'] as $attribute_group) { ?>
														<?php echo $attribute_group['name']; ?><br />
																<?php foreach($attribute_group['attribute'] as $attribute) { ?>
																		<b><?php if ($attribute['text']) {echo $attribute['name']; } else { echo $attribute['name'].' | '; } ?></b>
																		<?php IF ($attribute['text']) { echo $attribute['text'].' | '; } ?>
																		<?php } ?>
												<?php } ?>
											</div>
										<?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>