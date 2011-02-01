<?php

class GenericProperties
{
	public $id;
	public $name;
	public $price;
}

class TaxableProperties extends GenericProperties
{
	public $tax;
}

class ItemProperties extends TaxableProperties
{
	public $quantity;
}

class ItemLineLogic
{
	/** @var ItemProperties **/
	private $properties;

	/** @var GenericLineLogic **/
	private $genericLogic;
	
	/** @var TaxableLineLogic **/
	private $taxableLogic;

	public function __construct(ItemProperties $properties = null)
	{
		if (is_null($properties)) { $properties = new ItemProperties; }

		$this->genericLogic = new GenericLineLogic($properties);
		$this->taxableLogic = new TaxableLineLogic($properties);

		$properties->quantity = 2;
		$this->properties = $properties;
	}
}

class TaxableLineLogic
{
	/** @var TaxableProperties **/
	private $properties;

	public function __construct(TaxableProperties $properties = null)
	{
		if (is_null($properties)) { $properties = new TaxableProperties; }

		$this->properties = $properties;
		$this->properties->tax = 0.05;		
	}	
}

class GenericLineLogic
{
	/** @var GenericProperties **/
	private $properties;

	public function __construct(GenericProperties $properties = null)
	{
		if (is_null($properties)) { $properties = new GenericProperties; }

		$this->properties = $properties;
		$this->properties->id = 1;
		$this->properties->name = 'Foo';
		$this->properties->price = 1.25;
	}	
}

class Line
{
	private $lineLogic;

	private $properties;

	public function __construct($lineType)
	{
		$propName = $lineType . "Properties";
		$this->properties = new $propName;

		$logicName = $lineType . "LineLogic";
		$this->lineLogic = new $logicName($this->properties);

		print_r($this->properties);
	}
}

//new Line('Generic');
//new Line('Taxable');
new Line('Item');