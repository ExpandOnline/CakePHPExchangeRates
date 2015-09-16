<?php
App::uses('CakePHPExchangeRatesAppModel', 'CakePHPExchangeRates.Model');

/**
 * Class ExchangeRate
 *
 * @property ExchangeRateLog $ExchangeRateLog
 * @property Currency $Currency
 */
class ExchangeRate extends CakePHPExchangeRatesAppModel {

/**
 * If the different is greater than 5%, log this.
 * @var int
 */
	protected $_maxDiffPercentage = 5;

/**
 * The table is prefixed with 'cper'.
 * @var string
 */
	public $useTable = 'cper_exchange_rates';

/**
 * @var array
 */
	public $hasMany = array(
		'ExchangeRateLog' => array(
			'className' => 'CakePHPExchangeRates.ExchangeRateLog',
			'foreign_key' => 'exchange_rate_id'
		)
	);

/**
 * @var array
 */
	public $belongsTo = array(
		'Currency' => array(
			'className' => 'CakePHPExchangeRates.Currency',
			'foreignKey' => 'currency'
		)
	);

/**
 * Called after each successful save operation.
 *
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return void
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
 * @see Model::save()
 */
	public function afterSave($created, $options = array()) {
		$this->_compareWithPreviousExchangeRate($this->data);
	}

/**
 * @param string $currency
 * @param string $date
 *
 * @return string
 */
	public function getExistingId($currency, $date) {
		return $this->field('id', array(
			'currency' => $currency,
			'date' => $date
		));
	}

/**
 * Compare the new exchange rate with the previous exchange rate.
 *
 * @param array $data
 */
	protected function _compareWithPreviousExchangeRate(array $data) {
		$previousExchangeRate = $this->_getPreviousExchangeRate($data['ExchangeRate']['currency'], $data['ExchangeRate']['date']);
		if (!$previousExchangeRate) {
			return;
		}
		$diff = $previousExchangeRate['ExchangeRate']['rate'] - $data['ExchangeRate']['rate'];
		$percentageDiff = abs(($diff / $previousExchangeRate['ExchangeRate']['rate']) * 100);
		if ($percentageDiff > $this->_maxDiffPercentage) {
			$this->ExchangeRateLog->addLog(sprintf('Currency \'%s\' has changed more than the alert threshold of %d%%. '
				. 'Difference percentage: %d%%; Old rate: %f; New rate: %f;',
				$previousExchangeRate['ExchangeRate']['currency'],$this->_maxDiffPercentage, $percentageDiff,
				$previousExchangeRate['ExchangeRate']['rate'], $data['ExchangeRate']['rate']),
				$data['ExchangeRate']['id']);
		}
	}

/**
 * Get the previous exchange rate.
 *
 * @param array $data
 */
	protected function _getPreviousExchangeRate($currency, $dateString) {
		return $this->find('first', array(
			'conditions' => array(
				'ExchangeRate.date <' => $dateString,
				'ExchangeRate.currency' => $currency,
			),
			'contain' => array(
				'Currency.surcharge'
			),
			'order' => 'date DESC'
		));
	}

/**
 * @param          $currency
 * @param DateTime $date
 *
 * @return array|null
 */
	public function getRate($currency, DateTime $date) {
		$rate = $this->_getPreviousExchangeRate($currency, $date->format('Y-m-d H:i:s'));
		if (empty($rate)) {
			throw new NotFoundException(
				sprintf('No exchange rate was found for %s before %s', $currency, $date->format('Y-m-d'))
			);
		}
		return $rate;
	}
}