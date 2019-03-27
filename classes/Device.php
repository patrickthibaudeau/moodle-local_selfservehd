<?php
namespace local_selfservehd;

abstract class Device {
    
    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert(){
        global $DB;        
    }
    
    /**
     * 
     * @global \moodle_database $DB
     */
    public function update(){
        global $DB;        
    }
    
    /**
     * 
     * @global \moodle_database $DB
     */
    public function delete(){
        global $DB;        
    }
    
}

