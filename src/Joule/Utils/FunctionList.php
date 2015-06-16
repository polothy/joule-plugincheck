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

namespace Joule\Utils;

/**
 * Parse a PHP file and build a list of functions in a PHP file
 */
class FunctionList
{
    /**
     * Build a list of functions defined in a PHP file
     *
     * @param string $filepath the path to the input file
     *
     * @return array an array of functions defined in the PHP file
     *
     * @throws \InvalidArgumentException if the $filepath is invalid
     * @throws \Joule\Utils\FileNotFoundException if the $filepath could not be found
     */
    public static function getDefinedFunctions($filepath)
    {
        // Double check the parameter
        if ($filepath == null || trim($filepath) == "") {
            throw new \InvalidArgumentException('The $filepath parameter is required');
        }

        if (!is_file($filepath) || !is_readable($filepath)) {
            throw new \Joule\Utils\FileNotFoundException($filepath);
        }

        // Get all of the PHP tokens.
        $tokens = token_get_all(file_get_contents($filepath));
        $functions = array();

        if (count($tokens) == 0) {
            return $functions;
        }

        $skip = 0;
        $nextisfunction = false;

        // Look for all of the tokens that define functions.
        foreach ($tokens as $token) {
            // Skip tokens we know we don't need.
            if ($skip > 0) {
                $skip--;
                continue;
            }

            if (!is_array($token)) {
                continue;
            }

            // Is this the start of a function definition?
            if ($token[0] == T_FUNCTION) {
                $nextisfunction = true;
                $skip = 1;
                continue;
            }

            if ($nextisfunction && $token[0] == T_STRING) {
                $functions[] = $token[1];
                $nextisfunction = false;
            }
        }

        return $functions;
    }
}
