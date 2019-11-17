<img src="pix/logo.png" align="right" />

Local Contact Form plugin for Moodle
====================================
![PHP](https://img.shields.io/badge/PHP-v5.6%20%2F%20v7.0%20%2F%20v7.1%20%2F%207.2-blue.svg)
![Moodle](https://img.shields.io/badge/Moodle-v3.0%20to%20v3.8.x-orange.svg)
[![GitHub Issues](https://img.shields.io/github/issues/michael-milette/moodle-local_contact.svg)](https://github.com/michael-milette/moodle-local_contact/issues)
[![Contributions welcome](https://img.shields.io/badge/contributions-welcome-green.svg)](#contributing)
[![License](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](#license)

# Table of Contents

- [Basic Overview](#basic-overview)
- [Requirements](#requirements)
- [Download Contact for Moodle](#download-contact-for-moodle)
- [Installation](#installation)
- [Usage](#usage)
- [Updating](#updating)
- [Uninstallation](#uninstallation)
- [Limitations](#limitations)
- [Language Support](#language-support)
- [Frequently Asked Questions (FAQ)](#faq)
- [Contributing](#contributing)
- [Motivation for this plugin](#motivation-for-this-plugin)
- [Further information](#further-information)
- [License](#license)

# Basic Overview

The Contact Form plugin for Moodle processes information submitted through a web form, sending it by email.

Examples uses for this plugin include:

* Contact us form;
* Support request form;
* Request a course form;
* Information request form;
* Lead generation form;
* Membership application form.

[(Back to top)](#table-of-contents)

# Requirements

This plugin requires Moodle 3.0+ from https://moodle.org .

It may work with previous versions of Moodle all the way back to Moodle 2.7 but it has not been tested yet. If it works for you, let us know. Tip: You might need to modify the version.php in order for Moodle to let you install it on earlier versions.

[(Back to top)](#table-of-contents)

# Download Contact for Moodle

The most recent STABLE release of Contact Form for Moodle is available from:
https://moodle.org/plugins/local_contact

The most recent DEVELOPMENT release can be found at:
https://github.com/michael-milette/moodle-local_contact

[(Back to top)](#table-of-contents)

# Installation

Install the plugin, like any other plugin, to the following folder:

    /local/contact

See https://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins.

[(Back to top)](#table-of-contents)

# Usage

Before getting started:

* Ensure email settings are properly configured in Moodle.
* Ensure that you have configured the support name and email address in Moodle.

## Creating a new form

### Quick method

The quickest way to get started by far is to use the [FilterCodes](https://moodle.org/plugins/filter_filtercodes/ Moodle plugin. As of version 1.3.0, it includes several plain text tags that you can easily copy and paste into any Atto editor. The {tags} include:

{formquickquestion} : Adds a "quick question" form to your course. Form only includes a Subject and Message field. Note: User must be logged in or the form will not be displayed.

{formcontactus} : Adds a "Contact Us" form to your site (example: in a page). Form includes Name, Email address, Subject and Message fields.

{formcourserequest} : Adds a "Course Request" form to your site (example: in a page). Unlike Moodle's request-a-course feature where you can request to create your own course, this tag allows users to request that a course they are interested in be created. Could also be used to request to take a course. Form includes Name, Email address, Course name, Course Description.

{formsupport} : Adds a "Support Request" form to your site (example: in a page). Form includes Name, Email address, pre-determined Subject, specific Subject, URL and Message fields.

{formcheckin} : Adds a "I'm here!" button to your to your course. Form does not include any other fields. Note: User must be logged in or the button will not be displayed.

### Custom method

This plugin is for administrators with a little knowledge of HTML forms. You can simply copy and paste any of the [examples from the Wiki](https://github.com/michael-milette/moodle-local_contact/wiki/HTML-Form-Templates) to get started.

To create a new web form on your site, start by adding a Moodle page or HTML block. Be sure to switch to the Source Code view button in the Moodle Atto WYSIWYG editor before entering or pasting HTML code similar to the following:

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

That is it. Just save and you are done.

Note: If you are putting the form into a block, you will need to adjust the "../.." part in the action of the form so that it is relative to the webroot of your Moodle website. If you are using the FilterCodes plugin, you can simply use {wwwroot} and it will work anywhere you put the form whether it is in a page or a block.

Example:

    <form action="{wwwroot}/local/contact/index.php" method="post" class="contact-us">
    :       :       :       :       :

To see a full example of the above form, see [Contact Us with FilterCodes example](https://github.com/michael-milette/moodle-local_contact/wiki/HTML-Form-Templates#user-content-contact-us-form-with-filtercodes-for-contact-form-for-moodle).

### Customizing the form

You can customize your form to suit your particular requirements. You will need to be familiar with how to create basic HTML5 web forms. If you are not, take a look at the [HTML5 Forms tutorial](http://www.html5-tutorials.org/forms/introduction/).

Almost any type of HTML field included with the form should automatically appear in the email. Example: text, password, textarea, radio, checkbox, select drop-down, hidden and more. See the section on [Limitations](#limitations).

In the previous example, the form's class "contact-us" is not required but is simply included to help you to apply CSS styling to the form. Feel free to change it to anything you like.

**REQUIRED FIELDS:** The following input fields are required in order to avoid the built-in anti-spam protection. If these input fields are not present in the form, it will not work:

1. **name** - You can create an alias for this field name by editing the **field-name** string in the Moodle language editor. If user is logged in, this field will be ignored and the users full name as registered in Moodle will be used instead. If the user is currently logged in (not guest), this field will be ignored if it exists and user profile info (firstname lastname) will be used instead.
2. **email** - You can create an alias for this field name by editing the **field-email** string in the Moodle language editor. If the user is currently logged in (not guest), this field will be ignored if it exists and user profile info (firstname lastname) will be used instead.
3. **sesskey** - Must include both the hidden **sesskey** field as well as the SCRIPT line below it.
4. **submit** - The name of the button.

Your FORM tag must have an action set to **../../local/contact/index.php** and a method set to **post**.

**OPTIONAL FIELDS:** Although not required, the following fields have special meaning to Contact Form:

* **subject**  : If you want the subject of the email to contain content from the submitted web form, your form must include a field called **subject**. You can create an alias for this field name by editing the **field-subject** string in the Moodle language editor.
* **message**  : If you want a textarea field, like a Message field, to be formatted properly when inserted in the email, the field must be called **message**. You can create an alias for this field name by editing the **field-message** string in the Moodle language editor.
* **recipient**: Add this field if you want to specify a recipient other than the Moodle support email address. This field must contain an alias, not an email address. See the section on Configuring the List of Recipients in this documentation.

You can also add the referring URL, the page that the user was on before going to the form, by adding the following to your form:

    <input type="hidden" id="referrer" name="referrer" value="">
    <script>document.getElementById('referrer').value = document.referrer;</script>

An side benefit to including these two lines is that the **Continue** button, which appears after you submit the form, will take the user back to the form's referrer URL instead the site's front page.

If you would rather have the **Continue** button take the user back to the form itself, simply replace **document.referrer** with **document.location.href**. So the above two lines would become:

    <input type="hidden" id="referrer" name="referrer" value="">
    <script>document.getElementById('referrer').value = document.location.href;</script>

This will result in the form's address being inserted into the email in the referrer field

If you prefer to have the continue button always take the user to a different page, you can specify the URL in the input field. Just be sure that the page is on the Moodle site. The continue button will not allow you to take the user to a different website. Example:

    <input type="hidden" id="referrer" name="referrer" value="https://moodle.example.com/mod/page/view.php?id=21">

Note that, in these two last examples, the referrer field will no longer actually refer to the page from where the user actually came from before the form which can be a little misleading. For a support page, it is recommended to use **document.referrer** with the script tag in order to submit the URL of the page from where they came. This will be helpful when the student submits something like "Lesson 2 of the course didn't work" but offers no clue which course they were in at the time.

Returning the student back to the page they were on before the form was submitted is also helpful if it would be rather complicated to navigate back to where they were before they submitted the form. This is especially important if you are dealing with students who may have accessibility issues.

#### Additional tips

If you want to insert spaces in your field names, use underscores "_" in your form field id and name. Contact Form for Moodle will replace these with a space before inserting the field name into the email message.

Field id/name tokens must begin with a letter. They may optionally also contain any combination of letters (a-z), numbers (0-9), underscores, dashes, periods and colons (_-.:). They are not case sensitive.

## Configuring the email message

To edit the language strings including the email message to be sent to the user, you will need to make the changes using the Moodle language editor. To do this:

1. Login to Moodle as an Administrator
2. Navigate to **Home** > **Site Administration** > **Language** > **Language Customization**.
3. Select the language you wish to modify and then click **Open Language Pack for Editing** button.
4. Select the local_contact.php from the list and click the **Show Strings** button.

For more information on using the language editor, see the [Moodle documentation on Language Customization](https://docs.moodle.org/en/Language_customisation#Using_the_obtained_information_in_order_to_change_the_intended_strings).

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

Note that, in the future, the email message will be configurable from within the plugin's settings.

## Optional Contact Form for Moodle settings

Contact Form for Moodle includes the following settings. These are available on the plugin's `Settings` page by going to:

Site administration > Plugins > Local plugins > Contact Form

### Configuring the List of Recipients

By default, messages sent from the Contact Form for Moodle will be delivered to your Moodle support contact email address. However, you can optionally specify a different recipient on a per form basis. Configuring this requires two additional easy steps:

#### Step 1 - Create the List of Available Recipients

Start by specifying a List of Available Recipients in the plugin's settings.

The format for each recipient is alias|emailaddress|name. You should only enter one recipient per line. Incorrectly entered lines and blank lines will be ignored.

For example:

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

Note that this list is not automatically populated in forms. You will need to do that manually in the next step.

#### Step 2 - Add a field to your form.

Single Recipient - This can be done by specifying the recipient's alias in a "hidden" type input field in your form. For example:

    <input type="hidden" name="recipient" id="recipient" value="webmaster">

One of Many Recipients - You can also create a drop-down (select) list in your form and have the user specify the recipient. For example:

    <select name="recipient" id="recipient" required>
        <option value="">Please select...</option>
        <option value="tech support">Technical support</option>
        <option value="webmaster">Moodle administrator</option>
    </select>

A different form on the same site might have:

    <select name="recipient" id="recipient" required>
        <option value="">Please select...</option>
        <option value="history">History teacher</option>
        <option value="math">Math teacher</option>
        <option value="english">English teacher</option>
        <option value="philosophy">Philosophy teacher</option>
    </select>

Notice that you can include any number of recipients in your form's drop-down list. You need not include all of them. If a specified alias is not in the List of Available Recipients, the email message will default to being delivered to the Moodle site's support email address.

### Select multiple items

If you are using a select form where you allow multiple items to be selected, all of the selected items will be merged together in a commas/space delimited list. Example:

    <select name="cars[]" id="cars">
        <option value="">Please select...</option>
        <option value="TOYOTA">Toyota</option>
        <option value="GM">General Motors</option>
        <option value="VOLKSWAGEN">Volkswagen</option>
        <option value="NISSAN">Nissan</option>
        <option value="HYUNDAI">Hyundai</option>
        <option value="FORD">Ford</option>
        <option value="CHRYSLER">Chrysler</option>
        <option value="HONDA">Honda</option>
        <option value="BMW">BMW</option>
    </select>

Important: Don't forget to end the name of your field with [] or all you will see is the last selected item.

### Configuring reCAPTCHAs

Note: If Moodle's reCAPTCHA is not configured, you will not see this setting.

To use reCAPTCHA in your Contact form, you must:

- Configure Moodle's reCAPTCHA settings. See Site administration > Plugins > Authentication > Manage authentication. These settings are near the bottom of the page.
- Install and enable the [filter_filtercodes](https://moodle.org/plugins/filter_filtercodes) plugin.
- Add the {recaptcha} tag inside your form, usually right before the `Send` button. This will be converted into HTML code when your form is displayed. For more information on inserting a {recaptha} tag, see the [FilterCodes documentation](https://github.com/michael-milette/moodle-filter_filtercodes#usage).

However, even if reCAPTCHA is enabled, you can tell Contact Form for Moodle not to use it. Just go into the settings for Contact Form, check the box for `No reCAPTCHA` and save. In this case, you will not need to include the {recaptcha} tag in the form. Example:

    <form action="../../local/contact/index.php" method="post" class="template-form">
        <fieldset>
            <label for="name" id="namelabel">Your name <strong class="required">(required)</strong></label><br>
            <input id="name" name="name" type="text" pattern="[A-zÀ-ž]([A-zÀ-ž\s]){2,}" title="Minimum 3 letters/spaces." required="required" value="" style="width:100%;"><br>
            <label for="email" id="emaillabel">Email address <strong class="required">(required)</strong></label><br>
            <input id="email" name="email" type="email" required="required" value="" style="width:100%;"><br>
            <input type="hidden" id="sesskey" name="sesskey" value="">
            <script>document.getElementById('sesskey').value = M.cfg.sesskey;</script>
            **{recaptcha}**
        </fieldset>
        <div>
            <input type="submit" name="submit" id="submit" value="Send">
        </div>
    </form>

### Require login

The `Require login` setting requires that users be logged-in in order to be able to submit the form. If a form is submitted and the user is not logged-in they will be redirected to the login page. If you require users to be logged-in, it is also highly recommended that you also place your form on a page which is only accessible to logged-in users. Guest users are not considered to be logged-in.

[(Back to top)](#table-of-contents)

# Updating

There are no special considerations required for updating the plugin.

The first public BETA version was released on 2016-12-05. For more information on releases since then, see
[CHANGELOG.md](https://github.com/michael-milette/moodle-local_contact/blob/master/CHANGELOG.md).

[(Back to top)](#table-of-contents)

# Uninstallation

Uninstalling the plugin by going into the following:

Home > Administration > Site Administration > Plugins > Manage plugins > Contact Form

...and click Uninstall. You may also need to manually delete the following folder:

    /local/contact

[(Back to top)](#table-of-contents)

# Limitations

This is not a form builder.

The plugin doesn't currently properly support more than one textarea type fields. Additional textareas will still work however they won't be formatted as nice.

Any HTML entered will be escaped. You cannot use any kind of HTML formatting or markup/markdown other than pressing ENTER at the end of a paragraph.

You cannot configure the Contact Form email processor on a per form basis. All contact forms on your site will share:

* The message that is displayed to the user after the message has been sent.
* The footer of the email containing additional user information.
* Enabling/disabling of the autoresponder.
* The autoresponder message (if enabled).

Web forms are limited to 1024 fields including hidden fields and the submit button. Total size of the submission may not exceed 256 KB.

There is no support file attachments type fields or form-data encoded as "multipart/form-data".

[(Back to top)](#table-of-contents)

# Language Support

This plugin includes support for the English language. Additional languages including French are supported if you've installed one or more additional Moodle language packs.

If you need a language that is not yet supported, please contribute translations using the Moodle AMOS Translation Toolkit for Moodle at
https://lang.moodle.org/

This plugin has not been tested for right-to-left (RTL) language support.
If you want to use this plugin with a RTL language and it doesn't work as-is,
feel free to prepare a pull request and submit it to the project page at:

https://github.com/michael-milette/moodle-local_contact

[(Back to top)](#table-of-contents)

# FAQ

## Answers to frequently asked questions

### How do I make this form available to everyone, even if they are not logged in?

Add a page or block to your Moodle Frontpage. Edit the content and paste in your HTML form source code. Make sure that the WYSIWYG editor is in HTML mode.

Since you don't need to be logged into your Moodle Frontpage to see it, your form will also be accessible to visitors to your site who are logged-out, logged-in as a guest as well as to regular logged-in users. If this option is not available to you, the process is a little more complicated as it involves making a course available to guests and having Moodle automatically logged them in as guests.

### All I see is the word "Forbidden" or a blank screen after submitting a form. What should I do?

Although this plugin is still in BETA, it has been extensively tested. If you are getting this error, it is likely that you will need to fix your form and/or enable Moodle debugging. Alternatively you can try the form logged in as a Moodle administrator. This will enable the display of additional diagnostic information.

### Where do emails go when they are submitted on my Moodle website?

Emails are sent to the Support Email address. Logged in as a Moodle administrator, you can find out the email address by going to:

Administration > Site Administration > Server > Support Contact

If the field is empty, take note of the indicated default email address.

### Why are emails submitted on my Moodle website not being delivered?

Make sure Moodle email is working. We recommend test your Moodle email system using the eMailTest plugin:

  https://moodle.org/plugins/local_mailtest

### My site successfully completed the eMailTest process. Why is it still not working?

If you still can't get your web form to work, the problem might be your form. Try using HTML sample form included in the [Usage](#usage) section. Then customize it to meet your needs.

### I am still getting a lot of spam emails through my web form. Can I block certain IP addresses?

There are a couple of ways you can blacklist an IP address. The best way is to add them to your web server settings. Consult your web server documentation for more information. If you don't have access to those settings, Moodle Administrators can add the IP addresses to the Moodle IP Blocker settings. For more information, see:

  https://docs.moodle.org/en/IP_blocker

### Why does the User's IP address ([userip]) says "::1" or 0:0:0:0:0:1 instead showing a real IP address when I receive an email submitted from the form?

::1 and 0:0:0:0:0:1 are the equivalent of 127.0.0.1 (localhost). This should only happen if your web browser is on the same computer as the web server. Otherwise you should be seeing a real IP address.

### Can I include my favourite captcha in a form?

No. Only Moodle's reCAPTCHA will work. See the [Usage](#usage) section for more information.

### Moodle's reCAPTCHA is enabled. Do I need to use it in my Contact forms?

It is not required. However, if you don't want to use it, you must check the `No ReCAPTCHA` checkbox in the plugin's settings.

### Can I add a check box that must be checked, like for accepting the privacy policy, before the user can submit the form?

Absolutely. Information on how to do this will be coming in the future. (Hint: It requires a JavaScript code snippet)

### I have a multilingual Moodle site. Why does the form works in one language but not in the other?

Each language file defines the names of the fields for your form. To make a form work for all languages, change the name of this fields for each language by editing the "field-" strings in the Moodle language editor so that they are all the same ones you used in your form).

### How can I change the names of the fields that appear in the email?

In your form, change the value of "label for=" to the word you want. On the next line, change the id= and the name= to be the same as the one for the "label for=". Finally, if the field was "name", "email", "subject" or "message", you will also need to edit the related "field-*" string in the Moodle language editor.

### What types of web forms should not be implemented using Contact Form?

This plugin is not suitable for any form whose data should not end up in an email inbox. For example, Moodle natively supports several excellent types of forms processors such as Feedback, Survey and Database. Unless your e-commerce solution involves low volume semi-manual process, this could be better handled by applications designed with this in mind. Signing up for mailing list subscriptions should be done through a service such as Aweber, Constant Contact, MailChimp and other similar services.

Note: The mention of any 3rd party product other than Moodle and FilterCodes is not meant as an endorsement or recommendation. They are simply provided as examples.

### How can I make the form only available to logged-in users?

To only display your form for logged-in users, ensure that it is on a Moodle page that is only viewable by logged-in users. User access to pages and blocks is controlled by Moodle, not by this plugin. With that in mind, if you don't include a name and email address field in your form, only registered users who are logged-in to the Moodle site will be able to submit the form. Another option is to use the {if...}{/if...} conditional tags in the FilterCodes plugin to control who can see the form.

### Why is the name and/or email address I entered in a form getting changed when submitted?

This only happens if a user is logged in. In this case, their registered first and last name and email address will be used instead of the name and email address entered in a form.

### Can I include user profile fields and custom profile fields in the email footer and confirmation email message?

Yes. Not all profile fields are available, but you can do it by inserting [FilterCodes](https://moodle.org/plugins/filter_filtercodes/) tags.

### Why does the "Continue" button always take me back to the front page instead of back to the referrer URL?

This may happen in a few situations:

1) If you manually specified a referrer URL in the form instead of using the recommended JavaScript snippet, this can work but the referrer URL must be fully qualified, be from the Moodle site and begin with the address of your front page ($CFG->wwwroot).
2) If you try to trick it by manually specifying a URL from a different website, that URL will be ignored and your user will be redirected to the front page.
3) If you access the from by manually typing in it's URL or using a bookmark, the continue button will still take you back to the front page since this would result in no referrer URL being available.

### Why do the form <input> fields disappear every time I save my form in Moodle?

ANSWER 1: This will happen if you are using the old TinyMCE editor in Moodle instead of the newer Atto editor. With default settings, the TinyMCE editor would filter out HTML form tags when you went to save it.

The easy solution is to simply switch your preferred editor to the Atto editor, edit and then save your form. The form fields should remain intact. Once you save your form using the Atto editor, you can switch your preferred editor back to TinyMCE and the form will continue to work for everyone. However, if one day you or someone else should you forget and edit the form with the TinyMCE editor, the fields will disappear again.

If, for whatever reason, you really want to use the TinyMCE editor, you can still get it to work but you will need to modify its Moodle Configuration Settings to allow HTML form field tags.

Additional information:

* [Customizing TinyMCE](https://docs.moodle.org/en/TinyMCE_editor)
* [TinyMCE settings](https://lmgtfy.com/?q=tinymce+input+field) - You will need to do the research.

ANSWER 2: If you are having problems specifically with the StaticPages plugin, go into its configuration options and set the Clean HTML code to "No, don't clean HTML code". Otherwise the plugin will filter out HTML tags including all your form tags. (thanks to Alex Ferrer for this solution)

### Are there any security considerations?

There are no known security considerations at this time.

## Other questions

Got a burning question that is not covered here? Checkout the [troubleshooting section of our Wiki](https://github.com/michael-milette/moodle-local_contact/wiki/Troubleshooting). If you still can't find your answer, submit your question in the Moodle forums or open a new issue on GitHub at:

https://github.com/michael-milette/moodle-local_contact/issues

[(Back to top)](#table-of-contents)

# Contributing

If you are interested in helping, please take a look at our [contributing](https://github.com/michael-milette/moodle-local_contact/blob/master/CONTRIBUTING.md) guidelines for details on our code of conduct and the process for submitting pull requests to us.

## Contributors

Michael Milette - Author and Lead Developer

## Pending Features

Some of the features we are considering for future releases include:

* Add ability to specify custom profile fields in the body of the email message.
* Option to enable the auto-responder / confirmation message.
* Auto-responder will be editable in the plugin's settings.
* Add additional examples of web forms to the documentation (see Wiki).
* Create a basic form builder.
* Make all submitted web form fields available as markup tags that you can insert into your message template.
* Add some Moodle logging of sent messages.
* Add a Whitelist and Blacklist for email addresses.
* Add a Whitelist and Blacklist for email domains.
* Add support for form-specific custom autoresponders.
* Add support for form-specific custom confirmation message.
* Add support to optionally only use autoresponder feature without also sending the main email message.

If you could use any of these features, or have other needs, consider contributing or hiring us to accelerate development.

[(Back to top)](#table-of-contents)

# Motivation for this plugin

The initial development for this project was sponsored by the kind folk at l'Action ontarienne contre la violence aux femmes together with TNG Consulting Inc.

[(Back to top)](#table-of-contents)

# Further information

For further information regarding the local_contact plugin, support or to
report a bug, please visit the project page at:

https://github.com/michael-milette/moodle-local_contact

[(Back to top)](#table-of-contents)

# License

Copyright © 2016-2019 TNG Consulting Inc. - https://www.tngconsulting.ca/

This file is part of the Contact Form plugin for Moodle - https://moodle.org/plugins/local_contact/

Contact Form is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Contact Form is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Contact Form.  If not, see <https://www.gnu.org/licenses/>.

[(Back to top)](#table-of-contents)