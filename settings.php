<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_selfservehd', get_string('pluginname', 'local_selfservehd'));

    $ADMIN->add('localplugins', $settings);
    $settings->add(new admin_setting_heading('raspberrypi_heading', get_string('raspberry_pi_settings', 'local_selfservehd'), ''));
    //Pi User name
    $name = 'selfservehd_pi_username';
    $text = get_string('username', 'local_selfservehd');
    $help = get_string('username_help', 'local_selfservehd');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, 'pi', PARAM_TEXT));

//Pi password
    $name = 'selfservehd_pi_password';
    $text = get_string('password', 'local_selfservehd');
    $help = get_string('password_help', 'local_selfservehd');
    $params = '';
    $settings->add(new admin_setting_configpasswordunmask($name, $text, $help, '', PARAM_TEXT));

//Token
    $name = 'selfservehd_pi_token';
    $text = get_string('token', 'local_selfservehd');
    $help = get_string('token_help', 'local_selfservehd');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT));

//Heading
    $name = get_string('ticketing_system', 'local_selfservehd');
    $settings->add(new admin_setting_heading('selfservehd_ticketing', $name, ''));

//Agent iframe site
    $name = 'selfservehd_agent_site';
    $text = get_string('site_url', 'local_selfservehd');
    $help = get_string('site_url_help', 'local_selfservehd');
    $params = '';
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT));
    
//Agent iframe site
    $name = 'selfservehd_email_send';
    $text = get_string('ticket_system_email', 'local_selfservehd');
    $help = get_string('ticket_system_email_help', 'local_selfservehd');
    $params = '';    
    $settings->add(new admin_setting_configtext($name, $text, $help, '', PARAM_TEXT)); 
    
//Heading
    $name = get_string('service_hours', 'local_selfservehd');
    $settings->add(new admin_setting_heading('selfservehd_service_hours', $name, ''));

//Agent Service hours
    $name = 'selfservehd_service_hours';
    $text = get_string('service_hours', 'local_selfservehd');
    $help = get_string('service_hours_help', 'local_selfservehd');
    $params = '';
    $settings->add(new admin_setting_configtextarea($name, $text, $help, '', PARAM_RAW));  
}