<?php

class MoneyException extends PrettyException
{
	const NON_NUMERIC_AMOUNT = "Amount must be numeric";
	const NEGATIVE_AMOUNT = 'Amount cannot be less than zero.';	
}


