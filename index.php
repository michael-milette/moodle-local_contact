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

require_once('../../config.php');
require_once($CFG->dirroot . '/local/contact/classes/local_contact.php');

if (empty(get_local_referer(false))) {
    $PAGE->set_url('/local/contact/index.php');
} else {
    $PAGE->set_url(get_local_referer(false));
}

// If we require user to be logged in.
if (!empty(get_config('local_contact', 'loginrequired'))) {
    // Log them in and then redirect them back to the form.
    if (!isloggedin() || isguestuser()) {
        // Set message that session has timed out.
        $SESSION->has_timed_out = 1;
        require_login();
    }
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_heading(format_text($SITE->fullname, FORMAT_HTML, ['context' => $context, 'escape' => false]));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('confirmationpage', 'local_contact'));
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

// Determine the recipient's name and email address.

// The default recipient is the Moodle site's support contact. This will
// be used if no recipient was specified or if the recipient is unknown.
$name = trim($CFG->supportname ?? '');
$email = trim($CFG->supportemail ?? '');

// Handle recipient alias.
// If the form includes a recipient's alias, search the plugin's recipient list settings for a name and email address.
$recipient = trim(optional_param('recipient', '', PARAM_TEXT));
if (!empty($recipient)) {
    $lines = explode("\n", get_config('local_contact', 'recipient_list'));
    foreach ($lines as $linenumbe => $line) {
        $line = trim($line ?? '');
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
        if (file_exists($CFG->libdir . '/recaptchalib_v2.php')) {
            // For reCAPTCHA 2.0.
            require_once($CFG->libdir . '/recaptchalib_v2.php');
            $response = recaptcha_check_response(RECAPTCHA_VERIFY_URL, $CFG->recaptchaprivatekey,
                   getremoteaddr(), optional_param('g-recaptcha-response', '', PARAM_TEXT));
            $resp = new stdClass();
            $resp->is_valid = $response['isvalid'];
            if (!$resp->is_valid) {
                $resp->error = $response['error'];
            }
        } else {
            // For reCAPTCHA 1.0.
            $resp = recaptcha_check_answer($CFG->recaptchaprivatekey, $_SERVER["REMOTE_ADDR"],
                    optional_param('recaptcha_challenge_field', '', PARAM_TEXT),
                    optional_param('recaptcha_response_field', '', PARAM_TEXT));
        }

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

// Continue button takes the user back to the original page that he/she started from before going to the form.
// If the referrer URL was not provided in the submitted form fields or is not from this site, go to the front page.
$continueurl = optional_param('referrer', '', PARAM_URL);
if (stripos($continueurl, $CFG->wwwroot) !== 0) {
    $continueurl = $CFG->wwwroot;
}
echo $OUTPUT->continue_button($continueurl);

// Display page footer.
echo $OUTPUT->footer();
