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
        $retrial->setRetrialCount(3)->execute();
    }
}
