window.Customweb = window.Customweb || {};

Customweb.ExternalCheckout = {
	onSubmit: null,
	beforeUpdatePanes: null,
	afterUpdatePanes: null,
	onShowOverlay: null,
	onHideOverlay: null,
	
	init: function(shippingPaneSelector, confirmationPaneSelector){
		var me = this;
		
		this.jQuery = ____jQueryNameSpace____;
		this.shippingPaneSelector = shippingPaneSelector;
		this.confirmationPaneSelector = confirmationPaneSelector;
		
		var Overlay = function(pane) {
			this.pane = pane;
			this.element = me.jQuery('<div/>').css({
				position: 'absolute',
				backgroundColor: '#fff',
				opacity: 0.5,
				zIndex: 9999,
			});
		};
		Overlay.prototype.show = function(){
			this.element.css({
				height: this.pane.height(),
				width: this.pane.width(),
				top: this.pane.offset().top,
				left: this.pane.offset().left,
			});
			me.jQuery('body').append(this.element);
		}
		Overlay.prototype.hide = function(){
			this.element.remove();
		}
		
		me.jQuery(document).ready(function(){
			me.shippingPane = me.jQuery(me.shippingPaneSelector);
			me.confirmationPane = me.jQuery(me.confirmationPaneSelector);
			me.shippingOverlay = new Overlay(me.shippingPane);
			me.confirmationOverlay = new Overlay(me.confirmationPane);
			
			me.jQuery(document).on('submit', me.shippingPaneSelector + ' form', function(event){
				me.submit();
				event.stopPropagation();
				return false;
			});
		});
	},
	
	submit: function(){
		var me = this,
			form = me.jQuery(me.shippingPaneSelector + ' form');
		
		me.call('onSubmit');
		
		if (me.call('onShowOverlay')) {
			me.shippingOverlay.show();
			me.confirmationOverlay.show();
		}
		
		me.jQuery.ajax({
			url: form.attr('action'),
			data: form.serializeArray(),
			type: 'POST',
			success: function(response){
				me.updatePanes(response);
			},
			complete: function(){
				if (me.call('onHideOverlay')) {
					me.shippingOverlay.hide();
					me.confirmationOverlay.hide();
				}
			}
		});
	},
	
	updatePanes: function(response){
		var me = this;

		me.call('beforeUpdatePanes');
		
		me.shippingPane.html(me.jQuery(response).find(me.shippingPaneSelector).html());
		me.confirmationPane.html(me.jQuery(response).find(me.confirmationPaneSelector).html());

		me.call('afterUpdatePanes');
	},
	
	call: function(functionName){
		var me = this;
		
		if (typeof me[functionName] == 'function') {
			return me[functionName]();
		} else {
			return true;
		}
	}
}