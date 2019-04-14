<?php
$observers = array(
    array(
        'eventname'   => '\core\event\user_loggedin',
        'callback'    => 'redirect_user',
        'includefile' => '/local/selfserve/lib.php'
    ),    
);

