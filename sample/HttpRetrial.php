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
        echo "trial\n";
        var_dump($result);
        return $result === false ? false : true;
    }
}

$retrial = new HttpRetrial('http://example.com');
$retrial->execute(3);
$retrialFail = new HttpRetrial('http://example.com/_______________');
$retrialFail->execute(3);
