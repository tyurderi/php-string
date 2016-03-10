<?php

namespace WCKZ\StringUtil;

class MutateableString
{

    protected $value  = '';

    protected $length = 0;

    public function __construct($value = null)
    {
        $this->value = (string) $value;
        $this->calculateLength();
    }

    public function __toString()
    {
        return $this->value;
    }

    public function length()
    {
        return $this->length;
    }

    public function add($value)
    {
        $this->value .= $value;
        $this->calculateLength();
    }

    public function set($value)
    {
        $this->value = $value;
        $this->calculateLength();
    }

    public function find($value)
    {
        return strpos($this, $value);
    }

    public function cut($start, $length = PHP_INT_MAX)
    {
        return substr($this->value, $start, $length);
    }

    protected function calculateLength()
    {
        $this->length = strlen($this);
    }

}

$pattern = new MutateableString('abc+');
$pattern->add('!');

var_dump($pattern->cut(1));