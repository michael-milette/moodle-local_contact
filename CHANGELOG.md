# Change Log
All notable changes to this project will be documented in this file.

## [1.0.,0] - 2019-11-17
### Added
- Documentation references to new {form...} FilterCode tags. Enables you to easily create common web-forms with just one FilterCode tag.
### Updated
- Documentation for Moodle 3.8.
- Code maturity is now considered STABLE, supporting Moodle 3.0 to 3.8.
- Copyright notice.
- Note: No code changes in this release.

## [0.8.4] - 2018-05-21
### Added
- Support for Privacy API

## [0.8.3] - 2018-03-30
### Added
- Support for reCAPTCHA v2 in Moodle as of versions 3.1.11+, 3.2.8+, 3.3.5+, 3.4.5+ and 3.5+.
- New setting to remove site name from email subject field.
### Updated
- After submitting the form, the continue button will now take you to the front page or, if the "referrer" field was included in the form, the page the user was on just before going to the form.
- Documentation including how to edit email messages and FAQ for those using TinyMCE.
- Corrected login detection bug introduced in v0.8.2.
- Contact Form upgrade notifications now works properly when a updates are available on Moodle.org.
- ReCAPTCHA tags are now filtered out from the email message.
- Copyright notices now includes 2018.

## [0.8.2] - 2017-12-04
### Added
- Settings option to require users to be logged-in when submitting the form. Not enforced by default. (Thanks to contributions by @kmoouni and @jezhops)
### Updated
- Leading or trailing spaces in email addresses in recipient list settings will no longer cause a problem.
- Fixed bug where forms could be submitted without sesskey JavaScript in the form.
- Fixed missing reply-to address.
- Fixed support for multiple selections for select tag.

## [0.8.1] - 2017-11-13
### Updated
- No ReCAPTCHA option now actually has an effect.

## [0.8.0] - 2017-11-11
### Added
- Support for Moodle ReCAPTCHA. Can be disabled for Contact Forms in settings. Must be use with the {recaptcha} tag from the FilterCodes plugin.
### Updated
- Updated documentation with new examples in README.md.

## [0.7.2] - 2017-10-29
### Added
- The French translation for Contact Form for Moodle is now available. Update your Moodle language pack to get it!
- You can now specify the recipient's email address on a per form basis.
- Added POST method detection.
- Added "Continue" button on the confirmation page.
- Added ability to specify some profile fields using FilterCodes filter plugin for Moodle in the footer of the email message.
- Added alias support for the 'name', 'email', 'subject' and 'message' fields.
- Added CONTRIBUTE.md.
### Updated
- If present, the name and email address form fields will now be ignored for users currently logged-in to Moodle. Their user profile info will be used instead.
- Clarified documentation's instructions for creating a form.
- Added some new FAQ items to the documentation relating to changes to the name and email address field requirements.
- Added some new ideas for features to the documentation.
- Fixed detection of maximum number of submitted fields.
- Reorganized README.md (New: logo, status badges, table of contents, contributing, etc).
- Has been tested with Moodle 3.4.

## [0.7.0] - 2017-05-13
### Updated
- Made source code comments clearer and phpdoc valid.
- Now properly selects current default Moodle sender.
- Updated copyright notice to include 2017.
- Updated documentation.
- Plugin officially compatible and tested with Moodle 3.0, 3.1, 3.2 and 3.3.

### Added
- Additional troubleshooting messages added.
- New option to always show communications dialogue with server, even if there are no errors.
- Underscores in field ID/name tokens are now replaced with spaces to make field names easier to read in emails.
- Wiki on GitHub which includes documentation, FAQ, template and examples of web forms.
- Sanitization of form id/name tokens.
- Now limited to 256 KB total encoded submission size. New related debugging message added.
- Now limited to 1024 fields. New related debugging message added.
- Will no longer process form if it includes a file submissions.

## [0.6.0] - 2016-12-05
### Added
- Initial public release on Moodle.org and GitHub.
- Plugin officially compatible and tested with Moodle 3.0, 3.1 and 3.2.
