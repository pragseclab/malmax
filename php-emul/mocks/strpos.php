<?php

use PHPEmul\SymbolicVariable;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeAbstract;

function strpos_mock($emul, $haystack, $needle, $offset=0)
{
    if ($needle instanceof SymbolicVariable || $offset instanceof  SymbolicVariable) {
        return new SymbolicVariable('strpos symbolic needle or offset', '*');
    }
    elseif ($haystack instanceof SymbolicVariable) {
        $result = clone $haystack;
        $regex_value = $result->variable_value;
        $index = strpos($regex_value, $needle, $offset);
        if ($index === false) {
            // Since haystack is symbolic, the * part could be matching the needle.
            return $haystack;
        }
        else {
            return $index;
        }
    }
    else {
        return strpos($haystack, $needle, $offset);
    }
}