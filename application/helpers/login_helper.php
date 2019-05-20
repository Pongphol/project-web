<?php

function is_logged_in() {
    
    $CI =& get_instance();
    
    $user = $CI->session->userdata('user_id');
    return isset($user) ? true : false;
}

?>