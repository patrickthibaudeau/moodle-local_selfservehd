<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_selfservehd;

/**
 * Description of RaspberryPis
 *
 * @author patrick
 */
class RaspberryPis extends Devices {
    
    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     */
    public function __construct() {
        global $CFG, $DB;
        
    }
    
    public function getHtml() {
        parent::getHtml();
    }
}
