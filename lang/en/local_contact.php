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

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Contact Form';
$string['globalhelp'] = 'Contact Form is a plugin for Moodle that allows your site to process information submitted through HTML web forms to the site\'s support email address.';
$string['configure'] = 'Configure this plugin';

$string['field-name'] = 'name';
$string['field-email'] = 'email';
$string['field-subject'] = 'subject';
$string['field-message'] = 'message';

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
