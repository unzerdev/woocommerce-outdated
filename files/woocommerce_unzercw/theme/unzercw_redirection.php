<div class="woocommerce unzercw">
	<form action="<?php print $form_target_url; ?>" method="POST" name="process_form">
		<?php echo $hidden_fields; ?>
		<input class="button btn btn-success cw-button-redirection" type="submit" name="continue_button" value="<?php print __('Continue', 'woocommerce_unzercw'); ?>" />
	</form>
	<script type="text/javascript"> 
		jQuery(document).ready(function() {
			jQuery('.cw-button-redirection').attr("disabled", true);
			document.process_form.submit(); 
		});
	</script>
</div>