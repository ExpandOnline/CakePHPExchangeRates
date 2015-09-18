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
		'plugin.CakePHPExchangeRates.currency',
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
		$previousExchangeRate = $this->ExchangeRate->find('first', array(
			'conditions' => array(
				'currency' => 'USD'
			),
			'order' => 'id DESC'
		));
		$data = array(
			'currency' => 'USD',
			'date' => date('Y-m-d', strtotime('yesterday')),
			'rate' => $previousExchangeRate['ExchangeRate']['rate']
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
			'rate' => $previousExchangeRate['ExchangeRate']['rate'] + 1
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