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

function lotto_answer($number1, $number2, $cutNumber2 = false, $todNumner = false)
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
            if ($todNumner) 
            {
               $tod_result =  check_tod_number($number1);
               foreach($tod_result as $row)
               {
                    if($row == $number2)
                    {
                        $status = 'win';
                        break;
                    } 
                    $status = 'lose';
               }
            }
            else
            {
                $status = ($number1 == $number2) ? 'win' : 'lose';
            }
            
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
            if ($todNumner) 
            {
               $tod_result =  check_tod_number($number1);
               foreach($tod_result as $row)
               {
                    if($row == $number2)
                    {
                        $status = 'win';
                        break;
                    } 
                    $status = 'lose';
               }
            }
            else
            {
                $status = ($number1 == $number2) ? 'win' : 'lose';
            }
        }   
    }

    return $status;
}
function check_tod_number($number)
{
    $split_num = str_split($number);
    $size = count($split_num);

    if($size == 2)
    {
        if($split_num[0] == $split_num[1])
        {
            $size = 1;
        }
        else
        {
            $size = 2;
        }
        
        $output = array();
        
        while(count($output) < $size)
        {
          shuffle($split_num);
          $shuf_num = implode("",$split_num);
          if(!in_array( $shuf_num , $output))
          $output[] = $shuf_num;
        }
        return $output;
    }
    if($size == 3)
    {
        if($split_num[0] == $split_num[1])
        {
          if($split_num[1] == $split_num[2])
          {
            $size = 1;
          }
          else
          {
            $size = 3;
          }
          
      }
      else if($split_num[0] == $split_num[2])
      {
        $size = 3;
      }
      else if($split_num[1] == $split_num[2])
      {
        $size = 3;
      }
      else
      {
        $size = 6;
      }
      
      $output = array();
      
      while(count($output) < $size)
      {
        shuffle($split_num);
        $shuf_num = implode("",$split_num);
        if(!in_array( $shuf_num , $output))
        $output[] = $shuf_num;
      }
      return $output;
    }
}

?>