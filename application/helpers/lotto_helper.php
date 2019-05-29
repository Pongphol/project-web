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

function get_lotto_array($type = 'latest')
{
    $response = get_lotto($type)['response'];

    $data = [
        'date' => stringDateThaiToDate($response['date']),
        'prize_first' => serialize($response['prizes'][0]['number']),
        'number_back_three' => serialize($response['runningNumbers'][1]['number']),
        'number_back_two' => serialize($response['runningNumbers'][2]['number'])
    ];

    return $data;
}

function lotto_answer($number1, $number2, $cutNumber2 = false)
{
    $status = 'wait';

    if (is_numeric($cutNumber2) && $cutNumber2 !== false)
    {
        if (is_array($number2))
        {
            foreach ($number2 as $value)
            {
                $nb2 = substr($value, $cutNumber2);

                if ($number1 == $nb2)
                {
                    $status = 'win';
                    break;
                }
                else
                {
                    $status = 'lose';
                }
            }
        }
        else
        {
            $number2 = substr($number2, $cutNumber2);
            $status = ($number1 == $number2) ? 'win' : 'lose';
        }  
    }
    else
    {
        if (is_array($number2))
        {
            foreach ($number2 as $value)
            {
                if ($number1 == $value)
                {
                    $status = 'win';
                    break;
                }
                else
                {
                    $status = 'lose';
                }
            }
        }
        else
        {
            $status = ($number1 == $number2) ? 'win' : 'lose';
        }   
    }

    return $status;
}

?>