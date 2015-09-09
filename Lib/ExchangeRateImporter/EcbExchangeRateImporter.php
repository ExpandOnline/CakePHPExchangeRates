<?php
App::uses('ExchangeRateImporter', 'CakePHPExchangeRates.Lib/ExchangeRateImporter');

/**
 * Class EcbExchangeRateImporter
 */
class EcbExchangeRateImporter extends ExchangeRateImporter {

/**
 * @var string
 */
	protected $_ecbExchangeRateUrl = 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

/**
 * @return bool
 */
	public function import() {
		$XMLFile = $this->_getXMLFile();
		$exchangeRateDate = $this->_getExchangeRateDate($XMLFile);
		if (!$this->_isToday($exchangeRateDate)) {
			$this->_ExchangeRateLog->addLog('No exchange rate data available for today.');
			return false;
		}
		$this->_getAndSaveExchangeRates($XMLFile);
		return true;
	}

/**
 * @return SimpleXMLElement
 */
	protected function _getXMLFile() {
		return simplexml_load_file($this->_ecbExchangeRateUrl);
	}

/**
 * @param SimpleXMLElement $XMLFile
 *
 * @return DateTime
 */
	protected function _getExchangeRateDate(SimpleXMLElement $XMLFile) {
		return new DateTime((string) $XMLFile->Cube->Cube['time']);
	}

/**
 * @param DateTime $exchangeRateDate
 *
 * @return bool
 */
	protected function _isToday(DateTime $exchangeRateDate) {
		return date('Ymd') === $exchangeRateDate->format('Ymd');
	}

/**
 * @param SimpleXMLElement $XMLFile
 */
	protected function _getAndSaveExchangeRates(SimpleXMLElement $XMLFile) {
		$date = date('Y-m-d');

		foreach ($XMLFile->Cube->Cube->Cube as $exchangeRate) {
			$currency = (string) $exchangeRate['currency'];
			$rate = (string) $exchangeRate['rate'];

			$this->_saveExchangeRate($date, $currency, $rate);
		}
	}

/**
 * @param string $date
 * @param string $currency
 * @param float $rate
 *
 * @throws Exception
 */
	protected function _saveExchangeRate($date, $currency, $rate) {
		$data = array(
			'currency' => $currency,
			'rate' => $rate,
			'date' => $date
		);
		$id = $this->_ExchangeRate->getExistingId($currency, $date);
		if ($id) {
			$data['id'] = $id;
			$this->_ExchangeRateLog->deleteAll(array(
				'exchange_rate_id' => $id
			));
		}
		$this->_ExchangeRate->create();
		$this->_ExchangeRate->save($data);
	}

}