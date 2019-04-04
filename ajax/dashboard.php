<?php

/**
 * *************************************************************************
 * *                        Self Serve Help Desk                          **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  selfservehd                                               **
 * @name        Self Serve Help Desk                                      **
 * @copyright   Glendon ITS - York University                             **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
global $CFG, $USER, $DB, $PAGE, $OUTPUT;
require_once('../config.php');

$PAGE->set_context(CONTEXT_SYSTEM::instance());
$PAGE->set_url("$CFG->wwwroot/local/selfservehd/ajax/dashboard.php");

$action = required_param('action', PARAM_TEXT);

switch ($action) {
    case 'getInfo':
        $id = required_param('id', PARAM_INT);
        $PI = new \local_selfservehd\RaspberryPi($id);
        $data = [];
        $data['building_longname'] = $PI->getBuildingName();
        $data['building_shortgname'] = $PI->getBuildingShortName();
        $data['room_number'] = $PI->getRoomNumber();

        echo json_encode($data);
        break;

    case 'save':
        $id = required_param('id', PARAM_INT);
        $buildingLongName = optional_param('building_longname', '', PARAM_TEXT);
        $buildingShortName = optional_param('building_shortname', '', PARAM_TEXT);
        $roomNumber = optional_param('room_number', '', PARAM_TEXT);

        $data = [];
        $data['id'] = $id;
        $data['userid'] = $USER->id;
        $data['building_longname'] = $buildingLongName;
        $data['building_shortname'] = $buildingShortName;
        $data['room_number'] = $roomNumber;

        $PI = new \local_selfservehd\RaspberryPi($id);
        $PI->update($data);

        $PIS = new \local_selfservehd\RaspberryPis();
        echo $PIS->getHtml();
        break;
    case 'delete' :
        $id = required_param('id', PARAM_INT);
        $PI = new \local_selfservehd\RaspberryPi($id);
        $PI->delete();
        break;
    case 'reboot':
        $id = required_param('id', PARAM_INT);
        $PI = new \local_selfservehd\RaspberryPi($id);
        $connection = ssh2_connect($PI->getIp());
        ssh2_auth_password($connection, 'pi', 'glendonglendon');
//        ssh2_exec($connection, 'reboot');
        ssh2_exec($connection, 'sudo -S reboot < /home/pi/.reboot');
        echo true;
        break;
}

