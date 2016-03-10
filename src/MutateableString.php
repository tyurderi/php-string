<?php

namespace WCKZ\StringUtil;

include 'Char.php';

class MutateableString implements \ArrayAccess
{

    protected $value  = '';

    protected $length = 0;

    protected $chars  = array();

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

    public function update()
    {
        if(empty($this->chars))
        {
            for($i = 0; $i < $this->length(); $i++)
            {
                $char = new Char($this->value[$i], $i, $this);
                $char->prev($i == 0 ? : $this->chars[$i - 1]);

                if($char->prev())
                {
                    $char->next($char);
                }

                $this->chars[] = $char;
            }
        }
        else
        {
            /** @var Char $char */
            $char        = $this->chars[0];
            $this->chars = array();
            $i           = 0;

            while($char)
            {
                $char->position($i);
                $this->chars[] = $char;

                $char = $char->next();
            }
        }
    }

    public function offsetExists($offset)
    {
        return $this->offsetGet($offset) !== null;
    }

    public function offsetGet($offset)
    {
        return $this->chars[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if($this->offsetExists($offset))
        {
            $this->offsetGet($offset)->set($value);
        }
    }

    public function offsetUnset($offset)
    {
        //unset($this->chars[$offset]);
    }

    protected function calculateLength()
    {
        $this->length = strlen($this);
        $this->update();
    }

}

$pattern = new MutateableString('abc+');