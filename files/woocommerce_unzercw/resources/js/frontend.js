(function ($) {
	
	var isSubmitted = false;
	
	var CheckoutObject = {
		
		cssClass: '',
		successCallback: '',
		
		placeOrder: function() {
			var form = $('form.checkout');
			var form_data = form.data();
			
			// WGM: Back Button
			if($("input[name=cw-wgm-button-back]").length > 0) {
				return true;
			}
			//WGM: MultiStep
			if($("input[name=wc_gzdp_step_submit]").length > 0) {
				if($("input[name=wc_gzdp_step_submit]").val() === "address"){
					return true;
				}
			}
			
			var selectedPaymentMethodElement = $('input:radio[name=payment_method]:checked');
			var selectedPaymentMethod = selectedPaymentMethodElement.val();
			var secondRun = false;
			if($("input[name=unzercw_payment_method_choice]").length > 0) {
				secondRun = true;
				selectedPaymentMethodElement = $("input[name=unzercw_payment_method_choice]");
				selectedPaymentMethod = selectedPaymentMethodElement.val();
			}
			var moduleName = 'unzercw';
			var selectedModuleName = (selectedPaymentMethod !== undefined) ?
					selectedPaymentMethod.toLowerCase().substring(0, moduleName.length) : '';
			
			onUnzerCwCheckoutPlaceObject = this;
			
			if (moduleName === selectedModuleName) {
				form.addClass('processing');
				if ( form_data["blockUI.isBlocked"] !== 1 ) {
					form.block({
						message: null,
						overlayCSS: {
							background: '#fff',
							opacity: 0.6
						}
					});
				}
				
				this.successCallback = previewAuthorization;
				this.cssClass = 'unzercw-preview-fields';
				onUnzerCwCheckoutPlaceObject = this;
				
				if(secondRun) {
					this.generateOrder(form, selectedPaymentMethod);
					return false;
				}

				var validateFunctionName = 'cwValidateFields'+selectedPaymentMethod.toLowerCase();
				var validateFunction = window[validateFunctionName];
				
				if (typeof validateFunction !== 'undefined') {
					validateFunction(function(valid){onUnzerCwCheckoutPlaceObject.successCall();}, function(errors, valid){onUnzerCwCheckoutPlaceObject.failureCall(errors, valid);});
					return false;
				}
				onUnzerCwCheckoutPlaceObject.successCall();
				
				return false;
			}
	
		},
	
		failureCall: function(errors, valid){
			alert(errors[Object.keys(errors)[0]]);
			var form = $('form.checkout');
			form.removeClass('processing').unblock();
			form.find( '.input-text, select, input:checkbox' ).trigger( 'validate' ).blur();
		},
	
		successCall : function(){
			
			var form = $('form.checkout');
			var selectedPaymentMethodElement = $('input:radio[name=payment_method]:checked');
			var selectedPaymentMethod = selectedPaymentMethodElement.val();			
			onUnzerCwCheckoutPlaceObject = this;			
			onUnzerCwCheckoutPlaceObject.generateOrder(form, selectedPaymentMethod);			
			return false;
		},
		
		generateOrder: function(form, selectedPaymentMethod) {

			onUnzerCwCheckoutPlaceObject = this;
			
			var checkoutUrl = wc_checkout_params.checkout_url;			
			var postData = "&";
			if($('.payment_method_'+selectedPaymentMethod+' > .unzercw-validate').length > 0){
			    var inputData = getFormFieldValues('unzercw-preview-fields', selectedPaymentMethod.toLowerCase());
			    $.each(inputData, function(key, value) {
        			postData += encodeURIComponent(key)+"="+encodeURIComponent(value)+"&";
			    });
			}
			
			$.ajax({
				type: 		'POST',
				url: 		checkoutUrl,
				data: 		form.serialize() + postData + onUnzerCwCheckoutPlaceObject.cssClass + "=true",
				success: 	function( code ) {
					var response = '';
					try {
						try {
						    	// Check for valid JSON
							response = $.parseJSON( code );
						} catch ( e ) {
							// Attempt to fix the malformed JSON
							var validJson = code.match( /{"result".*}/ );
							if ( null === validJson ) {
								throw 'Invalid response';
							} else {
								response = $.parseJSON(validJson[0]);
							}
						}
						if ( response.result === 'success' ) {
							onUnzerCwCheckoutPlaceObject.successCallback(response, selectedPaymentMethod);
						}
						else if ( response.result === 'failure' ) {
							throw 'Result failure';
						} else {
							throw 'Invalid response';
						}
					}
					catch( err ) {
						if ( response.reload === 'true' ) {
							window.location.reload();
							return;
						}
						// Remove old errors
						$( '.woocommerce-error, .woocommerce-message' ).remove();
						// Add new errors
						if ( response.messages ) {
							form.prepend( response.messages );
						} else {
							form.prepend( code );
						}
						// Cancel processing
						form.removeClass( 'processing' ).unblock();
						// Lose focus for all fields
						form.find( '.input-text, select, input:checkbox' ).trigger( 'validate' ).blur();
						// Scroll to top
						$( 'html, body' ).animate({
							scrollTop: ( $( 'form.checkout' ).offset().top - 100 )
						}, 1000 );
						// Trigger update in case we need a fresh nonce
						if ( response.refresh === 'true' ) {
							$( 'body' ).trigger( 'update_checkout' );
						}
						$( 'body' ).trigger( 'checkout_error' );
					}
				},
				dataType: 'html'
			});
		},
	};
	
	var getFormFieldValues = function(parentCssClass, paymentMethodPrefix) {
		var output = {};
		$('.' + parentCssClass + ' *[data-field-name]').each(function (element) {
			var name = $(this).attr('data-field-name');
			if(name.lastIndexOf(paymentMethodPrefix, 0) === 0) {
				name = name.substring(paymentMethodPrefix.length);
				name = name.substring(1, name.length -1 );
				if(this.type === "radio") {
					 if(this.checked) {
						 output[name] = $(this).val();
					 }
				}
				else{
					output[name] = $(this).val();
				}
			}
		});
		return output;
	};
	
	var generateHiddenFields = function(data) {
		var output = '';
		$.each(data, function(key, value) {
			output += '<input type="hidden" name="' + encodeURI(key) + '" value="' + encodeURI(value) + '" />';
		});
		return output;
	};
	

	var removeNameAttributes= function(cssClass) {
		// Remove name attribute to prevent submitting the data
		var submittableTypes = ['select', 'input', 'button', 'textarea'];
		for(var i = 0; i < submittableTypes.length; i++) {
			$('.' + cssClass + ' ' + submittableTypes[i] + '[name]').each(function (element) {
				$(this).attr('data-field-name', $(this).attr('name'));
				if($(this).is(':radio')){
					return true;
				}
				$(this).removeAttr('name');
			});
		}
	}
	
	var addAlias = function(cssClass){
		
	}
		
	
	var registerCheckoutObject = function(){
		bindOrderConfirmEvent(CheckoutObject);
	};
	
	var bindOrderConfirmEvent = function (CheckoutObject) {
		var form = $('form.checkout');
		var attached = form.attr('data-unzercw-attached');
		if (attached !== 'true') {
			form.attr('data-unzercw-attached', 'true');
			form.bind('checkout_place_order', function() {
				return CheckoutObject.placeOrder();
			});
			return false;
		}
	};
	
	// We have to make sure that the JS in the response is executed.
	$( document ).ready(function() {
		if (typeof window['force_js_execution_on_form_update_listener'] === 'undefined') {
			window['force_js_execution_on_form_update_listener'] = true;
			$('body').bind('updated_checkout', function() {
				removeNameAttributes('unzercw-preview-fields');
            	addAlias('unzercw-preview-fields');
        		if ($('.unzercw-preview-fields').length > 0) {			
        			registerCheckoutObject();
        		}
			});
		}
	});

	$( document ).ajaxStop(function(event, xhr, settings) {
		removeNameAttributes('unzercw-preview-fields');
		addAlias('unzercw-preview-fields');
		if ($('.unzercw-preview-fields').length > 0) {			
			registerCheckoutObject();
		}
	});
		
	var previewAuthorization = function (result, selectedPaymentMethod) {
		if(typeof result.redirect !== 'undefined') {

			var additionalFields = $('<div class="unzercw-preview-fields" style="display: none;"></div>');
			$('.' + 'unzercw-preview-fields' + ' *[data-field-name]').each(function (element) {
				var name = $(this).attr('data-field-name');
				if(name.lastIndexOf(selectedPaymentMethod.toLowerCase(), 0) === 0) {
					$(additionalFields).append($(this));
				}
			});
			var redirectUrl;
			if ( result.redirect.indexOf( "https://" ) !== -1 || result.redirect.indexOf( "http://" ) !== -1 ) {
				redirectUrl = result.redirect;
			} else {
				redirectUrl = decodeURI( result.redirect );
			}
			$.get(redirectUrl, function(data){
				var newBodyString = data.replace(/^[\S\s]*<body[^>]*?>/i, "").replace(/<\/body[\S\s]*$/i, "");
				var newBody = $('<div></div>').html(newBodyString);
				if(newBody.find('.wgm-go-back-button').length > 0){
					$('body').html(newBody.html());
					$('form.checkout').append(additionalFields);
					$('form.checkout').append('<input type="hidden" name="unzercw_payment_method_choice" value="'+selectedPaymentMethod+'"/>');
					$('.wgm-go-back-button').on('click', function() {
						$('form.checkout').append('<input type="hidden" name="cw-wgm-button-back" value="back"/>');
					});
					$('form.checkout').on('submit', function(){
						return CheckoutObject.placeOrder();
					});
					$("html, body").animate({
						scrollTop: $("form.checkout").offset().top - 100
				    	}, 1e3);
				}
				else {
					window.location = decodeURI( redirectUrl );
				}			
			});
		}
		else if(typeof result.ajaxScriptUrl !== 'undefined'){
			$.getScript(result.ajaxScriptUrl, function() {
				eval("var callbackFunction = " + result.submitCallbackFunction);
				callbackFunction(getFormFieldValues('unzercw-preview-fields', selectedPaymentMethod.toLowerCase()));
			});
		}
		else {
			var newForm = '<form id="unzercw_preview_form" action="' + result.form_action_url + '" method="POST">';
			newForm += result.hidden_form_fields;
			newForm += generateHiddenFields(getFormFieldValues('unzercw-preview-fields', selectedPaymentMethod.toLowerCase()));
			newForm += '</form>';
			$('body').append(newForm);
			$('#unzercw_preview_form').submit();
		}
	}
}(jQuery));
