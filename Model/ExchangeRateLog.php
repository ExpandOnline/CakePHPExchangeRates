<?php
App::uses('CakePHPExchangeRatesAppModel', 'CakePHPExchangeRates.Model');

/**
 * Class ExchangeRateLog
 */
class ExchangeRateLog extends CakePHPExchangeRatesAppModel {

/**
 * The table is prefixed with 'cper'.
 * @var string
 */
	public $useTable = 'cper_exchange_rate_logs';

/**
 * @param      $message
 * @param null $exchangeRateId
 */
	public function addLog($message, $exchangeRateId = null) {
		$this->create();
		$this->save(array(
			'message' => $message,
			'exchange_rate_id' => $exchangeRateId
		));
	}

}