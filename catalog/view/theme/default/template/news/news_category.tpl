<?php echo $header; ?>
<div class="breadcrumb">
   <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
   <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="main-content">
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($news_categories) { ?>
  <?php if ($view_subcategory == 'images') { ?>
    <div class="box-category">
	  <div class="box-heading-subcategory"><?php echo $text_refine; ?></div>
      <div class="box-subcategory">
	    <?php foreach ($news_categories as $news_category) { ?>
		  <div style="width: <?php echo $sub_width; ?>px;">
		    <?php if ($news_category['thumb']) { ?>
			  <div class="image"><a href="<?php echo $news_category['href']; ?>"><img src="<?php echo $news_category['thumb']; ?>" alt="<?php echo $news_category['name']; ?>" /></a></div>
		    <?php } else { ?>
			  <div class="image"><a href="<?php echo $news_category['href']; ?>"><img src="<?php echo $news_category['no_image']; ?>" alt="<?php echo $news_category['name']; ?>" /></a></div>
		    <?php } ?>
			<div class="description-box"><?php echo $news_category['description']; ?></div>
		    <div class="name"><a href="<?php echo $news_category['href']; ?>"><?php echo $news_category['name']; ?></a></div>
		  </div>
	    <?php } ?>
	  </div>
    </div>
  <?php } ?>
  <?php if ($view_subcategory == 'default') { ?>
    <div class="category-list">
	  <div class="box-category">
	    <div class="box-heading-subcategory"><?php echo $text_refine; ?></div>
        <?php if (count($news_categories) <= 5) { ?>
          <ul>
            <?php foreach ($news_categories as $news_category) { ?>
              <li><a href="<?php echo $news_category['href']; ?>"><?php echo $news_category['name']; ?></a></li>
            <?php } ?>
		  </ul>
	    <?php } else { ?>
		  <?php for ($i = 0; $i < count($news_categories);) { ?>
		    <ul>
			  <?php $j = $i + ceil(count($news_categories) / 4); ?>
			  <?php for (; $i < $j; $i++) { ?>
			    <?php if (isset($news_categories[$i])) { ?>
				  <li><a href="<?php echo $news_categories[$i]['href']; ?>"><?php echo $news_categories[$i]['name']; ?></a></li>
			    <?php } ?>
			  <?php } ?>
		    </ul>
		  <?php } ?>
	    <?php } ?>
	  </div>
	</div>
  <?php } ?>
  <?php } ?>
  <?php if ($news) { ?>
  <div class="product-filter">
    
    <div class="limit"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="product-list">
    <?php foreach ($news as $article) { ?>
    <div>
      <?php if ($article['thumb']) { ?>
        <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /></a></div>
      <?php } else { ?>
	    <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['no_image']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /></a></div>
      <?php } ?>
      <div class="name"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div>
	  <div class="description-list top"><?php echo $article['description_list']; ?></div>
	  <div class="description-grid"><?php echo $article['description_grid']; ?></div>
	  <div class="data-news"><a href="<?php echo $article['href']; ?>" class="poshytips button-more" title="<?php echo $button_more; ?>"></a><div class="info"><span class="date-available"><?php echo $article['date_available']; ?></span><span class="poshytips viewed" title="<?php echo $article['viewed']; ?>"></span><span class="poshytips comments" title="<?php echo $article['news_comments']; ?>"></span></div></div>
    </div>
    <?php } ?>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } ?>
  <?php if (!$news_categories && !$news) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			html  = '';			
			
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '  <div class="data-news" style="width: <?php echo $width; ?>px;">' + $(element).find('.data-news').html() + '</div>';
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description-list top">' + $(element).find('.description-list').html() + '</div>';
			 
						
			$(element).html(html);
		});	
		
		$('.poshytips').poshytip({
			className: 'tip-twitter',
			showTimeout: 1,
			alignTo: 'target',
			alignX: 'center',
			offsetY: 5,
			allowTipHover: false
		});
		
		$('.display').html('<?php echo $text_display; ?>&nbsp;<img align="absmiddle" src="catalog/view/theme/default/image/icon/list-icon-active.png">&nbsp;<a onclick="display(\'grid\');"><img align="absmiddle" src="catalog/view/theme/default/image/icon/grid-icon.png" title="<?php echo $text_grid; ?>"></a>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="data-news">' + $(element).find('.data-news').html() + '</div>';
			html += '  <div class="description-list top">' + $(element).find('.description-list').html() + '</div>';
			 
			
			$(element).html(html);
		});	
		
		$('.poshytips').poshytip({
			className: 'tip-twitter',
			showTimeout: 1,
			alignTo: 'target',
			alignX: 'center',
			offsetY: 5,
			allowTipHover: false
		});
					
		$('.display').html('<?php echo $text_display; ?>&nbsp;<a onclick="display(\'list\');"><img align="absmiddle" src="catalog/view/theme/default/image/icon/list-icon.png" title="<?php echo $text_list; ?>"></a>&nbsp;<img align="absmiddle" src="catalog/view/theme/default/image/icon/grid-icon-active.png">');

		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display('list');
} else {
	display('list');
}
//--></script> 
<?php echo $footer; ?>