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

namespace local_selfservehd;

class Base {

    /**
     * Creates the Moodle page header
     * @global \stdClass $CFG
     * @global \moodle_database $DB
     * @global \moodle_page $PAGE
     * @global \stdClass $SITE
     * @param string $url Current page url
     * @param string $pagetitle  Page title
     * @param string $pageheading Page heading (Note hard coded to site fullname)
     * @param array $context The page context (SYSTEM, COURSE, MODULE etc)
     * @param string $pagelayout Default standard available layouts: base, course,incourse,frontpage,admin,embedded.
     * Full list available at https://docs.moodle.org/dev/Page_API#Base_theme_page_layouts
     * @return HTML Contains page information and loads all Javascript and CSS
     */
    public static function page($url, $pagetitle, $pageheading, $context, $pagelayout = 'standard') {
        global $CFG, $PAGE, $SITE;

        $stringman = get_string_manager();
        $strings = $stringman->load_component_strings('local_selfservehd', current_language());

        $PAGE->set_url($url);
        $PAGE->set_title($pagetitle);
        $PAGE->set_heading($pageheading);
        $PAGE->set_pagelayout($pagelayout);
        $PAGE->set_context($context);
        $PAGE->requires->css('/local/selfservehd/js/datatable_1_10_18/DataTables-1.10.18/css/jquery.dataTables.min.css');
        $PAGE->requires->css('/local/selfservehd/js/datatable_1_10_18/Buttons-1.5.2/css/buttons.dataTables.min.css');
        $PAGE->requires->css('/local/selfservehd/js/daterangepicker/daterangepicker.css');
        $PAGE->requires->css('/local/selfservehd/js/select2-4.0.3/dist/css/select2.min.css');
        $PAGE->requires->css('/local/selfservehd/js/editor/dist/summernote-bs4.css');
        $PAGE->requires->css('/local/selfservehd/css/jquery-ui.min.css');
        $PAGE->requires->css('/local/selfservehd/css/dashboard.css');
        $PAGE->requires->strings_for_js(array_keys($strings), 'local_selfservehd');
    }

    /**
     * Sets filemanager options
     * @global \stdClass $CFG
     * @param \stdClass $context
     * @param int $maxfiles
     * @return array
     */
    public static function getFileManagerOptions($context, $maxfiles = 1) {
        global $CFG;
        return array('subdirs' => 0, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => $maxfiles);
    }

    /**
     * This function provides the javascript console.log function to print out php data to the console for debugging.
     * @param string $object
     */
    public static function consoleLog($object) {
        $html = '<script>';
        $html .= 'console.log("' . $object . '")';
        $html .= '</script>';

        echo $html;
    }

    public static function getEditorOptions($context) {
        global $CFG;
        return array('subdirs' => 1, 'maxbytes' => $CFG->maxbytes, 'maxfiles' => -1,
            'changeformat' => 1, 'context' => $context, 'noclean' => 1, 'trusttext' => 0);
    }


    /**
     * Returns a single user record based on
     * 1. user id
     * 2. user name
     * 3. id number
     * $id will always have precedence
     * If an id is provide as well as a username, id will be used.
     * if an id is provided as well as a username and idnumber, id will be used
     * if a username and an id number are provided, username will be used.
     * @global \moodle_database $DB
     * @param int $id
     * @param string $username
     * @param string $idnumber
     */
    public static function getUserRecord($id = 0, $userName = '', $idNumber = '') {
        global $DB;


        if ($id != 0) {
            return $DB->get_record('user', array('id' => $id));
        }

        if ($userName != '') {
            return $DB->get_record('user', array('username' => $userName));
        }

        if ($idNumber != '') {
            return $DB->get_record('user', array('idnumber' => $idNumber));
        }
    }
}
