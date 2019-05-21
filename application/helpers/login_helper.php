<?php

function is_logged_in() {
    $CI =& get_instance();
    $user = $CI->session->userdata('account_id');

    return isset($user) ? true : false;
}

function require_login($redirect='')
{
    if (!is_logged_in())
    {
        redirect($redirect);
    }
}

function require_no_login($redirect='')
{
    if (is_logged_in())
    {
        redirect($redirect);
    }
}

?>