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
 * PHP version 5
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @link      https://github.com/techxplorer/joule-plugincheck
 */

/**
 * A Sniff to warn about core Moodle deprecated functions
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Functions_DisallowDeprecatedFunctionsSniff
    extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{


    /**
     * Constructor for this class, loads in the list of disallowed functions
     */
    public function __construct()
    {
        $datapath = __DIR__.'/../../../data/mdl-deprecated-functions.json';

        if (is_file($datapath) === false) {
            throw new \RuntimeException(
                'Unable to find the list of deprecated functions.'
            );
        }

        $json = file_get_contents($datapath);

        if ($json === false) {
            throw new \RuntimeException(
                'Unable to load the list of deprecated functions.'
            );
        }

        $functions = json_decode($json);

        if (is_array($functions) === false) {
            throw new \RuntimeException('No deprecated function names found');
        }

        // Prepare the list of functions for use by parent class.
        $forbidden = array();

        foreach ($functions as $function) {
            $forbidden[$function] = null;
        }

        $this->forbiddenFunctions = $forbidden;

    }//end __construct()


    /**
     * Generates the error or warning for this sniff.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the forbidden function
     *                                        in the token array.
     * @param string               $function  The name of the forbidden function.
     * @param string               $pattern   The pattern used for the match.
     *
     * @return void
     */
    protected function addError($phpcsFile, $stackPtr, $function, $pattern=null)
    {
        $data  = array($function);
        $error = 'The use of deprecated function %s() is strongly discouraged.';
        $phpcsFile->addError(
            $error,
            $stackPtr,
            'DisallowDeprecatedFunctions',
            $data
        );

    }//end addError()


}//end class
