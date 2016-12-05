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
 * @copyright  2016 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/local/contact/locallib.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/contact/index.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_contact'));
$PAGE->navbar->add('');

$contact = new local_contact();
if ($contact->isspambot) {
    header('HTTP/1.0 403 Forbidden');
    if ($CFG->debugdisplay == 1 || is_siteadmin()) {
        die(get_string('forbidden', 'local_contact') . '. ' . $contact->errmsg);
    } else {
        die(get_string('forbidden', 'local_contact')) . '.';
    }
}

// Display page header.
echo $OUTPUT->header();

if ($contact->sendmessage()) {
    // Share a gratitude and Say Thank You! Your user will love to know their message was sent.
    echo '<h3>' . get_string('messagesent', 'message') . '</h3>';
    echo get_string('confirmationmessage', 'local_contact');
} else {
    // Oh no! What are the chances. Looks like we failed to meet user expectations (message not sent).
    echo '<h3>'.get_string('errorsendingtitle', 'local_contact').'</h3>';
    echo get_string('errorsending', 'local_contact');
}

// Display page footer.
echo $OUTPUT->footer();
