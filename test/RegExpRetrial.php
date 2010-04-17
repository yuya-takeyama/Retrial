<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
require_once 'Retrial.php';

class RegExpRetrial extends Retrial
{
    public function process($exp, $str)
    {
        return preg_match($exp, $str) > 0;
    }
}
