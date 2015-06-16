<?php
/**
 * This file is part of the Joule Plugin Code Checker suite.
 *
 * Joule Plugin Code Checker suite is free software: you can redistribute
 * it and/or modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Joule Plugin Code Checker suite is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with the Joule PLugin Code Checker suite.
 * If not, see <http://www.gnu.org/licenses/>
 *
 * @author Corey Wallis <corey.wallis@blackboard.com>
 * @copyright Blackboard Inc. 2015
 * @license GPL-3.0+
 * @version 1.0
 */

namespace Joule\Apps;

use \InvalidArgumentException;
use \RuntimeException;

/**
 * A base class for all applications
 */
abstract class Application
{

    /** @var string $application_name the name of the application. */
    protected static $application_name;

    /** @var string $application_version the version of the application. */
    protected static $application_version;

    /** @var string $application_license the URI for more information about the license. */
    protected $application_license = 'http://www.gnu.org/copyleft/gpl.html';

    /** @var bool $testing indicate that the class is undergoing testing */
    protected $testing = false;

    /** @var object $options the list of parsed command line options */
    protected $options;

    /**
     * Construct a new Application object
     *
     * @throws \RuntimeException if required properties are not implemented
     */
    protected function __construct()
    {
        if (empty(static::$application_name)) {
            throw new RuntimeException(get_called_class() . ' must define the $application_name property');
        }

        if (empty(static::$application_version)) {
            throw new RuntimeException(get_called_class() . ' must define the $application_version property');
        }
    }


    /**
     * Main entry point for the application.
     *
     * @return void
     */
    abstract public function doTask();

    /**
     * Parse the command line options.
     *
     * @return void
     */
    abstract protected function parseOptions();

    /**
     * Print the help screen if required
     *
     * @return void
     */
    protected function printHelpScreen()
    {
        if ($this->options['help']) {
            \cli\out($this->options->getHelpScreen());
            \cli\out("\n\n");
            die(0);
        }
    }

    /**
     * Print the application header
     *
     * @return void
     */
    protected function printHeader()
    {
        $message = static::$application_name . ' - ' . static::$application_version . "\n";
        $message .= 'License: ' . $this->application_license . "\n\n";

        if ($this->testing) {
            return $message;
        } else {
            \cli\out($message);
        }
    }

    /**
     * Convenience function to print info text
     *
     * @param string $message the message to print
     *
     * @throws InvalidArgumentException if the message is empty
     *
     * @return void
     */
    protected function printInfo($message)
    {
        if (empty(trim($message))) {
            throw new InvalidArgumentException('The $message argument is required.');
        }

        $message = 'INFO: ' . trim($message) . "\n";

        if ($this->testing) {
            return $message;
        } else {
            \cli\out($message);
        }
    }

    /**
     * Convenience function to print warning text
     *
     * @param string $message the message to print
     *
     * @throws InvalidArgumentException if the messasge is empty
     *
     * @return void
     */
    protected function printWarning($message)
    {
        if (empty(trim($message))) {
            throw new InvalidArgumentException('The $message argument is required.');
        }

        $message = '%yWARNING:%w ' . trim($message) . "\n";

        if ($this->testing) {
            return $message;
        } else {
            \cli\out($message);
        }
    }

    /**
     * Convenience function to print error text
     *
     * @param string $message the message to print
     *
     * @throws InvalidArgumentException if the message is empty
     *
     * @return void
     */
    protected function printError($message)
    {
        if (empty(trim($message))) {
            throw new InvalidArgumentException('The $message argument is required.');
        }

        $message = '%rERROR:%w ' . trim($message) . "\n";

        if ($this->testing) {
            return $message;
        } else {
            \cli\err($message);
        }
    }

    /**
     * Convenience function to print success text
     *
     * @param string $message the messae to print
     *
     * @throws InvalidArgumentException if the message is empty
     *
     * @return void
     */
    protected function printSuccess($message)
    {
        if (empty(trim($message))) {
            throw new InvalidArgumentException('The $message argument is required.');
        }

        $message = '%gSUCCESS:%w ' . trim($message) . "\n";

        if ($this->testing) {
            return $message;
        } else {
            \cli\out($message);
        }
    }

    /**
     * Validate an option and if necessary use a default value
     *
     * @param string $option  the name of the required option
     * @param string $default the default option if it isn't found
     *
     * @return bool true if valid, false if it isn't
     *
     * @throws InvalidArgumentException if one of the options is invalid
     */
    protected function validateOption($option, $default = null)
    {
        if (empty(trim($option))) {
            throw new InvalidArgumentException('The $option argument is required.');
        }

        $option = trim($option);

        if (empty($this->options[$option])) {
            if (empty($default)) {
                $this->printError("Missing required option --{$option}");
                exit(1);
            } else {
                $this->printWarning("Missing option --{$option} using the default value:\n  {$default}");
                $this->options[$option] = $default;
            }
        }
    }
}
