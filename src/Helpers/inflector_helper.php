<?php
function string_purifier($string = '')
    {
        $purified = preg_replace( '/[^a-z0-9]+/', '-', $string);
    return $purified;
    }
