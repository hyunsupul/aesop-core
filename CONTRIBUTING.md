#Contributing To Aesop Story Engine

Community made patches, localisations, bug reports, and contributions are always welcome and are crucial to ensure Aesop Story Engine remains the #1 storytelling plugin on WordPress.

When contributing please ensure you follow the guidelines below so that we can keep on top of things.

__Please Note:__ GitHub is for bug reports and contributions only - if you have a support question or a request for a customization don't post here, go to our [Support Forum](https://wordpress.org/support/plugin/aesop-story-engine) instead.

## License
By contributing code to [ASE](https://github.com/bearded-avenger/aesop-core), you agree to license your contribution under the [GPL License](https://github.com/bearded-avenger/aesop-core/blob/master/LICENSE.txt).

## Issues
Open a GitHub issue for anything. We've covered quite a bit of ground through the first year, so it would be helfpul to search for related topics first. That said, don't worry if you find yourself opening something that sounds like it could be obvious. There is no such thing.

## Comments
Comment on any GitHub issue, open or closed. The only guidelines here are to be friendly and welcoming. If you see that a question has been asked and you think you know the answer, don't wait!

## Getting Started

* Submit a ticket for your issue, assuming one does not already exist.
  * Raise it on our [Issue Tracker](https://github.com/bearded-avenger/aesop-core/issues)
  * Clearly describe the issue including steps to reproduce the bug.
  * Make sure you fill in the earliest version that you know has the issue as well as the version of WordPress you're using.

## Making Changes

* Fork the repository on GitHub
* Make the changes to your forked repository
  * Ensure you stick to the [WordPress Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards)
* When committing, reference your issue (if present) and include a note about the fix
* If possible, and if applicable, please also add/update unit tests for your changes
* Push the changes to your fork and submit a pull request to the 'dev' branch of the ASE repository

The master branch can be considered stable and a list of stable releases are maintained as we go and can be used by anyone concerned by ongoing development.

## Milestones and Labels
Some loose organization has grown around milestones and labels. We may have the next version listed for selection as a milestone. Things like bugs, enhancements, questions, etc. are listed as labels.

## Code Documentation

* We ensure that every ASE function is documented well and follows the standards set by phpDoc
* An example function can be found [here](https://gist.github.com/michaelbeil/232e08f3f4cf212df81f)
* Please make sure that every function is documented so that when we update our documentation things don't go awry!
	* If you're adding/editing a function in a class, make sure to add `@access {private|public|protected}`
* Finally, please use tabs and not spaces. The tab indent size should be 4 for all ASE code.

At this point you're waiting on us to merge your pull request. We'll review all pull requests, and make suggestions and changes if necessary.

# Additional Resources
* [ASE Developers](http://aesopstoryengine.com/developers)
* [General GitHub Documentation](http://help.github.com)
* [GitHub Pull Request documentation](http://help.github.com/send-pull-requests)
* [PHPUnit Tests Guide](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html)
