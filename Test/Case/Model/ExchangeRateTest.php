<?php

/**
 * Class ExchangeRateTest
 *
 * @property ExchangeRate $ExchangeRate
 */
class ExchangeRateTest extends CakeTestCase {

	public $fixtures = array(
		'plugin.CakePHPExchangeRates.exchange_rate',
		'plugin.CakePHPExchangeRates.exchange_rate_log',
	);

/**
 *
 */
	public function setUp() {
		parent::setUp();
		$this->ExchangeRate = ClassRegistry::init('CakePHPExchangeRates.ExchangeRate');
	}

/**
 *
 */
	public function tearDown() {
		unset($this->ExchangeRate);
		parent::tearDown();
	}

/**
 * Test the afterSave method.
 */
	public function testSave() {
		$data = array(
			'currency' => 'USD',
			'date' => date('Y-m-d', strtotime('yesterday')),
			'rate' => '1'
		);
		$savedData = $this->ExchangeRate->save($data);
		$this->assertEquals(0, $this->ExchangeRate->ExchangeRateLog->find('count', array(
			'conditions' => array(
				'ExchangeRateLog.exchange_rate_id' => $savedData['ExchangeRate']['id']
			)
		)));

		$data = array(
			'currency' => 'USD',
			'date' => date('Y-m-d'),
			'rate' => '2'
		);
		$this->ExchangeRate->create();
		$savedData = $this->ExchangeRate->save($data);
		$this->assertEquals(1, $this->ExchangeRate->ExchangeRateLog->find('count', array(
			'conditions' => array(
				'ExchangeRateLog.exchange_rate_id' => $savedData['ExchangeRate']['id']
			)
		)));
	}
}