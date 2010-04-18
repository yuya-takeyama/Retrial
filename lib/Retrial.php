<?php
require_once 'Retrial/Failures.php';
require_once 'Retrial/FailureException.php';
require_once 'Retrial/FailureAllException.php';

abstract class Retrial
{
    protected $_maxTrial = 1;

    private $_trialCount;

    private $_sleepTime = 0;

    private $_failedFlag = NULL;

    public function execute()
    {
        $failures = new Retrial_Failures;
        $args = func_get_args();
        // @TODO hook some processes
        for ($this->_trialCount = 1; $this->_trialCount <= $this->_maxTrial; $this->_trialCount++)
        {
            // @TODO hook some processes
            try {
                $this->_sleep();
                $result = call_user_func_array(array($this, 'process'), $args);
                $this->_success();
            } catch (Retrial_FailureException $e) {
                $this->_fail();
                $failures->push($e);
            }
            // @TODO hook some processes
            if ($this->isSucceeded()) {
                break;
            }
        }
        // @TODO hook some processes
        if ($this->isSucceeded()) {
            return $result;
        }
        $e = new Retrial_FailureAllException('All of the trial has been a failure.');
        $e->setFailures($failures);
        throw $e;
    }

    public function setMaxTrial($max)
    {
        $this->_maxTrial = $max;
        return $this;
    }

    public function setSleepTime($sec = 0)
    {
        $this->_sleepTime = (int) $sec;
        return $this;
    }

    public function isSucceeded()
    {
        $this->_assertValidFailedFlag(__METHOD__);
        return !$this->isFailed();
    }

    public function isFailed()
    {
        $this->_assertValidFailedFlag(__METHOD__);
        return $this->_failedFlag;
    }

    private function _sleep()
    {
        if ($this->_trialCount > 1 && $this->_sleepTime > 0) {
            sleep($this->_sleepTime);
        }
    }

    private function _success()
    {
        $this->_failedFlag = false;
    }

    private function _fail()
    {
        $this->_failedFlag = true;
    }

    private function _assertValidFailedFlag($methodName)
    {
        if (!is_bool($this->_failedFlag)) {
            throw new ErrorException("Invalid using of {$methodName}.");
        }
    }

    protected function process()
    {
        throw new ErrorException('Retrial#process must be implemented.');
    }
}
