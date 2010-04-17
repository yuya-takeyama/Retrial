<?php
abstract class Retrial
{
    public function execute($times = 1)
    {
        for ($i = 0; $i < $times; $i++)
        {
            $result = $this->process();
            if ($result === true) {
                break;
            }
        }
    }

    abstract protected function process();
}
