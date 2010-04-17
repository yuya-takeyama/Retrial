<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
require_once 'Retrial.php';

class HttpRetrial extends Retrial
{
    private $_url;

    public function __construct($url)
    {
        $this->_url = $url;
    }

    public function process()
    {
        $result = @file_get_contents($this->_url);
        if ($result === false) {
            throw new Retrial_FailureException('Failed to get ' . $this->_url . '.');
        }
        return $result;
    }
}
