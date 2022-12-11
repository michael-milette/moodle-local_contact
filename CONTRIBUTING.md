Contributing
-------------------

1. File an issue to notify the maintainers about what you are working on.
2. Fork the repo, develop and test your code changes, add docs.
3. Make sure that your commit messages clearly describe the changes.
4. Send a pull request.

File an Issue
-------------------

Use the issue tracker to start the discussion. It is possible that someone else is already working on your idea, your approach is not quite right, or that the functionality exists already. The ticket you file in the issue tracker will be used to hash that all out.

Keep in mind that the maintainers get final say on whether new features will be integrated into the project.

Style Guides
-------------------
1. Write in UTF-8 in PHP 5.6, 7.0, 7.1, 7.2, 7.3, 7.4 and 8.0.
2. Follow the official[Moodle Coding Style Guide](https://docs.moodle.org/dev/Coding_style).
3. Fully test your code with Moodle **Debug Messages** setting set to **DEVELOPER: extra Moodle debug messages for developers** and **Display debug messages** setting checked. Ensure that there are no errors or warnings at all.
4. Test your code using the [Moodle Code Checker](https://moodle.org/plugins/local_codechecker) and [Moodle PHPdoc check](https://moodle.org/plugins/local_moodlecheck) plugins. Ensure that there are no errors or warnings at all. 
5. Look at the existing style and adhere accordingly.

Fork the Repository
-------------------

Be sure to add the relevant tests before making the pull request. The documentation will be updated automatically when we merge to the **master** branch, but you should also build the documentation yourself and make sure it is readable.

Make a Pull Request
-------------------

Once you have made all your changes, tests, and updated the documentation, make a pull request to move everything back into the main branch of the **repository**. Be sure to reference the original issue in the pull request. Expect some back-and-forth with regards to style and compliance of these rules.

Versioning
-------------------
We use [SemVer](http://semver.org/) for versioning.
