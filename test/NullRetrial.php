<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
require_once 'Retrial.php';

class NullRetrial extends Retrial
{
    private $_count = 0;

    private $_fooFlag;

    private $_fooCounter = 0;

    private $_barCounter = 0;

    /**
     * This method throws Retrial_FailureException while $this->_count is smaller than 100.
     * If the count is greater than or equals to 100, returns true.
     */
    public function process()
    {
        $this->_count += 1;
        if ($this->_count < 100) {
            throw new Retrial_FailureException($this->_count . ' is smaller than 100.');
        }
        return true;
    }

    protected function initialize()
    {
        if (!is_null($this->_fooFlag) || $this->_fooCounter !== 0 || $this->_barCounter !== 0) {
            throw new Exception('When this exception is throwed, that means an error had been occured in ' . __METHOD__ . '.');
        }
        $this->_fooFlag = true;
    }

    protected function finalize()
    {
        if ($this->_fooFlag !== true) {
            throw new Exception('When this exception is throwed, that means an error had been occured in ' . __METHOD__ . '.');
        }
    }

    protected function before()
    {
        if ($this->_fooCounter !== $this->_barCounter) {
            throw new Exception('When this exception is throwed, that means an error had been occured in ' . __METHOD__ . '.');
        }
        $this->_fooCounter += 1;
    }

    protected function after()
    {
        if ($this->_fooCounter - $this->_barCounter !== 1) {
            throw new Exception('When this exception is thrwoed, that means an error had been ocured in ' . __METHOD__ . '.');
        }
        $this->_barCounter += 1;
    }
}
