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
class RaspberryPi extends Device {

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
     * @var string 
     */
    private $faqId;

    /**
     *
     * @var string 
     */
    private $buildingName;

    /**
     *
     * @var string 
     */
    private $buildingShortName;

    /**
     *
     * @var string 
     */
    private $roomNumber;

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
    
    /**
     *
     * @var string 
     */
    private $dbTable;
    
    /**
     *
     * @var bool 
     */
    private $isAlive;

    /**
     * 
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \stdClass $USER
     * @param $id int
     */
    public function __construct($id = 0) {
        global $CFG, $DB, $USER;
        
        $this->dbTable = 'local_sshd_rpi';

        if ($id) {
            $results = $DB->get_record($this->dbTable, ['id' => $id]);
        } else {
            $results = new \stdClass();
        }

        $this->id = $id;
        $this->mac = $results->mac ?? '';
        $this->ip = $results->ip ?? '';
        $this->faqId = $results->faqid ?? 0;
        $this->buildingName = $results->building_longname ?? 0;        
        $this->buildingShortName = $results->building_shortname ?? 0;        
        $this->roomNumber = $results->room_number ?? '';
        $this->lastPing = $results->lastping ?? 0;
        if (isset($results->lastping)) {
            $this->lastPingHr = date('F d, Y', $results->lastping);
            
            //Calculate if device is alive
            $difference = time() - $results->lastping;
            if ($difference <= 300) {
                $this->isAlive = true;
            } else {
                $this->isAlive = false;
            }
         } else {
            $this->lastPingHr = '';
            $this->isAlive = false;
        }

        $this->timeCreated = $results->timecreated ?? 0;
        if (isset($results->timecreated)) {
            $this->timeCreatedHr = date('F d, Y', $results->timecreated);
        } else {
            $this->timeCreatedHr = '';
        }

        $this->timeModified = $results->timemodified ?? 0;
        if (isset($results->timemodified)) {
            $this->timeModifiedHr = date('F d, Y', $results->timemodified);
        } else {
            $this->timeModifiedHr = '';
        }
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function insert($data) {
        global $DB;
        
        $data['timecreated'] = time();
        $data['timemodified'] = time();
        
        $DB->insert_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function update($data) {
        global $DB;
  
        $data['timemodified'] = time();
        
        $DB->update_record($this->dbTable, $data);
    }

    /**
     * 
     * @global \moodle_database $DB
     */
    public function delete() {
        global $DB;
        
        $DB->delete_records($this->dbTable,['id' => $this->id] );
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getMac() {
        return $this->mac;
    }

    public function getIp() {
        return $this->ip;
    }
    
    public function getFaqId() {
        return $this->faqId;
    }

    public function getBuildingName() {
        return $this->buildingName;
    }

    public function getBuildingShortName() {
        return $this->buildingShortName;
    }

    public function getRoomNumber() {
        return $this->roomNumber;
    }

    public function getLastPing() {
        return $this->lastPing;
    }

    public function getLastPingHr() {
        return $this->lastPingHr;
    }

    public function getTimeCreated() {
        return $this->timeCreated;
    }

    public function getTimeCreatedHr() {
        return $this->timeCreatedHr;
    }

    public function getTimeModified() {
        return $this->timeModified;
    }

    public function getTimeModifiedHr() {
        return $this->timeModifiedHr;
    }

    public function getIsAlive() {
        return $this->isAlive;
    }



}
