<?php

/**
 * Class ExchangeRateLogFixture
 */
class ExchangeRateLogFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'CakePHPExchangeRates.ExchangeRateLog');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'message' => 'Currency \'EUR\' has changed more than the alert threshold of 5%. Difference percentage: 5%; Old rate: 1.3; New rate: 2;',
			'exchange_rate_id' => 64,
			'created' => '2015-10-20 16:00:04',
			'modified' => '2015-10-20 16:00:04',
		)
	);

}
