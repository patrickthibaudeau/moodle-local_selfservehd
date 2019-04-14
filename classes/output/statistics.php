<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_selfservehd\output;

/**
 * 
 * @global \stdClass $USER
 * @param \renderer_base $output
 * @return array
 */
class statistics implements \renderable, \templatable {

    public function __construct() {
        
    }

    /**
     * 
     * @global \stdClass $USER
     * @global \moodle_database $DB
     * @param \renderer_base $output
     * @return array
     */
    public function export_for_template(\renderer_base $output) {
        global $CFG, $USER, $DB;

        $data = [
            'wwwroot' => $CFG->wwwroot,
            'callsToRoom' => $this->callsToRoom(),
            'agents' => $this->agents(),
        ];

        return $data;
    }

    private function callsToRoom() {
        global $OUTPUT;
        $stats = \local_selfservehd\Statistics::getDeviceCalls();
        $chart = new \core\chart_pie();
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }
    
    private function agents() {
        global $OUTPUT;
        $stats = \local_selfservehd\Statistics::getAgents();
        $chart = new \core\chart_pie();
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }

}
