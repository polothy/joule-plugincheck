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
 * An include file to support the associated unit test in
 * the file with the same name as this one only ending in .php
 */

// A random selection of deprecated functions.

$var = add_event();
$var = delete_event();

// comments should be left alone.
// $var = delete_event();

// What about with parameters?
$var = check_browser_operating_system($param1, $param2, array('1', '2'), '12345');

error("Where's the kaboom? There was supposed to be an earth-shattering kaboom!");

$var = normalize_component();

$var = session_touch();
