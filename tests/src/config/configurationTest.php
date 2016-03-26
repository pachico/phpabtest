<?php

namespace Pachico\Abtest\Config;

use \Pachico\Abtest\Test,
	\Pachico\Abtest\Split,
	\Pachico\Abtest\Memory,
	\Pachico\Abtest\Tracking;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Configuration
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Configuration;
	}

	/**
	 * @covers Pachico\Abtest\Config\Configuration::addTest
	 * @covers Pachico\Abtest\Config\Configuration::getTests
	 */
	public function testAddTest()
	{
		$test1 = new Test\Test('foo', new Split\ArrayProbability([50, 50]), new Memory\Cookie('foo'));

		$this->assertInstanceOf(
			'Pachico\Abtest\Config\Configuration', $this->object->addTest($test1)
		);

		$this->assertArrayHasKey('foo', $this->object->getTests());

		$this->assertCount(1, $this->object->getTests());

		$test2 = new Test\Test('bar', new Split\ArrayProbability([50, 50]), new Memory\Cookie('foo'));

		$this->assertInstanceOf(
			'Pachico\Abtest\Config\Configuration', $this->object->addTest($test2)
		);

		$this->assertArrayHasKey('bar', $this->object->getTests());

		$this->assertCount(2, $this->object->getTests());
	}

	/**
	 * @covers Pachico\Abtest\Config\Configuration::getTestByName
	 */
	public function testGetTestByName()
	{
		$test = new Test\Test('foo', new Split\ArrayProbability([50, 50]), new Memory\Cookie('foo'));

		$this->object->addTest($test);

		$this->assertSame($test, $this->object->getTestByName('foo'));

		$this->assertNull($this->object->getTestByName('bar'));
	}

	/**
	 * @covers Pachico\Abtest\Config\Configuration::setTracking
	 */
	public function testSetTracking()
	{

		$tracking = new Tracking\GoogleExperiments();
		
		$this->assertInstanceOf(
			'Pachico\Abtest\Config\Configuration', $this->object->setTracking($tracking)
		);
	}

}
