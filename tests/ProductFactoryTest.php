<?php

require_once dirname(__FILE__) . '/../ProductFactory.inc.php';

class ProductFactoryTest extends PHPUnit_Framework_TestCase
{
	public function testCanBuildASandwich()
	{
		$sandwich = ProductFactory::build('sandwich');
		$this->assertInstanceOf('Product', $sandwich);
		$this->assertEquals($sandwich->exposeName(), 'sandwich');
		$this->assertEquals($sandwich->exposePrice(), 3.25);
	}
}
