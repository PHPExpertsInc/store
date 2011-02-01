<?php

class ProductFactory
{
	// @codeCoverageIgnoreStart
	private function __constructor() { }
	// @codeCoverageIgnoreStop

	/** @return Product **/
	public static function build($name)
	{
		switch ($name)
		{
			case 'car': return new Product($name, '25000.00');
			case 'sandwich': return new Product($name, '3.25');
		}
	}
}


