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

use \Joule\Utils\FunctionList;
use \Joule\Utils\FileNotFoundException;

/**
 * Test the FunctionList class
 */
class FunctionListTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the parameter validation of the class
     *
     * @return void
     * @expectedException InvalidArgumentException
     */
    public function testgetDefinedFunctionsOne() {
        FunctionList::getDefinedFunctions(null);
    }

    /**
     * Test the parameter validation of the class
     *
     * @return void
     * @expectedException InvalidArgumentException
     */
    public function testgetDefinedFunctionsTwo() {
        FunctionList::getDefinedFunctions("");
    }

    /**
     * Test the parameter validation of the class
     *
     * @return void
     * @expectedException InvalidArgumentException
     */
    public function testgetDefinedFunctionsThree() {
        FunctionList::getDefinedFunctions("     ");
    }

    /**
     * Test the parameter validation of the class
     *
     * @return void
     * @expectedException \Joule\Utils\FileNotFoundException
     */
    public function testgetDefinedFunctionsFour() {
        FunctionList::getDefinedFunctions('/file/not/found');
    }

    /**
     * Test the retrieval of functions
     *
     * @return void
     * @covers \Joule\Utils\FunctionList::getDefinedFunctions
     */
    public function testgetDefinedFunctionsFive() {
        $functions = FunctionList::getDefinedFunctions(__FILE__);
        $this->assertCount(6, $functions);
    }

    /**
     * Test the retrieval of functions
     *
     * @return void
     */
    public function targetDefinedFunctionsSix() {
        global $CFG;

        $functions = FunctionList::getDefinedFunctions($CFG->rootdir . '/boostrap.php');
        $this->assertCount(0, $functions);
    }


}
