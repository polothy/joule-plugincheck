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
 * An exception indicating that a file was not found
 */
class FileNotFoundException extends \RuntimeException
{
    /**
     * Constructor for the exception
     *
     * @param string $path the path to the file that was not found
     */
    public function __construct($path)
    {
        parent::__construct(
            sprintf(
                "The file '%s' could not be found.",
                $path
            )
        );
    }
}
