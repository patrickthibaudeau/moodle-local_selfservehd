<?php

/**
 * *************************************************************************
 * *                        Self Serve Help Desk                          **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  selfservehd                                               **
 * @name        Self Serve Help Desk                                      **
 * @copyright   Glendon ITS - York University                             **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
require_once('config.php');

/**
 * Display the content of the page
 * @global stdobject $CFG
 * @global moodle_database $DB
 * @global core_renderer $OUTPUT
 * @global moodle_page $PAGE
 * @global stdobject $SESSION
 * @global stdobject $USER
 */
function display_page() {
    // CHECK And PREPARE DATA
    global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

    $id = optional_param('id', 0, PARAM_INT); //List id

    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    $pagetitle = get_string('pluginname', 'local_selfservehd');
    $pageheading = get_string('pluginname', 'local_selfservehd');

    echo \local_selfservehd\Base::page($CFG->wwwroot . '/local/selfservehd/test.php',
            $pagetitle, $pageheading, $context);




    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    $PI = new \local_selfservehd\RaspberryPi(2);
    $connection = ssh2_connect($PI->getIp());
    ssh2_auth_password($connection, 'pi', 'glendonglendon');
    ssh2_exec($connection, 'sudo -S reboot < /home/pi/Documents/pwd');
//    $shell = ssh2_shell($connection, 'xterm');
//    fwrite($shell, 'cd /homw/pi/Documents' . PHP_EOL);
//    fwrite($shell, './reboot.sh' . PHP_EOL);
//    fwrite($shell, 'glendonglendon' . PHP_EOL);

    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>
