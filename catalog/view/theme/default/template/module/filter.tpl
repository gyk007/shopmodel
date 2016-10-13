<div class="box" style = "margin-bottom: 20px; border: solid 1px #CCCCCC">
  <div class="box-heading" style ="margin-top: 0px;"><?php echo $heading_title; ?></div>
  <div class="box-content" style = "background:#E2E0EB;">
    <ul class="box-filter" style = "border-bottom: none;">
      <?php foreach ($filter_groups as $filter_group) { ?>
      <ul style = "background:#E2E0EB; display: block; border-top: none; padding-top: 0px; float: left;  ">
      <li style = "background:#E2E0EB; border: none; margin-left: -5px;"><span style = "background:#E2E0EB; border-bottom: none; font-size: 18px; padding-bottom: 4px;" id="filter-group<?php echo $filter_group['filter_group_id']; ?>"><?php echo $filter_group['name']; ?></span></li>
		 
          <?php foreach ($filter_group['filter'] as $filter) { ?>
          <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
          <li  >
            <input type="checkbox" value="<?php echo $filter['filter_id']; ?>" id="filter<?php echo $filter['filter_id']; ?>" checked="checked" />
            <label for="filter<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
          </li>
          <?php } else { ?>
          <li  >
            <input type="checkbox" value="<?php echo $filter['filter_id']; ?>" id="filter<?php echo $filter['filter_id']; ?>" />
            <label for="filter<?php echo $filter['filter_id']; ?>"><?php echo $filter['name']; ?></label>
          </li>
          <?php } ?>
          <?php } ?>
             
        </ul>
         
       
      <?php } ?>
      <div class="clear"></div>
    </ul>
    <div class="button-filter" style = "background:#E2E0EB; border-top: none;"><a id="button-filter" class="button"><?php echo $button_filter; ?></a></div>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').bind('click', function() {
	filter = [];
	
	$('.box-filter input[type=\'checkbox\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script> 
