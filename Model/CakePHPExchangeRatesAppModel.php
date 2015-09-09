<?php
App::uses('Model', 'Model');

/**
 * Class CakePHPExchangeRatesAppModel
 */
class CakePHPExchangeRatesAppModel extends Model {

/**
 * @var int
 */
	public $recursive = -1;

/**
 * @param       $methodName
 * @param array $args
 *
 * @return mixed
 */
	public function testProtected($methodName, array $args) {
		return call_user_func_array(array($this, $methodName), $args);
	}

}