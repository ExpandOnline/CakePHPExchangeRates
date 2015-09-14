<?php
App::uses('CakePHPExchangeRatesAppModel', 'CakePHPExchangeRates.Model');

/**
 * Class Currency
 *
 * @property ExchangeRate $ExchangeRateLog
 */
class Currency extends CakePHPExchangeRatesAppModel {

	// http://www.iso.org/iso/home/standards/currency_codes.htm
	public $primaryKey = 'currency'; //The ISO 4217 standard.

/**
 * The table is prefixed with 'cper'.
 * @var string
 */
	public $useTable = 'cper_currencies';

/**
 * @var array
 */
	public $hasMany = array(
		'ExchangeRate' => array(
			'className' => 'CakePHPExchangeRates.ExchangeRate',
			'foreignKey' => 'currency',
			'order' => 'ExchangeRate.date desc',
			'limit' => 1
		)
	);
}