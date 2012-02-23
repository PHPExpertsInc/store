<?php

require_once dirname(__FILE__) . '/../PrettyException.inc.php';
require_once dirname(__FILE__) . '/../MoneyException.inc.php';
require_once dirname(__FILE__) . '/../MoneyStore.inc.php';

class MoneyStoreTest extends PHPUnit_Framework_TestCase
{
	/** @var MoneyStore **/
	private $store;

	public function setUp()
	{
		$this->store = new MoneyStore;
	}

	public function testCannotFundWithNonNumericAmounts()
	{
		try
		{
			$this->store->addFunds('Totally Invalid');
			$this->fail('A non-numeric amount was accepted');
		}
		catch (MoneyException $e)
		{
			if ($e->getMessage() != MoneyException::NON_NUMERIC_AMOUNT)
			{
				$this->fail();
			}
		}
	}

	public function testCannotFundWithNegativeAmounts()
	{
		try
		{
			$this->store->addFunds(-1);
			$this->fail('A negative amount was accepted');
		}
		catch (MoneyException $e)
		{
			if ($e->getMessage() != MoneyException::NEGATIVE_AMOUNT)
			{
				$this->fail();
			}
		}		
	}

	public function testCannotPayWithNonNumericAmounts()
	{
		try
		{
			$this->store->removeFunds('Totally Invalid');
			$this->fail('A non-numeric amount was accepted');
		}
		catch (MoneyException $e)
		{
			if ($e->getMessage() != MoneyException::NON_NUMERIC_AMOUNT)
			{
				$this->fail();
			}
		}
	}

	public function testCannotPayWithNegativeAmounts()
	{
		try
		{
			$this->store->removeFunds(-1);
			$this->fail('A negative amount was accepted');
		}
		catch (MoneyException $e)
		{
			if ($e->getMessage() != MoneyException::NEGATIVE_AMOUNT)
			{
				$this->fail();
			}
		}		
	}

	public function testCannotPayMoreThanBalance()
	{
		$this->store->addFunds(1);

		try
		{
			$this->store->removeFunds(2);
		}
		catch (MoneyStoreException $e)
		{
			if ($e->getMessage() != MoneyStoreException::INSUFFICIENT_FUNDS)
			{
				$this->fail();
			}
		}
	}

	public function testBalanceStartsAtZero()
	{
		$this->assertEquals($this->store->exposeBalance(), 0, "Balance did not start at 0.00.");
	}
	
	public function testShowsProperBalanceAfterAddingFunds()
	{
		$this->store->addFunds(1.25);
		$this->assertEquals($this->store->exposeBalance(), 1.25);
		$this->store->addFunds(2.75);
		$this->assertEquals($this->store->exposeBalance(), 4.00);
	}

	public function testShowsProperBalanceAfterRemovingFunds()
	{
		$this->store->addFunds(10000);
		$this->store->removeFunds(1.50);
		$this->assertEquals($this->store->exposeBalance(), 9998.5);
	}
}
