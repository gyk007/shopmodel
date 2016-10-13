<?php if ($type) { ?>

<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
	pageLanguage: '<?php echo $current_language_code; ?>',
	floatPosition: google.translate.TranslateElement.FloatPosition.BOTTOM_LEFT,
    autoDisplay: false,
    gaTrack: true, 
    gaId: 'UA-51060416-1'
  });
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<?php } else { ?>
<div class="box">  
  <div class="box-content">
    <div id="google_translate_element"></div>
	<script>
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({
			pageLanguage: '<?php echo $current_language_code; ?>',
            autoDisplay: false,
    gaTrack: true, 
    gaId: 'UA-51060416-1',
			layout: google.translate.TranslateElement.InlineLayout.SIMPLE
		  }, 'google_translate_element');
		}
    </script>
	<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  </div>
</div>
<?php } ?>
 