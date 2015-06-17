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
 * A Sniff to warn about a PHP source file containing more than one
 * namespace definition
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Style_DisallowMultipleNamespacesSniff
    implements PHP_CodeSniffer_Sniff
{
    /**
     * Keep track of the files that have been process
     *
     * @var $_files
     */
    private $_files;

    /**
     * Constructor for this class
     */
    public function __construct()
    {
        $this->_files = array();

    }//end construct()

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_NAMESPACE,
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
        $filename = md5($phpcsFile->getFilename());

        if (isset($this->_files[$filename])) {
            // The file declares a namespace twice.
            $this->_addError($phpcsFile, $stackPtr);
        } else {
            $this->_files[$filename] = true;
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
    private function _addError($phpcsFile, $stackPtr)
    {
        $type  = 'MultipleNamespaceDeclarations';
        $error = 'A PHP file can only declare a namespace once';
        $data  = array();
        $phpcsFile->addError($error, $stackPtr, $type, $data);

    }//end _addError()


}//end class
