<?php
namespace local_selfservehd;

abstract class Device {
    
    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert($data){
        global $DB;        
    }
    
    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data){
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

