<?php

/**
* CashRegister
 [x] Balance starts at zero
 [x] Can purchase a product
 [x] Cannot purchase an unaffordable product
 [x] Will not accept payment from itself
 [x] Shows proper balance after purchase
*/
class CashRegister
{
	/** @var MoneyStore **/
	private $money;

	public function __construct(MoneyStore $money)
	{
		$this->money = $money;
	}

	/**
	  * Attempt to purchase a product.
	  * @throws MoneyStoreException
	  * @return boolean true on success
	  */
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

	/**
	  * Returns the remaining balance.
	  * @return float remaining balance
	  */
	public function exposeBalance()
	{
		return $this->money->exposeBalance();
	}
}


