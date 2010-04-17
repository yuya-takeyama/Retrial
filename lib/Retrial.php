<?php
require_once 'Retrial/Failures.php';
require_once 'Retrial/FailureException.php';
require_once 'Retrial/FailureAllException.php';

abstract class Retrial
{
    protected $_result;

    protected $_retrialCount = 1;

    public function execute()
    {
        $failures = new Retrial_Failures;
        $args = func_get_args();
        for ($i = 0; $i < $this->_retrialCount; $i++)
        {
            try {
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

    public function setRetrialCount($count)
    {
        $this->_retrialCount = $count;
        return $this;
    }

    protected function process()
    {
        throw new ErrorException('Retrial#process must be implemented.');
    }
}
