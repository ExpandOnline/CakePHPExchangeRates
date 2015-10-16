<?php
App::uses('EcbExchangeRateImporter', 'CakePHPExchangeRates.Lib/ExchangeRateImporter');

/**
 * Class ExchangeRateImportShell
 *
 * This shell imports exchange rate
 */
class ExchangeRateImportShell extends Shell {

/**
 * @return ConsoleOptionParser
 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();

		return $parser
			->addSubcommand('import', array(
				'help' => 'Import exchange rate of the Euro from the European central bank.',
			));
	}

/**
 * Import exchange rate for the euro.
 */
	public function import() {
		$exchangeRateImporter = new EcbExchangeRateImporter();
		$exchangeRateImporter->import();

		$event = new CakeEvent('ExchangeRateImport.completed', $this);
		CakeEventManager::instance()->dispatch($event);
	}

}