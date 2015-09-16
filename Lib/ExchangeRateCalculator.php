<?php

/**
 * Class ExchangeRateCalculator
 * @property ExchangeRate $ExchangeRate
 */

class ExchangeRateCalculator {

/**
 * @var ExchangeRate Model
 */
	protected $ExchangeRate;

/**
 *
 */
	function __construct() {
		$this->ExchangeRate = ClassRegistry::init('CakePHPExchangeRates.ExchangeRate');
	}

/**
 * Converts one currency to another. Note that when both currencies have a surcharge, both are applied.
 * @param          $fromCurrency
 * @param          $toCurrency
 * @param DateTime $date
 * @param          $moneyInMicros
 *
 * @return mixed
 */
	public function convert($moneyInMicros, $fromCurrency, $toCurrency, DateTime $date = null) {
		if (is_null($date)) {
			$date = new DateTime('now', new DateTimeZone(CIA_APPLICATION_TIMEZONE));
		}
		return $moneyInMicros * $this->_getRate($fromCurrency, $date, true) * $this->_getRate($toCurrency, $date, false);
	}

/**
 * @param          $currency
 * @param DateTime $date
 *
 * @return int
 */
	protected function _getRate($currency, DateTime $date, $from = true) {
		$rate = $this->ExchangeRate->getRate($currency, $date);
		$rawRate = ($from ? (1 / $rate['ExchangeRate']['rate']) : $rate['ExchangeRate']['rate']);
		return $rawRate * (1 - ($rate['Currency']['surcharge'] / 100));
	}

}