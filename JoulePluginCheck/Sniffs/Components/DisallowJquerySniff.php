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
 * A Sniff to warn about manually including the jQuery libraries
 * as opposed to using the ones bundled with Moodle core.
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Components_DisallowJquerySniff
    implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_CONSTANT_ENCAPSED_STRING,
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

        $content = trim($tokens[$stackPtr]['content'], '\'"');

        if (preg_match('/jquery(\.|-).+js$/i', $content) === 1) {
            $this->_addError($phpcsFile, $stackPtr);
        }

    }//end process()


    /**
     * Add an error for the found path
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned
     * @param int                  $stackPtr  The pointer to the element in the stack
     *
     * @return void
     */
    private function _addError($phpcsFile, $stackPtr)
    {
        $type  = 'jQueryComponents';
        $error = 'Including jQuery et al. directly is strongly discouraged.';
        $data  = array();
        $phpcsFile->addError($error, $stackPtr, $type, $data);

    }//end _addError()


}//end class
