<?php

function pre_r($data = '')
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function is_logged_in() {
    $CI =& get_instance();
    $user = $CI->session->userdata('account_id');

    return isset($user) ? true : false;
}

function is_admin()
{
    $CI =& get_instance();
    $user = $CI->session->userdata('account_role');

    return (isset($user) && $user == 'admin') ? true : false;
}

function admin_only()
{
    if (!is_admin())
    {
        redirect('member');
    }
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