<?php
require_once 'PHPUnit/Framework.php';
require_once 'HttpRetrial.php';

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $retrial = new HttpRetrial('http://example.com/');
        $this->assertRegExp('/These domain names are reserved for use in documentation/', $retrial->setRetrialCount(3)->execute());
    }

    /**
     * @expectedException Retrial_FailureAllException
     */
    public function testFail()
    {
        $retrial = new HttpRetrial('http://example.com/___');
        $retrial->setRetrialCount(1)->execute();
    }

    public function testRetrial_FailureAllException()
    {
        $retrial = new HttpRetrial('http://example.com/___');
        try {
            $retrial->setRetrialCount(3)->execute();
        } catch (Retrial_FailureAllException $e) {
            $failures = $e->getFailures();
            $this->assertEquals(3, count($failures->getAll()));
            return;
        }
        $this->fail();
    }
}
