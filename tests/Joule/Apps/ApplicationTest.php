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
 * @category  PHP
 * @package   JoulePluginCheck
 * @author    Corey Wallis <corey.wallis@blackboard.com>
 * @copyright 2015 Blackboard Inc.
 * @license   https://www.gnu.org/copyleft/gpl.html GPLv3
 * @link      https://github.com/techxplorer/joule-plugincheck
 */

/**
 * Test the abstract Application class
 */
class ApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the various convenience functions
     *
     * @return void
     *
     * @covers Joule\Apps\Application::printWarning
     * @covers Joule\Apps\Application::printWarning
     * @covers Joule\Apps\Application::printError
     * @covers Joule\Apps\Application::printSuccess
     * @covers Joule\Apps\Application::printInfo
     * @covers Joule\Apps\Application::printHeader
     */
    public function testConvenienceFunctions() {
        // Build a test stub object.
        $methods = get_class_methods('Joule\Apps\Application');
        $stub = $this->getMockBuilder('Joule\Apps\Application')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMockForAbstractClass();

        // Use reflection to set the protected testing attributes.
        $attribute = new ReflectionProperty('Joule\Apps\Application', 'testing');
        $attribute->setAccessible(true);
        $attribute->setValue($stub, true);

        $attribute = new ReflectionProperty('Joule\Apps\Application', 'application_name');
        $attribute->setAccessible(true);
        $attribute->setValue($stub, 'Test Application');

        $attribute = new ReflectionProperty('Joule\Apps\Application', 'application_version');
        $attribute->setAccessible(true);
        $attribute->setValue($stub, '2.0');

        // Use reflection to get at the protected methods.
        $method = new ReflectionMethod('Joule\Apps\Application', 'printWarning');
        $method->setAccessible(true);

        $expected = "%yWARNING:%w Danger!\n";

        $this->assertEquals($expected, $method->invoke($stub, 'Danger!'));

        $method = new ReflectionMethod('Joule\Apps\Application', 'printError');
        $method->setAccessible(true);

        $expected = "%rERROR:%w Kaboom!\n";

        $this->assertEquals($expected, $method->invoke($stub, 'Kaboom!'));

        $method = new ReflectionMethod('Joule\Apps\Application', 'printSuccess');
        $method->setAccessible(true);

        $expected = "%gSUCCESS:%w Woo Hoo!\n";

        $this->assertEquals($expected, $method->invoke($stub, 'Woo Hoo!'));

        $method = new ReflectionMethod('Joule\Apps\Application', 'printInfo');
        $method->setAccessible(true);

        $expected = "INFO: It's snowing in california.\n";

        $this->assertEquals($expected, $method->invoke($stub, "It's snowing in california."));

        $method = new ReflectionMethod('Joule\Apps\Application', 'printHeader');
        $method->setAccessible(true);

        $expected = "Test Application - 2.0\nLicense: http://www.gnu.org/copyleft/gpl.html\n\n";

        $this->assertEquals($expected, $method->invoke($stub));
    }
}
