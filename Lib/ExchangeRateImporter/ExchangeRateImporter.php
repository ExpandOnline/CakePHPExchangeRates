<?php

/**
 * Class ExchangeRateImporter
 */
abstract class ExchangeRateImporter {

/**
 * @var ExchangeRate
 */
	protected $_ExchangeRate;

/**
 * @var ExchangeRateLog
 */
	protected $_ExchangeRateLog;

/**
 * Setup models.
 */
	public function __construct() {
		$this->_ExchangeRate = ClassRegistry::init('CakePHPExchangeRates.ExchangeRate');
		$this->_ExchangeRateLog = ClassRegistry::init('CakePHPExchangeRates.ExchangeRateLog');
	}

/**
 * Imports exchange rates.
 *
 * @return bool
 */
	public abstract function import();

}