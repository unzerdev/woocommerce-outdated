<?php
/**
  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Core/Util/Error.php';


/**
 * In PHP 5.2.x DateTime object can not be serialized.
 * This class is a wrapper, which allows the
 * serialization of the DateTime also prior to version 5.3.
 * The date is stored as a String.
 *
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_Core_DateTimeAbstract extends DateTime {
	/**
	 *
	 * @var DateTime
	 */
	protected $dateTime = null;
	protected $dateTimeAsString = '';
	public function __construct($time = null, $timezone = null) {

		if ($time instanceof DateTime || ( (version_compare(PHP_VERSION, '5.5.0') >= 0) && $time instanceof DateTimeInterface)) {
			$time = $time->format ( 'Y-m-d H:i:sP' );
		}

		// Prevent invalid dates
		if ($time === '0000-00-00' || $time === '0000-00-00 00:00:00' ) {
			$time = null;
		}

		if ($timezone === null) {
			// In some environments where no time zone is set, we need this to make sure no warning is thrown.
			Customweb_Core_Util_Error::deactivateErrorMessages();
			date_default_timezone_set(@date_default_timezone_get());
			Customweb_Core_Util_Error::activateErrorMessages();

			$this->dateTime = new DateTime ( $time );
		} else {
			$this->dateTime = new DateTime ( $time, $timezone );
		}
	}

	/**
	 * Static constructor to allow simpler coding with the fluent API.
	 *
	 * @param string $time
	 * @param string $timezone
	 * @return Customweb_Core_DateTime
	 */
	public static function _($time = null, $timezone = null) {
		return new Customweb_Core_DateTime($time, $timezone);
	}

	public function __sleep() {
		$this->dateTimeAsString = $this->dateTime->format ( 'Y-m-d H:i:sP' );
		return array (
				'dateTimeAsString'
		);
	}

	public function __wakeup() {
		Customweb_Core_Util_Error::deactivateErrorMessages();
		date_default_timezone_set(@date_default_timezone_get());
		Customweb_Core_Util_Error::activateErrorMessages();

		// In case 'date' is set, we need to convert from PHP serialized object
		if (isset($this->date)) {
			if (isset($this->timezone_type) && isset($this->timezone) && $this->timezone_type == 3) {
				$this->dateTime = new DateTime ( $this->date, new DateTimeZone($this->timezone));
			}
			else {
				$this->dateTime = new DateTime ( $this->date );
			}
		}
		else {
			$this->dateTime = new DateTime ( $this->dateTimeAsString );
		}

	}

	/**
	 * Helper method to provide fluid interface. Checks if the result is false, and returns either false or this.
	 * @param false|DateTime $result
	 * @return false|Customweb_Core_DateTimeAbstract
	 */
	protected function returnFluid($result) {
		if($result === false) {
			return $result;
		}
		return $this;
	}

	public function format($format) {
		return $this->dateTime->format ( $format );
	}

	public function modify($modify) {
		return new Customweb_Core_DateTime($this->dateTime->modify ( $modify ));
	}

	public function add($interval) {
		return $this->returnFluid($this->dateTime->add ( $interval ));
	}

	public function sub($interval) {
		return $this->returnFluid($this->dateTime->sub ( $interval ));
	}

	public function getTimezone() {
		return $this->dateTime->getTimezone ();
	}

	public function setTimezone($timezone) {
		return $this->returnFluid($this->dateTime->setTimezone ( $timezone ));
	}

	public function getOffset() {
		return $this->dateTime->getOffset ();
	}

	public function setDate($year, $month, $day) {
		return $this->returnFluid($this->dateTime->setDate ( $year, $month, $day ));
	}

	public function setISODate($year, $week, $day = null) {
		if ($day === null) {
			return $this->returnFluid($this->dateTime->setISODate ( $year, $week ));
		}
		else {
			return $this->returnFluid($this->dateTime->setISODate ( $year, $week, $day ));
		}
	}

	public function setTimestamp($unixtimestamp) {
		$this->dateTime->setDate(date('Y', $unixtimestamp), date('m', $unixtimestamp), date('d', $unixtimestamp));
		$this->dateTime->setTime(date('H', $unixtimestamp), date('i', $unixtimestamp), date('s', $unixtimestamp));
		return $this;
	}

	public function getTimestamp() {
		return $this->dateTime->format('U');
	}

	/**
	 * This method adds the given number of seconds to the date time.
	 *
	 * @param int $seconds
	 * @return Customweb_Core_DateTime
	 */
	public function addSeconds($seconds) {
		return $this->returnFluid($this->setTimestamp($this->getTimestamp() + $seconds + $this->getOffset()));
	}

	/**
	 * Removes the given number of seconds.
	 *
	 * @param int $seconds
	 * @return Customweb_Core_DateTime
	 */
	public function subtractSeconds($seconds) {
		return $this->returnFluid($this->setTimestamp($this->getTimestamp() - $seconds + $this->getOffset()));
	}

	/**
	 * Adds the given number of minutes.
	 *
	 * @param int $minutes
	 * @return Customweb_Core_DateTime
	 */
	public function addMinutes($minutes) {
		return $this->returnFluid($this->addSeconds($minutes * 60));
	}

	/**
	 * Removes the given number of minutes.
	 *
	 * @param int $minutes
	 * @return Customweb_Core_DateTime
	 */
	public function subtractMinutes($minutes) {
		return $this->returnFluid($this->subtractSeconds($minutes * 60));
	}

	/**
	 * Adds the given number of hours.
	 *
	 * @param int $hours
	 * @return Customweb_Core_DateTime
	 */
	public function addHours($hours) {
		return $this->returnFluid($this->addSeconds($hours * 3600));
	}

	/**
	 * Removes the given number of hours.
	 *
	 * @param int $hours
	 * @return Customweb_Core_DateTime
	 */
	public function subtractHours($hours) {
		return $this->returnFluid($this->subtractSeconds($hours * 3600));
	}

	public function diff($datetime2, $absolute = null) {
		if ($absolute == null) {
			return $this->dateTime->diff($datetime2);
		}
		else {
			return $this->dateTime->diff($datetime2, $absolute);
		}
	}
}

if(version_compare(PHP_VERSION, '7.1') < 0){

	class Customweb_Core_DateTime extends Customweb_Core_DateTimeAbstract {

		public function setTime($hour, $minute, $second = null) {
			if ($second === null) {
				return $this->returnFluid($this->dateTime->setTime ( $hour, $minute));
			}
			else {
				return $this->returnFluid( $this->dateTime->setTime ( $hour, $minute, $second));
			}
		}
	}

}
else{

	class Customweb_Core_DateTime extends Customweb_Core_DateTimeAbstract {

		public function setTime($hour, $minute, $second = null, $microseconds = null) {

			if($microseconds === null) {
				if ($second === null) {
					return $this->returnFluid($this->dateTime->setTime ( $hour, $minute));
				}
				else {
					return $this->returnFluid($this->dateTime->setTime ( $hour, $minute, $second ));
				}
			}
			else{
				return $this->returnFluid($this->dateTime->setTime ( $hour, $minute, $second, $microseconds ));
			}
		}
	}
}
