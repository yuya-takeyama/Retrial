<?php
require_once 'Retrial/Failures.php';
require_once 'Retrial/FailureException.php';
require_once 'Retrial/FailureAllException.php';

abstract class Retrial
{
    protected $_result;

    public function execute($times = 1)
    {
        $failures = new Retrial_Failures;
        for ($i = 0; $i < $times; $i++)
        {
            try {
                $result = $this->process();
                return $result;
            } catch (Retrial_FailureException $e) {
                $failures->push($e);
            }
        }
        $e = new Retrial_FailureAllException('All of the trial has been a failure.');
        $e->setFailures($failures);
        throw $e;
    }

    abstract protected function process();
}
