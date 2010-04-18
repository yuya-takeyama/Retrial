<?php
require_once 'Retrial/Failures.php';
require_once 'Retrial/FailureException.php';
require_once 'Retrial/FailureAllException.php';

abstract class Retrial
{
    protected $_result;

    protected $_maxTrial = 1;

    private $_trialCount;

    private $_sleepTime = 0;

    public function execute()
    {
        $failures = new Retrial_Failures;
        $args = func_get_args();
        for ($this->_trialCount = 1; $this->_trialCount <= $this->_maxTrial; $this->_trialCount++)
        {
            try {
                $this->_sleep();
                $result = call_user_func_array(array($this, 'process'), $args);
                return $result;
            } catch (Retrial_FailureException $e) {
                $failures->push($e);
            }
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

    private function _sleep()
    {
        if ($this->_trialCount > 1 && $this->_sleepTime > 0) {
            sleep($this->_sleepTime);
        }
    }

    protected function process()
    {
        throw new ErrorException('Retrial#process must be implemented.');
    }
}
