<?php
namespace Acme\Test; // TODO: Add to the generator

require __DIR__.'/../vendor/autoload.php';

use Acme\TestGenerator; // TODO: Add to the generator

class TestGeneratorTest extends \PHPUnit_Framework_TestCase
{

	public function setUp()
	{

		$this->mockInput = 'showMeTheMoney';

		$this->mockOutput = 'weAreAllOut';
	}

	public function testMyFakeFunctionReturnsTrue()
	{
		$tester = $this->mockTestGenerator('myFakeFunction');

		$tester->expects($this->once())
			   ->method('myFakeFunction')
			   ->will($this->returnValue(true));

		$result = $tester->runMyFakeFunction();
		$this->assertTrue($result);
	}

	public function testConfigureFailure()
	{

	}

	// public function testExecuteSuccess()
	// {

	// }

	// public function testExecuteFailure()
	// {

	// }

	// public function testParseFileSuccess()
	// {

	// }

	// public function testParseFileFailure()
	// {

	// }

	// public function testReturnTestFunctionsSuccess()
	// {

	// }

	// public function testReturnTestFunctionsFailure()
	// {

	// }

	// public function testWriteFunctionsToFileSuccess()
	// {

	// }

	// public function testWriteFunctionsToFileFailure()
	// {

	// }
	//
	public function mockTestGenerator($methods)
	{
		// $methods = array_merge(array($methods));

		$tester = $this->getMockBuilder('Acme\TestGenerator')
				->setMethods([$methods])
				->getMock();

		return $tester;
	}

}