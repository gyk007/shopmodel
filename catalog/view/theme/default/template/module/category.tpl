<?php if ($side) { ?>
<div class="box_left_menu" id = "my_left_menu">
  <div class="box-heading">ЖЕНСКАЯ ОДЕЖДА</div>
  <div class="box-content">
    <ul class="box-category">
    <?php foreach ($categories as $category) {
        if($category['name'] == 'партнерская программа')
        {
            continue;
        }
        if($category['variant'] != 0)
        {
            continue;
        }
          if ($category['category_id'] == $category_id) { ?>
	<li class="active"><a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
    <?php } else { ?>
	<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
    <?php } ?>
    <?php if ($category['children']) { ?>
      <a href="<?php echo $category['href']; ?>" class="category-button"><?php echo $category['name']; ?></a>
	  <ul>	  
	  <?php foreach ($category['children'] as $child) { ?>
	  <?php if ($child['category_id'] == $child_id) { ?>
	  <li class="active"><a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
	  <?php } else { ?>
	  <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
      <?php } ?>
	  <?php if($child['child2_id']){ ?>
	    <a href="<?php echo $child['href']; ?>" class="category-button"></a>
	    <ul>
		<?php if ($child['child_thumb']) { ?>
		<li class="image"><a href="<?php echo $child['href']; ?>" title="<?php echo $child['name']; ?>"><img src="<?php echo $child['child_thumb']; ?>" alt="<?php echo $child['name']; ?>"></a>
		<div class="description" style="width:<?php echo $width; ?>px;"><?php echo $child['child_description']; ?></div></li>
		<?php } ?>
		<?php foreach ($child['child2_id'] as $child2) { ?>
		<?php if ($child2['category_id'] == $child2_id) { ?>
		<li class="active"><a href="<?php echo $child2['href']; ?>" class="active"><?php echo $child2['name']; ?></a>
		<?php } else { ?>
		<li><a href="<?php echo $child2['href']; ?>"><?php echo $child2['name']; ?></a>
		<?php } ?>
		<?php if($child2['child3_id']){ ?>
		  <a href="<?php echo $child2['href']; ?>" class="category-button"></a>
		  <ul>
		  <?php if ($child2['child2_thumb']) { ?>
		  <li class="image"><a href="<?php echo $child2['href']; ?>" title="<?php echo $child2['name']; ?>"><img src="<?php echo $child2['child2_thumb']; ?>" alt="<?php echo $child2['name']; ?>"></a>
		  <div class="description" style="width:<?php echo $width; ?>px;"><?php echo $child2['child2_description']; ?></div></li>
		  <?php } ?>
		  <?php foreach ($child2['child3_id'] as $child3) { ?>
		  <?php if ($child3['category_id'] == $child3_id) { ?>
		  <li class="active"><a href="<?php echo $child3['href']; ?>" class="active"><?php echo $child3['name']; ?></a></li>
		  <?php } else { ?>
		  <li><a href="<?php echo $child3['href']; ?>"><?php echo $child3['name']; ?></a></li>
		  <?php } ?>
		  <?php } ?>
		  </ul>
		<?php } ?>
		</li>
        <?php } ?>
        </ul>
      <?php } ?>
      </li>
      <?php } ?>
      </ul>
    <?php } ?>
    </li>
  <?php } ?>
  </ul>
  </div>
</div>



<!-- <div class="box_left_menu" id = "my_left_menu">
  <div class="box-heading">ДЕТСКАЯ ОДЕЖДА</div>
  <div class="box-content">
    <ul class="box-category">
    <?php foreach ($categories as $category) {
         
        if($category['name'] == 'партнерская программа')
        {
            continue;
        }
        if($category['variant'] != 1)
        {
            continue;
        }
          
          if ($category['category_id'] == $category_id) { ?>
	<li class="active"><a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
    <?php } else { ?>
	<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
    <?php } ?>
    <?php if ($category['children']) { ?>
      <a href="<?php echo $category['href']; ?>" class="category-button"><?php echo $category['name']; ?></a>
	  <ul>	  
	  <?php foreach ($category['children'] as $child) { ?>
	  <?php if ($child['category_id'] == $child_id) { ?>
	  <li class="active"><a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
	  <?php } else { ?>
	  <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
      <?php } ?>
	  <?php if($child['child2_id']){ ?>
	    <a href="<?php echo $child['href']; ?>" class="category-button"></a>
	    <ul>
		<?php if ($child['child_thumb']) { ?>
		<li class="image"><a href="<?php echo $child['href']; ?>" title="<?php echo $child['name']; ?>"><img src="<?php echo $child['child_thumb']; ?>" alt="<?php echo $child['name']; ?>"></a>
		<div class="description" style="width:<?php echo $width; ?>px;"><?php echo $child['child_description']; ?></div></li>
		<?php } ?>
		<?php foreach ($child['child2_id'] as $child2) { ?>
		<?php if ($child2['category_id'] == $child2_id) { ?>
		<li class="active"><a href="<?php echo $child2['href']; ?>" class="active"><?php echo $child2['name']; ?></a>
		<?php } else { ?>
		<li><a href="<?php echo $child2['href']; ?>"><?php echo $child2['name']; ?></a>
		<?php } ?>
		<?php if($child2['child3_id']){ ?>
		  <a href="<?php echo $child2['href']; ?>" class="category-button"></a>
		  <ul>
		  <?php if ($child2['child2_thumb']) { ?>
		  <li class="image"><a href="<?php echo $child2['href']; ?>" title="<?php echo $child2['name']; ?>"><img src="<?php echo $child2['child2_thumb']; ?>" alt="<?php echo $child2['name']; ?>"></a>
		  <div class="description" style="width:<?php echo $width; ?>px;"><?php echo $child2['child2_description']; ?></div></li>
		  <?php } ?>
		  <?php foreach ($child2['child3_id'] as $child3) { ?>
		  <?php if ($child3['category_id'] == $child3_id) { ?>
		  <li class="active"><a href="<?php echo $child3['href']; ?>" class="active"><?php echo $child3['name']; ?></a></li>
		  <?php } else { ?>
		  <li><a href="<?php echo $child3['href']; ?>"><?php echo $child3['name']; ?></a></li>
		  <?php } ?>
		  <?php } ?>
		  </ul>
		<?php } ?>
		</li>
        <?php } ?>
        </ul>
      <?php } ?>
      </li>
      <?php } ?>
      </ul>
    <?php } ?>
    </li>
  <?php } ?>
  </ul>
  </div>
</div>--> 






<?php } ?>