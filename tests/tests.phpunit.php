<?php

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Framework/TestCase.php';

/*// SimpleTest compatibility layer.
class UnitTestCase extends PHPUnit_Framework_TestCase
{
	
}
*/

require_once dirname(__FILE__) . '/MoneyStoreTest.php';
require_once dirname(__FILE__) . '/ProductTest.php';
require_once dirname(__FILE__) . '/ProductFactoryTest.php';
require_once dirname(__FILE__) . '/CashRegisterTest.php';

/**
 * Static test suite.
 */
// @codeCoverageIgnoreStart
class UserDirectoryTests extends PHPUnit_Framework_TestSuite {
	protected $topTestSuite = true;
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		ob_start();
		$this->setName('Store Test Suite');
		$this->addTestSuite('MoneyStoreTest');
		$this->addTestSuite('ProductTest');
		$this->addTestSuite('ProductFactoryTest');
		$this->addTestSuite('CashRegisterTest');
	}

	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
}
// @codeCoverageIgnoreStop
