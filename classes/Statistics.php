<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_selfservehd;

/**
 * Description of Statistics
 *
 * @author patrick
 */
class Statistics {
    
    /**
     * Returns array of devices and the number of calls returned by the device.
     * @global type $DB
     */
    public static function getDeviceCalls() {
        global $DB;
        
        $deviceSql = 'SELECT DISTINCT(rpiid) as id FROM {local_sshd_call_log}';
        $devices = $DB->get_records_sql($deviceSql);
        
        $dataSets = [];
        $labels = [];
        foreach ($devices as $d) {
            $countSql = 'SELECT COUNT(rpiid) as total FROM {local_sshd_call_log} WHERE rpiid = ?';
            $RPI = new \local_selfservehd\RaspberryPi($d->id);
            $count = $DB->get_record_sql($countSql, [$d->id]);  
            
            $labels[] = $RPI->getBuildingShortName() . ' ' . $RPI->getRoomNumber();
            $dataSets[] = $count->total;

        }
        $data = ['data' => new \core\chart_series('Calls to rooms', $dataSets), 'labels' => $labels];
        
        return $data;
    }
    
    /**
     * Returns array of agents and the number of calls answered.
     * @global type $DB
     */
    public static function getAgents() {
        global $DB;
        
        $agentsSql = 'SELECT DISTINCT(agentid) as id FROM {local_sshd_call_log}';
        $agents = $DB->get_records_sql($agentsSql);
        
        $dataSets = [];
        $labels = [];
        foreach ($agents as $a) {
            $countSql = 'SELECT COUNT(agentid) as total FROM {local_sshd_call_log} WHERE agentid = ?';
            if ($user =$DB->get_record('user', ['id' => $a->id])) {
                $name = fullname($user);
            } else {
                $name = get_string('unanswered', 'local_selfservehd'); 
            }
            $count = $DB->get_record_sql($countSql, [$a->id]);  
            
            $labels[] = $name;
            $dataSets[] = $count->total;

        }
        $data = ['data' => new \core\chart_series(get_string('number_of_calls_answered', 'local_selfservehd'), $dataSets), 'labels' => $labels];
        
        return $data;
    }
}
