var CustomwebModal = {};

CustomwebModal.init = function(){
	var $ = ____jQueryNameSpace____;
	
	var Modal = function(element, options){
		this.options = options;
		this.$body = $(document.body);
		this.$element = $(element);
		this.$backdrop = null;
		this.$container = null;
		this.$iframe = null;
	};
	
	Modal.prototype.show = function(event){
		if (event) {
			event.preventDefault();
		}
	
		this.$backdrop = $('<div class="cw-modal-backdrop" />');
		this.$container = $('<div class="cw-modal-container" />');
		this.$iframe = $('<iframe />');
		
		if (this.options.modalId) {
			this.$container.attr('id', this.options.modalId);
		}
		if (this.options.modalCss) {
			this.$container.addClass(this.options.modalCss);
		}
	
		if (this.options.modalDismiss) {
			this.$dismissButton = $('<button class="cw-modal-dismiss-button">&times;</div>');
			this.$container.append(this.$dismissButton);
		}
		
		this.$container.append(this.$iframe);
		this.$body.append(this.$backdrop).append(this.$container).addClass('cw-modal-noscroll');
	
		this.$iframe.attr('src', this.$element.attr('href'));
		
		this.$iframe.on('load.customweb.modal', $.proxy(function(){
			this.$iframe.fadeIn();
		}, this));
	
		$(document).on('keydown.hide.customweb.modal', $.proxy(function(event) {
			event.which == 27 && this.hide();
		}, this));
	
		this.$backdrop.on('click.hide.customweb.modal', $.proxy(function(event) {
			$(event.target).is(this.$backdrop) && this.hide();
		}, this));
		
		if (this.options.modalDismiss) {
			this.$dismissButton.on('click.hide.customweb.modal', $.proxy(function(event) {
				this.hide();
			}, this));
		}
		
		this.$backdrop.fadeIn();
		this.$container.fadeIn();
	};
	
	Modal.prototype.hide = function(event){
		if (event) {
			event.preventDefault();
		}
	
		this.$backdrop.fadeOut({
			complete: $.proxy(function(){
				this.$backdrop.remove();
				this.$backdrop = null;
			}, this)
		});

		this.$container.fadeOut({
			complete: $.proxy(function(){
				this.$container.remove();
				this.$container = null;
				this.$iframe = null;
			}, this)
		});
	
		$(document).off('keydown.hide.customweb.modal');
	
		this.$body.removeClass('cw-modal-noscroll');
	};
	
	function Plugin(option) {
		return this.each(function() {
			var $this = $(this);
			var options = $.extend({}, $this.data(), typeof option == 'object' && option);
			var instance = new Modal(this, options);
			instance.show();
		})
	}
	
	$.fn.customwebModal = Plugin
	$.fn.customwebModal.Constructor = Modal
	
	
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	var tmpId = "";
	for(var i = 0; i < 10; i++) {
	    tmpId += possible.charAt(Math.floor(Math.random() * possible.length));
	}	
	$('[data-toggle="cw-modal"]').first().attr('data-toggle', 'cw-modal-'+tmpId);
	
	$(document).on('click.show.customweb.modal', '[data-toggle="cw-modal-'+tmpId+'"]', function(event){
		var $this = $(this);
		if ($this.is('a')) {
			event.preventDefault();
		}
		Plugin.call($this);
		event.stopImmediatePropagation();
	});
};