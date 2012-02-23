<?php



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

	private static function guaranteeSaneAmount($amount)
	{
		if (!is_numeric($amount)) { throw new MoneyException(MoneyException::NON_NUMERIC_AMOUNT); }
		if ($amount < 0) { throw new MoneyException(MoneyException::NEGATIVE_AMOUNT); }
	}
	
	public function addFunds($amount)
	{
		self::guaranteeSaneAmount($amount);
		$this->balance += $amount;
	}
	
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

	public function exposeBalance()
	{
		return $this->balance;
	}
}


