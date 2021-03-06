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
    
    /**
     *
     * @var int
     */
    private $from;
    
    /**
     *
     * @var int 
     */
    private $to;

    public function __construct($from = null, $to = null) {
        $this->from = $from;
        $this->to = $to;
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

        $responseTimes = \local_selfservehd\Statistics::getDifferenceTimeCreatedTimeReplied($this->from, $this->to); 
               
        $data = [
            'wwwroot' => $CFG->wwwroot,
            'callsToRoom' => $this->callsToRoom(),
            'agents' => $this->agents(),
            'averageResponse' => $this->convertToReadableTime($responseTimes['avg']),
            'longestResponse' => $this->convertToReadableTime($responseTimes['longest']),
            'shortestResponse' => $this->convertToReadableTime($responseTimes['shortest']),
            'totalCalls' => $responseTimes['numberOfCalls'],
            'startDate' => $this->convertToDate($this->from),
            'endDate' => $this->convertToDate($this->to),
        ];

        return $data;
    }

    private function callsToRoom() {
        global $OUTPUT;
        $stats = \local_selfservehd\Statistics::getDeviceCalls($this->from, $this->to);
        $chart = new \core\chart_bar();
        $chart->set_horizontal(true);
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }
    
    private function agents() {
        global $OUTPUT;
        $stats = \local_selfservehd\Statistics::getAgents($this->from, $this->to);
        $chart = new \core\chart_pie();
        $chart->add_series($stats['data']);
        $chart->set_labels($stats['labels']);
        
        return $OUTPUT->render($chart);
    }

    private function convertToReadableTime($valueInSeconds) {
        return gmdate('H:i:s', $valueInSeconds);
    }
    
    private function convertToDate($valueInSeconds) {
        return date('m/d/Y', $valueInSeconds);
    }
}
