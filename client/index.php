<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once('../config.php');
$IP = $_SERVER['REMOTE_ADDR'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <META HTTP-EQUIV="refresh" CONTENT="10">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/client.css">
        <title></title>
    </head>
    <body>
        <a href="" class="btn btn-primary btn-fullscreen" ><?php echo get_string('request_help', 'local_selfservehd');?></a>
        <script src="js/jquery-3.3.1.min.js" />
        <script src="js/bootstrap.min.js" />
    </body>
</html>
