<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('../config.php');
$IP = $_SERVER['REMOTE_ADDR'];
global $CFG, $DB;
//echo $IP;

if ($device = $DB->get_record('local_sshd_rpi', ['ip' => $IP])) {
    $FAQ = new \local_selfservehd\Faq($device->faqid);

    if (current_language() == 'en') {
        $content = $FAQ->getMessageEn();
    } else {
        $content = $FAQ->getMessageFr();
    }
} else {
    $content = $IP;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <META HTTP-EQUIV="refresh" CONTENT="5">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo $CFG->wwwroot;?>/local/selfservehd/client/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $CFG->wwwroot;?>/local/selfservehd/client/css/client.css">
        <title></title>

    </head>
    <body>

        <?php echo $content; ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <div>
                    <a href="index.php" class="btn btn-outline-success btn-lg"><?php
                        echo get_string('it_works', 'local_selfservehd');
                        ?></a>
                    <a href="#" class="btn btn-outline-danger btn-lg"><?php
                        echo get_string('help', 'local_selfservehd');
                        ?></a>
                </div>
            </div>
        </nav>
        <script src="<?php echo $CFG->wwwroot;?>/local/selfservehd/client/js/jquery-3.3.1.min.js" />
        <script src="<?php echo $CFG->wwwroot;?>/local/selfservehd/client/js/bootstrap.min.js" />
    </body>
</html>
