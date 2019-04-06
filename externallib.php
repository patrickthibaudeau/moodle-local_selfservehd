<?php

require_once($CFG->libdir . "/externallib.php");

class local_selfservehd_external extends external_api {

    public static function get_raspberry_pi_details() {
        $fields = array(
            'mac' => new external_value(PARAM_TEXT,
                    'MAC address of raspberry pi'),
            'ip' => new external_value(PARAM_TEXT,
                    'IP address of raspberry pi'),
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
        }

        $return = [];
        $return[]['mac'] = $mac;
        $return[]['ip'] = $ip;
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
        global $USER, $DB;
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
        } else {
            $newCall = 0;
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
            $data['id'] = $inProgress->id;
            $data['timeclosed'] = time();
            $data['status'] = true;
            $DB->update_record('local_sshd_call_log', $data);
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

}
