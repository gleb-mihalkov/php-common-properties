<?php
require 'vendor/autoload.php';
use Common\IProperties;
use Common\TAssocProperties;

class Test implements IProperties, ArrayAccess
{
    use TAssocProperties;

    protected $foo = 'bar';

    protected function getFooProperty()
    {
        return $this->foo;
    }

    protected function setFooProperty($value)
    {
        $this->foo = $value;
    }
}

$test = new Test();
var_dump($test->foo);