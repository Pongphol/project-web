<?php

function get_lotto($type = 'latest', $encode = false)
{
    if (is_numeric($type))
    {
        $type = 'lotto/' . $type;
    }

    $ch =  curl_init('https://thai-lotto-api.herokuapp.com/' . $type);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

    $result = curl_exec($ch);

    if (!$encode)
    {
        return json_decode($result, true);
    }
    
    echo json_encode($result);
}

?>