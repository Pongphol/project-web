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

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>