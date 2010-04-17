<?php
require_once 'PHPUnit/Framework.php';
require_once 'NullRetrial.php';
require_once 'RegExpRetrial.php';

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $retrial = new NullRetrial();
        $this->assertTrue($retrial->setRetrialCount(100)->execute());
    }

    /**
     * @expectedException Retrial_FailureAllException
     */
    public function testFail()
    {
        $retrial = new NullRetrial;
        $retrial->setRetrialCount(99)->execute();
    }

    public function testRetrial_FailureAllException()
    {
        $retrial = new NullRetrial;
        try {
            $retrial->setRetrialCount(50)->execute();
        } catch (Retrial_FailureAllException $e) {
            $failures = $e->getFailures();
            $failuresArray = $failures->getAll();
            $this->assertEquals(50, count($failuresArray));
            $this->assertEquals('50 is smaller than 100.', $failures->get()->getMessage());
            $this->assertEquals('50 is smaller than 100.', $failures->get(-1)->getMessage());
            $this->assertEquals('49 is smaller than 100.', $failures->get(-2)->getMessage());
            $this->assertEquals('1 is smaller than 100.', $failures->get(0)->getMessage());
            return;
        }
        $this->fail();
    }

    public function testVariableArguments()
    {
        $retrial = new RegExpRetrial;
        $this->assertTrue($retrial->execute('/bar/', 'foobarbaz'));
        $this->assertFalse($retrial->execute('/hoge/', 'foobarbaz'));
    }
}
