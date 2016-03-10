<?php

namespace WCKZ\StringUtil;

class Char
{

    protected $value    = '';

    protected $position = 0;

    protected $parent   = null;

    protected $prev     = null;

    protected $next     = null;

    public function __construct($value, $position = 0, MutateableString $parent = null)
    {
        $this->value    = $value;
        $this->position = $position;
        $this->parent   = $parent;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function prev($prev = null)
    {
        if($prev)
        {
            $this->prev = $prev;
        }

        return $this->prev;
    }

    public function next($next = null)
    {
        if($next)
        {
            $this->next = $next;
        }

        return $this->next;
    }

    public function set($value)
    {
        $this->value = $value;
    }

    public function position($position)
    {
        $this->position = $position;
    }

}