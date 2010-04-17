<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
require_once 'Retrial.php';

class NullRetrial extends Retrial
{
    private $_count = 0;

    /**
     * This method throws Retrial_FailureException while $this->_count is smaller than 100.
     * If the count is greator than or equals to 100, returns true.
     */
    public function process()
    {
        $this->_count += 1;
        if ($this->_count < 100) {
            throw new Retrial_FailureException($this->_count . ' is smaller than 100.');
        }
        return true;
    }
}
