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

$user = $DB->get_record('user', array('id'=>'1'));
$user = $DB->get_record_sql('SELECT * FROM {user} WHERE id = ?', array(1));

/// Question mark placeholders:
$DB->get_record_sql('SELECT * FROM {user} WHERE firstname = ? AND lastname = ?',
    array('James', 'Bond'));

/// Named placeholders:
$DB->get_record_sql('SELECT * FROM {user} WHERE firstname = :firstname AND lastname = :lastname',
    array('firstname'=>'James', 'lastname'=>'Bond'));

$DB->get_records_sql($sql, $params, $limitfrom, $limitnum);
$DB->get_records_sql_menu($sql, $params, $limitfrom, $limitnum);
$DB->count_records_sql($sql, $params);
$DB->record_exists_sql($sql, $params);
$DB->get_field_sql($sql, $params, $strictness);
$DB->get_fieldset_sql($sql, $params);
$DB->execute($sql, $parms);
$DB->get_recordset_sql($sql, $params, $limitfrom, $limitnum);
