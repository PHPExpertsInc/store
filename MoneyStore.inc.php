<?php


//TODO: Convert from float to integer.
require_once 'MoneyException.inc.php';

class MoneyStoreException extends MoneyException
{
	const INSUFFICIENT_FUNDS = "There are insufficient funds for the transaction.";
	const IDENTICAL_PAYEE_PAYER = "The two payment parties are the same entity.";
}

class MoneyStore
{
	/** @var float **/
	private $balance = 0.00;

	/**
	* - Cannot fund with non-numeric amounts
	* - Cannot fund with negative amounts.
	* @param float $amount
	*/
	public function addFunds($amount)
	{
		self::guaranteeSaneAmount($amount);
		$this->balance += $amount;
	}
	
	/**
	* - Cannot pay with non-numeric amounts.
	* - Cannot pay with negative amounts.
	* - Cannot pay more than balance.
	* @param float $amount
	*/
	public function removeFunds($amount)
	{
		self::guaranteeSaneAmount($amount);

		if ($this->balance < $amount)
		{
			throw new MoneyStoreException(MoneyStoreException::INSUFFICIENT_FUNDS);
		}

		$this->balance -= $amount;

		return $amount;
	}

	/**
	* - Balance starts at zero.
	* - Shows proper balance after adding funds.
	* - Shows proper balance after removing funds
	*/
	public function exposeBalance()
	{
		return $this->balance;
	}

	private static function guaranteeSaneAmount($amount)
	{
		if (!is_numeric($amount)) { throw new MoneyException(MoneyException::NON_NUMERIC_AMOUNT); }
		if ($amount < 0) { throw new MoneyException(MoneyException::NEGATIVE_AMOUNT); }
	}	
}


