<?php

require_once dirname(__FILE__) . '/../Product.inc.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
	public function testMustHaveValidNameAndPrice()
	{
		try
		{
			$product = new Product(null, null);
			$this->fail('Empty product created');
		}
		catch(LogicException $e) { }
		
		try
		{
			$product = new Product(-1, 1.25);
			$this->fail('Invalid product name');
		}
		catch(LogicException $e) { }
		
		try
		{
			$product = new Product('Foo', 'invalid');
			$this->fail('Non-numeric product price');
		}
		catch(MoneyException $e)
		{
			$this->assertEquals($e->getMessage(), MoneyException::NON_NUMERIC_AMOUNT);
		}
		
		try
		{
			$product = new Product('Foo', -1);
			$this->fail('Invalid product price');
		}
		catch(MoneyException $e)
		{
			$this->assertEquals($e->getMessage(), MoneyException::NEGATIVE_AMOUNT);
		}
		
		try
		{
			$product = new Product('Foo', 1.25);
		}
		catch(Exception $e)
		{
			$this->fail($e->getMessage());
		}
	}

	public function testExposesNameProperly()
	{
		$product = new Product('Foo', 1.25);
		$this->assertEquals($product->exposeName(), 'Foo');
	}

	public function testExposesPriceProperly()
	{
		$product = new Product('Foo', 1.25);
		$this->assertEquals($product->exposePrice(), 1.25);
	}

	public function testCanBeAccessedAsString()
	{
		$product = new Product('Foo', 1.25);
		$this->assertEquals(sprintf('%s', $product), 'Foo - 1.25');
	}
}
