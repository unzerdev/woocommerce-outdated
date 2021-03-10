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
require_once 'Customweb/Core/Number.php';


/**
 * This class represents a number which has a fixed format.
 * This implementation is immutable.
 *
 * @author Thomas Hunziker
 *
 */
final class Customweb_Core_Number {
	private $number = null;
	private $decimalPlaces = 2;
	private $thousandSeparator = '';
	private $decimalSeperator = '.';

	public function __construct($number, $decimalPlaces = 2, $decimalSeperator = '.', $thousandSeparator = ''){
		if ($number instanceof Customweb_Core_Number) {
			$this->number = $number->number;
			$this->decimalPlaces = $number->decimalPlaces;
			$this->decimalSeperator = $number->decimalSeperator;
			$this->thousandSeparator = $number->thousandSeparator;
		}
		else {
			$this->number = (float) $number;
			$this->decimalPlaces = $decimalPlaces;
			$this->decimalSeperator = $decimalSeperator;
			$this->thousandSeparator = $thousandSeparator;
		}
	}

	public function setDecimalPlaces($decimalPlaces){
		return new Customweb_Core_Number($this->number, $decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function setDecimalSeparator($separator){
		return new Customweb_Core_Number($this->number, $this->decimalPlaces, $separator, $this->thousandSeparator);
	}

	public function setThousandSepartor($separator){
		return new Customweb_Core_Number($this->number, $this->decimalPlaces, $this->decimalSeperator, $separator);
	}

	public function add($number){
		if ($number instanceof Customweb_Core_Number) {
			$number = $number->number;
		}
		else {
			$number = (float) $number;
		}
		return new Customweb_Core_Number($this->number + $number, $this->decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function subtract($number){
		if ($number instanceof Customweb_Core_Number) {
			$number = $number->number;
		}
		else {
			$number = (float) $number;
		}
		return new Customweb_Core_Number($this->number - $number, $this->decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function multiply($number){
		if ($number instanceof Customweb_Core_Number) {
			$number = $number->number;
		}
		else {
			$number = (float) $number;
		}
		return new Customweb_Core_Number($this->number * $number, $this->decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function divide($number){
		if ($number instanceof Customweb_Core_Number) {
			$number = $number->number;
		}
		else {
			$number = (float) $number;
		}
		return new Customweb_Core_Number($this->number / $number, $this->decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function getDecimalPlaces(){
		return $this->decimalPlaces;
	}

	public function getThousandSeparator(){
		return $this->thousandSeparator;
	}

	public function getDecimalSeperator(){
		return $this->decimalSeperator;
	}

	public function getFormatedNumber(){
		return number_format($this->number, $this->decimalPlaces, $this->decimalSeperator, $this->thousandSeparator);
	}

	public function __toString(){
		return $this->getFormatedNumber();
	}
}