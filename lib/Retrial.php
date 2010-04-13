<?php
abstract class Retrial
{
    public function tries($times = 1)
    {
        for ($i = 0; $i < $times; $i++)
        {
            $result = $this->execute();
            if ($result === true) {
                break;
            }
        }
    }

    abstract public function execute();
}
