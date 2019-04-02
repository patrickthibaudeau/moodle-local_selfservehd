<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace local_selfservehd;

/**
 * Description of RaspberryPi
 *
 * @author patrick
 */
class RaspberryPi extends Device{
    
    /**
     *
     * @var int 
     */
    private $id;
    
    /**
     *
     * @var int 
     */
    private $userId;
    
    /**
     *
     * @var string 
     */
    private $mac;
    
    /**
     *
     * @var string 
     */
    private $ip;
      
    /**
     *
     * @var int 
     */
    private $roomId;
      
    /**
     *
     * @var int 
     */
    private $lastPing;
      
    /**
     * Human readable
     * @var string 
     */
    private $lastPingHr;
      
    /**
     *
     * @var int 
     */
    private $timeCreated;
      
    /**
     * Human readable
     * @var string 
     */
    private $timeCreatedHr;
      
    /**
     *
     * @var int 
     */
    private $timeModified;
      
    /**
     * Human readable
     * @var string 
     */
    private $timeModifiedHr;
    
    
    public function __construct() {
        ;
    }
    
    
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
