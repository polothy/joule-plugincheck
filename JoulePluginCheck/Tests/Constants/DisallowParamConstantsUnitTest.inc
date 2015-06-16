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

$mform = $this->_form;

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_RAW);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_CLEAN);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_INTEGER);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_NUMBER);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_ACTION);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_FORMAT);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_MULTILANG);

$mform->addElement('text', 'name', get_string('name', 'mymod'), array('size'=>'64'));
$mform->setType('name', PARAM_CLEANFILE);

$id = optional_param('id', '', PARAM_TEXT);
$id = optional_param('id', '', PARAM_RAW);
$id = optional_param('id', '', PARAM_CLEAN);
$id = optional_param('id', '', PARAM_INTEGER);
$id = optional_param('id', '', PARAM_NUMBER);
$id = optional_param('id', '', PARAM_ACTION);
$id = optional_param('id', '', PARAM_FORMAT);
$id = optional_param('id', '', PARAM_MULTILANG);
$id = optional_param('id', '', PARAM_CLEANFILE);
