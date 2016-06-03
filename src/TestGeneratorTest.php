<?php

class TestGeneratorTest extends \PHPUnit_Framework_TestCase
{

	public function testConfigureSuccess()
	{
		$tester = $this->getMockBuilder('TestGenerator')
                         ->setMethods(['execute'])
                         ->getMock();

        $tester->execute('foo', 'bar');
	}

	public function testConfigureFailure()
	{

	}

	public function testExecuteSuccess()
	{

	}

	public function testExecuteFailure()
	{

	}

	public function testParseFileSuccess()
	{

	}

	public function testParseFileFailure()
	{

	}

	public function testReturnTestFunctionsSuccess()
	{

	}

	public function testReturnTestFunctionsFailure()
	{

	}

	public function testWriteFunctionsToFileSuccess()
	{

	}

	public function testWriteFunctionsToFileFailure()
	{

	}

}