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
        echo "trial: " . $this->_url . "\n";
        echo $result . "\n";
        if ($result === false) {
            throw new Retrial_FailureException('Failed to get ' . $this->_url . '.');
        }
        return $result;
    }
}

try {
    $retrial = new HttpRetrial('http://gist.github.com/raw/364324/1c27c8a609b4ddc1b09d71234148618c39388cdc/sample.js');
    $retrial->execute(3);
} catch (Retrial_FailureAllException $e) {
}
try {
$retrialFail = new HttpRetrial('http://example.com/_______________');
$retrialFail->execute(3);
} catch (Retrial_FailureAllException $e) {
    echo $e->getMessage() . "\n";
    $failures = $e->getFailures()->getAll();
    foreach ($failures as $failure)
    {
        echo $failure->getMessage() . "\n";
    }
}
