<?php

// for anonymizing URL data such as projectID

function random_pw($pw_length) {
    $pass = NULL;
    $charlist = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz023456789';
    $ps_len = strlen($charlist);
    mt_srand((double)microtime()*1000000);

    for($i = 0; $i < $pw_length; $i++) {
        $pass .= $charlist[mt_rand(0, $ps_len - 1)];
    }
    return ($pass);
}
?>