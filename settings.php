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
 * @copyright  2016-2017 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // Heading.
    $settings = new admin_settingpage('local_contact', get_string('pluginname', 'local_contact'));
    $ADMIN->add('localplugins', $settings);

    // List of tags and recipient email addresses.
    $default = '';
    $name = 'local_contact/recipient_list';
    $title = get_string('recipient_list', 'local_contact');
    $description = get_string('recipient_list_description', 'local_contact');
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);
}

