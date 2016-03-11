<?php

namespace WCKZ\StringUtil;

class MutateableChar extends StaticChar
{

    protected $parent = null;

    public function __construct($value, $position = 0, MutateableString $parent)
    {
        parent::__construct($value, $position);

        $this->parent = $parent;
    }

    public function before($value)
    {
        $char = new MutateableChar($value, -1, $this->parent);
        $char->next($this);
        $char->prev($this->prev(), true);

        if($this->prev())
        {
            $this->prev()->next($char);
        }

        $this->prev($char);
        $this->parent->rebuild();

        return $char;
    }

    public function after($value)
    {
        $char = new MutateableChar($value, -1, $this->parent);
        $char->prev($this);
        $char->next($this->next(), true);

        if($this->next())
        {
            $this->next()->prev($char);
        }

        $this->next($char);
        $this->parent->rebuild();

        return $char;
    }

    public function replace($value)
    {
        $this->value = $value;
        $this->parent->rebuild();

        return $this;
    }

    public function remove()
    {
        if($this->prev())
        {
            $this->prev()->next($this->next(), true);
        }

        if($this->next())
        {
            $this->next()->prev($this->prev(), true);
        }

        $this->prev(null, true);
        $this->next(null, true);

        $this->parent->rebuild();
    }

}