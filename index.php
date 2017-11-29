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

require_once('../../config.php');
require_once($CFG->dirroot . '/local/contact/class/local_contact.php');
if (false) { // This is only included to avoid code checker warning.
    require_login(); // We don't ever actually want to require users to be logged-in.
}

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

// Are we being spoofed by external scripts? issue #38
// must be logged in and not a guest.
if (!empty(get_config('local_contact', 'loginrequired')) && (!isloggedin() || isguestuser())) {
    echo '<h3>' . get_string('errorsendingtitle', 'local_contact') . '</h3>';
    echo get_string('mustbeloggedin', 'error');
    echo $OUTPUT->continue_button($CFG->wwwroot);
    echo $OUTPUT->footer();
    die;
}

// Determine the recipient's name and email address.

// The default recipient is the Moodle site's support contact. This will
// be used if no recipient was specified or if the recipient is unknown.
$name = trim($CFG->supportname);
$email = trim($CFG->supportemail);

// Handle recipient alias.
// If the form includes a recipient's alias, search the plugin's recipient list settings for a name and email address.
$recipient = trim(optional_param('recipient', null, PARAM_TEXT));
if (!empty($recipient)) {
    $lines = explode("\n", get_config('local_contact', 'recipient_list'));
    foreach ($lines as $linenumbe => $line) {
        $line = trim($line);
        if (empty($line)) { // Blank line.
            continue;
        }
        $thisrecipient = explode('|', $line);
        // 0 = alias, 1 = email address, 2 = name.
        if (count($thisrecipient) == 3) {
            // Trim leading and trailing spaces from each of the 3 parameters.
            $thisrecipient = array_map('trim', $thisrecipient);
            // See if this alias matches the one we are looking for.
            if ($thisrecipient[0] == $recipient && !empty($thisrecipient[1]) && !empty($thisrecipient[2])) {
                $email = $thisrecipient[1];
                $name = $thisrecipient[2];
                break;
            }
        }
    }
}

// Test for ReCAPTCHA.

// ReCAPTCHA is never required for logged-in non-guest users.
if (!isloggedin() || isguestuser()) {
    // Is ReCAPTCHA configured in Moodle?
    if (!empty($CFG->recaptchaprivatekey) &&
            !empty($CFG->recaptchapublickey) &&
            empty(get_config('local_contact', 'norecaptcha'))) {
        // If so, ensure that it was filled correctly and submitted with the form.
        require_once($CFG->libdir . '/recaptchalib.php');
        $resp = recaptcha_check_answer($CFG->recaptchaprivatekey, $_SERVER["REMOTE_ADDR"],
                optional_param('recaptcha_challenge_field', '' , PARAM_TEXT),
                optional_param('recaptcha_response_field', '' , PARAM_TEXT));

        if (!$resp->is_valid) {
            // Display error message if CAPTCHA was entered incorrectly.
            echo '<h3>' . get_string('missingrecaptchachallengefield') . '</h3>';
            echo '<p>' . get_string('recaptcha_help', 'auth') . ($CFG->debugdisplay == 1 ? ' (' .  $resp->error . ')' : '') .'</p>';
            echo '<button type="button" onclick="history.back();">' . get_string('incorrectpleasetryagain', 'auth') . '</a>';
            // Display page footer.
            echo $OUTPUT->footer();
            die;
        }
    }
}

// Send the message.

if ($contact->sendmessage($email, $name)) {
    // Share a gratitude and Say Thank You! Your user will love to know their message was sent.
    echo '<h3>' . get_string('eventmessagesent', 'message') . '</h3>';
    echo get_string('confirmationmessage', 'local_contact');
} else {
    // Oh no! What are the chances. Looks like we failed to meet user expectations (message not sent).
    echo '<h3>'.get_string('errorsendingtitle', 'local_contact').'</h3>';
    echo get_string('errorsending', 'local_contact');
}
echo $OUTPUT->continue_button($CFG->wwwroot);

// Display page footer.
echo $OUTPUT->footer();
