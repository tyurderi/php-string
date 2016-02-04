<?php

namespace String;

class Char
{

    /**
     * @var string
     */
    protected $charValue = '';

    /**
     * @var Char
     */
    protected $prev     = null;

    /**
     * @var Char
     */
    protected $next     = null;

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var CharChain
     */
    protected $chain    = null;

    public function __construct($charValue = '\0', $position = 0, CharChain $chain)
    {
        $this->charValue = $charValue;
        $this->chain     = $chain;
    }

    public function before($charValue)
    {
        $char = new Char($charValue, -1, $this->chain);
        $char->setNext($this);

        if($this->prev())
        {
            $this->prev()->setNext($char);
        }

        $this->setPrev($char);
        $this->chain->rebuild();

        return $char;
    }

    public function after($charValue)
    {
        $char = new Char($charValue, -1, $this->chain);
        $char->setPrev($this);

        if($this->next())
        {
            $this->next()->setPrev($char);
        }

        $this->setNext($char);
        $this->chain->rebuild();

        return $char;
    }

    public function replace($charValue)
    {
        $this->charValue = $charValue;

        $this->chain->rebuild();

        return $this;
    }

    public function remove()
    {
        if($this->prev())
        {
            $this->prev()->setNext($this->next());
        }

        if($this->next())
        {
            $this->next()->setPrev($this->prev());
        }

        $this->setPrev(null);
        $this->setNext(null);

        $this->chain->rebuild();
    }

    public function prev()
    {
        return $this->prev;
    }

    public function next()
    {
        return $this->next;
    }

    public function setPrev(Char $prev = null)
    {
        $this->prev = $prev;
    }

    public function setNext(Char $next = null)
    {
        $this->next = $next;
    }

    public function position($position = null)
    {
        if(isset($position))
        {
            $this->position = $position;
        }

        return $this->position;
    }

    public function __toString()
    {
        return $this->charValue;
    }

    public function match($pattern)
    {
        return preg_match($pattern, $this->charValue);
    }

    public function is($string)
    {
        $length = strlen($string);
        if($length == 1)
        {
            return $string == $this->charValue;
        }

        $buffer = '';
        $char   = $this;
        while($char && $length > 0)
        {
            $buffer .= $char;
            $char    = $char->next();
            $length -= 1;
        }

        return $buffer === $string;
    }

}