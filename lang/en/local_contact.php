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

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Contact Form';
$string['privacy:metadata'] = 'The Contact Form plugin does not store any personal data about any user.';
$string['globalhelp'] = 'Contact Form is a plugin for Moodle that allows your site to process information submitted through HTML web forms to the site\'s support email address.';
$string['configure'] = 'Configure this plugin';
$string['confirmationpage'] = 'Status';

$string['field-name'] = 'name';
$string['field-email'] = 'email';
$string['field-subject'] = 'subject';
$string['field-message'] = 'message';

$string['noreplyto'] = 'No reply-to';
$string['noreplyto_description'] = 'Some SMTP servers reject emails if the from and noreply-to fields in the heading are different. Enable this option to ensure that the no-reply field matches the from address instead of the sender\'s email address.';

$string['confirmationmessage'] = 'Thank you for contacting us. If required, we will be in touch with you very soon.';
$string['confirmationsent'] = 'An email has been sent to your address at {$a}.';
$string['forbidden'] = 'Forbidden';
$string['errorsendingtitle'] = 'Failed to send e-mail';
$string['errorsending'] = 'An error occurred while sending the message. Please try again later.';

$string['defaultsubject'] = 'New message';
$string['extrainfo'] = '<hr>
<p><strong>Additional User Information</strong></p>
<ul>
    <li><strong>Site user:</strong> [userstatus]</li>
    <li><strong>Preferred language:</strong> [lang]</li>
    <li><strong>From IP address:</strong> [userip]</li>
    <li><strong>Web browser:</strong> [http_user_agent]</li>
    <li><strong>Web Form:</strong> <a href="[http_referer]">[http_referer]</a></li>
</ul>
';
$string['confirmationemail'] = '
<p>Dear [fromname],</p>
<p>Thank you for contacting us. If required, we will be in touch with you very soon.</p>
<p>Regards,</p>
<p>[supportname]<br>
[sitefullname]<br>
<a href="[siteurl]">[siteurl]</a></p>
';
$string['lockedout'] = 'LOCKED OUT';
$string['notconfirmed'] = 'NOT CONFIRMED';
$string['duplicateemailaddresses'] = 'There are multiple users with the same email address.';

$string['senderaddress'] = 'Custom sender';
$string['senderaddress_description'] = 'Emails will be delivered from this email address. If this field is blank, emails will be delivered from the no-reply email address.';

$string['recipient_list'] = 'List of available recipients';
$string['recipient_list_description'] = 'You can configure a list of potential recipients here, any of which can be used in a Contact Form to specify the email recipient using a hidden text field, or in a select dropdown list to allow users to select the recipient without divulging the recipient\'s actual email address. If the list is empty, emails will be sent to the Moodle email address, either the support email address or the primary Moodle administrator.
Each line must consist of a unique text alias/label, a single email address and a name, each separated by pipe characters. For example:
<pre>
tech support|support@example.com|Joe Fixit
webmaster|admin@example.com|Mr. Moodle
electrical|nikola.tesla@example.com|Nikola
history|charles.darwin@example.com|Mr. Darwin
law|issac.newton@example.com|Isaac Newton
math|galileo.galilei@example.com|Galileo
english|mark.twain@example.com|Mark Twain
physics|albert.einstein@example.com|Albert
science|thomas.edison@example.com|Mr. Edison
philosophy|aristotle@example.com|Aristotle
</pre>';

$string['loginrequired'] = 'Login required';
$string['loginrequired_description'] = 'Only allow logged-in users to submit the Contact forms. Guests are not considered to be logged-in.';

$string['nosubjectsitename'] = 'No site name in email subject field';
$string['nosubjectsitename_description'] = 'Enable to not prefix email subject with [site name]. Does not affect Moodle\'s own <strong>Email subject prefix text</strong> setting.';

$string['recapchainfo'] = 'Using ReCAPTCHA';
$string['recapchainfo_description'] = 'ReCAPTCHA is currently enabled in Moodle. You <strong>must</strong>:<br>
<ul>
  <li>Ensure that the {recaptcha} tag is included in all forms processed by Contact Form for Moodle.</li>
  <li>Ensure that the <a href="https://moodle.org/plugins/filter_filtercodes">FilterCodes plugin</a> is installed and enabled.</li>
</ul>';

$string['norecaptcha'] = 'No ReCAPTCHA';
$string['norecaptcha_description'] = 'Don\'t use ReCAPTCHA with forms procesed by Contact form.';
