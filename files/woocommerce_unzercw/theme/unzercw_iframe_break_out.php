<?php
add_filter( 'run_wptexturize', '__return_false' );
?>
<div class="woocommerce unzercw">
	<?php echo __('Redirecting... Please Wait ', 'woocommerce_unzercw'); ?>
	<script type="text/javascript"> 
		top.location.href = '<?php echo $url; ?>';
	</script>
	

	<noscript>
		<a class="button btn btn-success unzercw-continue-button" href="<?php echo $url; ?>" target="_top"><?php echo __('If you are not redirected shortly, click here.', 'woocommerce_unzercw'); ?></a>
	</noscript>
</div>