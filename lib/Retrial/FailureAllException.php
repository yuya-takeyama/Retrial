<?php
class Retrial_FailureAllException extends Exception
{
    public function setFailures(Retrial_Failures $failures)
    {
        $this->_failures = $failures;
    }

    public function getFailures()
    {
        return $this->_failures;
    }
}
