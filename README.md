Local Contact Form plugin for Moodle
====================================

Copyright
---------
Copyright © 2016-2017 TNG Consulting Inc. - http://www.tngconsulting.ca/

This file is part of the Contact Form plugin for Moodle - http://moodle.org/

Contact Form is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Contact Form is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Contact Form.  If not, see <http://www.gnu.org/licenses/>.

Authors
-------
Michael Milette - Lead Developer

Description
-----------
The Contact Form plugin for Moodle processes information submitted through a web form, sending it by email.

Examples uses for this plugin include:

* Contact us form.
* Support request form.
* Request a course form.
* Information request form.
* Lead generation form.
* Membership application form.

Requirements
------------
This plugin requires Moodle 3.0+ from http://moodle.org .

It may work with previous versions of Moodle all the way back to Moodle 2.7 but it has not been tested yet. If it works for you, let us know. Tip: You might need to modify the version.php in order for Moodle to let you install it on earlier versions.

Changes
-------
The first public BETA version was released on 2016-12-05.

For more information on releases since then, see CHANGELOG.md.

Download Contact for Moodle
------------------------------

The most recent STABLE release of eMail Test for Moodle is available from:
https://moodle.org/plugins/local_contact

The most development release can be found at:
https://github.com/michael-milette/moodle-local_contact

Installation and Update
-----------------------
Install the plugin, like any other plugin, to the following folder:

    /local/contact

See http://docs.moodle.org/33/en/Installing_plugins for details on installing Moodle plugins.

There are no special considerations required for updating the plugin.

Uninstallation
--------------
Uninstalling the plugin by going into the following:

Home > Administration > Site Administration > Plugins > Manage plugins > Contact Form

...and click Uninstall. You may also need to manually delete the following folder:

    /local/contact

Usage & Settings
----------------
There are no configurable settings for this plugin at this time. However:

* Ensure email settings are properly configured in Moodle.
* You should configure the support name and email address in Moodle.
* You can edit the language files to modify the messages sent to the user.

The message can include the following tags which will be substituted at the time the message is sent:

* **[fromemail]**      : User's email address as entered in the web form or the users registered email address if logged in.
* **[fromname]**       : User's name as entered in the web form or the users registered first and last name if logged in.
* **[http_referer]**   : URL of the web form page that the email was generated from.
* **[http_user_agent]**: Web browser.
* **[lang]**           : Language that the user was viewing the website in at the time they submitted the form.
* **[sitefullname]**   : Site's fullname.
* **[siteshortname]**  : Site's short name.
* **[siteurl]**        : URL of the website.
* **[supportemail]**   : Site's support email address.
* **[supportname]**    : Site's support name.
* **[userip]**         : Best attempt to determine the user's IP address. Will be the firewall address if they are behind one.
* **[userstatus]**     : Displays the user's current status if they are known to the Moodle site, either because they are logged in or by their email address.

To make a web form, start by creating a Moodle page or block containing a web form similar to the following:

    <form action="../../local/contact/index.php" method="post" class="contact-us">
        <fieldset>
            <label for="name" id="namelabel">Your name <strong class="required">(required)</strong></label><br>
            <input id="name" name="name" type="text" size="57" maxlength="45" pattern="[A-zÀ-ž]([A-zÀ-ž\s]){2,}"
                    title="Minimum 3 letters/spaces." required="required" value=""><br>
            <label for="email" id="emaillabel">Email address <strong class="required">(required)</strong></label><br>
            <input id="email" name="email" type="email" size="57" maxlength="60" required="required" value=""><br>
            <label for="subject" id="subjectlabel">Subject <strong class="required">(required)</strong></label><br>
            <input id="subject" name="subject" type="text" size="57" maxlength="80" minlength="5"
                    title="Minimum 5 characters." required="required"><br>
            <label for="message" id="messagelabel">Message <strong class="required">(required)</strong></label><br>
            <textarea id="message" name="message" rows="5" cols="58" minlength="5"
                    title="Minimum 5 characters." required="required"></textarea><br>
            <input type="hidden" id="sesskey" name="sesskey" value="">
            <script>document.getElementById('sesskey').value = M.cfg.sesskey;</script>
        </fieldset>
        <div>
            <input type="submit" name="submit" id="submit" value="Send">
        </div>
    </form>

More examples of web forms for Contact Form for Moodle are available in the Wiki:

https://github.com/michael-milette/moodle-local_contact/wiki/HTML-Form-Templates

Almost any type of HTML field included with the form should automatically appear in the email.
Example: text, password, textarea, radio, checkbox, select dropdown, hidden and more.
See the section on Limitations below.

**REQUIRED FIELDS:** The following input fields are required in order to avoid the built-in anti-spam protection. If these input fields are not present in the form, it will not work:

1. **name** - You can change the name of this field by editing the **field-name** string in the Moodle language editor. If user is logged in, this field will be ignored and the users full name as registered in Moodle will be used instead.
   Exception: This form fields not required and will be ignored if it exist but only if the user is currently logged-in to Moodle. User profile info (firstname lastname) will be used instead.
2. **email** - You can change the name of this field by editing the **field-email** string in the Moodle language editor.
   Exception: This form fields not required and will be ignored if it exist but only if the user is currently logged-in to Moodle. User profile info (email address) will be used instead.
3. **sesskey** - Must include both the hidden **sesskey** field as well as the SCRIPT line below it.
4. **submit** - The name of the button.

Your FORM tag must have an action set to **../../local/contact/index.php** and a method set to **post**.

**A Few Tips**

Although not required, the following fields have special meaning to Contact Form:

* **subject** : If you want the subject of the email to contain content from the submitted web form, your form must include a field called **subject**. You can change the name of this field by editing the **field-subject** string in the Moodle language editor.
* **message** : If you want a textarea field, like a Message field, to be formatted properly when inserted in the email, the field must be called **message**. You can change the name of this field by editing the **field-message** string in the Moodle language editor.

Optional: You can add the referring URL, the page that the user was on before going to the form, by adding the following to your form:

    <input type="hidden" id="referrer" name="referrer" value="">
    <script>document.getElementById('referrer').value = document.referrer;</script>

If you are not familiar with how to create basic HTML web forms, take a look at this tutorial:

http://www.w3schools.com/html/html_forms.asp

If you want to insert spaces in your field names, use underscores "_" in your form field id and name. Contact Form for Moodle will replace these with a space before inserting the field name into the email message.

Field id/name tokens must begin with a letter. They may optionally also contain any combination of letters (a-z), numbers (0-9), underscores, dashes, periods and colons (_-.:). They are not case sensitive.

Security considerations
-----------------------
There are no known security considerations at this time.

Motivation for this plugin
--------------------------
The initial development for this project was sponsored by the kind folk at l'Action ontarienne contre la violence aux femmes together with TNG Consulting Inc.

Limitations
-----------
This is not a form builder.

This plugin has yet to been tested with PHP 7.0 or later.

The plugin doesn't currently properly support more than one textarea type fields. Additional textareas will still work however they won't be as pretty.

Any HTML entered will be escaped. You cannot use any kind of HTML formatting or markup/markdown other than pressing ENTER at the end of a paragraph.

You cannot configure the Contact Form email processor on a per form basis. All contact forms on your site will share:

* The message that is displayed to the user after the message has been sent.
* The footer of the email containing additional user information.
* Enabling/disabling of the autoresponder.
* The autoresponder message (if enabled).

Web forms are limited to 1024 fields including hidden fields and the submit button. Total size of the submission may not exceed 256 KB.

There is no support file attachments type fields or form-data encoded as "multipart/form-data".

Future Releases
---------------
Here are some of the features we are considering for future releases:

* Add ability to specify recipient email address (selectable from dropdown list in the form).
* Option to enable the auto-responder / confirmation message.
* Auto-responder will be editable in the plugin's settings.
* Add additional examples of web forms to the documentation (see Wiki).
* Create a basic form builder.
* Make all submitted web form fields available as markup tags that you can insert into your message template.
* Add a "Continue" button on the confirmation screen.
* Add some Moodle logging of sent messages.
* Add a Whitelist and Blacklist for email addresses.
* Add a Whitelist and Blacklist for email domains.
* Add support for form-specific custom autoresponders.
* Add support for form-specific custom confirmation message.
* Add support to optionally only use autoresponder feature without also sending the main email message.

If you could use any of these features, or have other needs, consider hiring us to accelerate development.

Further information
-------------------
For further information regarding the local_contact plugin, support or to
report a bug, please visit the project page at:

http://github.com/michael-milette/moodle-local_contact

Language Support
----------------
This plugin includes support for the English language. Additional languages including French are supported if you've installed one or more additional Moodle language packs.

If you need a language that is not yet supported, please contribute translations using the Moodle AMOS Translation Toolkit for Moodle at
https://lang.moodle.org/

This plugin has not been tested for right-to-left (RTL) language support.
If you want to use this plugin with a RTL language and it doesn't work as-is,
feel free to prepare a pull request and submit it to the project page at:

http://github.com/michael-milette/moodle-local_contact

Frequently Asked Questions (FAQ)
--------------------------------
Here are a few answers to questions folks often come up with at this point.

**Question: How do I make this form available to everyone, even if they are not logged in?**

Answer: Add a page or block to your Moodle Frontpage. Edit the content and paste in your HTML form source code. Make sure that the WYSIWYG editor is in HTML more.

Since you don't need to be logged into your Moodle Frontpage to see it, your form will also be accessible to visitors to your site who are logged-out, logged-in as a guest as well as to regular logged-in users. If this option is not available to you, the process is a little more complicated as it involves making a course available to guests and having Moodle automatically logged them in as guests.

**Question: All I see is the word "Forbidden" after submitting a form. What should I do?**

Answer: Although this plugin is still in BETA, has been tested pretty extensively. If you are getting this error, it is likely that your will need to fix your form and/or enable Moodle debugging. Alternatively you can try the form logged in as a Moodle administrator. This will enable the display of additional diagnostic information.

**Question: Where do emails go when they are submitted on my Moodle website?**

Answer: Logged in as a Moodle administrator, you can find out by going to:

Administration > Site Administration > Server > Support Contact

Emails are sent to the Support Email address. If the field is empty, take note
of the indicated default email address.

**Question: Why are emails submitted on my Moodle website not being delivered?**

Answer: Make sure Moodle email is working. We recommend test your Moodle email system using the eMailTest plugin:

  https://moodle.org/plugins/local_mailtest

**Question: My site successfully completed the eMailTest process. Why is it still not working?**

Answer: If you still can't get your web form to work, the problem might be your form. Try using HTML sample form included above. Then customize it to meet your needs.

**Question: I am still getting a lot of spam emails through my web form. Can I block certain IP addresses?**

Answer: There are a couple of ways you can blacklist an IP address. The best way is to add them to your web server settings. Consult your web server documentation for more information. If you don't have access to those settings, Moodle Administrators can add the IP addresses to the Moodle IP Blocker settings. For more information, see:

https://docs.moodle.org/33/en/IP_blocker

**Question: Why does the User's IP address ([userip]) says "::1" instead showing a real IP address when I receive an email submitted from the form?**

Answer: ::1 is the equivalent of 127.0.0.1 (localhost). This should only happen if your web browser is on the same computer as the web server.

**Question: Can I include my favourite captcha in a form?**

Answer: White we haven't tried every captcha out there, we don't see any reason why it would not work. This plugin has nothing to do with the actual form. If your form works, it should work with this plugin.

**Question: Can I add a check box that must be checked, like for accepting the privacy policy, before the user can submit the form?**

Answer: Absolutely. Information on how to do this will be coming in the future. (Hint: It requires a JavaScript code snippet)

**Question: I have a multilingual Moodle site. Why does the form works in one language but not in the other?**

Answer: Each language file defines the names of the fields for your form. To make a form work for all languages, change the name of this fields for each language by editing the "field-" strings in the Moodle language editor so that they are all the same ones you used in your form).

**Question: How can I change the names of the fields that appear in the email?**

Answer: In your form, change the value of "label for=" to the word you want. On the next line, change the id= and the name= to be the same as the one for the "label for=". Finally, if the field was "name", "email", "subject" or "message", you will also need to edit the related "field-*" string in the Moodle language editor.

**Question: What types of web forms are not recommended for Contact Form?**

Answer: This plugin is not suitable for any form whose data should not end up in an email inbox. For example, Moodle natively supports several excellent types of forms processors such as Feedback, Survey and Database. Unless your e-commerce solution involves low volume semi-manual process, this could be better handled by applications designed with this in mind. Signing up for mailing list subscriptions should be done through a service such as Aweber, Constant Contact, MailChimp and other similar services.

Note: The mention of any 3rd party product is not meant as an endorsement or recommendation. They are simply provided as examples.

**Question: How can I make the form only available to logged-in users?**

Answer: To only display your form for logged-in users, ensure that it is on a Moodle page that is only viewable by logged-in users. User access to pages and blocks is controlled by Moodle, not by this plugin. With that in mind, if you don't include a name and email address field in your form, only registered users who are logged-in to the Moodle site will be able to submit the form.

**Question: Why is the name and/or email address I entered in a form getting changed when submitted?**

Answer: This only happens if a user is logged in. In this case, their registered first and last name and email address will be used instead of the name and email address entered in a form.

**Other questions**

Got a burning question that is not covered here? Submit your question in the Moodle forums (coming soon) or open a new issue on Github at:

http://github.com/michael-milette/moodle-local_contact
