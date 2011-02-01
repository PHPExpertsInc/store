<?php

class CashRegister
{
	/** @var MoneyStore **/
	private $money;

	public function __construct(MoneyStore $money)
	{
		$this->money = $money;
	}

	public function purchase(Product $product, MoneyStore $money)
	{
		// Make sure that we're not robbing ourselves to pay for the product.
		if (spl_object_hash($money) == spl_object_hash($this->money))
		{
			throw new MoneyStoreException(MoneyStoreException::IDENTICAL_PAYEE_PAYER);
		}

		$productCost = $product->exposePrice();
		$this->money->addFunds($money->removeFunds($productCost));

		return true;
	}

	public function exposeBalance()
	{
		return $this->money->exposeBalance();
	}
}


