<?php
class S127ExchangeRate5Decimals extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'S127_exchange_rate_5_decimals';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'alter_field' => array(
				'cper_exchange_rates' => array(
					'rate' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '13,5', 'unsigned' => false),
				),
			),
		),
		'down' => array(
			'alter_field' => array(
				'cper_exchange_rates' => array(
					'rate' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,2', 'unsigned' => false),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		return true;
	}
}
