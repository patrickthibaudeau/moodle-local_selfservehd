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

require_once(dirname(__FILE__) . '../../../config.php');
//require_once('locallib.php');

require_once($CFG->dirroot . '/local/selfservehd/classes/Base.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/Device.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/Devices.php');
