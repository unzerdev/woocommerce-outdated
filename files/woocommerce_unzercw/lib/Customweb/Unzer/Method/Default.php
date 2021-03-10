<?php

/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

require_once 'Customweb/Unzer/Container.php';
require_once 'Customweb/Unzer/Communication/Operation/DirectCharge/ResponseProcessor.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/Unzer/Communication/Operation/RecurringPaymentProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/Recurring/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Metadata/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/Recurring/RequestBuilder.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';
require_once 'Customweb/Unzer/Util/Spinner.php';
require_once 'Customweb/Util/Invoice.php';
require_once 'Customweb/Unzer/Communication/Processor/DefaultProcessor.php';
require_once 'Customweb/Payment/Authorization/AbstractPaymentMethodWrapper.php';
require_once 'Customweb/Unzer/Communication/Webhook/Processor.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Communication/Operation/DirectCharge/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/Shipment/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/CancelAuthorize/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Customer/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/CancelAuthorize/ResponseProcessor.php';
require_once 'Customweb/Payment/Util.php';
require_once 'Customweb/Core/Logger/Factory.php';
require_once 'Customweb/Unzer/Communication/Webhook/PaymentResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Basket/CreateRequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/Charge/ResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/Shipment/RequestBuilder.php';
require_once 'Customweb/Unzer/Util/Form.php';
require_once 'Customweb/Unzer/Communication/Webhook/RetrieveRequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Metadata/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/Authorize/RequestBuilder.php';
require_once 'Customweb/Unzer/Form/Adapter.php';
require_once 'Customweb/Unzer/Communication/Operation/CancelCharge/CancelResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Webhook/ReturnProcessor.php';
require_once 'Customweb/Unzer/Communication/Customer/UpdateRequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/CancelCharge/RefundResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Operation/Charge/RequestBuilder.php';
require_once 'Customweb/Unzer/Endpoint/UnsupportedWebhookException.php';
require_once 'Customweb/Unzer/Communication/Operation/CancelCharge/RequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/Authorize/ResponseProcessor.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Communication/Operation/DirectCharge/PaymentInformationResponseProcessor.php';
require_once 'Customweb/Unzer/Communication/Customer/CreateRequestBuilder.php';
require_once 'Customweb/Unzer/Communication/Operation/PaymentProcessor.php';
require_once 'Customweb/Unzer/WebhookAdapter.php';
require_once 'Customweb/Unzer/Communication/Basket/ResponseProcessor.php';


/**
 *
 * @author Sebastian Bossert
 * @Method()
 */
class Customweb_Unzer_Method_Default extends Customweb_Payment_Authorization_AbstractPaymentMethodWrapper {
	private $container;
	private $logger;
	protected static $paymentMapping = array(
		'creditcard' => array(
			'machine_name' => 'CreditCard',
 			'method_name' => 'Credit / Debit Card',
 			'parameters' => array(
				'jsConstructor' => 'Card',
 				'path' => '/types/card',
 				'prefix' => 'crd',
 				'authorize' => 'yes',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'yes',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'yes',
 				'updatable' => 'no',
 				'customer' => 'mandatory',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 				'customer_email' => 'mandatory',
 				'partialCapture' => 'yes',
 			),
 			'not_supported_features' => array(
			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'secureinvoice' => array(
			'machine_name' => 'SecureInvoice',
 			'method_name' => 'Secure Invoice',
 			'parameters' => array(
				'paymentInformation' => 'yes',
 				'jsConstructor' => 'InvoiceSecured',
 				'path' => '/types/invoicesecured',
 				'prefix' => 'ivs',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'yes',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'mandatory',
 				'basket' => 'mandatory',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'yes',
 				'birthdate' => 'mandatory',
 				'pending' => 'authorize',
 			),
 			'not_supported_features' => array(
				0 => 'Recurring',
 				1 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 		'openinvoice' => array(
			'machine_name' => 'OpenInvoice',
 			'method_name' => 'Invoice',
 			'parameters' => array(
				'paymentInformation' => 'yes',
 				'jsConstructor' => 'Invoice',
 				'path' => '/types/invoice',
 				'prefix' => 'ivc',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'yes',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 				'pending' => 'authorize',
 			),
 			'not_supported_features' => array(
				0 => 'Recurring',
 				1 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 		'securesepa' => array(
			'machine_name' => 'SecureSepa',
 			'method_name' => 'Secure SEPA',
 			'parameters' => array(
				'jsConstructor' => 'SepaDirectDebitSecured',
 				'path' => '/types/sepadirectsecured',
 				'prefix' => 'dds',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'yes',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'mandatory',
 				'basket' => 'mandatory',
 				'returnUrl' => 'mandatory',
 				'birthdate' => 'mandatory',
 				'b2b' => 'yes',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Cancellation',
 				2 => 'Recurring',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'directdebitssepa' => array(
			'machine_name' => 'DirectDebitsSepa',
 			'method_name' => 'Sepa Direct Debits',
 			'parameters' => array(
				'jsConstructor' => 'SepaDirectDebit',
 				'path' => '/types/sepadirectdebit',
 				'prefix' => 'sdd',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Cancellation',
 				2 => 'Recurring',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'bcmc' => array(
			'machine_name' => 'Bcmc',
 			'method_name' => 'Bancontact',
 			'parameters' => array(
				'jsConstructor' => 'Bancontact',
 				'path' => '/types/bancontact',
 				'prefix' => 'bct',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEcAAAAyCAYAAAAOX8ZtAAAEi0lEQVR42u2bTUhUURTHZ+HChYsWgi5atCiQchEU0SJIokVhiwIpDcOsoKLECCHLyCzFUMEonSIzpQ+ysozMFEkMLUb6QFHDb83PiSwsM0XH8fT+r84wjm8m805vHnkPHJ733fvuO+93z7n33DtoMilCRP6KJiv6RtEJWpwyrGipouEmFqUQoGgTSXGWZIaTLVnMEZuiawGnQ7LQlPMmycCtFEg4Eo6E8x/AGS0isu4l6g4h6lqmv/aFKTYUGwyOrZ+ofwtRq8kYOm4xCByblagz2DhgoEPRBoBj/07UE2osMFCEl0/hzNh+GWE0MIaAMxhpTDA+h/MpUfgDzMVnyBRxVUg/NIQbDM5IjjCY8qp4YTCWl7EG8xzkEG1+QmCa3u4WBnOnNMHzewa26wxnvJaoPUAIzGDzVvKPEgOTUpDy5wH6WqgjnMkW4VzmW+s6CtpnFgITkW4me/cq/TJkS9tHOnSthvbmVGtq2r0ymuleLgRmsn0FrYzLFQKz/Ohdso780G9vdaGk3qNBgTE5NNq6RgiMvT2INp68JAQm+MBNahkY0XfjufTgLbcG+e0001DTJiEwM8octTsjSwhMQHQ+1bZY9d+VezKqoW6H2JKtTJpJ+elCYPx2XaNiS5dvjizcGVXybL9wLpP3KEl4yb5Y1ui78xx3RsVdTqVjuWkL1j2ZGcJgEm5a6B+KWFj5UiOyKn1/EmhEMBtOP6aJqWkJx1VD4otoZGzSGGfIyw7fMRQYLyZ54nCQHcONfQkFudbZ+2/1CKWF7a0wYj2fRnVXHT1F/m4l4Ug4BoCzPaNCXbFwHLD5XOm/TNfnLdh9938eW9CzmMPmuXufX54DMNGXqtSlFOWrle8d9VhBbNN27d/y3NzXylM8rUTO/WD3DRuwejnL94kpzWdd7+NZnEF5DQ53BuIoH7jyQi3jDMU5ncdH3K5pV8vrT5U4jhOevut1fBinBbgPSbxdR/5Reeo9eCnAMQD0gV036jEg1c2Ds5b41Ifv1L75eVzZs+FZkdnPHXVISZyfRRR4zXMACB8GYyvq+9S6wuo2VWEE2j1+3aOW8fe29HL1g9B+S2qZ2h4GIUSvV7WoENEP2qKeYQIWQ8A9tA2MLVS9FvBR5gHDUt9h/eqwA30DBtoBHNrhsA51HE78vqbeL96FgytG/HnjgFqHK9wbINjVGQ6unGFzyg9Qzi7Np4zoByPNhjMcDp2w5CfqsxDXOoQjgAEq7EMdoK098VB9t6dI8GpY4aVcxkjAYIQCyp7gQIdHJ+YY9jdwUNaCgzDi44vVCQ8ccEKP39cHDsIJIQIQ7PpFrzodbssf6QkOz1F/E1ZacHjuwIE/Jlt4LbwZz3A7wMEC4hpWEIQd2mGwhOEsibkx60gS8wuMQue8evEVcc4TMuAxHIwijzp/wHwmZPTHcNCGVx/n92GeQx1s47CCFwKQ64QMYWhemZB55neXVyxkM6i17IpsKjEBu0sb3C3xMkOW2wcJx2dw+iUHTckEnALJQVPCACcQm1XJYpbkOf/PVeBvDxpe5FDwf2dHmMtPwJEXuT3bF5YAAAAASUVORK5CYII=',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEcAAAAyEAAAAAB7pEXyAAADjklEQVR42u2XX0gTcRzAhSAHNXwy9jCf7EmECl+2HkIOmlcDh2QKowNLF9QGq5GgWcOB5AYxLoKDkJGSw0KFYDBYGmJkuOY2cf6nFMcORhszmyCN5S++rbFbzbt5dw9Suy9ju/3uvr/Pff9fGTpSR1kJp4RTwinhHHgkrm++Cn1buMtX1qSJFZFwUnfW7b4l4bJ7SQScFD3/VQwY39KGQzDOD9PivjgwvqU1qUCc/eSaVCwYEXA+k+LBCMaJ1HJtMBjAaHb5oBMJ58sVLhjXMS6YNy0iWSexMrfFDjO9zgXz8nL+HZ8qeOIkFwM32GE+HscvsMM8PfPnA8X51Z29MFel8QebFthhurdDr3lV5eUastYWycng+dBZdpigiYiwwxBkQsGrZ40M5ytqjPvfc8CcuB1nh2keC9fzbKGt00xFF0/ObrPDBE49uMYOo/aGRnl39HxVb5+ww8xtkRxuUsnenRMwYDBVjVZxVZoXp7mSezwuaN5hqnp0z+pkk4fPuWCeVQgcv7g2OIxYygRPg+LBGJUpzZHBaXPuloswK2sJcWCKK3ucOMs1RqUwlNbpoeTh3cTSsxKKqJWv8LNK6bXvX8Ax67QEQXZaDlfcCx3h+lg1y3SpKNTlC9QdguzH25wY7fr1UpbSpP25VebvXF3Jz6PMNaFRjB5K/h7f5IxRTp7dxxYpCgcuC9dj9OPvCDWPZYp92j/Zi9GGCRgXZinYDMqB2ovQgB2nMNqs2y0HAMOESoZTLsd8dybpnZJZCtZxCqwdq+6rg7Plmsxqp6Uo69giRqVK5qtEyKP36PvqMHqmw6PH6B6Ny6GSdVUh1GnREu7gZK+vEqO7qgBzwA4Ihgl3sOl+mzPtdwfhwaJW+iro0BI4lfY7JRg9MuzRg6Pgvk1pkTgEqfYGGhAKNAwlezRgdsDx6KFqQ/lXyTKmhtkx0BCrBuWAA+4xGVQyhLJnKY07OGAnSIyOWm9ZtUS+F4p0VtQK3wmFSmbW2SL5OFpiR59VVhgHo3M443EYM262AE77Kg8co9LlMOvA/FMuMC5smY8DMVXYWTkciA+ydk/eo1F757vhv6i1H886CyGcMhl29Jw4jRuZkbKvbk++o4cMg49TAqE85QKc9lV4dtjg71B2SgAHpyCDMvfNdOCUSgbOilVHrdlQRgjQighliH9mvTi4GebSl71hpv3M8sBM+lKTKOGUcP5LnJ+hejw+HoD48AAAAABJRU5ErkJggg==',
 		),
 		'wechatpay' => array(
			'machine_name' => 'WeChatPay',
 			'method_name' => 'WeChat Pay',
 			'parameters' => array(
				'jsConstructor' => 'Wechatpay',
 				'path' => '/types/wechatpay',
 				'prefix' => 'wcp',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAgCAYAAADZubxIAAAFK0lEQVR42u1bLVAbQRSOiEAgKiIiEBGIzDQi015CBOJmEHB37dCZighEBCICEYFAICIiEAhERUQEIiIzRWR6F4pARFRUICoqKioQCEQFogIR0e473tHXzd6xm8td05l9M28gx97e5n3v/x2ZjAKZYzNreK9Mw7PbVc85q3jWuDKyrx/Zs7+xvw3Zz07F29pg65cymhafKud2GQBl/JOB90uW/fUj+3TNtWpaigtIAAwD6lIF1Ai+BEXRUl0AAldcdZ1DBspkTuAGPIF9YX8t5X/njvPMtX6aM7BT1vz8vbmspZ0ygdBTADfgzxrkdN3yUorgBuxpyaflmv3SJjVgb6sj56A8fPNMSz4Feum9LiaQUE2za1+x2nmHJlkA8tpHa0WjkKT1uvZFgsBOoPnx0ttan26a2Hvs73dQK2sUkqp1mfUkZL13Fdc6qQ23CtPhYGsDul5UCZgXyWk0krDekbUfAdI94xslYB9ali1RfH3xYXMVEith18t1dhWOLVIGcPt5hfUyzzAZrwvuT0oZoaooEI7f6o3sVLGYiWuOJNqSnwzX3hY1MQBs3OM+4ll9hWOfCa4BEF8E16FNeqCwNyjmO8ZdxqB0Dfy8TdbECSlLCJ6IGrh3GxlkcgkinPlpDJjvURYcWCJYpSi+AjDVc9sI3X/kNCBrlrD+rwrHhi9fFFw7FQjvUEFAYEFDwd48xQG4gGcNA9gUnOk4jgXfRwkeJkd/1lp1rJVvfYs8t/OhsR362H7WLO3eb1TKdsZN7tog4jpPJbRs3gWeSCrDKbdXmEKU8TnZGAAD7RPFzeKeJYmQkcvIJEsq9aqftDGrVk3KYPKkAHAW3Rf9gl28PuC0v0c+F9G9t9Btj9G1R7n+MIDfouB30OqplW0w7jDeY3zE+IJTojGCXJYEGEKEgfu1UYn7uHdwnmVBKOhn5OpX60SqE+Y6h6ojRcLfFJ0PBbJOYmSfWMwmCi1QijGXiGURnCxaRFvy2WNUEkrdiPWbRJFmcdFXIQlXB6+vI/j8Xk6GK1dCa1nIgMPdvFXH7DlOE+RCEeB9YgE9osFNIiSwqqCJYoQItoOWbSokY1ec283gvWWBpyngsw8lAaZJVhcVuSRIBAsog1pIKDoLwBnM2jeG+a7/Vsc86uaRpZpIlAkgAy7GHQmu73DCo1xAocm66O4T1lfCNceocLsE1FliMPVUPby/gb+bRLHXiTLvBwDvyIIAnSfSHOnNs0HCd7okqY9f5kCgvXmMd7SMakjsJ9M2bT8Bzhln4dT9r8wI8CrxAtRrmMSVd0nMzj3GTr/rpNKhmnPXC0q1GYuAHn5pQ5CUtDD20aRjIHCtlFYQnOUYABc4xcrgWdocMKoAN7iEMMgF6PpjDDd/exgohVIeEwo9wwy0G9LcAGCvBUDV0E3XEMy6AKwyglxHq1nBBG5ZwYJ7eE+OxGB6TxM5rwDwEp7LwDMVBeuLKI+/FR4G77GTpBgTphiv8OSwJBEJYzviniYKvBQhzA20tA7G72ecEohcaJ64yzoqYPC5LOi8bUbsEeZhmuQ+0fphSCbsDwAmKQM8ieqCaVImhyjVNOH4LjVwDdd+qzGZC9UQ3JMnBxQhPedFiruapmk7IiQJBgSus5sguHfacv8xQU2aDLjWWL+eswDELKw5b2BhVqwluyAEbUMOpB9+bB7Zp5KzXX++C/vM2KHSlKgFP/yH4OMQgJ/7wuABLBJe94Emif/fhiPn4GG4z8qtiDmxpkWw4IcBBLwI0NLS+L/pN/SXXK+UD8CVAAAAAElFTkSuQmCC',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAgEAAAAACsQj/XAAAFLElEQVR42t2ZQUgbWRiAc8qtF2HxJO1V9qJFQaSHHFroMaxzyGEOKcwhhyA55KAQcIoRIhtpcCM71IgjTW2krUQ21ICREIYy6CwNNWUnEJpZnLIKUYKO3VBGMvX59nVmkpcYZQ9O/nfw+d6bmff9///+978Xm4aVev/fv+Tsr5Mr4/PDoCysro1m75eFc0KzuNiamw4nXydDg08/40pocGPzy6MuAv7y6MUUHtVYXkwdTnYBcL2f65kWr8YFZVrkeur9lgY+e7Bc6gxWt/O3JcsCf1u6Li4oSxHrIV8CnxM3wQXlld+SwNn7N4Gdy7x/Xtu3IPDRz52GKr0s9u2dwKBV2z+lLAb88s51UKfFtdH9uyiu757M8hublgI+pTq37yyfLlfP0KNlYWEVquDfnywEzI8ZkWb2nr3Dw84P7/TqK/a4+Mqv9334int1pYJqqnpwgGtvfiKb5TjU33pcsyiKdCm12pXA5sxqsU/TtkcaYZdLxbieZtT2t0dm9oz963Xcq4kfeTfHDQygOs+HQrjR1arX6/HEYizr9SaToMXtbjfxWk2S9P9Y1u2mL4QkHz7M59sCR+1mCwMr7vTqK3a9/s9vxgc+PpnLNCrkdxb3apoWRVRzu9H0gkHchBTF6USjkbQHliSaNgJns+hN/rZbpc1sq6efc3bQ/OlouTSX2R45e2DOtBf7cO7+7B3u1dksw8Cay2Wso/5CgeeRC/p8zWqAwIWCURH5PM+rajtgTQuHgXJVlecLhcalUanYmgMTfm89pdbrrYJZaBD3hKqSJPyIx6OqEFRRqMtNTBQJIhIJhRwOjjO7vxH4zZtwOB53OqHNMplAIBqdmHj8GKrI4aBppCYjsNcrCNEoTTMMSU5MgPcoCloGJGlrnn663Pjpc4LraXVgBGVhFe8+EDKRAGuSJIFl0mmWBapwOGAYU1WnU1ULBaO1kDgckQiseTzG9nQaKKm1Sw8N6aErEKjVOC4aRaNSKRvcWsw77XHR+IFPR/PD7berl3fwwOEwsABFAQ0zDJiS3y/LmiYI+mQDAVHMZnGBbGgIOq+mhULIkqoqSYIQDDYDw6Dl8bhc0JFBGJSkcJjn9WUE/Mj21tkuQz6cXBm/en/emsID5/MABH5OkoB7wXo8DqcHRZKqVZxL63aF9isUPB6/n2FiMYDaeg1Dr6IommZZigLtDAN8QhDC4QvgvRMcwu4JWLV/jHWWlKDMq1lIUhCQ9Qji4MDng9sUyzaOA5ZvjPJmHIKAFocLQJZbA5dKwAegb4B2RQHK83pB+LKdE7M8PqvqNP+K2ltvAhQVDAoCCiaRSDoNg4fLhdwViiwTBAoteGBJgsrStEgE9hiXgRmYZWEoBHEAtvv9ogg95iKXztlvdjQ0ekMricX0lCOdvncPQfG8283zspxIIKx8niASiVJJlpNJOKrRwhSVTFYqYA3DHuZCUAZnBq7VCEIQZFkUUbsoDgxAxdvA4f+qoNT+3NTuqqdSyWT0acAMCvUwDE2jAAP7M5lQKBCIx6tVqALdRQGYoiQSsRj4i3o4DnoMGmH0GIYBfXq702k4D5eF6x8QUUQ352G3VVIpoCrDFc/uyc1w/1q9/bA8n0r5fGhv/nGJp+fP/8/qvT2STBqXkuGa9sPX68DO8lawbtt76f27neOujFvrYgcL/GeyU9hivCt+atn67yrg19xO78Zm86kXnHu3plpnVZYDXhuFBwF0Bj4uFuP8WM6es79//vFJWTCfjbsA+K1zZm+nV+ty+Q5uw8BK9STX0QAAAABJRU5ErkJggg==',
 		),
 		'alipay' => array(
			'machine_name' => 'Alipay',
 			'method_name' => 'Alipay',
 			'parameters' => array(
				'jsConstructor' => 'Alipay',
 				'path' => '/types/alipay',
 				'prefix' => 'ali',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAfCAYAAAAslQkwAAAGP0lEQVR42u1bLWwbSRQ2MOjJ++dcIwUUBBQUFBQEBBywVHC62r6cFJ0MCgwCDhQUFBQcyEkGBQUF0el0auytFFAQYBBQEGAQYGAQEJ2su92VQUBAgEGAwYLce7Oz9sx41vtnb+LIKz018Y4ns/u97/18M83l6FUxrVKl5RxXWla/3LIH87ZKy76otpyjV+Z/L3KrK9sLXn4D7DYjc6st+7fVW8/oKh865QzBHYO8YnJ27D27A4BvMVyv3n42AN/EB8g5//nQfvqLOdhEg8+6CUC+uA/PXzIHjx46wLHZVzZtU5ijk2SeuGvdzOUeGYZS+l5Vn0UZbxjGJo73Db/v3/vps/WEOqb7oKPJMgFsaKpp6Oot2AB+zYeN13W1T8d7BoAHFpZfnJfLjuXa2ndP8BlVVX2Mv6+vryuzAO5S4KasbDrv2YmrpvUpaCyG83kArGnaUwDJ9cHSdaUW6hDgCEEAC8XlDaQaY9kBNgx1B5z6g6Ep+17UUo8CAcbcOpcIQfrr9AAz7KWmnacBGK9XTWer0rTeYLh+CNHYS0lqHa2oK78bhtZYihBNQg/D3gmLCy/TAPzQLgzJGOnQ/Ki3FABDyPkkgktZfJoUYNbb0fyXMr6nq59J1ECD0Fcsqj9gyMPIQec9xs/kuV/fQvbA+BMImV0cj/UA2DcMoeiwwjrbdE5isJYfg56pqGmvYYyF4+Dncqoiq9y03/mtEGvVv/99zIU6c7AhHdeye2kBXi8UNuCljChIF2BDHrTCi0QAI4DcPbXO5LK64EyXcgdTXVjbe0lxt0fXejx2El3tTSIPPA/kSTZ3Rkw/eWYtl1EKzTAGnyFbo1q16Yw9+tc//1GwBUkLMMte4r0Cm3Vd+5oIYDGnzwb4lqaINjWXX4OyGyV8ArBX/PfUPcYpusJ6dqYdR6kx998trE0Klh8HG+N5m87rtCEaADEY9lroscho4QW7bHhdEMAum+9JAcPft6KwCcL2W+FvnkzuQdUbwmImCgzx3cwD4EuaX7t0RyhYemza3/h5rZPUAGO5LwNABAdYvVCAsd2YZuOIHbOmadtiYVjUlDcA3EFRVz/is5AWhneMjrDeThCLOQcIeN6oAKN0eVA+tJ/LZD3SWpjO20rTbrMyZ7lljQsDlDHTFlkGoe8433IMKRaV50KoG/nN/UIAhrGStu1sxvd3pmoFuXEAk0KOf66+/9w0NXipIk43ILz0KwTQl/JQDADm1jHcVk1rW9RtS3908qgAAeD73A4V5OPUADPsRSZIwGsLLN7PGGBTyMNkCxRlVCGFWCQ0AwPDGCx9LlrhR6k5wgEGsAj7PHbKQBmBnSLoQSI9KkIwZpgGYNSM/YIE/2U15KCcJRuXMcA1+t0jIY/mg/OsBGDoCsT8DqD+Nfk7+lZSgE+RkWGtDWPDiml9EFsmP5TD/RrNw25cgLliBH6eoW5xYVJk+kIBxhZIMjdtj+TriQCwdO7JOs4Sbzagvgxtzm68ytnqh2m46AAkZ0v2ncPYm8C4XL1ggC+YMT3p50LaiAqwqLvPap2iAwxhF/NsHHDZtghPaLB9cBDYXk63v8Ic13KlBirP8QMpB+x2n8yme8tJTzq/NolXzGielUqmZM2MQJIEYLn2Tpw31XZhg4oT4Zv3ABCOnewmDZ5hgeaLI9WWtZNLduWpDBe51+NaKaF/nKfQgSKL3yIx7YwrhmGqvLHblG3qiHtU5owEsMhiWaEZF2ALc7AHMp6uJAWVcMzG7ongIXMZcDmG4+G6OCcmuBcrqYojtFM+80sLULLQrsFuJsWPvOChDO8J3x3GAdhb/3j8tazQTNImNdgWiIDnKVI1ZOlUyG1aezJHkBVj921LjvSqyH7fGE17WuhQDohMiNtwwOSolazHZmXXn9s7kYKbHJ7h/eDDCvoWU2g25naiAzfvEdwIe7xxD+u5GBnC8vQ9Ab8e1mMv8iKOQDsEFHFmOUJSqfIKiqGPHnOtbTRyAsJ09med0IhzaO8+n42+K4A9tmsNrnBMw945bzbENWsFcIjy5rVn+ZQAW/27Adg5XgE8BXCHbBuSQwaF+fzHANKX3gXAkMfv7dEX3JLk+u0lP+qD54IzBriRW13ZXkTJ8nTo0QLD8jkWa6u3nd31P7MWb4nhM+ysAAAAAElFTkSuQmCC',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAAfEAAAAABZboqvAAAFjElEQVR42tWZXUgbWRSAfWleBRsEd6HdBHxoJQ+yUgxrqYuCFMFFyVIZqg+LiHEJpKxKJbugIOpuaaw/GNZS7QYJDhJiSCMKSs0mEFDMWiUhSMOi0ZCoNIb+EJKV2Z5eLzOZzGSS1Egz58Hcn7l3vnvOPefcawH18fHXWUQzoqfV6crzk8WtoyYqL58CinJEH5dkLtrAK2teAvs2s8FFyPmo5YI5SbbAj0sWt/IQeKyfD0e/HTZHvBGvQcHX4/nJ53/Afw2XDMyvv6Vh1IUM8/fhGzZaayd3y5Lr9/x2EiRaC6W3Vw0KbeBy7SRHwEp1oURGxOPs+oq5QgnInh9K2F3ul+Ya89C25z+JUNS70wRgg4IM07I+ijq/pJi1+m1hYJ+nKAhYRiO7RUYwgZHDHOuPHuca2Krtaxwy2cn2jgTgiFf4VX+dMDDoF6RqJDUwRQWb//nt7dXcG/Ke36AxaB4FBqZzYNKHNqRfkLXR1MCX9bw79Xl8HrC9HAA/HMS4hZIfHqQCRutu0MCnQEk1qVQr1Vatc769o2pERrT2Oufpd12+gel7ipp1GVEx13TS13hoQ/WEWUaArPzFnImMlUtlxHKJgNPacEIgQvJhDXV5f4uum3UIAYfkxW2FksqFa7cR2vYyP7BqEpUMGigZNKh0Y5xesKLgyC/4XX1L5UJrLyxJ9R1oK24bMqH9mbyB4nEY5cZ4sttkAc9Jloa55OCTW4mptAEhYKRfMob1/JOEHxjv9URgwCTMhBlvDHNPsoGWno+ub4FyzToqWbW4h9EI5XF9RmGJmUS+vwWdPTtCJn0aAf2WS+PxkBx9cFEQGWz6wEVBtPMfBVAZRmPPo+tCbfcUULKTbB2DDVy7fRoRBP5zkQwbFE+rE2uNP6LOphoh4CETDYBxHg5mBtzegfUIiwey8Q12h1O27s5ffUOmvkbUUj+BWuonmDpGC8CclwN4rH/17+MjOuELNrvuLqyixPPfT58XNgs5rdMI7FysEc88+ojitpNIJsBKNe5dRzDbrVrsF2jBwM7zuSrmYG7CDHbCHQnOgXWhYDOker5Nt9izEwjjDPfMtV/qvI5+Lw0LASP9TtlwGSYGQc4lc2DcPv07Re2WoS1SLtV12Um2hum5wOcn+44k4P3SsHlhlQZ5YplfcYuZiX30eKIhNXC0FlxJ6SDKk5l7i67LDhgytvYOtEuR9eCRaeDtZbzjH3wPf12+FMDzK2cudsABmWiw/4yDE5i5d8NUk+inkx2JrotZh40Saz0z4NZeunflAnOcZGC6N0gdkfLwsD66+we3f54RsfPcD2uuu/QZmq1fPsH7OjNgBFl9h/6NNwcXMM7gEwMUJ7BbHAhz46JwdNR0kITtFr+4P/k1XTNlg4m6O9Hxjxa8DCiapgOMs7PdMmZ62t2JkhJ+YHq8cqnA8dARjamSj/kv7sdU0OXNTV0IUpLX3fzDxOPlUu7IhxwZjpHpJR5kDIIShJqiIDbikBwdLQmzndS3VI1wAWMd026TB/hZ45krprKInlgw7KwD4x01AS7W+Csr9w0F+ljaG7NDFYidTBe4UCK98lUPaIrpenbLUEoJC8sNTFFQL71Cu01eL+2IoiB01OTZ8W68uYmbd76jF4F2ZBd1oLNqh0wgKN/GwN2dRqNBQ8a4/GxIbu6B3tHaPT9ISM5sdfng/YHptG48Xn7EZZ98+S74tAGL6ODCD+0YmMtO0nmitRATitsSFyFFaqkL2b71bgTCgbBv03k98WaD+5LvYm+mPwfY3DMwjdxjav2meXjgk2eNXwow9g1KdfJBgwU8I8oe2CL6UoDrJ2rWlerEszcPsFucPbC/7iKBQ3IUuXN7/VNAUYtb2eEiz56H/0yjKLd41sEOP0IOy7eZn/89/B/3rielBT2j2gAAAABJRU5ErkJggg==',
 		),
 		'prepayment' => array(
			'machine_name' => 'Prepayment',
 			'method_name' => 'Prepayment',
 			'parameters' => array(
				'paymentInformation' => 'yes',
 				'jsConstructor' => 'Prepayment',
 				'path' => '/types/prepayment',
 				'prefix' => 'ppy',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 				'pending' => 'uncertain',
 				'pendingCapture' => 'yes',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 		'eps' => array(
			'machine_name' => 'Eps',
 			'method_name' => 'EPS',
 			'parameters' => array(
				'jsConstructor' => 'EPS',
 				'path' => '/types/eps',
 				'prefix' => 'eps',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE0AAAAyCAYAAAAZfVakAAAFEUlEQVR42u2aL2zbWBzHCw7kLslUsJMKTrpJN3BgYGBgYKDSgYGBgoIDA3H8ntNTCwaqq50NNFLBwEBBwUDBwMBAQUHBwEDA7pLpelJBwcBAQUFBQUHBQED3+z7b1+eXZ8eO7dyWvJ/0U9L62en75Pf/dW7OiBEjRowYySLduU6lV2+zXtU76NW8417NPSLdw+/o2neGkCK96tPfCNQp6VWMfvrrh417hlQggEFQBgnAQr38UHcfGJf8sVODFUXgVL2Tv2veLlRjfadw49l2y5q7pkB5KUMB1H7dex2F6j6ZdWj7ctzSBfzAGq8tru69nWlo5ILnErSduHX9WvuN7L4zbmnXbteveZuxcKveKwPtGtpAgvYsYd2O7MYz7p5P7xCsRShiV2yWne/Mh+t6N7zbplAzkl76896tcfXD9xs/zRYsCvio7lN0ACPUvaAEsT79LdONjfv5YUWVypblKbcyqd7SK6Yb28ikUHQIQ23WsMXtJ31mq9W62eT8d9JnUNt2HnPOU7u3xfmixRzXsvlmolrWfEnTDO9Et3EC1IcVJrj0Yq/ePowB19Xdwxi7bTNnv8n4lU5txt/SmjtxnwmwTZsfxN2vqmX9cWuC0NztNPMyrAma+JHQyKKWaCOXKTY7aDLWGLIuy6oQsI9pgU0UGiAU4OJd1Z18GOk3DMgR6IxtZbp/YtDovTrmgTX1q95jwCQ4W7r5GQpduv9MB01YCONnmk19shh7Ra+7MRZ0Icck+vlIuX72lcQ0d0Xjfu817runui9KDR00m/P1YSBsq9OJ3k/r1lRrpI0/l6BFr5H1/n+9pgTt3/r6zQiIuruExlyrdE1ei+JWB4022I9slqwr7m9pMueFao3Scy4i14R1soaqlImXkXAmBe20gGb/TAMtGmcc525iKTIUl3wXE26cLaYdJX1WIdDghgUMMI9GQVPdctjaovEvDOYB0POM4D6XAu4/SytgJgZYo6AlFq1+0ojELrnotW37XtayAxY36ovKFdPUzIlM2a+2G2mVnvExDzTRJUTXX6prVldXa7bNGcW/Hbre1ejpkIsXnTSSsuc/1T8XJBBZNDM0q9X6VXU/m7E3WfeDGEj3HivZulFmcXusXkdGBcyggO2mU3c7NhGgb5TU7xRE1vw81FaRO/pu2Xqg3henop9VXJyy6aNyO4KCRztZq3gJ7kup/brKoQMkkdJ7zyJHO2NtlPN3CN6IX+RaJ/mgOS8mNeUYwOKK+CeXrFaBLgDARGwieLmA2fwAGbmM06fjpH9ywQwNIyKMtMuBBkti79FahZW8KC3Gt7Dz4HmNubJEOYorSN21cUqOb0b87DhWWaHXevtQduuphBZMMyoY/+CAJZfSM9QCeWqhlSkGWonQ0FijOS9tcDht0JDpUJOh1KD3K+gt83wmwJc26v5aoIXVP6wNwNBzogShzS9g83iPaQetu486ruk4D324zrK4h/M1vGKdKIipi6DXBVwPjgqX/NESa1BZ8zOa/fCLwXMwGLWY8+TbgmbzTWyWoGz7kPghajbAxO9Q1QswtLHwiC/oV3cBEeem9P41oPnvBfAKRu0YBATnBRU8TwAX0xS2QiB/8e/D+UMJnUMOaJHRjW6N3y7Rt09gwimt+PZFnCNro00HBe+KBPo5wGLT4ZQE68TZKlkRrFJAg3XCXQHfP5hexs9Yg3Agxkw23yu1GJ4mEbM5AgvrNDQySOFTXSNGjExKvgAUDcNzmIs00gAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAE0AAAAyEAAAAABshtU7AAAEfklEQVR42u2YX0gbSRzHe3APpbSV43z00YMrwj2Ug9am93Av5SilhJ4P1aRynITSXtcikV5ylZCkd1itYsRwZetuEaIQYsoaTkRpCUkgxooklJRiLBK6hGr+oD2Txbhh67k3TncTd7NJat0U3O/T/GZm57Pzm5nfb+fIdtU+Rw7RDtHkRqMbnx398/t2S8e53pPPjjJ1VYP2YrqtR/kDpxsnXrurAu21+8p7Phirq+ZXMdnRNpM3TgAcTcBKW2k4f209dKPMaFOnAcrDJEDZTFrOAMs/38mM1n0JrC5u6W8mwcyZf5IZ7ZqbxXj0hG/rPwUcLDMacJ4d49sGI1WBBnbnuJpve/QEOFlmtDf2MBWmNpN8G3WMta00HwYqYbTEhWJKPZAJzY5dNRdGgUKpvp1oOnC0iF4KC2p24oDRwNnFqd2Ct46rx9UPPwQuqO5L+S9Jp+fRSdOkKRBdWxUaZHF0CnUp80XlykDTBLjBf/8qouc3C1OdNq62i7dT46RV9+tbTgO62Ba/59rq4GV+PVSqtiI0vHVvfsbUWem9aCHzzYuFg2rUfuRD1sfcPS4EViGalRZrDF0O0RZHNWrhgUNm0IJQCNdXhKYJwNSHqfM2WOmxBJenUcd+CXBoNNNBwIH0X+NzIyZuhm55wVoy7jq7g9iHtTadgWB6NXRg70no4IkmDm2mD4IQCmb3HW4tnEen6v937pYWRz9qhwK0jRZQeo4ORjg9R4E19YBD+0sDhsXn+C90IHAe2dItLyjdPe5HoBaCcbICtLYeqQ6sSwEanDMSyz9IoJ112YhJeKUZdfm9SkDTq6U6dJwrRGMKWxDcQk+nb58VhrseloIrQJPOyLqaC9EKfhIZuL7A8RtdEjs+jDqmvLUG9+ermFsrpN+CxdHmUWC9eRFashlfbMzY+zNU5zewZ/HNIbpD1/9gIYQljrbyGDoQPS82JJUzfAHacEdzSWjtFljeaJnO9J/qat4rvJWPtjgKFDI7kOthaI0u7fzPfgnr+Jo0QZe/WC8zGpSa9Iid86xs9WwQK9aCDWjpdNkxtLSkR3zQ/kZmZ4XduVcczYFUEN6vvJ9okr6AEZsLp4rZWU/9jcXBBi/TTMlo7Zb8C5hxdUSfuFA62p173bOEgj3po0vFZuz22e5ZP1JWNAA/dKVo6rT44fFJstyNFvHjgq9OG3D2AaKx133eBjtWXN4GeCgfKFp5z2eGRmKpWukkUQY0P5LNMNseg0/i/pLKSaff+4zGxgAS88XQ84Ti3VaqllCsrS4POFUvcY9hIUhibi2JEYpsJmT+N7EQnEdD5nTaj6SoMSP7MR4DPvf0/idCcymzGXtNqta8Hidt9fYaB+LWPr3P/vw5kBGTUxWIDg8RikCUUNDMTN/KY5eSZmz1L/F51GNIJIaHjDp+hPgINJjkcJZsZszo1rK5LT5HYu+2XMroksfA1jhVcXJ4iM1MXMo46YstD8z0LQ9QOXvNpGkhSOV8MWbbF/v7R//+oO3vk83M9AWiVXqJxXzG92uHaCU8/wG5e24aqL/T8wAAAABJRU5ErkJggg==',
 		),
 		'ideal' => array(
			'machine_name' => 'IDeal',
 			'method_name' => 'iDEAL',
 			'parameters' => array(
				'jsConstructor' => 'Ideal',
 				'path' => '/types/ideal',
 				'prefix' => 'idl',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAAAyEAAAAACTJPDZAAAESUlEQVR42sWYXUgcVxSAg0P6lqcGLAQtDXlYCCGQh9Q8rPRBmJfBC4OyVSIskUW3MWXFOiiB/G2yxVbDClvT20INC6us7UJCgikVZou1stmGFCosSdl0E/Qimj8ilbQh9naOZyc7M46irjO552V/5tzvnp977pm7i7s+dr015Ny+7cjrU2UgPyDbk4PMSxpZK+sWBqh6+d93XECaxUP8wog0t2/TyK276HVwls/yjDQpxWibcIzp6Hr2q+QQ0jqeBVOSLCD2E/qwzwUkjvvt4QrPqpsHqF2CbRp5+vu1EikMTg9Oj6V/+Slf/fIH49N53iSgrWuhm0YSZWNpWDzzZerqAitpxOlBZgfdMSSK7OtL/3Vd1/kt6LGxdIeRKLHEq37UuiUd0CyNUceRRAlNze9GvZsSJJJxrzqEJIq/So/rcc1Ov+ACkihdPnRvbtW5k1+4gCTKlUuo261tmE66AXI5GB1vZfXsrJQzlK3RoXhHpNCchKmak6NDugSiesrAt/Mn8VukMDoUKcg+dO7DIMRz+bN1kDnJ+6ZMH2DfUrOtT3p6K4kSiBpLBCB8WXRivhqRqsi5KhJl+B4+9ZHm2pRki/yH11lOh0zxwZlsvhqhDYuIvF87k53JhqYA0ZfWl3BixYhsTuJSzkqwP22RSWo9kI6zUiwDUShr/TIieysD0UBU9umIafqkh/NYwogkyu1D8OykhhSZLRJWY5bDxJg+uRaIqtGxGMulGoBNtHF+96kZOZZG78FcGE0LsoeuPfeNyEeDnKeuWpG9las1tePHzzl/1e/LGpG6y6H0/TFkg4yvQTaaHAufrlyyOnYsbUyxSMGIPDWHv0JS4t60IJeDXgtSLaaPKt7ZA6mwVNOcROQ0VUVVBADYvlSzwBYYxHqiDZHzu+F/+AQDju7UsO0m+V06wkrAAcsm+ftO+D/zJtEjq3wINn3zHufPP0akebS+2SY2peBZMEJlQWSdNGMoBap4491Ywl8FE7fU4vrRyt5KVQTL0PXw24mVWKL0BOq3aVYmqeMFD09Q1Icu4ebXriD1IED9yVy0RX4qeIlR5oPlIbuKVkKGPNhvi2wSzBk7W6aV/TJ2vDDX472uIKE8wD4o1THHkXh8RcfXLes7jQxNoXajFskRyRXkz39iTYNWRG+5HEW2h1beX63K46Wjy1Gk7JvJguYLfpjo9dVhJOYq5wMUbCx17I4h4x36CxGclBODG/SxO4Fsqb37FLUW+VFtjiZhwxeEcpENi7EE9ECYqdC81ZGlPY4h20PXzkEXpLu0XtsaR4n17qBMpL8qEO3ynT+ZkG4fKsGwpYEYHmE5xYUXd84zEi7cL2AhdxT5gn83Xle8kIm/dPR6Is+vSeGKeuYp9r7hivXuQ0zIbmFr0kmbhEbmJceYMfYiGxnRX3gcvd3yEFkIV9z6av7Cpi/UUsPbE/Vy5uKD/Vu7QHx7l6Nujv8BicIW6mI4150AAAAASUVORK5CYII=',
 		),
 		'przelewy24' => array(
			'machine_name' => 'Przelewy24',
 			'method_name' => 'Przelewy24',
 			'parameters' => array(
				'jsConstructor' => 'Przelewy24',
 				'path' => '/types/przelewy24',
 				'prefix' => 'p24',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'giropay' => array(
			'machine_name' => 'Giropay',
 			'method_name' => 'giropay',
 			'parameters' => array(
				'jsConstructor' => 'Giropay',
 				'path' => '/types/giropay',
 				'prefix' => 'gro',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGwAAAAyEAAAAADMGb3VAAAFZklEQVR42u2afUhbVxTA0+6PUl3APx6i4MShmEJhMQvNIA4Z7XAITRO6iRnatZChaRREMyZ0MjGtmZsQk4UOP+owI47aGbCuzmIrvlZnowOhkciK6AyhBSE4GaKpRLLdnpy8fGoiZu1L884f75373k3u752P+/Eux5ukB+e1AXvyC60eeMguuftg/l3Pqahgbun3DSc7uRQ7Je/tptG19AhgywbhO2yFYuBodQjY04L8DbZjEclwTn0cBFbWAzd46zeNm9pEBrX2eGLRePTGfT/Y3QdQWGrYmEh0tko0GJf6zuYH+3yAFGTpHFWJT8OJB+Nf9IPxL5ICRd//0b8kHoxLEWd8AUaNEPW6KlnAHBd8YKCaLSmwFBjLwBaKiPz5OOnAJHIiCjoFxhYwfSeRH39KJY9XC2z+THtx/dH24vGhbZ1zC6zk3Aq1mNUEGnm+ZbZOMGglpbt8Ut5UUSdoU5nUK+WhYEKl2UKk1JCx0rh6r9+WbbYo+gImICU11f3OKdmyce7ycGGthJompadvQa1v/TMRRR+UiHdiBjOpIZKINFX80QhXC0WhMfbzNmiLHNkJciaIzq36o0xtiVx2Qt+5rQsEK5sGrVYyXMj8p9mSsQJt0R4PfslPC3nrXCqnwi0FnWhEngwRbWMCwGMAs5oCGyaRf5a7H9ilv+Hca9vW1QmwXvkc83J2+eFga28GA3w5A235+lOv17Voy7Zl+/1HGNhGeI7fClq3MGZX/EKLQCPiRU5HOjYvOhiRNtWIeKGo1wZancBq8npXyvGljA+Fg/03czfWZ5Ya7vUjKLx78U6ZzwZZumUj3CtxMPUmtYhPjvcEMYOBW0nkzx6BjvaIDibvgfjzetFeDp+TjQ+B3uwOB3NLC45B89HJZGpsnlBZU924Wp85dAHuQAyC83lEeSVcakbD2DJGMHQv1LuP7AfWa4Mnt3UIinWfPQp8PhhsRoONmfTN22uqiXZ2MHxuCHeu6DE6eetwVZ8ZN9j55xjy+4ONLfmcqQv0ynP4W1hSrQ8Hs2VjYzCJVLq4lEztEUFSmNSaLcHIeSVg20ltrYScN7VZujjA0BXpFyCbE/snj4lmrIsJA914igN6e3GkGBMqiU5NYxohkQQtcUv5rYHzRADjUuCaHtG8kJxveOLqxzTdaLNem/lDec/+yYMB03dCiaab2NtqUtB7JQ+7U55fNg3RgsnD7mSuSxyIjGBMXXKcvhUXmKMQbRactmMBW+uqPIevBaEk8pbZSP1Y6AFp/KYRey9iFXBLBoxLYZ4kryXukccUh+mDWmZH02IH83qXrgV30KQX+yctEtgdLtoqsIMWKpklQI+o0hXcxzFp3uttXD3AkMqlHE37QWC8RBft8nEc4lJGG1IthnwFoIs60hsWFHS1viPdaoLOORzMbMnSGa7OaBxVc5drJQErTa39TrvTUTWj+eR90jIiJK2AFBwDK7qlORVxg611BV5DlJ1/fliDYAbsIIPcs4N7194TTN+poHttY0ujad1HMHm0qV42WKXrhgfXqj0iyKhxgl3hBUcJ6XLBEV8mWODg+LrqQNMWZnwI0rCwdO3w5mMHBet34u8YruJM4ADJY/7MRPOgdWzp98fY2R4WWE5F2TSRaM4UTcj4UfNBrWTveqnltxTYqwaW4UxSMPikjjMd9oO57D6wql9hpuNaTAYwHu3/8Gf5CIrk+TiSZjPYV2Y/mOeU+DcoFO9MyXD1gZ1gOSLY7eEbk9tXs/yrDxkrJ8cSJ5HH44cnt3NDNrDMqdi/04MaGXgYYcvRWrp6C75Gs3Prinzevhp1k5hben/Y9Nc3b7BLet66nUtS/Ou5rS9Zjn8BMZm8Nb5SG3QAAAAASUVORK5CYII=',
 		),
 		'sofortueberweisung' => array(
			'machine_name' => 'Sofortueberweisung',
 			'method_name' => 'SOFORT',
 			'parameters' => array(
				'jsConstructor' => 'Sofort',
 				'path' => '/types/sofort',
 				'prefix' => 'sft',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Recurring',
 				2 => 'Cancellation',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAAAyCAYAAAAUYybjAAAE/UlEQVR42u1aiU7UUBTl240xhhijxqiRGDW4BIWA4i4ucYssbkQRN8QNVEAEHdBpX6/3nL7XeZ0FlAAdp20ymen0dUgP95537rm3rbzliBSvv3u1FSAUYBVglbd1Srn9RL7BCnadkujjV4kWSmJG30h569GaNeHpGyK/A8Fh7j+ruyYXYAGo8PpDCfZ0S/T6o5hbT9Jg7uslUAAyOHxBJAglPHcvn2ABCJdeDhj/uhl6HkeTO9fP+C6fYOlR3nGycv5jSYKDZyuRN7coQeflNFj3nuY0DZWrfHDM+DsJLw3Gkba3J440j6Oi91/IYfkECw/fda1C5gqUeToRf74yLGZssiZtAWIuwQIwLpIYTYfOMxUJ5MSUhP13K9cO9Iks/86vdDB3RlMEjpRj9Ozv485X3tlVibreWwQwt2BBBoCnUqk5OS1mcEyiqdk0sBmRe/OI0uNXakAJbz6SaOZ7jebKityzBWv7McqB8MxtCY5cFCn9qgFQjCF/NQO5ZwoWUin6Ms+dLppdiLWWApisaT8u0dvpNIAZknumYFE7WeIOB0Y0iiIJOs6uzG0Zknu2YGmEoIBOuOjbopjh56z9QPYkeCXzsOdmsi5Lcs8MLHBV9HmO4CTfaREt5VAkNJQS4DK8g9AhH6L5HyI/l8Q8eMG1uQALuxzIHGCRwP0yZ/S1RJ9m6vpYjLihMTEv3vN+pGTLg8WiuKM/KWVA8jT1cH7hfo2EaMRdVPj2vtYFa3qOssApdaRZot53d5PLsAsycjzlXrMr6oH31k5DLZgRXQ6IxCX9Ok+g4FOR0zyuQu0YnByo1Vs2Qlua4Kmtfi5L2e2GGmHhVZUPpeWKFaPvWEd+050Ru2IKLJUajSKv9aSDPiyiJomwo5fi1HIyQcscRFc9QOq5qS0NFuq+6M0npqR5/IpiE/57itsapBksG39t65c7EJgKErgI6QYVn1jLWvasVNYwLfPUsKBdrAQO/dSo0G4kaAnkJsuGzC0a8hJ4y2tWrNpfXChR3efSz0IvkEJVCX41yQEhmrvasJ5TCiBcsxUEHp65E9eHym3cDBTQavmQ31kH5SCodjMyzrqRLun4O0YSFX8G7fpiiqYAqwArJ2C1n4j101pmqTa53ssULG7xdo4Kh99pXvE+XUeXYXL63/8mOkSNxG0zgwUzjwNn2NVgr2A0aLWdTEWpK6xhAK5lCqe6Sdv8YGna4UjczmqQFBQOeiiAvmaizkIU+s1TSAl0qtG0QB1oyxvY0LCm+W6HSWK0og2XGOsfWRNTMWCIEqSge0jYKqVf4h/Ryw8VXx7Pq4U1p2cUdBehyVrYz1ovIuViLyeMe40OLHusVgk0F8EjItAH1GKXDwlXFA+vwDB6rF0MUFw0ObAQHRChqBl5ita93osujztPwFLF7/iQ1zCJg7bZBnar2zZSkaPucwChAIYqT40VOQAsWM52YXTCCXXOAywbG4kOLNzzf3OWHR/Cf5wOAXx0pEZHP3c5fsbsAixj5S0+NOpAC5brByK63DWf0/B9ApbnPLCnCLsHKQjO0le1Z990YLmRRpdSPtkzkizPuDVwQ+m/V4EFoBN+s+nMOVP9vh5YSD/3mwAs+b115q91jywAxk4yRrTR4vJEJkgeEcV0gjNq0wy7Gsjd97UADIdH8DuwZew1NlvhsFbrKkv++Bv8vAYJUpQ7BVgFWAVYBVg5ff0B2hNzLhhqp6wAAAAASUVORK5CYII=',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAAAyEAAAAABhmKV8AAAEQElEQVR42u2Y7U4aWRjH4QZWPuDSe2iELlewJBD5wHIDhoRtuAd3xWxvwbhCA1fAa2YiqOsLq0ZSLNJQswYISIYyjCyEtiyvHWB46tOTCWhioh3rbFJnPpw5M0P45Zz//J8Xhb/3fzwVj1jyY4UClE1mrIjv/fOetSQEDeKdV6aREiCvndyRAev98390G6rqMKMj8634SFkSYoxgSdllxBopccMQhswL7rwWx7y24JYRC4D24djndhZxbHsPVglWjpURq2clOJVhWu3vbS6MlERTDc0rk4xYDU28iGNaXTb7e2+XWVrc3M0FGbHKZlwlf29vrc/5ezXHSQhn2zMDj6wGkXUSiQcNI+VfvwmWdRXOjvmaQ1aslL0yJFd1Kl/+kCTXUgR/L1iHRRHlbKmlF91LiuAlYoW7B6tJ499/8lYRcPxyb0264CVi5dhmlaVbFwDhLs6pn+tPyBNpgpeINVKivE8T4+juD1efSBO8RKyBJ/LF3zs/nc/FmMrwUvLaxArekyZ4SVgHq83Z8zm82lCNNsaKrDNpzDobGsHS4T4tF10bKhmwzpZ4a3N2/JIEnlLpw4+TXCvGFH7nKN56zD84Vtu7+xRDTbMaCvh7b16LJjGtrz6Hzx4U6+OLwyI6e0ODHh+dG3jqT4759amN254B2J55YKx4se1FCMxN//tj4Cm4D1aJrsrmI5P4peKKPrDkWfrTL5EFXLHTZ/wzTGaCBpbmrXUqsULeGEfXVTIYxDja4fCP9+cB0BYyuoZmAjLJVx8Yq6X/l257GVfNUR0SvU1v2kmoOpQFK69lXEcmlj5NYNoc7l4NOHVKphJjc0GwxJjp0D1ttgPP19qD5MQmo+twpMC4Xjv2rEmjjPlWSWh79+evm0efky0mTrLTPocl7Eko+WvSmNe29G2vaBGy9iBCgWP+/F1ztqWvDHPsYfHri/zHRtL3iUXZYszNXat1lSxY8SL2rABIBX31TKsFS5266ZdJ47Tl3jNWswpw/q7DFdzXvzPahyH7zeubOzqV4TfComwAmH+KSLTv7XLBTdwpZQcgpWookLLntSk7Bp2dxbOlnUVsmgCMo3c1jVuvVs0B0OHSavzLrThvhS/HBY1ZPQDjKpspG64oHs1quJs0AggWAMTC43okuCesUOA0MfAAtL2U7YIGwAS5bMZ1QqxxNMdmdAAZHWXLOnFErD6HSgQomxMrd6uxFXdz85KAQD1rS09aRwiAWJjC1BzjKOYQ4S6uImKdLX1jbWG7KK2O+BoagN2ndQpgby1oKLgBTkKIhTVhjsUZ0VqORSySQ3Q4wbI/HzQEDUeme8bC1iNuFRH+3hqqBu98fBE0iFgRHyoON7rPRXwTrMQKvrk/j+/dVmGK26d8WWd1mNcS29yKF9wXl1kpblq8yLhIzhXx5djqZbDGWYxhXKJf4QewFQ93bzaRx5j4iPWdY30GdA9Pr5EIdBUAAAAASUVORK5CYII=',
 		),
 		'paypal' => array(
			'machine_name' => 'PayPal',
 			'method_name' => 'PayPal',
 			'parameters' => array(
				'jsConstructor' => 'Paypal',
 				'path' => '/types/paypal',
 				'prefix' => 'ppl',
 				'authorize' => 'yes',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'yes',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 				'partialCapture' => 'yes',
 			),
 			'not_supported_features' => array(
			),
 			'image_color' => 'data:image/png;base64,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',
 			'image_grey' => 'data:image/png;base64,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',
 		),
 		'unzerbanktransfer' => array(
			'machine_name' => 'UnzerBankTransfer',
 			'method_name' => 'Unzer Bank Transfer',
 			'parameters' => array(
				'jsConstructor' => 'FlexiPayDirect',
 				'path' => '/types/pis',
 				'prefix' => 'pis',
 				'authorize' => 'no',
 				'charge' => 'yes',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'no',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'optional',
 				'basket' => 'optional',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 			),
 			'not_supported_features' => array(
				0 => 'Capturing',
 				1 => 'Cancellation',
 				2 => 'Recurring',
 				3 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 		'unzerinstallment' => array(
			'machine_name' => 'UnzerInstallment',
 			'method_name' => 'Unzer Instalment',
 			'parameters' => array(
				'jsConstructor' => 'InstallmentSecured',
 				'path' => '/types/installment-secured',
 				'prefix' => 'ins',
 				'authorize' => 'yes',
 				'charge' => 'no',
 				'cancelAuthorize' => 'no',
 				'cancelCharge' => 'yes',
 				'shipment' => 'yes',
 				'recurring' => 'no',
 				'updatable' => 'no',
 				'customer' => 'mandatory',
 				'basket' => 'mandatory',
 				'returnUrl' => 'mandatory',
 				'b2b' => 'no',
 				'splitAmounts' => 'yes',
 				'birthdate' => 'mandatory',
 			),
 			'not_supported_features' => array(
				0 => 'Recurring',
 				1 => 'ZeroCheckout',
 			),
 			'image_color' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAABYElEQVR42u2ZLW/CUBiFKycRCAQCgUA2/UgnEPUTkwjEJAKBnERMTkzwAyonEfwABGKCHzCJQCCRiAl2TlLREEJp1+62zXmTk9vb9H486blvb3MtS6FQGIsgCLqu675Be8/ztiifagdh23aLANAJWkEH6Mf3/U6tQBzHGWPiZ5Qj1glAENTnRieGSewy6kgQaMj2YRg+xPdOWfsC/GORIOec+sb6mKBc5u0D7cMqgPxZpYHQ9xSuXyj6HmUEbRKWyvX22A/6m8bJoVwQZKReykLvY/DnOPXSUl8XvueEV3hugXLGtMwsd2VNmgUpMLkIRCACEYhAGg6CXa3NgdKEdoNKg2CQD9xb36FXWeufrNVhvQgZBcHG7zPHT9dVyVoCSYDEGSnrD9Rab0QgxWWt90Z8R9CuLWtVbK91U7XZ/aZJ1hKIQAQikFQQfjt4lFCmkscTOuhpOkhkUANLoVAoGL8gCnE5V68QmgAAAABJRU5ErkJggg==',
 			'image_grey' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyEAAAAABrxAsuAAABJUlEQVR42mP4TwfAMGoJDS15+XnaSc/1sYcOH6aZJZ++eq63nF9g41ZplvnmBY0s2dZrbLzzxP//b16YZc6sp9ASn2fYoQOPsfH58/////ztwGM5H5eqS2eIssQYDwgOXruuuBifijM3KbaEMCDJkp0ndp7YDAQz6xt8kpNBQYXPfw0+Kxe7VZJsydPXqKKPPh64M+1kcXGCDiTsg4MLbDqjl908fPjTV1hcUmwJYTBqyaglI9WSm5fO3ESH9+9T2ZLebWkz0eGCnKEYXG9ePH1NGFJoSaU5rsoJGY4mYaglaTNxVVRpM0dzPFGpa0IMHfLJ+/dDMbiwlV3okCalMDocTcKjlgxKS3q3zawnDUK6F4OvE0RjSxp8KIGYrbLRsZURagkAp+ib3uw6gLQAAAAASUVORK5CYII=',
 		),
 	);

	public function __construct(Customweb_Payment_Authorization_IPaymentMethod $paymentMethod, Customweb_DependencyInjection_IContainer $container){
		parent::__construct($paymentMethod);
		$this->container = Customweb_Unzer_Container::get($container);
	}

	public function getPublicKey(){
		return $this->getContainer()->getConfiguration()->getPublicKey();
	}

	public function getPrivateKey(){
		return $this->getContainer()->getConfiguration()->getPrivateKey();
	}

	public function isB2B(Customweb_Payment_Authorization_IOrderContext $orderContext){
		return $this->getPaymentMethodParameter('b2b') === 'yes' && $orderContext->getBillingAddress()->getCompanyName();
	}

	public function getJsConstructor(){
		return $this->getPaymentMethodParameter('jsConstructor');
	}

	public function getJsPrefix(){
		return $this->getJsConstructor();
	}

	public function isParameterMandatory($name, $requestType){
		return $this->getPaymentMethodParameter($requestType . '_' . $name) === 'mandatory';
	}

	protected final function getPaymentInformationMap(){
		return self::$paymentMapping;
	}

	/**
	 *
	 * @return Customweb_Unzer_Container
	 */
	protected final function getContainer(){
		return $this->container;
	}

	public function getAdditionalAuthorizeParameters(Customweb_Unzer_Authorization_Transaction $transaction){
		return array();
	}

	protected function getJavascriptCallbackPreError(Customweb_Payment_Authorization_ITransaction $transaction){
		return "null";
	}

	public function getJavaScriptCallbackFunction(Customweb_Payment_Authorization_ITransaction $transaction){
		$paymentEndpoint = $this->getContainer()->createSecuredEndpointUrl('process', 'payment', $transaction);
		$failureEndpoint = $this->getContainer()->createSecuredEndpointUrl('process', 'error', $transaction);

		$context = $transaction->getTransactionContext();
		/** @var $context Customweb_Payment_Authorization_Ajax_ITransactionContext */

		$successCallback = $context->getJavaScriptSuccessCallbackFunction();
		$failCallback = $context->getJavaScriptFailedCallbackFunction();

		$showOverlayScript = Customweb_Unzer_Util_Spinner::getLoadOverlayScript();

		$identifier = $this->getJsPrefix();
		return "function(formFields) {
	var preError = {$this->getJavascriptCallbackPreError($transaction)};
	if(preError) {
		fail('{$failureEndpoint}&error=' + encodeUri(preError));
		return;
	}

	$showOverlayScript

	var fail = {$failCallback};
	var success = {$successCallback};
	if(typeof document.{$identifier}Result === 'undefined') {
		alert('Result not found.');
		fail('{$failureEndpoint}&error=Result%20not%20found');
		return;
	} 
	var httpRequest = new XMLHttpRequest();
	if (!httpRequest) {
		alert('Cannot create an XMLHTTP instance');
		fail('{$failureEndpoint}&error=JS_ERROR');
		return false;
	}
	httpRequest.onreadystatechange = function() {
		if(httpRequest.readyState === XMLHttpRequest.DONE) {
			if(httpRequest.status === 200) {
				success(httpRequest.response);
			}
			else {
				fail('{$failureEndpoint}&error=' + this.response);
			}
		}
	};
	httpRequest.onerror = function() {
		var err = '';
		if(this.response) {
			err = '&error=' + this.response;
		}
		else {
			err = '&error=HTTP_ERROR';
		}
		fail('{$failureEndpoint}' + err);

	}
	httpRequest.open('POST', '$paymentEndpoint');
	httpRequest.setRequestHeader('Content-Type', 'application/json');
	httpRequest.send(JSON.stringify({result: document.{$identifier}Result, form: formFields}));
}";
	}

	/**
	 * Create a processor used to process a payment.
	 * May return a processor including either authorize, directcharge or recurring / register.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return Customweb_Unzer_Communication_Operation_PaymentProcessor
	 */
	public function getPaymentProcessor(Customweb_Unzer_Authorization_Transaction $transaction){
		return new Customweb_Unzer_Communication_Operation_PaymentProcessor($transaction->getExternalTransactionId(),
				$this->getPaymentRequestBuilder($transaction), $this->getContainer(), $transaction->getUnzTypeId()); //TODO cleaner
	}

	/**
	 * Get processor to process a recurring transaction (not used for initial transaction, use getPaymentProcessor(..)
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return Customweb_Unzer_Communication_Operation_RecurringPaymentProcessor
	 */
	public function getRecurringProcessor(Customweb_Unzer_Authorization_Transaction $transaction){
		return new Customweb_Unzer_Communication_Operation_RecurringPaymentProcessor($transaction, $this->getContainer());
	}

	public function getRecurringRequestBuilder(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getPaymentRequestBuilder($transaction);
	}

	public function getRecurringResponseProcessor(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getPaymentResponseProcessor($transaction);
	}

	/**
	 * Create a request builder used to trigger the payment process - should return either an authorize builder or a charge builder depending on the
	 * deferred setting.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return Customweb_Unzer_Communication_Operation_Authorize_RequestBuilder
	 */
	public function getPaymentRequestBuilder(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($transaction->isZeroCheckout() && $this->isZeroCheckoutSupported()) {
			return new Customweb_Unzer_Communication_Operation_Recurring_RequestBuilder($transaction, $this->getContainer());
		}
		else if ($this->isDeferredCapturingActive()) {
			return new Customweb_Unzer_Communication_Operation_Authorize_RequestBuilder($transaction, $this->getContainer());
		}
		else {
			return new Customweb_Unzer_Communication_Operation_DirectCharge_RequestBuilder($transaction, $this->getContainer());
		}
	}

	public function getPaymentResponseProcessor(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($transaction->isZeroCheckout() && $this->isZeroCheckoutSupported()) {
			return new Customweb_Unzer_Communication_Operation_Recurring_ResponseProcessor($transaction, $this->getContainer());
		}
		else if ($this->isDeferredCapturingActive()) {
			return new Customweb_Unzer_Communication_Operation_Authorize_ResponseProcessor($transaction, $this->getContainer());
		}
		else {
			if ($this->isUsingPaymentInformation()) {
				return new Customweb_Unzer_Communication_Operation_DirectCharge_PaymentInformationResponseProcessor($transaction,
						$this->getContainer());
			}
			else {
				return new Customweb_Unzer_Communication_Operation_DirectCharge_ResponseProcessor($transaction, $this->getContainer());
			}
		}
	}

	protected function isUsingPaymentInformation(){
		return $this->getPaymentMethodParameter('paymentInformation') == 'yes';
	}

	public function getAuthorizeReturnUrl(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($this->getPaymentMethodParameter('returnUrl') === 'mandatory') {
			return $this->getReturnUrl($transaction);
		}
		return null;
	}

	protected function getReturnUrl($transaction){
		return $this->getContainer()->createUnsecuredEndpointUrl('process', 'returntostore', $transaction);
	}

	public function getOrderId(Customweb_Unzer_Authorization_Transaction $transaction){
		$applied = Customweb_Payment_Util::applyOrderSchemaImproved($this->getContainer()->getConfiguration()->getOrderIdSchema(),
				$transaction->getExternalTransactionId(), 30);
		return $applied;
	}

	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		$this->preValidate($orderContext, $paymentContext);
		Customweb_Unzer_Util_Form::processFormData($paymentContext, $formData);
	}

	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		parent::preValidate($orderContext, $paymentContext);
	}

	public function getAjaxFile(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getContainer()->getAssetResolver()->resolveAssetUrl('dummy.js');
	}

	public function canCancelPendingCharge(){
		return true;
	}

	public function isDeferredCapturingActive(){
		return $this->getPaymentMethodParameter('authorize') === 'yes' &&
				(($this->getPaymentMethodParameter('charge') === 'no') || // check supported features
				($this->existsPaymentMethodConfigurationValue('capturing') && $this->getPaymentMethodConfigurationValue('capturing') == 'deferred')); // check active if supported
	}

	public function getVisibleFormFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$this->preValidate($orderContext, $paymentCustomerContext);
		$webhookAdapter = new Customweb_Unzer_WebhookAdapter($this->getContainer());
		$webhookAdapter->run($this);
		$formAdapter = new Customweb_Unzer_Form_Adapter($orderContext, $paymentCustomerContext, $aliasTransaction, $this,
				$this->getContainer());
		return $formAdapter->getFormElements();
	}

	public function getRequiredInputFields(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, $aliasTransaction = null){
		$fields = array();
		if (($this->isSendCustomerActive() || !empty($aliasTransaction))) {
			if ($this->isB2B($orderContext)) {
				$fields += $this->getB2BInputFields($orderContext, $paymentCustomerContext);
			}
			else {
				$fields += $this->getB2CInputFields($orderContext, $paymentCustomerContext);
			}
			if (Customweb_Unzer_Util_Form::getMappedSalutation($orderContext->getBillingAddress()) === 'unknown') {
				$fields[] = Customweb_Unzer_Util_Form::getSalutationField($paymentCustomerContext);
			}
			if ($orderContext->getBillingAddress()->getEMailAddress() === null && $this->isEmailRequired()) {
				$fields[] = Customweb_Unzer_Util_Form::getEmailField($paymentCustomerContext);
			}
		}
		return $fields;
	}

	protected function getB2BInputFields(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$fields = array();

		if ($orderContext->getBillingAddress()->getCommercialRegisterNumber() === null) {
			$fields[] = $registerNumberElement = Customweb_Unzer_Util_Form::getCommercialRegisterNumberField($paymentCustomerContext);
			$registerNumberControlId = $registerNumberElement->getControl()->getControlId();
			$fields[] = Customweb_Unzer_Util_Form::getDateOfBirthField($paymentCustomerContext, 18, $registerNumberControlId);
			$fields[] = Customweb_Unzer_Util_Form::getCommercialSectorField($paymentCustomerContext, $registerNumberControlId);
		}
		
		return $fields;
	}

	protected function getB2CInputFields(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext){
		$fields = array();
		if ($orderContext->getBillingAddress()->getDateOfBirth() === null && $this->isBirthdateRequired()) {
			$fields[] = Customweb_Unzer_Util_Form::getDateOfBirthField($paymentCustomerContext);
		}
		return $fields;
	}

	protected function processCaptureCharge(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		$requestBuilder = new Customweb_Unzer_Communication_Operation_Charge_RequestBuilder($amount, $transaction, $this->getContainer());
		$responseProcessor = new Customweb_Unzer_Communication_Operation_Charge_ResponseProcessor($transaction, $items, $close,
				$this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$processor->process();

		if ($close && $transaction->getCapturableAmount()) { // close rest
			$this->cancel($transaction, $transaction->getCapturableAmount());
		}
	}

	public function capture(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$transaction->partialCaptureByLineItemsDry($items, $close);

		if ($transaction->getUnzChargeId()) {
			$cancelItems = Customweb_Util_Invoice::getResultingLineItemsByDeltaItems($transaction->getUncapturedLineItems(), $items);
			$cancelAmount = Customweb_Util_Invoice::getTotalAmountIncludingTax($cancelItems);
			if (Customweb_Util_Currency::compareAmount($cancelAmount, 0, $transaction->getCurrencyCode()) !== 0) {
				$this->getLogger()->logDebug("Cancelling", $cancelItems);
				$this->processCancelCharge($transaction, $transaction->getUnzChargeId(), $cancelItems, $close, false);
			}
			if ($this->isShipmentSupported()) {
				$this->getLogger()->logDebug("Shipping", $items);
				$this->processShipment($transaction, $items);
			}
			else {
				$capture = $transaction->partialCaptureByLineItems($items, true, Customweb_I18n_Translation::__("Rest has been cancelled."));
				$capture->setChargeId($transaction->getUnzChargeId()); // for refund mapping
			}
		}
		else {
			$this->processCaptureCharge($transaction, $items, $close);
		}
	}

	public function refund(Customweb_Unzer_Authorization_Transaction $transaction, array $items, $close){
		$this->getLogger()->logInfo("Process refunds start.");
		$transaction->refundByLineItemsDry($items, $close);
		$amountToRefund = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
		$capturesToRefund = array();

		// group items to previous captures, so we can reference correct chargeId for refund.
		/**
		 *
		 * @var $capture Customweb_Unzer_Authorization_Capture
		 */
		foreach ($transaction->getCaptures() as $capture) {
			$refundableItems = $capture->getRefundableLineItems($items);
			if (!empty($refundableItems)) {
				$total = Customweb_Util_Invoice::getTotalAmountIncludingTax($refundableItems);
				if (Customweb_Util_Currency::compareAmount($total, 0, $transaction->getCurrencyCode()) !== 0) {
					$items = Customweb_Util_Invoice::getResultingLineItemsByDeltaItems($items, $refundableItems);
					$rest = Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
					$finalCapture = Customweb_Util_Currency::compareAmount($rest, 0, $transaction->getCurrencyCode()) === 0;
					$capturesToRefund[$capture->getChargeId()] = array(
						'capture' => $capture,
						'items' => $refundableItems,
						'close' => $finalCapture && $close
					);
				}
			}
		}
		$this->getLogger()->logInfo("Creating refunds as follows.", $capturesToRefund);

		foreach ($capturesToRefund as $chargeId => $capture) {
			if (empty($chargeId)) {
				$chargeId = $transaction->getUnzChargeId(); //fallback
			}
			$amount = $this->processCancelCharge($transaction, $chargeId, $capture['items'], $capture['close']);
			$amountToRefund -= $amount;
			$capture['capture']->refundLineItems($capture['items']);
		}

		$this->processUnrefundedAmount($transaction, $amountToRefund);
		$this->getLogger()->logInfo("Process refunds complete");
	}
	
	protected function processUnrefundedAmount(Customweb_Unzer_Authorization_Transaction $transaction, $amount){
		if (Customweb_Util_Currency::compareAmount($amount, 0, $transaction->getCurrencyCode()) !== 0) {
			$transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__("Refund could not be completely processed, rest amount open: @amount",
									array(
										'@amount' => $amount
									)), Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
		}
	}

	protected function processCancelCharge(Customweb_Unzer_Authorization_Transaction $transaction, $chargeId, $items, $close, $doAction = true){
		$requestBuilder = new Customweb_Unzer_Communication_Operation_CancelCharge_RequestBuilder($transaction->getUnzPaymentId(),
				$chargeId, $items, $transaction->getCurrencyCode(), $this->isSplitAmounts(), $this->getContainer(), $this->getPrivateKey());
		$responseProcessor = null; // cancel charge can either be a refund (credit card, sofort etc) or a cancel (invoice, prepayment etc)

		// TODO: $doAction can cause a superfluous history item to be added
		if ($transaction->isCaptured() && $doAction) {
			$responseProcessor = new Customweb_Unzer_Communication_Operation_CancelCharge_RefundResponseProcessor($transaction, $items,
					$close, $chargeId, $this->getContainer());
		}
		else {
			$responseProcessor = new Customweb_Unzer_Communication_Operation_CancelCharge_CancelResponseProcessor($transaction,
					$this->getContainer(), $doAction);
		}
		$this->getLogger()->logInfo("Processing $chargeId");
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$processor->process();
		return Customweb_Util_Invoice::getTotalAmountIncludingTax($items);
	}

	/**
	 * Send a cancel request and process it.
	 * Pass an amount to cancel that specific amount (e.g. closing after final capture)
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @param number $amount
	 */
	public function cancel(Customweb_Unzer_Authorization_Transaction $transaction, $amount = 0){
		if (!$transaction->isCaptured()) {
			$this->getLogger()->logInfo("Cancel start dry");
			try {
				$transaction->cancelDry();
			}
			catch (Exception $e) {
				$this->getLogger()->logException($e);
			}
			$this->getLogger()->logInfo("Cancel dry done");
		}

		if ($transaction->getUnzChargeId()) {
			$this->processCancelCharge($transaction, $transaction->getUnzChargeId(), $transaction->getUncapturedLineItems(), true);
		}
		else {
			$this->processCancelAuthorize($transaction, $amount);
		}
	}

	protected function processCancelAuthorize(Customweb_Unzer_Authorization_Transaction $transaction, $amount = 0){
		$requestBuilder = new Customweb_Unzer_Communication_Operation_CancelAuthorize_RequestBuilder($transaction, $this->getContainer(),
				$amount);
		$responseProcessor = new Customweb_Unzer_Communication_Operation_CancelAuthorize_ResponseProcessor($transaction,
				$this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$this->getLogger()->logInfo("Cancel start process");
		$processor->process();
		$this->getLogger()->logInfo("Cancel done");
	}

	public function setAliasForDisplay(Customweb_Unzer_Authorization_Transaction $transaction, array $paymentInstrument){
		if ($transaction->getTransactionContext()->getAlias() == 'new' && isset($paymentInstrument['recurring']) && $paymentInstrument['recurring'] &&
				($paymentInstrument['attributes']) && isset($paymentInstrument['attributes']['email'])) {
			$transaction->setAliasForDisplay($paymentInstrument['attributes']['email']);
		}
	}

	public function isCustomerRequired(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->isSendCustomerActive() || $transaction->getTransactionContext()->createRecurringAlias();
	}
	
	public function isEmailRequired() {
		return $this->getPaymentMethodParameter('customer_email') === 'mandatory';
	}

	public function isBirthdateRequired(){
		return $this->getPaymentMethodParameter('birthdate') === 'mandatory';
	}

	public function isSendCustomerActive(){
		return $this->getPaymentMethodParameter('customer') === 'mandatory' || $this->getPaymentMethodConfigurationValue('send_customer') == 'yes';
	}

	public function isBasketRequired(Customweb_Unzer_Authorization_Transaction $transaction){
		return $this->getPaymentMethodParameter('basket') === 'mandatory' || $this->getPaymentMethodConfigurationValue('send_basket') == 'yes';
	}

	public function isRefundSupported(){
		return !in_array('Refund', $this->getNotSupportedFeatures());
	}

	public function isCaptureSupported(){
		return !in_array('Capturing', $this->getNotSupportedFeatures());
	}

	public function isPartialCaptureSupported(){
		return $this->getPaymentMethodParameter('partialCapture') == 'yes';
	}

	public function isCancelSupported(){
		return !in_array('Cancellation', $this->getNotSupportedFeatures());
	}

	public function getRequiredPlaceholders(){
		return array();
	}

	public function getPaymentMethodParameter($key){
		$parameters = $this->getPaymentMethodParameters();
		if (isset($parameters[$key])) {
			return $parameters[$key];
		}
		return null;
	}

	public function isUseWidePlaceholders(){
		if ($this->existsPaymentMethodConfigurationValue('placeholder_size')) {
			return $this->getPaymentMethodConfigurationValue('placeholder_size') === 'wide';
		}
		return false;
	}

	public function getWebhookProcessor(Customweb_Unzer_Authorization_Transaction $transaction, array $webhookData){
		return new Customweb_Unzer_Communication_Webhook_Processor($webhookData, $transaction, $this->getContainer());
	}

	public function getWebhookRequestBuilder(Customweb_Unzer_Authorization_Transaction $transaction, array $webhookData){
		return new Customweb_Unzer_Communication_Webhook_RetrieveRequestBuilder($transaction, $this->getContainer(), $webhookData);
	}

	public function getWebhookResponseProcessor(Customweb_Unzer_Authorization_Transaction $transaction, array $webhookData){
		$event = explode(".", $webhookData['event']);
		if($event[0] === 'payment') {
			return new Customweb_Unzer_Communication_Webhook_PaymentResponseProcessor($transaction, $this->getContainer());
			
		}
		throw new Customweb_Unzer_Endpoint_UnsupportedWebhookException("Unsupported webhook event {$event[0]}");
	}
	
	public function isCompletedPaid() {
		return true;
	}
	
	public function isAuthorizePaid() {
		return false;
	}
	
	public function isPendingAuthorizePaid() {
		return false;
	}

	public function isPendingAuthorization(){
		$param = $this->getPaymentMethodParameter('pending');
		$isPendingAuthorization = $param == 'uncertain' || $param == 'authorize';
		$this->getLogger()->logDebug("{$this->getPaymentMethodName()} pending authorization: {$isPendingAuthorization} / {$param}");
		return $isPendingAuthorization;
	}

	public function isPendingUncertain(){
		$isPendingUncertain = $this->getPaymentMethodParameter('pending') == 'uncertain';
		$this->getLogger()->logDebug(
				"{$this->getPaymentMethodName()} pending uncertain: {$isPendingUncertain} / {$this->getPaymentMethodParameter('pending')}");
		return $isPendingUncertain;
	}

	/**
	 * Control wether the payment method creates pending captures
	 *
	 * @return boolean
	 */
	public function isCreatePendingCapture(){
		return $this->getPaymentMethodParameter('pendingCapture') == 'yes';
	}

	public function isSplitAmounts(){
		return $this->getPaymentMethodParameter('splitAmounts') == 'yes';
	}

	public function processTypeData(Customweb_Unzer_Authorization_Transaction $transaction, array $type){
		if ($transaction->getTransactionContext()->createRecurringAlias()) {
			if (!isset($type['recurring']) || !$type['recurring']) {
				$transaction->addHistoryItem(
						new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
								Customweb_I18n_Translation::__('Request was succesfull, but no recurring alias could be created.'),
								Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
			}
		}
		// unzTypeId set in processResource after auth / charge
	}

	/**
	 * Process a payment update request, to be used when customer is returned to store.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 */
	public function update(Customweb_Unzer_Authorization_Transaction $transaction){
		if (!$transaction->getUnzPaymentId()) {
			return;
		}
		$processor = new Customweb_Unzer_Communication_Webhook_ReturnProcessor($transaction, $this->getContainer());
		$processor->process();
	}

	/**
	 * Check if basket should be sent for the given transaction, and creates basket if required.
	 * Returns true if a request was sent, and false if not.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return boolean
	 */
	public function sendBasket(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($this->isBasketRequired($transaction)) {
			$requestBuilder = new Customweb_Unzer_Communication_Basket_CreateRequestBuilder($transaction, $this->getContainer());
			$responseProcessor = new Customweb_Unzer_Communication_Basket_ResponseProcessor($transaction, $this->getContainer());
			$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
					$this->getContainer());
			$processor->process();
			return true;
		}
		return false;
	}

	public function sendMetadata(Customweb_Unzer_Authorization_Transaction $transaction){
		$requestBuilder = new Customweb_Unzer_Communication_Metadata_RequestBuilder($transaction, $this->getContainer());
		$responseProcessor = new Customweb_Unzer_Communication_Metadata_ResponseProcessor($transaction, $this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$processor->process();
		return true;
	}

	/**
	 * Check if customer should be sent for the given transaction, and creates / updates customer if required.
	 * Returns true if a request was sent, and false if not.
	 *
	 * @param Customweb_Unzer_Authorization_Transaction $transaction
	 * @return boolean
	 */
	public function sendCustomer(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($this->isCustomerRequired($transaction)) {
			$requestBuilder = $this->getCustomerRequestBuilder($transaction);
			$responseProcessor = new Customweb_Unzer_Communication_Customer_ResponseProcessor($transaction, $this->getContainer());
			$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
					$this->getContainer());
			$processor->process();
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param array $placeholders
	 * @param boolean $useWide
	 * @return string
	 */
	public function getInitializePlaceholdersJavascript(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $placeholders){
		$prefix = $this->getJsPrefix();
		$creator = "document.{$prefix}Instance.create";
		$script = "";
		$onlyIframe = $this->isUseWidePlaceholders() ? 'false' : 'true';
		foreach ($placeholders as $name => $id) {
			$script .= "
{$creator}('$name', {containerId: '$id', onlyIframe: $onlyIframe});";
		}
		return $script;
	}

	protected function getCustomerRequestBuilder(Customweb_Unzer_Authorization_Transaction $transaction){
		if ($transaction->getUnzCustomerId()) {
			return new Customweb_Unzer_Communication_Customer_UpdateRequestBuilder($transaction, $this->getContainer());
		}
		return new Customweb_Unzer_Communication_Customer_CreateRequestBuilder($transaction, $this->getContainer());
	}

	private function isZeroCheckoutSupported(){
		return false;
	}

	public function isShipmentSupported(){
		return $this->getPaymentMethodParameter('shipment') === 'yes';
	}

	protected function processShipment(Customweb_Unzer_Authorization_Transaction $transaction, $items = array()){
		if (empty($items)) {
			$items = $transaction->getUncapturedLineItems();
		}
		$requestBuilder = new Customweb_Unzer_Communication_Operation_Shipment_RequestBuilder($transaction, $this->getContainer());
		$responseProcessor = new Customweb_Unzer_Communication_Operation_Shipment_ResponseProcessor($transaction, $items,
				$this->getContainer());
		$processor = new Customweb_Unzer_Communication_Processor_DefaultProcessor($requestBuilder, $responseProcessor,
				$this->getContainer());
		$processor->process();
	}

	/**
	 *
	 * @return Customweb_Core_ILogger
	 */
	protected function getLogger(){
		if ($this->logger === null) {
			$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class());
		}
		return $this->logger;
	}
}
