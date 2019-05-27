<?php

function is_serial($string) {
    return (@unserialize($string) !== false || $string == 'b:0;');
}

function unserial($data)
{
    $result = [];

    foreach($data as $key => $value)
    {
        if (is_serial($value))
        {
            $result[$key] = unserialize($value);
        }
        else
        {
            $result[$key] = $value;
        }   
    }

    return $result;
}

?>