 <?php 
function MyGetOS1($userAgent) {
  // Создадим список операционных систем в виде элементов массива
    $oses = array (
        'iPhone' => '(iPhone)',
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // Используем регулярное выражение
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
        'Windows 8' => '(Windows NT 6.3)|(Windows NT 10.0)|(Windows NT 6.2)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',         
        'Open BSD'=>'OpenBSD',
        'Sun OS'=>'SunOS',
        'Linux'=>'(Linux)|(X11)',
        'Safari' => '(Safari)',
        'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
        'QNX'=>'QNX',
        'BeOS'=>'BeOS',
        'OS/2'=>'OS/2',
        'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
  
    foreach($oses as $os=>$pattern){
        if(eregi($pattern, $userAgent)) { // Пройдемся по массиву $oses для поиска соответствующей операционной системы.
            return $os;
        }
    }
    return 'Unknown'; // Хрен его знает, чего у него на десктопе стоит.
}
?>
<?php
if ( (MyGetOS1($_SERVER['HTTP_USER_AGENT'])  == 'Windows 7') || (MyGetOS1($_SERVER['HTTP_USER_AGENT'])  == 'Windows XP') || (MyGetOS1($_SERVER['HTTP_USER_AGENT'])  == 'Macintosh') || (MyGetOS1($_SERVER['HTTP_USER_AGENT'])  == 'Windows 8')){
    
    
    
 
?>
<?php if ($banners) { ?>
<div class="xg-gallery" style="width:<?php echo ($image_width + 12); ?>px;">
	<div id="xg-slide" style="width:<?php echo $image_width; ?>px; height:<?php echo $image_height; ?>px;">
		<div class="gallery" style="width:<?php echo $image_width; ?>px;">
			<ul class="items">
				<?php foreach($banners as $banner) { ?>
				<?php if ($banner['link']) {?>	
				<li><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="" /></a><span class="banner"><?php echo $banner['title']; ?></span></li>
				<?php } else { ?>
				<li><a><img src="<?php echo $banner['image']; ?>" alt="" /></a><span class="banner"><?php echo $banner['title']; ?></span></li>
				<?php } ?>
				<?php } ?>
			</ul>
		</div>
		<a href="#" class="prev"><?php echo $text_prev; ?></a> 
		<a href="#" class="next"><?php echo $text_next; ?></a> 
	</div>
	
	<?php if ($show_thumbnail) { ?>
	<div class="pag" style="width:710px;">
		<div class="img-pags" style="width: 640px !important;">
		  <ul>
			<?php foreach($banners as $banner) { ?>
			<li style="width:<?php echo ($thumbnail_width + 5); ?>px; height:<?php echo ($thumbnail_height + 20); ?>px;"><a href="#"><img src="<?php echo $banner['thumb']; ?>" alt="" /></a></li>
			<?php } ?>
		  </ul>  
		</div>								
		<a href="#" class="xg-button button1" data-type="prevPage"><</a>
		<a href="#" class="xg-button button2" data-type="nextPage">></a>
	</div>
	<?php } ?>
</div>	
<a  href="/dostavka" title="Доставка женской одежды" target="_blank"><img id="mydostavka" style="margin-left: 18px; margin-top: 10px;" src = "dostavka.jpg" width="700px" height="71px" alt="Бесплатная доставка женской одежды"/></a> 

<?php } ?>

<script type="text/javascript">
function bp_redir(new_url){
	if (new_url != "undefined" && new_url != "no-link"){
		location = new_url;
	}
}

$(document).ready(function(){ 
        $('.gallery')._TMS({
            show:0,
			<?php if ($pause_on_hover) { ?>
            pauseOnHover:true,
			<?php } else { ?>
			pauseOnHover:false,
			<?php }  ?>
            prevBu:'.prev',
            nextBu:'.next',
            playBu:'.play',
            duration:<?php echo $duration; ?>,
            preset:'<?php echo $preset; ?>',
            pagination:$('.img-pags').uCarousel({show:<?php echo (int)$pag_show_elem; ?>, shift:0, buttonClass: 'xg-button'}),
            <?php if ($pag_nums) { ?>
			pagNums:true,
			<?php } else { ?>
			pagNums:false,
			<?php } ?>
            slideshow:7000,
			<?php if ($num_status) {?>
            numStatus:true,
			<?php } else { ?>
			numStatus:false,
			<?php } ?>
            <?php if ($banners_effect == 'disabled') { ?>
			banners: false,
			<?php } else { ?>
			banners: '<?php echo $banners_effect; ?>',
			<?php } ?>
			<?php if ($wait_banner_animation) { ?>
            waitBannerAnimation:false,
			<?php } else { ?>
			waitBannerAnimation:true,
			<?php } ?>
            progressBar:'<div class="progbar"></div>'
        })	
        
        $('.img-pags').css("width" , "645px");	
 })
</script>
 <?php }; ?>