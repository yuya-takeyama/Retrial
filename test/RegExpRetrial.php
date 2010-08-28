<?php
require_once dirname(__FILE__) . '/../lib/Retrial.php';

class RegExpRetrial extends Retrial
{
    public function process($exp, $str)
    {
        return preg_match($exp, $str) > 0;
    }
}
