<?php

namespace WCKZ\StringUtil;

class MutateableString extends StaticString
{

    protected function parse()
    {
        $this->chars = array();

        for($i = 0; $i < $this->length(); $i++)
        {
            $char = new MutateableChar($this->value[$i], $i, $this);

            if($prev = $this->offsetGet($i - 1))
            {
                $char->prev($prev);
                $prev->next($char);
            }

            $this->chars[] = $char;
        }
    }

    public function rebuild()
    {
        $char        = $this->firstChar();
        $this->chars = array();
        $buffer      = '';

        while($char)
        {
            $buffer .= $char;
            $char    = $char->next();
        }

        $this->value  = $buffer;
        $this->length = strlen($this->value);
        $this->parse();
    }

    protected function firstChar()
    {
        $char = null;
        while(true)
        {
            $char = array_shift($this->chars);
            if(!$char || ($char && $char->prev() == null && $char->next() == null))
            {
                $this->offsetUnset(0);
                continue;
            }
            else
            {
                break;
            }
        }

        while($char->prev() !== null)
        {
            $char = $char->prev();
        }

        return $char;
    }

}