<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
global $CFG;
include_once('../config.php');
$IP = $_SERVER['REMOTE_ADDR'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <META HTTP-EQUIV="refresh" CONTENT="10">
        <!-- Bootstrap CSS -->
        <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" crossorigin="anonymous"/>-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/client.css" crossorigin="anonymous"/>
        <title></title>
    </head>
    <body>
        <div class="container-fluid mt-10">
            <div class="row">
                <div class="col">
                    <a href="details.php?lang=fr" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_fr', 'local_selfservehd'); ?></a>
                </div>
                <div class="col">
                    <a href="details.php?lang=en" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help_en', 'local_selfservehd'); ?></a>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
    </body>
</html>
