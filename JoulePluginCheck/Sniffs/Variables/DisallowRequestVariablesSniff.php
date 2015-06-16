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
 * A Sniff to warn about accessing request data directly
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Variables_DisallowRequestVariablesSniff
    implements PHP_CodeSniffer_Sniff
{
    /**
     * The names of the variables that are not allowed.
     *
     * @var $varnames
     */
    protected $varnames;

    /**
     * The names of the variables that are not allowed,
     * as a 1 dimensional array to speed up lookups.
     *
     * @var $varkeys
     */
    protected $varkeys;


    /**
     * Constructor for this class
     */
    public function __construct()
    {
        $this->varnames = array(
                           '$_REQUEST' => true,
                           '$_GET'     => true,
                           '$_POST'    => true,
                           '$_FILES'   => true,
                          );

        $this->varkeys = array_keys($this->varnames);

    }//end __construct()


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_VARIABLE,
                T_DOUBLE_QUOTED_STRING,
               );

    }//end register()


    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $content = $tokens[$stackPtr]['content'];

        // Deal with sneaky developers.
        if ($tokens[$stackPtr]['code'] === T_DOUBLE_QUOTED_STRING) {
            foreach ($this->varkeys as $key) {
                if (strpos($content, $key) !== false) {
                    $this->_addError($key, $phpcsFile, $stackPtr);
                }
            }

            return;
        }

        if (isset($this->varnames[$content]) === true) {
            $this->_addError($content, $phpcsFile, $stackPtr);
        }

    }//end process()


    /**
     * Add an error for the found path
     *
     * @param string               $varname   The name of the variable found
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned
     * @param int                  $stackPtr  The pointer to the element in the stack
     *
     * @return void
     */
    private function _addError($varname, $phpcsFile, $stackPtr)
    {
        $type  = 'SuperglobalAccessed';
        $error = 'The %s super global must not be accessed directly';
        $data  = array($varname);
        $phpcsFile->addError($error, $stackPtr, $type, $data);

    }//end _addError()


}//end class
