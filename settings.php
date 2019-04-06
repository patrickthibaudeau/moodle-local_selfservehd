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

}