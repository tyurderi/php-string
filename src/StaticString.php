<?php

namespace WCKZ\StringUtil;

class StaticString implements \ArrayAccess, \Iterator
{

    protected $value    = '';

    protected $length   = 0;

    protected $chars    = array();

    protected $position = 0;

    public function __construct($value = null)
    {
        $this->value  = (string) $value;
        $this->length = strlen($this->value);

        for($i = 0; $i < $this->length(); $i++)
        {
            $char = new StaticChar($this->value[$i], $i, $this);
            $char->prev($i == 0 ? null : $this->chars[$i - 1]);

            if($char->prev())
            {
                $char->prev()->next($char);
            }

            $this->chars[] = $char;
        }
    }

    public function __toString()
    {
        return $this->value;
    }

    public function length()
    {
        return $this->length;
    }

    public function find($value)
    {
        return strpos($this, $value);
    }

    public function cut($start, $length = PHP_INT_MAX)
    {
        return substr($this->value, $start, $length);
    }

    public function offsetExists($offset)
    {
        return isset($this->chars[$offset]);
    }

    public function offsetGet($offset)
    {
        if($this->offsetExists($offset))
        {
            return $this->chars[$offset];
        }

        return null;
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
        unset($this->chars[$offset]);
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    public function current()
    {
        return $this->offsetGet($this->position);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function key()
    {
        return $this->position;
    }

}