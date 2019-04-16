<?php

/**
 * Update the navigation block with mprt_plus options
 * @global moodle_database $DB
 * @global stdClass $USER
 * @global stdClass $CFG
 * @global moodle_page $PAGE
 * @param global_navigation $navigation The navigation block
 */
function local_selfservehd_extend_navigation(global_navigation $navigation) {
    global $DB, $USER, $PAGE;

    $context = context_system::instance();
    //Only display if panorama is installed
    if (has_capability('local/selfservehd:admin', $context) || is_siteadmin()) {

        $node = $navigation->find('local_selfservehd',
                navigation_node::TYPE_CUSTOM);
        if (!$node) {
            $node = $navigation->add(get_string('pluginname',
                            'local_selfservehd'),
                    new moodle_url('/local/selfservehd/index.php'),
                    navigation_node::TYPE_CUSTOM,
                    get_string('pluginname', 'local_selfservehd'),
                    'local_selfservehd');
            $node->showinflatnavigation = true;
        }
    }
}

function local_selfservehd_pluginfile($course, $cm, $context, $filearea, $args,
        $forcedownload, array $options = array()) {
    global $DB;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }
//Do not require login as we want the system to access the files wihtout needing
//to login
//    require_login();

    $itemid = (int) array_shift($args);


    $fs = get_file_storage();
    $filename = array_pop($args);

    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }

    $file = $fs->get_file($context->id, 'local_selfservehd', $filearea, $itemid,
            $filepath, $filename);
    if (!$file) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}

function redirect_user($events) {
    global $CFG;
    $context = context_system::instance();
    if ((has_capability('local/selfservehd:agent', $context)) && ($CFG->selfservehd_auto_redirect == true)) {
            redirect($CFG->wwwroot . '/local/selfservehd/agent');
    }
}
