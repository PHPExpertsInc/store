<?php
//require_once dirname(__FILE__) . '/../Product.inc.php';
require_once dirname(__FILE__) . '/../MoneyStore.inc.php';
require_once dirname(__FILE__) . '/../CashRegister.inc.php';

class CashRegisterTest extends PHPUnit_Framework_TestCase
{
	/** @var CashRegister **/
	private $register;

	/** @var MoneyStore **/
	private $wallet;

	/** @var Product **/
	private $product;

	public function setUp()
	{
		$this->register = new CashRegister(new MoneyStore());
		$this->wallet = new MoneyStore;
		$this->wallet->addFunds('5.0');
		$this->product = new Product('sandwich', 1.25);
	}

	public function testBalanceStartsAtZero()
	{
		$this->assertEquals($this->register->exposeBalance(), 0, "Balance did not start at 0.00.");
	}
	
	public function testCanPurchaseAProduct()
	{
		$this->assertTrue($this->register->purchase($this->product, $this->wallet));
	}

	public function testCannotPurchaseAnUnaffordableProduct()
	{
		try
		{
			$this->register->purchase(new Product('Car', 10000), $this->wallet);
		}
		catch(MoneyStoreException $e)
		{
			$this->assertEquals($e->getMessage(), MoneyStoreException::INSUFFICIENT_FUNDS);
		}
	}

	public function testWillNotAcceptPaymentFromItself()
	{
		$register = new CashRegister($this->wallet);
		
		try
		{
			$register->purchase($this->product, $this->wallet);
			$this->fail("Accepted payment from itself.");
		}
		catch (MoneyStoreException $e)
		{
			$this->assertEquals($e->getMessage(), MoneyStoreException::IDENTICAL_PAYEE_PAYER);
		}
	}

	public function testShowsProperBalanceAfterPurchase()
	{
		$this->register->purchase($this->product, $this->wallet);
		$this->assertEquals($this->register->exposeBalance(), 1.25);
	}
}