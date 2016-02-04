<?php

namespace String;

class CharChain implements \ArrayAccess, \Iterator
{

    /**
     * @var string
     */
    protected $string = '';

    /**
     * @var Char[]
     */
    protected $chars  = array();

    /**
     * @var int
     */
    protected $length = 0;

    /**
     * @var int
     */
    protected $position = 0;

    public function __construct($string)
    {
        $this->string   = $string;
        $this->chars    = array();
        $this->length   = strlen($string);
        $this->position = 0;

        $this->parse();
    }

    public function length()
    {
        return $this->length;
    }

    public function iterate($callback)
    {
        if($this->length() == 0)
        {
            return false;
        }

        for($i = 0; $i < $this->length(); $i++)
        {
            call_user_func_array($callback, array(
                $this->chars[$i],
                &$i
            ));
        }

        return true;
    }

    public function string()
    {
        return $this->string;
    }

    public function sub($start, $length = null)
    {
        return substr($this->string, $start, $length);
    }

    public function __toString()
    {
        return $this->string();
    }

    protected function parse()
    {
        for($i = 0; $i < $this->length; $i++)
        {
            $char = new Char($this->string()[$i], $i, $this);

            if($prev = $this->offsetGet($i - 1))
            {
                $char->setPrev($prev);
                $prev->setNext($char);
            }

            $this->chars[] = $char;
        }

        $this->length = count($this->chars);
    }

    protected function getFirst()
    {
        $char = null;
        while(true)
        {
            $char = array_shift($this->chars);
            if($char->prev() == null && $char->next() == null)
            {
                $this->offsetUnset(0);
                continue;
            }
            else
            {
                break;
            }
        }

        return $char;
    }

    public function rebuild()
    {
        $char        = $this->getFirst();
        $this->chars = array();
        $buffer      = '';

        while($char)
        {
            $buffer .= $char;
            $char    = $char->next();
        }

        $this->string = $buffer;
        $this->length = strlen($buffer);
        $this->parse();
    }

    /** ArrayAccess */

    public function offsetGet($offset)
    {
        if(!$this->offsetExists($offset))
        {
            return false;
        }

        return $this->chars[$offset];
    }

    public function offsetExists($offset)
    {
        return isset($this->chars[$offset]);
    }

    public function offsetSet($offset, $value)
    {
        return false;
    }

    public function offsetUnset($offset)
    {
        return false;
    }

    /** Iterate */

    public function current()
    {
        return $this->offsetGet($this->position);
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    public function rewind()
    {
        $this->position = 0;
    }

}