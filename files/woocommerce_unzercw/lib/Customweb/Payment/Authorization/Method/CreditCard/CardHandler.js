
var ____cardHandlerNameSpace____ = {
	cardInformation: ____cardInformation____,
	brandMapping: ____brandMapping____,
	cardPrefixMap: ____cardNumberPrefixMap____,
	creditCardControlId: '____creditCardControlId____',
	cvcControlId: '____cvcControlId____',
	expiryMonthControlId: '____expiryMonthControlId____',
	expiryYearControlId: '____expiryYearControlId____',
	imageBrandControlId: '____imageBrandControlId____',
	brandDropDownControlId: '____brandDropDownControlId____',
	luhnArr: [0, 2, 4, 6, 8, 1, 3, 5, 7, 9],
	imageBrandSelectionActive: ____imageBrandSelectionActive____,
	autoBrandSelectionActive: ____autoBrandSelectionActive____,
	brandSelectionActive: ____brandSelectionActive____,
	enhancedWithJavaScript: ____enhancedWithJavaScript____,
	selectedBrand: '____selectedBrand____',
	forceCvcOptional: ____forceCvcOptional____,
	expiryFieldFormat: '____expiryFieldFormat____',
	expiryControlId: '____expiryControlId____',

	init: function() {
		this.jQuery = ____jQueryNameSpace____;
		this.cardNumberControl = this.jQuery("#" + this.creditCardControlId);
		this.hiddenCardNumberField = this.createHiddenControlCopy(this.cardNumberControl);
		this.cvcControl = this.jQuery('#' + this.cvcControlId);
		this.imageBrandSelectionWrapper = this.jQuery("#" + this.imageBrandControlId);

		this.attachObservers();
		this.handleImageBrandSelection();

		this.handleExpiryField();

		this.jQuery(document).trigger('customweb.ready');
	},

	createHiddenControlCopy: function(original) {
		if (typeof original.attr('data-cloned-element-id') === "undefined") {
			var copy = this.jQuery('<input type="hidden" />');
			copy.attr({
				name: original.attr('name'),
				value: original.val(),
				id: original.attr('id') + '-hidden',
				originalElement: original.attr('id'),
				'data-field-name': original.attr('data-field-name'),
				'class': original.attr('class'),
			});
			copy.hide();
			original.attr('data-name', original.attr('name'));
			original.attr('name', '');
			original.attr('data-cloned-element-id', copy.attr('id'));
			original.attr('data-field-name', '');
			original.after(copy);
			return copy;
		}
		else {
			var elementId=original.attr('data-cloned-element-id');
			return this.jQuery("#" + elementId);
		}
	},

	attachObservers: function() {
		this.cardNumberControl.keyup(this.jQuery.proxy(this.onCardNumberUpdate, this));
		this.cvcControl.keyup(this.jQuery.proxy(this.onCvcNumberUpdate, this));
		this.cardNumberControl.change(this.jQuery.proxy(this.onCardNumberUpdate, this));
		this.cvcControl.change(this.jQuery.proxy(this.onCvcNumberUpdate, this));
	},

	handleExpiryField: function() {
		if (this.expiryControlId != '') {
			this.expiryControl = this.jQuery('#' + this.expiryControlId);
			this.expiryControl.hide();
			this.expiryMonthControl = this.jQuery('#' + this.expiryMonthControlId);
			this.expiryYearControl = this.jQuery('#' + this.expiryYearControlId);
			this.expiryMonthControl.show();
			this.expiryYearControl.show();
			this.jQuery(".card-expiry-format-note").hide();
			this.expiryYearControl.change(this.jQuery.proxy(this.onExpiryUpdate, this));
			this.expiryMonthControl.change(this.jQuery.proxy(this.onExpiryUpdate, this));
		}
	},

	handleImageBrandSelection: function() {
		if (this.brandSelectionActive) {
			if (this.imageBrandSelectionActive) {
				this.imageBrandSelectionWrapper.show();
				this.jQuery("#" + this.brandDropDownControlId).hide();
				this.jQuery("#" + this.brandDropDownControlId + "-wrapper").hide();

				if (!this.autoBrandSelectionActive) {
					this.cvcControl.click(this.jQuery.proxy(this.onImageBrandSelection, this));
				}
			}
		}
	},

	onImageBrandSelection: function(event) {
		var brandSelected = this.jQuery(event.target).parents("card-brand-image-box");
		var brand = brandSelect.attr('data-brand');
		this.setBrand(brand);
		this.selectImageBrand();
	},

	onExpiryUpdate: function(event) {
		var month = this.expiryMonthControl.val();
		var year = this.expiryYearControl.val();
		var newValue = this.expiryFieldFormat.replace('MM', month).replace('YY', year);
		this.expiryControl.val(newValue);
	},

	onCardNumberUpdate: function(event) {
		var cardNumber = this.getCardNumber();
		if (cardNumber.length > 0) {
			this.handleInlineValidation();
			this.updateBrandSelection();
		}
		this.updateHiddenCardNumber();
	},

	updateHiddenCardNumber: function() {
		this.hiddenCardNumberField.val(this.getCardNumber());
	},

	updateBrandSelection: function() {
		if (this.autoBrandSelectionActive) {
			this.selectImageBrand();
			var brand = this.getBrand();

			// Set the dropdown value
			if (this.brandDropDownControlId !== '') {
				var brandOption = this.jQuery('#' + this.brandDropDownControlId + ' option[value="' + this.mapBrand(brand) + '"]');
				if (typeof brandOption !== "undefined") {
					brandOption.prop('selected', true);
				}
			}
		}
	},

	selectImageBrand: function() {
		if (this.imageBrandSelectionActive) {
			var brand = this.getBrand();
			this.imageBrandSelectionWrapper.find("img").removeClass("brand-is-selected");
			this.imageBrandSelectionWrapper.find("img").addClass("brand-is-deselected");
			var selectedBrandBox = this.imageBrandSelectionWrapper.find("div[data-brand='" + brand + "']");
			selectedBrandBox.find("img").removeClass("brand-is-deselected");
			selectedBrandBox.find("img").addClass("brand-is-selected");
		}
	},

	validateCardNumber: function() {
		var cardNumber = this.getCardNumber();
		var brand = this.getBrand();
		var data = this.cardInformation[brand];

		if (brand !== null && typeof data !== "undefined") {

			var brandFromCardNumber = this.getBrandNameByCardNumber(cardNumber);
			if (brandFromCardNumber != brand) {
				return false;
			}

			var valid = true;
			var backup = this;
			this.jQuery.each(data.validators, function(key, value) {
				if (value == 'LuhnAlgorithm') {
					if (!backup.luhnCheck(cardNumber)) {
						valid = false;
					}
				}
			});

			if (valid == false) {
				return false;
			}

			// Check length
			var cardNumberLength = cardNumber.length;
			var lengthMatch = false;
			this.jQuery.each(data.lengths, function(key, value) {
				if (value == cardNumberLength) {
					lengthMatch = true;
				}
			});

			return lengthMatch;
		}
		else {
			return false;
		}
	},

	onCvcNumberUpdate: function(event) {
		this.handleInlineValidation();
	},

	handleInlineValidation: function() {
		if (this.enhancedWithJavaScript) {
			// Handle card
			if (this.validateCardNumber()) {
				this.cardNumberControl.removeClass("invalid-card-number");
				this.cardNumberControl.addClass("valid-card-number");
			}
			else {
				this.cardNumberControl.removeClass("valid-card-number");
				this.cardNumberControl.addClass("invalid-card-number");
			}

			// Handle CVC
			if (this.validateCvcNumber()) {
				this.cvcControl.removeClass("invalid-cvc-number");
				this.cvcControl.addClass("valid-cvc-number");
			}
			else {
				this.cvcControl.removeClass("valid-cvc-number");
				this.cvcControl.addClass("invalid-cvc-number");
			}
		}
	},

	validateCvcNumber: function() {
		var cvc = this.getCvcNumber();
		if (this.forceCvcOptional && cvc.length == 0) {
			return true;
		}

		var brand = this.getBrand();
		var data = this.cardInformation[brand];

		if (brand !== null && typeof data !== "undefined") {

			var cvcLength = data.cvv_length;
			var cvcRequired = data.cvv_required;
			var cvcIsRequired = false;
			if (typeof cvcRequired !== "undefined") {
				if (cvcRequired == true) {
					cvcIsRequired = true;
				}
			}

			if (cvc.length == 0 && cvcIsRequired) {
				return false;
			}
			else if (cvc.length > 0 && typeof cvcLength !== "undefined" && cvc.length != cvcLength) {
				return false;
			}
		}
		else {
			if (this.autoBrandSelectionActive == false && this.selectedBrand === 'null') {
				return true;
			}
			else {
				return false;
			}
		}

		// By default, we accept the CVC.
		return true;
	},

	mapBrand: function (brand) {
		var mapped = this.brandMapping[brand];
		if (typeof mapped !== "undefined") {
			return mapped;
		}
		else {
			return brand;
		}
	},

	sanatizeNumber: function(number) {
		return String(number).replace(/[ ]/g, "");
	},

	getCardNumber: function() {
		return this.sanatizeNumber(this.cardNumberControl.val());
	},

	getCvcNumber: function () {
		return this.sanatizeNumber(this.cvcControl.val());
	},

	getBrand: function() {
		if (this.autoBrandSelectionActive) {
			var cardNumber = this.getCardNumber();
			return this.getBrandNameByCardNumber(cardNumber);
		}
		else {
			if (this.selectedBrand === null || this.selectedBrand == 'null') {
				return this.jQuery('#' + this.brandDropDownControlId).val();
			}
			else {
				return this.selectedBrand;
			}
		}
	},

	setBrand: function (brand) {
		this.selectedBrand = brand;
	},

	getBrandNameByCardNumber: function(cardNumber) {
		var brand = null;
		this.jQuery.each(this.cardPrefixMap, function(key, value) {
			if (cardNumber.indexOf(key) == 0) {
				brand = value;
				return false;
			}
		});

		return brand;
	},

	luhnCheck: function(cardNumber) {
		var counter = 0;
		var incNum;
		var odd = false;
		var temp = String(cardNumber).replace(/[^\d]/g, "");
		if (temp.length == 0) {
			return false;
		}

		for (var i = temp.length-1; i >= 0; --i)
		{
			incNum = parseInt(temp.charAt(i), 10);
			counter += (odd = !odd)? incNum : this.luhnArr[incNum];
		}
		return (counter%10 == 0);
	}

};



