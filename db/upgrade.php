<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

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
defined('MOODLE_INTERNAL') || die();

/**
 * Execute local_selfservehd upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_local_selfservehd_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();
    
    if ($oldversion < 2019032501) {

        // Define field lastping to be added to local_sshd_rpi.
        $table = new xmldb_table('local_sshd_rpi');
        $field = new xmldb_field('lastping', XMLDB_TYPE_INTEGER, '20', null,
                null, null, '0', 'room_name');

        // Conditionally launch add field lastping.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Selfservehd savepoint reached.
        upgrade_plugin_savepoint(true, 2019032501, 'local', 'selfservehd');
    }

    return true;
}
