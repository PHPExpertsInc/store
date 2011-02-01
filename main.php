<?php

function __autoload($name)
{
	include $name . '.inc.php';
}

function cashPaycheck(&$wallet)
{
	$wallet->addFunds('3000.00');
	echo "INFO: We cashed a check worth $3,000.\n";
	echo "INFO: Balance: {$wallet->exposeBalance()}\n";
}

function exception_handler($exception)
{
	echo "EXCEPTION: " . $exception->getMessage();
}

set_exception_handler('exception_handler');

$wallet = new MoneyStore();
// Get paid...	
cashPaycheck($wallet);

// How much money do we have?
printf("We have a balance of %.2f.\n", $wallet->exposeBalance());

// Pick up a sandwich...
$sandwich = ProductFactory::build('sandwich');

// Bring it to the cash register...
$cashRegister = new CashRegister(new MoneyStore());

// Buy it...
$cashRegister->purchase($sandwich, $wallet);

// How much money do we have left?
printf("We have a balance of %.2f.\n", $wallet->exposeBalance());

// How much money does the cash register have in it?
printf("The cash register has a balance of %.2f.\n", $cashRegister->exposeBalance());

// Try to buy a car...
try
{
	$car = ProductFactory::build('car');
	$cashRegister->purchase($car, $wallet);
}
catch(MoneyException $e)
{
	// Add more money...
	$carCost = $car->exposePrice();
	while ($wallet->exposeBalance() < $carCost)
	{
		cashPaycheck($wallet);
	}

	$cashRegister->purchase($car, $wallet);
}

// How much money do we have left?
printf("We have a balance of %.2f.\n", $wallet->exposeBalance());

// How much money does the cash register have in it?
printf("The cash register has a balance of %.2f.\n", $cashRegister->exposeBalance());
