# Plugin Check Helper Scripts for Joule #

As a software engineer in the product development team at [Moodlerooms][mr], part of the [Blackboard][bb] family, I work on [Moodle][m] code a significant amount of time. One of my many tasks, is the review of Moodle plugins to see if they are suitable for including in our enterprise class Moodle offering. Our Moodle offering known is known internally as Joule.

Unlike some of my colleagues, I can't 'sight read' PHP code. That is to say, I can't read code line by line, understanding how it all hangs together, whilst also looking out for issues. This repository, and the tools contained within it, are my work in progress for automating some of the checks that I need to do.

The checks are built around a custom standard for the [PHP_CodeSniffer][phpc]

## Installation ##
1. Clone this repository
2. Install [Composer][c]
3. Install the dependencies with composer
4. Configure the [PHP_CodeSniffer][phpc] application as below

## Configuration ##
To make it easier to run the [PHP_CodeSniffer][phpc] application with the included standard you can add it to the list of default standards by executing the following command:

`vendor/bin/phpcs --config-set installed_paths {full/path/to/the/standard}`

You need to replace `{full/path/to/the/standard}` with the full path to the `JoulePluginCheck` directory that is part of this repository.

## Checking Plugin Code ##
To check Moodle plugin code execute the [PHP_CodeSniffer][phpc] application like follows:

`vendor/bin/phpcs --standard=JoulePluginCheck {full/path/to/the/plugin}`

Any issues found by the sniffs that are part of the standard will output to the terminal.
## Individual Sniffs ##
The JoulePluginCheck standard is compromised of standard and custom sniffs. The standard sniffs are:

1. Generic.Files.ByteOrderMark
2. Generic.Files.LineEndings
3. Generic.PHP.DeprecatedFunctions
4. Generic.PHP.DisallowShortOpenTag
5. Generic.PHP.NoSilencedErrors
6. Squiz.PHP.DiscouragedFunctions
7. Squiz.PHP.Eval

Check the [PHP_CodeSniffer][phpc] documentation and code for details on what each of these sniffs does.

The following is a list of custom sniffs included in this standard:

1. Components.DisallowJquery - Check for code that manually included jQuery, rather than using the bundled version in Moodle
2. Constants.DisallowParamConstants - Check for code that uses deprecated PARAM_* constants used for parameter cleaning.
3. Functions.DisallowCurlFunctions - Check for code that uses cURL directly, rather than using the curl class in Moodle
4. Functions.DisallowDeprecatedFunctions - Find code that uses deprecated Moodle functions
5. Functions.DisallowFilesystemFunctions - Find functions that interact with the file system that can cause issues in a multi web node environment
6. Variables.DisallowRequestVariables - Find code that accesses the global request variables

## Updating the List of Deprecated Functions ##
The list of deprecated functions can be updated using the following following command:

`bin/MdlDeprecated.php --moodle {full/path/to/moodle}`

By default the JSON file will be output to the same location as that used by the Functions.DisallowDeprecatedFunctions sniff listed above.

## Running Uni Tests ##
There are two types of unit tests, as outlined below:

### The Included Scripts ###
To run the unit tests associated with the included scripts run the phpunit application using a command like this:

`vendor/bin/phpunit`

### The Included Sniffs ###

To run the unit tests associated with the included sniffs, it is necessary to:

1. Clone a copy of the  [PHP_CodeSniffer][phpc] repository
2. Configure this downloaded copy to include the standard `scripts/phpcs --config-set installed_paths {full/path/to/the/standard}`
3. Run the following phpunit command `phpunit --filter JoulePluginCheck`

You need to replace `{full/path/to/the/standard}` with the full path to the `JoulePluginCheck` directory that is part of this repository.
This also assumes that phpunit is available in your path.

## Dependencies ##
These tools would not be possible without following libraries, installed using [Composer][c]:

1. [wp-cli/php-cli-tools](https://github.com/wp-cli/php-cli-tools)
2. [squizlabs/php_codesniffer][phpc]
3. [PHPUnit](https://phpunit.de/)

## License ##

Joule Plugin Code Checker suite is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the  License, or (at your option) any later version.

 Joule Plugin Code Checker suite is distributed in the hope that it will  be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the [GNU General Public License](http://www.gnu.org/copyleft/gpl.html) for more details.

[m]: https://moodle.org/
[mr]: http://www.moodlerooms.com
[bb]: http://www.blackboard.com
[c]: https://getcomposer.org/
[phpc]: https://github.com/squizlabs/php_codesniffer