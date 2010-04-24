<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
require_once 'Retrial.php';

class CountUpRetrial extends Retrial
{
    private $_str;

    public function process($killWhen = NULL)
    {
        $this->_str .= $this->getTrialCount();
        if (is_int($killWhen) && $killWhen === $this->getTrialCount()) {
            throw new RuntimeException('Killed.');
        }
        if ($this->getTrialCount() < 5) {
            throw new Retrial_FailureException($this->getTrialCount() . ' is smaller than 5.');
        } else {
            return true;
        }
    }

    protected function initialize()
    {
        $this->_str = 'i';
    }

    protected function finalize()
    {
        $this->_str .= 'f';
    }

    protected function before()
    {
        $this->_str .= 'b';
    }

    protected function after()
    {
        $this->_str .= 'a';
    }

    public function getStr()
    {
        return $this->_str;
    }
}
