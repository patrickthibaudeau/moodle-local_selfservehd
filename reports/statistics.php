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
require_once('../config.php');

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
    $from = null;
    $to = null;
    $dateRange = optional_param('daterange', null, PARAM_TEXT);
    if (strstr($dateRange, ' - ')) {
        $dateRange = explode(' - ', $dateRange);
        $from = strtotime($dateRange[0] . ' 00:00:00');
        $to = strtotime($dateRange[1] . ' 23:59:59');
    }


    require_login(1, false); //Use course 1 because this has nothing to do with an actual course, just like course 1

    $context = context_system::instance();

    $pagetitle = get_string('pluginname', 'local_selfservehd');
    $pageheading = get_string('pluginname', 'local_selfservehd');

    echo \local_selfservehd\Base::page($CFG->wwwroot . '/local/selfservehd/index.php',
            $pagetitle, $pageheading, $context);

    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    $output = $PAGE->get_renderer('local_selfservehd');
    $statistics = new \local_selfservehd\output\statistics($from, $to);
    echo '<div id="statisticsContainer">';
    echo $output->render_statistics($statistics);
    echo '</div>';
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>
