# Change Log
All notable changes to this project will be documented in this file.

## [0.7.1] - 2017-06-11
### Added
- The French translation for Contact Form for Moodle is now available. Update your Moodle language pack to get it!
- You can now specify the recipient's email address on a per form basis.

### Updated
- If present, the name and email address form fields will now be ignored for users currently logged-in to Moodle. Their user profile info will be used instead.
- Clarified documentation's instructions for creating a form.
- Added some new FAQ items to the documentation relating to changes to the name and email address field requirements.
- Added some new ideas for features to the documentation.

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
