<?php


class MySampleClass
{

    public static function create()
    {
        return new static();
    }

    public function sumNumbers(...$numbers)
    {
        $sum = 0;
        foreach ($numbers as $n) {
            $sum += $n;
        }
        return $sum;
    }

    public function returnMe($arg)
    {
        return $arg;
    }
}