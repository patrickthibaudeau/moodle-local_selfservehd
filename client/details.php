<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('../config.php');
global $CFG, $DB;
$IP = $_SERVER['REMOTE_ADDR'];
$lang = optional_param('lang','en', PARAM_TEXT);

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
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" crossorigin="anonymous"/>
        <link rel="stylesheet" type="text/css" href="css/client.css" crossorigin="anonymous"/>
        <title></title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="card mt-2 mb-5">
                <div class="card-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <span class="float-right">
                    <a href="index.php" class="btn btn-outline-success btn-lg mr-2"><?php echo get_string('it_works', 'local_selfservehd'); ?></a>
                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-lg helpBtn" data-ip="<?php echo $IP;?>"><?php echo get_string('help', 'local_selfservehd'); ?></a>
                </span>
            </div>
        </nav>
        <script src="<?php echo $CFG->wwwroot; ?>/local/selfservehd/client/js/jquery-3.3.1.min.js" /></script>
    <script src="<?php echo $CFG->wwwroot; ?>/local/selfservehd/client/js/bootstrap.min.js" /></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('img').each(function () {
            $(this).removeAttr('width')
            $(this).removeAttr('height');
            $(this).addClass('img-fluid');
            $(this).removeClass('atto_image_button_text-bottom');
            $(this).removeClass('img-responsive');
        });
    });
</script>
</body>
</html>
