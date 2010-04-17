<?php
class Retrial_Failures
{
    private $_failures = array();

    public function push(Retrial_FailureException $e)
    {
        $this->_failures[] = $e;
    }

    public function getAll()
    {
        return $this->_failures;
    }

    public function get($num = -1)
    {
        if ($num < 0) {
            $num = count($this->_failures) + $num;
        }
        return $this->_failures[$num];
    }
}
