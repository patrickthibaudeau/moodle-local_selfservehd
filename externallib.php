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
    public static function get_raspberry_pi($mac,$ip) {
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

}
