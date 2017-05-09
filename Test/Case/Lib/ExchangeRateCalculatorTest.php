<?php
App::uses('ExchangeRateCalculator', 'CakePHPExchangeRates.Lib');

class ExchangeRateCalculatorTest extends CakeTestCase{

	public $fixtures = array(
		'plugin.CakePHPExchangeRates.ExchangeRate',
		'plugin.CakePHPExchangeRates.Currency'
	);

	public function testConvert() {
		$converter = new ExchangeRateCalculator();
		//€4,30 to $'s
		$date = new DateTime('2015-09-16 16:49:30', new DateTimeZone(CIA_APPLICATION_TIMEZONE));
		$x = $converter->convert(4300000, 'EUR', 'USD', $date);
		$this->assertEquals(4705232, $x);
		//This amount should also be equal to the original amount, but minus two surcharges.
		$this->assertEquals(4300000 * .977 * .977, $converter->convert(4705232, 'USD', 'EUR', $date));
	}

	public function testConvertWithoutSurcharge() {
		$converter = new ExchangeRateCalculator();
		//€4,30 to $'s
		$date = new DateTime('2015-09-16 16:49:30', new DateTimeZone(CIA_APPLICATION_TIMEZONE));
		$x = $converter->convert(4300000, 'EUR', 'USD', $date, false);
		$this->assertEquals(4816000, $x);
		//This amount should also be equal to the original amount, because we don't charge surcharges
		$this->assertEquals(4300000, $converter->convert(4816000, 'USD', 'EUR', $date, false));
	}
}