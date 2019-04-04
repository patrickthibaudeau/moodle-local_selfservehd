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

    if ($oldversion < 2019040300) {

        // Define field faqid to be added to local_sshd_rpi.
        $table = new xmldb_table('local_sshd_rpi');
        $field = new xmldb_field('faqid', XMLDB_TYPE_INTEGER, '5', null, null,
                null, '0', 'userid');

        // Conditionally launch add field faqid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table local_sshd_faq to be created.
        $table = new xmldb_table('local_sshd_faq');

        // Adding fields to table local_sshd_faq.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL,
                XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, null, null,
                null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '1333', null, null, null,
                null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, null, null,
                null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '20', null, null,
                null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '20', null, null,
                null, '0');

        // Adding keys to table local_sshd_faq.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for local_sshd_faq.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Selfservehd savepoint reached.
        upgrade_plugin_savepoint(true, 2019040300, 'local', 'selfservehd');
    }


    return true;
}
