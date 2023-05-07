<?php
// This file is part of the Contact Form plugin for Moodle - http://moodle.org/
//
// Contact Form is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Contact Form is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Contact Form.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin for Moodle is used to send emails through a web form.
 *
 * @package    local_contact
 * @copyright  2016-2023 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // Heading.
    $settings = new admin_settingpage('local_contact', get_string('pluginname', 'local_contact'));
    $ADMIN->add('localplugins', $settings);

    // Custom sender (from) email address.
    $default = '';
    $name = 'local_contact/senderaddress';
    $title = get_string('senderaddress', 'local_contact');
    $description = get_string('senderaddress_description', 'local_contact');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // List of tags and recipient email addresses.
    $default = '';
    $name = 'local_contact/recipient_list';
    $title = get_string('recipient_list', 'local_contact');
    $description = get_string('recipient_list_description', 'local_contact');
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);

    // Don't use reply-to.
    $default = 0;
    $name = 'local_contact/noreplyto';
    $title = get_string('noreplyto', 'local_contact');
    $description = get_string('noreplyto_description', 'local_contact');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Require the user to be logged-in in order to send the form.
    $default = 0;
    $name = 'local_contact/loginrequired';
    $title = get_string('loginrequired', 'local_contact');
    $description = get_string('loginrequired_description', 'local_contact');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Do not include site name in email subject line.
    $default = 0;
    $name = 'local_contact/nosubjectsitename';
    $title = get_string('nosubjectsitename', 'local_contact');
    $description = get_string('nosubjectsitename_description', 'local_contact');
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    // Override and disable ReCAPTCHA, if the private and public keys are setup in Moodle.
    if (!empty($CFG->recaptchaprivatekey) && !empty($CFG->recaptchapublickey)) {
        // Information on using recaptcha with Contact Form.
        $name = 'local_contact/recapchainfo';
        $title = get_string('recapchainfo', 'local_contact');
        if (empty(get_config('local_contact', 'norecaptcha'))) {
            $description = get_string('recapchainfo_description', 'local_contact');
        } else {
            $description = '';
        }
        $setting = new admin_setting_heading($name, $title, $description);
        $settings->add($setting);

        // Disable Recapcha - if configured.
        $name = 'local_contact/norecaptcha';
        $title = get_string('norecaptcha', 'local_contact');
        $description = get_string('norecaptcha_description', 'local_contact');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $settings->add($setting);
    }
}
