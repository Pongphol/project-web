<?php

function is_serial($string) {
    return (@unserialize($string) !== false || $string == 'b:0;');
}

function unserial($data)
{
    $result = [];

    foreach($data as $key => $value)
    {
        $result[$key] = is_serial($value) ? unserialize($value) : $value;
    }

    return $result;
}

function unserial_list($data)
{
    $result = [];

    foreach($data as $key => $value)
    {
        foreach($data[$key] as $k => $v)
        {
            $result[$key][$k] = is_serial($v) ? unserialize($v) : $v;
        }  
    }

    return $result;
}

?>