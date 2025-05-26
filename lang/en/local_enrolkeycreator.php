<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings for local_enrolkeycreator
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['enabled'] = 'Enable automatic enrollment key creation';
$string['enabled_desc'] = 'When enabled, the plugin will automatically generate and set an enrollment key when a new self-enrollment instance is created. Note: This setting has no effect if the Moodle core setting "enrol_self | requirepassword" is enabled, as Moodle core will already handle password generation in that case.';
$string['pluginname'] = 'Automatic enrollment key creator';
$string['pluginsettings'] = 'Enrollment key creator settings';