<?php
$observers = array(
    array(
        'eventname'   => '\core\event\user_loggedin',
        'callback'    => 'redirect_agents',
        'includefile' => '/local/selfservehd/lib.php'
    ),    
);

