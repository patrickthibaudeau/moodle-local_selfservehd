<?php

require_once('config.php');
require_once($CFG->libdir . "/externallib.php");

/**
 * Classes used for sending SMS
 */
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
/**
 * Classes used for sending SMS
 */

class local_selfservehd_external extends external_api {

    public static function get_raspberry_pi_details() {
        $fields = array(
            'id' => new external_value(PARAM_TEXT,
                    'Id of record'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_raspberry_pi_parameters() {
        return new external_function_parameters(
                array(
            'mac' => new external_value(PARAM_TEXT,
                    'The MAC address from the Raspberry PI'),
            'ip' => new external_value(PARAM_TEXT,
                    'The IP address from the Raspberry PI'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function get_raspberry_pi($mac, $ip) {
        global $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::get_raspberry_pi_parameters(),
                        array('mac' => $mac, 'ip' => $ip)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        //Search if exists
        if (!$macExist = $DB->get_record('local_sshd_rpi', ['mac' => $mac])) {
            $data = [];
            $data['mac'] = $mac;
            $data['ip'] = $ip;
            $data['lastping'] = time();
            $data['timecreated'] = time();
            $data['timemodified'] = time();
            $newMac = $DB->insert_record('local_sshd_rpi', $data);
        } else {
            $data = [];
            $data['id'] = $macExist->id;
            $data['ip'] = $ip;
            $data['lastping'] = time();
            $DB->update_record('local_sshd_rpi', $data);
            $newMac = $macExist->id;
        }

        $return = [];
        $return[]['id'] = $newMac;
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_raspberry_pi_returns() {
        return new external_multiple_structure(self::get_raspberry_pi_details());
    }

    /**
     * Get help call
     */
    public static function get_help_call_details() {
        $fields = array(
            'id' => new external_value(PARAM_TEXT,
                    'id of newly created record'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_help_call_parameters() {
        return new external_function_parameters(
                array(
            'ip' => new external_value(PARAM_TEXT,
                    'The IP address from the Raspberry PI'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function get_help_call($ip) {
        global $CFG, $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::get_help_call_parameters(),
                        array('ip' => $ip)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        $rpi = $DB->get_record('local_sshd_rpi', ['ip' => $ip]);
        //Check to see if a call is already in progress
        if (!$inProgress = $DB->get_record('local_sshd_call_log', ['rpiid' => $rpi->id, 'status' => 0])) {
            $data = [];
            $data['rpiid'] = $rpi->id;
            $data['timecreated'] = time();
            $newCall = $DB->insert_record('local_sshd_call_log', $data);

            $subject = 'Room ' . trim($rpi->building_shortname) . ' ' . trim($rpi->room_number) . ' requires attention (log id: ' . $newCall . ')';
            $message = 'A call from ' . trim($rpi->building_shortname) . ' ' . trim($rpi->room_number)
                    . ' was initiated at ' . date('H:i', $data['timecreated']) . ' on ' . date('F d, Y ', $data['timecreated']);

            //Send email to ticketing system.
            if ($CFG->selfservehd_email_send) {
                //Create user object
                $emailto = new \stdClass();
                $emailto->id = rand(2000000, 999999);
                $emailto->email = $CFG->selfservehd_email_send;
                $emailto->deleted = 0;
                $emailto->auth = 'manual';
                $emailto->mailformat = 1;
                $emailto->firstname = "Classroom";
                $emailto->lastname = "Support";

                email_to_user($emailto, $CFG->noreplyaddress, $subject, $message);
            }

            //Send SMS message
            if (($CFG->selfservehd_sms_apikey == true) && ($CFG->selfservehd_sms_agent_numbers == true)) {
                $message .= "\n\n$CFG->wwwroot/local/selfservehd/agent/index.php";
                $client = new SoapClient('http://www.smsgateway.ca/sendsms.asmx?WSDL');
                $cellNumbers = explode(',', $CFG->selfservehd_sms_agent_numbers);
                if (count($cellNumbers) > 1) {
                    $parameters = new SMSBulkParam();
                    $parameters->AccountKey = trim($CFG->selfservehd_sms_apikey);
                    $parameters->MessageBody = "$message";
                    $parameters->Reference = "$newCall";
                    $parameters->CellNumbers = $cellNumbers;
                    $Result = $client->SendBulkMessage($parameters);
                } else {
                    $parameters = new SMSSingleParam();
                    $parameters->AccountKey = trim($CFG->selfservehd_sms_apikey);
                    $parameters->MessageBody = "$message";
                    $parameters->Reference = "$newCall";
                    $parameters->CellNumber = trim($CFG->selfservehd_sms_agent_numbers);
                    $Result = $client->SendMessage($parameters);
                }
            }
        } else {
            $newCall = $inProgress->id;
        }

        $return = [];
        $return[]['id'] = $newCall;
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_help_call_returns() {
        return new external_multiple_structure(self::get_help_call_details());
    }

    /**
     * Call answered by agent
     */
    public static function call_answered_details() {
        $fields = array(
            'time' => new external_value(PARAM_INT,
                    'Time the agent pressed the answer button'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function call_answered_parameters() {
        return new external_function_parameters(
                array(
            'id' => new external_value(PARAM_INT,
                    'The id of service called'),
            'userid' => new external_value(PARAM_INT,
                    'The id of the user who answered the call'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function call_answered($id, $userid) {
        global $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::call_answered_parameters(),
                        array('id' => $id, 'userid' => $userid)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        $data = [];
        $data['id'] = $id;
        $data['agentid'] = $userid;
        $data['timereplied'] = time();
        $DB->update_record('local_sshd_call_log', $data);


        $return = [];
        $return[]['time'] = $time();
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function call_answered_returns() {
        return new external_multiple_structure(self::call_answered_details());
    }

    /**
     * Update status
     */
    public static function update_status_details() {
        $fields = array(
            'timeclosed' => new external_value(PARAM_TEXT,
                    'id of newly created record'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function update_status_parameters() {
        return new external_function_parameters(
                array(
            'ip' => new external_value(PARAM_TEXT,
                    'The IP address from the Raspberry PI'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function update_status($ip) {
        global $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::update_status_parameters(),
                        array('ip' => $ip)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        $rpi = $DB->get_record('local_sshd_rpi', ['ip' => $ip]);
        if ($inProgress = $DB->get_record('local_sshd_call_log', ['rpiid' => $rpi->id, 'status' => 0])) {
            $data = [];
            if ($inProgress->timereplied) {
                $data['id'] = $inProgress->id;
                $data['timeclosed'] = time();
                $data['status'] = true;
                $DB->update_record('local_sshd_call_log', $data);
            } else {
                $data['timeclosed'] = 0;
            }
        }


        $return = [];
        $return[]['timeclosed'] = $data['timeclosed'];
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function update_status_returns() {
        return new external_multiple_structure(self::update_status_details());
    }

    /**
     * Check status
     */
    public static function check_status_details() {
        $fields = array(
            'agent' => new external_value(PARAM_TEXT,
                    'Name of agent'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function check_status_parameters() {
        return new external_function_parameters(
                array(
            'ip' => new external_value(PARAM_TEXT,
                    'The IP address from the Raspberry PI'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function check_status($ip) {
        global $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::check_status_parameters(),
                        array('ip' => $ip)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        $rpi = $DB->get_record('local_sshd_rpi', ['ip' => $ip]);
        if ($inProgress = $DB->get_record('local_sshd_call_log', ['rpiid' => $rpi->id, 'status' => 0])) {
            if ($inProgress->timereplied) {
                //Get agent name
                $user = $DB->get_record('user', ['id' => $inProgress->agentid]);
                $agent = fullname($user);
            } else {
                $agent = 'false';
            }
        }
        
        $return = [];
        $return[]['agent'] = $agent;
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function check_status_returns() {
        return new external_multiple_structure(self::check_status_details());
    }

    /**
     * Service desk is open
     */
    public static function service_open_details() {
        $fields = array(
            'open' => new external_value(PARAM_TEXT,
                    'Boolean true if hours are open'),
        );
        return new external_single_structure($fields);
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function service_open_parameters() {
        return new external_function_parameters(
                array(
            'ip' => new external_value(PARAM_TEXT,
                    'The IP address from the Raspberry PI'),
                )
        );
    }

    /**
     * Returns welcome message
     * @return string welcome message
     */
    public static function service_open($ip) {
        global $USER, $DB;
        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::service_open_parameters(),
                        array('ip' => $ip)
        );

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_system::instance();
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('local/selfservehd:rpi', $context)) {
            throw new moodle_exception('cannotaccesssystem', 'local_selfservehd');
        }

        $return = [];
        $return[]['open'] = \local_selfservehd\Base::getServiceHours();
        //Look for existing mac in table
        return $return;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function service_open_returns() {
        return new external_multiple_structure(self::service_open_details());
    }

}
