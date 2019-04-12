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

    class SMSBulkParam {

        public $AccountKey;
        public $MessageBody;
        public $Reference;
        public $CellNumbers;

    }

    class SMSSingleParam {

        public $AccountKey;
        public $MessageBody;
        public $Reference;
        public $CellNumber;

    }

    $HTMLcontent = '';
    //**********************
    //*** DISPLAY HEADER ***
    //**********************
    echo $OUTPUT->header();
    //**********************
    //*** DISPLAY CONTENT **
    //**********************
    echo trim(($CFG->selfservehd_sms_agent_numbers));

    if (($CFG->selfservehd_sms_apikey == true) && ($CFG->selfservehd_sms_agent_numbers == true)) {
        $client = new SoapClient('http://www.smsgateway.ca/sendsms.asmx?WSDL');
        $cellNumbers = explode(',', $CFG->selfservehd_sms_agent_numbers);
        if (count($cellNumbers) > 1) {
            $parameters = new SMSBulkParam();
            $parameters->AccountKey = trim($CFG->selfservehd_sms_apikey);
            $parameters->MessageBody = "Test message";
            $parameters->Reference = "511";
            $parameters->CellNumbers = $cellNumbers;
            $Result = $client->SendBulkMessage($parameters);
        } else {
            $parameters = new SMSSingleParam();
            $parameters->AccountKey = trim($CFG->selfservehd_sms_apikey);
            $parameters->MessageBody = "Test message";
            $parameters->Reference = "511";
            $parameters->CellNumber = trim($CFG->selfservehd_sms_agent_numbers);
            $Result = $client->SendMessage($parameters);
        }
    }
    //**********************
    //*** DISPLAY FOOTER ***
    //**********************
    echo $OUTPUT->footer();
}

display_page();
?>

