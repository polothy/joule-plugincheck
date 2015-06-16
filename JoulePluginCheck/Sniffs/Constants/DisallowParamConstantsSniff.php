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
 * A Sniff to warn about using deprecated PARAM_* constants
 * in Moodle.
 *
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @version   Release: @package_version@
 * @link      https://github.com/techxplorer/joule-plugincheck
 */
class JoulePluginCheck_Sniffs_Constants_DisallowParamConstantsSniff
    implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of paramter constants and their alternatives.
     * @var $_paramnames
     */
    private $_paramnames;


    /**
     * Constructor for this class
     */
    public function __construct()
    {
        $this->_paramnames = array(
                              'PARAM_RAW'       => '',
                              'PARAM_CLEAN'     => '',
                              'PARAM_INTEGER'   => 'PARAM_INT',
                              'PARAM_NUMBER'    => 'PARAM_FLOAT',
                              'PARAM_ACTION'    => 'PARAM_ALPHANUMEXT',
                              'PARAM_FORMAT'    => 'PARAM_ALPHANUMEXT',
                              'PARAM_MULTILANG' => 'PARAM_TEXT',
                              'PARAM_CLEANFILE' => 'PARAM_FILE',
                             );

    }//end __construct()


    /**
     * Return the token types that this Sniff is interested in
     *
     * @return array
     */
    public function register()
    {
        return array(T_STRING);

    }//end register()


    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $name = trim($tokens[$stackPtr]['content']);

        if (isset($this->_paramnames[$name]) === true) {
            $this->addError($phpcsFile, $stackPtr, $name);
        }

    }//end process()


    /**
     * Generates the error or warning for this sniff.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the forbidden function
     *                                        in the token array.
     * @param string               $param     The name of the forbidden param.
     *
     * @return void
     */
    protected function addError($phpcsFile, $stackPtr, $param)
    {
        $data = array($param);

        $error = 'The use of the constant %s is strongly discouraged.';

        if (empty($this->_paramnames[$param]) === false) {
            $error .= " Use '".$this->_paramnames[$param]."' instead.";
        }

        $phpcsFile->addError($error, $stackPtr, 'Discouraged', $data);

    }//end addError()


}//end class
