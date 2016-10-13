    
    <?php foreach ($products as $product) { 
        if($product['price'] == 0){
            continue;
        }
        
        ?>
    <div>
      <?php if ($product['thumb']) { ?>
      <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
      <?php } else { ?>
	  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['no_image']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a><?php echo $product['sale']; ?><?php echo $product['new']; ?><?php echo $product['popular']; ?></div>
	  <?php } ?>
      <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      <div class="description-list"><?php echo $product['description_list']; ?></div>
	  <div class="description-grid"><?php echo $product['description_grid']; ?></div>
	  <?php if ($product['price']) { ?>
		<div class="price">
		  <?php if (!$product['special']) { ?>
		    <?php echo $product['price']; ?>
		  <?php } else { ?>
			<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
		  <?php } ?>
		  <?php if ($product['tax']) { ?>
			<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
		  <?php } ?>
		</div>
      <?php } ?>
	  <div class="cart-box">
        <div class="cart-button">
           
		  <a onclick="addToWishList('<?php echo $product['product_id']; ?>');" class="poshytips button-wishlists" title="<?php echo $button_wishlist; ?>" /></a>
		  <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="poshytips button-carts" title="<?php echo $button_cart; ?>">Купить</a>
		   
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
	  
    </div>
	
    <?php } ?>
  