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
       
        $node = $navigation->find('local_selfservehd', navigation_node::TYPE_CUSTOM);
        if (!$node) {
            $node = $navigation->add(get_string('pluginname', 'local_selfservehd'), new moodle_url('/local/selfservehd/index.php'), navigation_node::TYPE_CUSTOM, get_string('pluginname', 'local_selfservehd'), 'local_selfservehd');
            $node->showinflatnavigation = true;
        }
    }
}
