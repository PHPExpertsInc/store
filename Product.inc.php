<?php
class Product
{
	private $name;
	private $price;
	
	public function __construct($name, $price)
	{
		if (!is_string($name))
		{
			throw new LogicException('The product name must be a string.');
		}
		
		if (!is_numeric($price))
		{
			throw new MoneyException(MoneyException::NON_NUMERIC_AMOUNT);
		}
		
		if ($price < 0)
		{
			throw new MoneyException(MoneyException::NEGATIVE_AMOUNT);
		}

		$this->name = $name;
		$this->price = $price;
	}
	
	public function exposeName()
	{
		return $this->name;
	}

	public function exposePrice()
	{
		return $this->price;
	}
	
	public function __toString()
	{
		return "{$this->name} - {$this->price}";
	}
}

