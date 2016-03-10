<?php

namespace WCKZ\StringUtil;

class StaticChar
{

    protected $value    = '';

    protected $position = 0;

    protected $prev     = null;

    protected $next     = null;

    public function __construct($value, $position = 0)
    {
        $this->value    = $value;
        $this->position = $position;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function prev(StaticChar $prev = null, $forceSet = false)
    {
        if($prev || $forceSet === true)
        {
            $this->prev = $prev;
        }

        return $this->prev;
    }

    public function next(StaticChar $next = null, $forceSet = false)
    {
        if($next || $forceSet === true)
        {
            $this->next = $next;
        }

        return $this->next;
    }

    public function position($position)
    {
        $this->position = $position;
    }

    public function str()
    {
        return $this->value;
    }

    public function match($pattern)
    {
        return preg_match($pattern, $this->str());
    }

    public function is($string)
    {
        $length = strlen($string);
        if($length == 1)
        {
            return $string == $this->str();
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