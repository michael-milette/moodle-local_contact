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

defined('MOODLE_INTERNAL') || die();

/**
 * @brief      local_contact class.
 *
 * @details    Handles processing of information submitted from a web form.
 */
class local_contact {

    /**
     * @brief Constructor.
     *
     * @return True if the information receives passes our spambot detection. False if it fails.
     *
     * @details Receives and validates information received through a web form submission.
     */
    public function __construct() {
        global $CFG;

        $this->fromname  = optional_param(get_string('field-name', 'local_contact'), null, PARAM_TEXT);
        $this->fromemail = optional_param(get_string('field-email', 'local_contact'), null, PARAM_EMAIL);
        $this->isspambot = false;
        $this->errmsg = '';

        if ($CFG->branch >= 32) {
            // As of Moodle 3.2, $CFG->emailonlyfromnoreplyaddress has been deprecated.
            $CFG->emailonlyfromnoreplyaddress = !empty($CFG->noreplyaddress);
        }

        // Did someone forget to configure Moodle properly?

        // Validate Moodle's no-reply email address.
        if (!empty($CFG->emailonlyfromnoreplyaddress)) {
            if (!$this->isspambot && !empty($CFG->emailonlyfromnoreplyaddress)
                    && $this->isspambot = !validate_email($CFG->noreplyaddress)) {
                $this->errmsg = 'Moodle no-reply email address is invalid.';
                if ($CFG->branch >= 32) {
                    $this->errmsg .= '  (<a href="../../admin/settings.php?section=outgoingmailconfig">change</a>)';
                } else {
                    $this->errmsg .= '  (<a href="../../admin/settings.php?section=messagesettingemail">change</a>)';
                }
            }
        }

        // Use primary administrators name and email address if support name and email are not defined.
        $primaryadmin = get_admin();
        $CFG->supportemail = empty($CFG->supportemail) ? $primaryadmin->email : $CFG->supportemail;
        $CFG->supportname = empty($CFG->supportname) ? fullname($primaryadmin, true) : $CFG->supportname;

        // Validate Moodle's support email address.
        if (!$this->isspambot && $this->isspambot = !validate_email($CFG->supportemail)) {
            $this->errmsg = 'Moodle support email address is invalid.';
            $this->errmsg .= ' (<a href="../../admin/settings.php?section=supportcontact">change</a>)';
        }

        // START: Spambot detection.

        // Validate submit button.
        if (!$this->isspambot && $this->isspambot = !isset($_POST['submit'])) {
            $this->errmsg = 'Missing submit button.';
        }

        // Validate if "sesskey" field contains the correct value.
        if (!$this->isspambot && $this->isspambot = !optional_param('sesskey', '3.1415', PARAM_RAW) == sesskey()) {
            $this->errmsg = '"sesskey" field is missing or contains an incorrect value.';
        }

        // Validate referrer URL.
        if (!$this->isspambot && $this->isspambot = !isset($_SERVER['HTTP_REFERER'])) {
            $this->errmsg = 'Missing referrer.';
        }
        if (!$this->isspambot && $this->isspambot = (stripos($_SERVER['HTTP_REFERER'], $CFG->wwwroot) != 0)) {
            $this->errmsg = 'Unknown referrer - must come from this site: ' . $CFG->wwwroot;
        }

        // Validate sender's email address.
        if (!$this->isspambot && $this->isspambot = !validate_email($this->fromemail)) {
            $this->errmsg = 'Unknown sender - invalid email address or the form field name is incorrect.';
        }

        // Validate sender's name.
        if (!$this->isspambot && $this->isspambot = empty($this->fromname)) {
            $this->errmsg = 'Missing sender - invalid name or the form field name is incorrect';
        }

        // Validate against email address whitelist and blacklist.
        $skipdomaintest = false;
        // TODO: Create a plugin setting for this list.
        $whitelist = ''; // $config->whitelistemails .
        $whitelist = ',' . $whitelist . ',';
        // TODO: Create a plugin blacklistemails setting.
        $blacklist = ''; // $config->blacklistemails .
        $blacklist = ',' . $blacklist . ',';
        if (!$this->isspambot && stripos($whitelist, ',' . $this->fromemail . ',') != false) {
            $skipdomaintest = true; // Skip the upcoming domain test.
        } else {
            if (!$this->isspambot && $blacklist != ',,'
                    && $this->isspambot = ($blacklist == '*' || stripos($blacklist, ',' . $this->fromemail . ',') == false)) {
                // Nice try. We know who you are.
                $this->errmsg = 'Bad sender - Email address is blacklisted.';
            }
        }

        // Validate against domain whitelist and blacklist... except for the nice people.
        if (!$skipdomaintest && !$this->isspambot) {
            // TODO: Create a plugin whitelistdomains setting.
            $whitelist = ''; // $config->whitelistdomains .
            $whitelist = ',' . $whitelist . ',';
            $domain = substr(strrchr($this->fromemail, '@'), 1);

            if (stripos($whitelist, ',' . $domain . ',') != false) {
                // Ya, you check out. This email domain is gold here!
                $blacklist = '';
            } else {
                 // TODO: Create a plugin blacklistdomains setting.
                $blacklist = 'example.com,example.net,sample.com,test.com,specified.com'; // $config->blacklistdomains .
                $blacklist = ',' . $blacklist . ',';
                if ($blacklist != ',,'
                        && $this->isspambot = ($blacklist == '*' || stripos($blacklist, ',' . $domain . ',') != false)) {
                    // Naughty naughty. We know all about your kind.
                    $this->errmsg = 'Bad sender - Email domain is blacklisted.';
                }
            }
        }

        // TODO: Test IP address against blacklist.

        // END: Spambot detection... Wait, got some photo ID on you? ;-) .
    }

    /**
     * @brief Creates a user info object based on provided parameters.
     *
     * @param  [string] $email Parameter_Description.
     * @param  [string] $name (optional) Plain text real name.
     * @param  [int]    $id   (optional) Moodle user ID.
     * @return [object] Moodle userinfo.
     */
    private function makeemailuser($email, $name = '', $id = -99) {
        $emailuser = new stdClass();
        $emailuser->email = trim(filter_var($email, FILTER_SANITIZE_EMAIL));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailuser->email = '';
        }
        $emailuser->firstname = format_text($name, FORMAT_PLAIN, array('trusted' => false));
        $emailuser->lastname = '';
        $emailuser->maildisplay = true;
        $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML emails.
        $emailuser->id = $id;
        $emailuser->firstnamephonetic = '';
        $emailuser->lastnamephonetic = '';
        $emailuser->middlename = '';
        $emailuser->alternatename = '';
        return $emailuser;
    }

    /*  @brief Send email message and optionally autorespond.
     *
     *  @param  [boolean] $confirm - set to true if you also want a confirmation email to be sent back to user (TODO).
     *  @return [boolean] $status - True if message was successfully sent, false if not.
     */
    public function sendmessage($sendconfirmationemail = false) {
        global $USER, $CFG, $SITE;

        // Create the sender from the submitted name and email address.
        $from = $this->makeemailuser($this->fromemail, $this->fromname);

        // Create the recipient.
        $to = $this->makeemailuser($CFG->supportemail, $CFG->supportname);

        // Create the Subject for message.
        $subject = '[' . $SITE->shortname . '] ' .
                optional_param(get_string('field-subject', 'local_contact'),
                get_string('defaultsubject', 'local_contact'), PARAM_TEXT);

        // Build the body of the email using user-entered information.
        $htmlmessage = '';
        $fieldmessage = get_string('field-message', 'local_contact');
        foreach ($_POST as $key => $value) {
            if (!in_array($key, array('sesskey', 'submit')) && trim($value) != '') {
                // Exclude fields we don't want in the message and empty fields.
                switch ($key) { // Make custom alterations.
                    case $fieldmessage:
                        $value = preg_replace('/\n(\s*\n){2,}/', "\n\n", $value); // Strip out excessive empty lines.
                        $value = format_text($value, FORMAT_PLAIN, array('trusted' => false));
                        $htmlmessage .= '<p><strong>' . ucfirst($key) . ' :</strong></p><p>' . $value . '</p>';
                        break;
                    default:
                        $value = format_text($value, FORMAT_PLAIN, array('trusted' => false));
                        $htmlmessage .= '<strong>'.ucfirst($key) . ' :</strong> ' . $value . '<br>' . PHP_EOL;
                }
            }
        }

        // Prepare arrays to handle substitution of embedded tags in the footer.
        $tags = array('[fromname]', '[fromemail]', '[supportname]', '[supportemail]',
                '[lang]', '[userip]', '[userstatus]',
                '[sitefullname]', '[siteshortname]', '[siteurl]',
                '[http_user_agent]', '[http_referer]'
        );
        $info = array($from->firstname, $from->email, $CFG->supportname, $CFG->supportemail,
                current_language(), $this->getuserip(), $this->moodleuserstatus($from->email),
                $SITE->fullname, $SITE->shortname, $CFG->wwwroot,
                $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_REFERER']
        );

        // Create the footer - Add some system information.
        $htmlmessage .= str_replace($tags, $info, get_string('extrainfo', 'local_contact'));

        // Send email message to recipient.
        $status = email_to_user($to, $from, $subject, html_to_text($htmlmessage), $htmlmessage, '', '', true);

        // If successful and a confirmation email is desired, send it the original sender.
        if ($status && $sendconfirmationemail) {
            // Substitute embedded tags for some information.
            $htmlmessage = str_replace($tags, $info, get_string('confirmationemail', 'local_contact'));
            $htmlmessage = format_text($htmlmessage, FORMAT_HTML, array('trusted' => true, 'noclean' => true, 'para' => false));

            $replyname  = empty($CFG->emailonlyfromnoreplyaddress) ? $CFG->supportname : get_string('noreplyname');
            $replyemail = empty($CFG->emailonlyfromnoreplyaddress) ? $CFG->supportemail : $CFG->noreplyaddress;
            $to = $this->makeemailuser($replyemail, $replyname);

            // Send confirmation email message to the sender.
            email_to_user($from, $to, $subject, html_to_text($htmlmessage), $htmlmessage, '', '', true);
        }
        return $status;
    }

    /**
     * @brief Get the user's public or private IP address.
     *
     * @return [string] IP Address - Public or private if the public address cannot be identified.
     */
    private function getuserip() {
        $fieldlist = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
                'REMOTE_ADDR', 'HTTP_CF_CONNECTING_IP', 'HTTP_X_CLUSTER_CLIENT_IP');

        // Public range first.
        $filterlist = array(
            FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
            FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );

        foreach ($filterlist as $filter) {
            foreach ($fieldlist as $field) {

                if (!array_key_exists($field, $_SERVER) || empty($_SERVER[$field])) {
                    continue;
                }

                $iplist = explode(',', $_SERVER[$field]);
                foreach ($iplist as $ip) {

                    // Strips off port number if it exists.
                    if (substr_count($ip, ':') == 1) {
                        // IPv4 with a port.
                        list($ip) = explode(':', $ip);
                    } else if ($start = (substr($ip, 0, 1) == '[') && $end = strpos($ip, ']:') !== false) {
                        // IPv6 with a port.
                        $ip = substr($ip, $start + 1, $end - 2);
                    }
                    // Sanitize so that we only get public addresses.
                    $lastip = $ip; // But save other address just in case.
                    $ip = filter_var(trim($ip), FILTER_VALIDATE_IP, $filter);
                    if ($ip !== false) {
                        return $ip;
                    }
                }
            }
        }
        // Private or restricted range.
        return $lastip;
    }

    /**
     * @brief Get a one line status report on a Moodle user.
     *
     * @param  [string] $emailaddress Plain text email address.
     * @return [string] Contains what we know about the user.
     *
     * @details Get information about the Moodle user, whether logged in or out,
     *          using their email address of their Moodle info if logged in.
     */
    private function moodleuserstatus($emailaddress) {
        if (isloggedin()) {
            global $USER;
            $info = $USER->firstname . ' ' . $USER->lastname . ' / ' . $USER->email . ' (' . $USER->username .
                    ' / ' . get_string('eventuserloggedin', 'auth') . ')';
        } else {
            global $DB;
            $usercount = $DB->count_records('user', array('email' => $emailaddress));
            switch ($usercount) {
                case 0:  // We don't know this email address.
                    $info = get_string('emailnotfound');
                    break;
                case 1: // We found exactly one match.
                    $user = get_complete_user_data('email', $emailaddress);
                    $extrainfo = '';

                    // Is user locked out?
                    if ($lockedout = get_user_preferences('login_lockout', 0, $user)) {
                        $extrainfo .= ' / ' . get_string('lockedout', 'local_contact');
                    }

                    // Has user responded to confirmation email?
                    if (empty($user->confirmed)) {
                        $extrainfo .= ' / ' . get_string('notconfirmed', 'local_contact');
                    }

                    $info = $user->firstname . ' ' . $user->lastname . ' / ' . $user->email . ' (' . $user->username .
                            ' / ' . get_string('eventuserloggedout') . $extrainfo . ')';
                    break;
                default: // We found multiple users with this email address.
                    $info = get_string('duplicateemailaddresses', 'local_contact');
            }
        }
        return $info;
    }
}
