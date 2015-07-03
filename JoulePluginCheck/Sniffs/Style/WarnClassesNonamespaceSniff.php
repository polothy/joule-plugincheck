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
 * A Sniff to warn about the use of classes that aren't namespaced
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Style_WarnClassesNonamespaceSniff
    implements PHP_CodeSniffer_Sniff
{
    /**
     * A flag to indicate that namespaces are in this file.
     *
     * @var boolean
     */
    private $_namespaceFlag = false;

    /**
     * Maintain a list of used namespaced classes
     *
     * @var array
     */
    private $_usedClasses = array();


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
                T_NAMESPACE,
                T_USE,
                T_NEW,
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

        // Process namespaces and classes construction differently.
        if ($tokens[$stackPtr]['code'] === T_NAMESPACE) {
            $this->_namespaceFlag = true;
            return;
        }

        // Don't process if no namespaces have been found.
        if ($this->_namespaceFlag === false) {
            return;
        }

        // Maintain a list of classes explicitly used.
        if ($tokens[$stackPtr]['code'] === T_USE) {
            $lineEnd = $phpcsFile->findNext(T_SEMICOLON, ($stackPtr + 1));
            $line    = '';

            for ($i = $stackPtr; $i <= $lineEnd; $i++) {
                $line .= $tokens[$i]['content'];
            }

            $line = trim($line, ';');

            // Is this an aliased class?
            if (strpos($line, ' as ') !== false) {
                $className = explode(' ', $line);
            } else {
                $className = explode('\\', $line);
            }

            // Finalise the class name and store it for later.
            $className = end($className);
            $this->_usedClasses[$className] = $line;

            return;
        }//end if

        // Find the name of the class.
        $classPtr = $phpcsFile->findNext(
            T_STRING,
            $stackPtr,
            null,
            false,
            null,
            true
        );

        $className = $tokens[$classPtr]['content'];

        if (isset($this->_usedClasses[$className]) === true) {
            return;
        }

        if (substr($className, 0, 1) !== '\\') {
            $this->_addWarning($className, $phpcsFile, $stackPtr);
        }

    }//end process()


    /**
     * Add a warning for class without backslash
     *
     * @param string               $className The name of the class found
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned
     * @param int                  $stackPtr  The pointer to the element in the stack
     *
     * @return void
     */
    private function _addWarning($className, $phpcsFile, $stackPtr)
    {
        $type   = 'NewClassWithoutBackslash';
        $error  = 'The instantiation of the class %s is likely ';
        $error .= 'missing a namespace prefix.';
        $data   = array($className);
        $phpcsFile->addWarning($error, $stackPtr, $type, $data);

    }//end _addWarning()


}//end class
