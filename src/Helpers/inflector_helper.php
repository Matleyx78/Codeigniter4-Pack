<?php
function string_purifier($string = '')
    {
        $purified = preg_replace( '/[a-zA-Z0-9_-]+/', '-', $string);
    return $purified;
    }
