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
global $CFG, $USER, $DB, $PAGE, $OUTPUT;
require_once('../config.php');

$PAGE->set_context(CONTEXT_SYSTEM::instance());
$PAGE->set_url("$CFG->wwwroot/local/selfservehd/ajax/agent.php");

$action = required_param('action', PARAM_TEXT);

switch ($action) {
    case 'changeDate' :
        $dateRange = required_param('daterange', PARAM_TEXT);
        $dateRangeArray = explode(' - ', required_param('daterange', PARAM_TEXT));
        $from = strtotime($dateRangeArray[0] . ' 00:00:00');
        $to = strtotime($dateRangeArray[1] . ' 23:59:59');
        
        redirect($CFG->wwwroot . '/local/selfservehd/reports/statistics.php?daterange=' . $dateRange);
       
//        $output = $PAGE->get_renderer('local_selfservehd');
//        $faq_alerts = new \local_selfservehd\output\faq_alerts();
//        echo $output->render_faq_alerts($faq_alerts);
        break;

                
}


