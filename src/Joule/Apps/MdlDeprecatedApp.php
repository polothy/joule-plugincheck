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

use \Joule\Utils\FunctionList;
use \Joule\Utils\FileNotFoundException;

/**
 * A base class for the MdlDeprecated App
 *
 * An application designed to update the list of deprecated
 * functions in Moodle for use by our custom PHP_CodeSniffer standard
 *
 */
class MdlDeprecatedApp extends Application
{
    /** @var $application_name the name of the application */
    protected static $application_name = 'Update Moodle Deprecated Function List';

    /** @var #application_version the version of the application */
    protected static $application_version = '1.0.0';

    /**
     * Constructor for this class
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Main entry point to the application
     *
     * @return void
     */
    public function doTask()
    {
        global $CFG;

        // Prepare to undertake the task.
        $this->printHeader();

        $this->parseOptions();
        $this->printHelpScreen();

        $this->validateOption('moodle');
        $this->validateOption('output', $CFG->datadir . '/mdl-deprecated-functions.json');

        // Find the Moodle deprecated library file.
        $moodlepath = realpath($this->options['moodle']);

        if (empty($moodlepath)) {
            $this->printError('Unable to find path specified by --moodle');
            exit(1);
        }

        if (!is_dir($moodlepath)) {
            $this->printError('The path specified by --moodle must be a directory');
            exit(1);
        }

        $moodlepath = $moodlepath . '/lib/deprecatedlib.php';

        if (!is_file($moodlepath)) {
            $this->printError("Unable to find deprecated library file at: \n $moodlepath");
            exit(1);
        }

        // Get a list of functions.
        try {
            $functions = FunctionList::getDefinedFunctions($moodlepath);
        } catch (FileNotFoundException $ex) {
            $this->printError($ex->getMessage());
            exit(1);
        }

        if (count($functions) == 0) {
            $this->printError("Unable to retrieve list of functions.");
            exit(1);
        }

        $this->printInfo('Number of functions found: ' . count($functions));

        asort($functions);
        $functions = array_values($functions);

        // Write the list of functions file.
        if (is_file($this->options['output'])) {
            $this->printWarning('Output file exists, it will be overwritten');
        }

        $fh = @fopen($this->options['output'], 'w+');

        if (!$fh) {
            $this->printError('Unable to open output file.');
            exit(1);
        }

        //debug code
        $json = json_encode($functions, JSON_PRETTY_PRINT);

        if (fwrite($fh, $json) === false) {
            $this->printError('Unable to write to output file.');
            exit(1);
        }

        fclose($fh);

        $this->printSuccess('The output file has been successfully updated.');
    }

    /**
     * Parse the command line options
     *
     * @return void
     */
    protected function parseOptions()
    {
        $this->options = new \cli\Arguments($_SERVER['argv']);

        $this->options->addOption(
            array('moodle', 'm'),
            array(
                'default' => '',
                'description' => 'The path to the Moodle instance'
            )
        );

        $this->options->addOption(
            array('output', 'o'),
            array(
                'default' => '',
                'description' => 'The path to the output file'
            )
        );

        $this->options->addFlag(array('help', 'h'), 'Show this help screen');

        $this->options->parse();
    }
}
