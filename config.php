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
require_once($CFG->dirroot . '/local/selfservehd/classes/Faq.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/Faqs.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/FaqAlert.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/FaqAlerts.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/RaspberryPi.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/RaspberryPis.php');
require_once($CFG->dirroot . '/local/selfservehd/classes/Statistics.php');
