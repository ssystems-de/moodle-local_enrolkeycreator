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
 * Plugin administration settings.
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Create the new settings page.
    $settings = new admin_settingpage('local_enrolkeycreator_settings',
            new lang_string('pluginsettings', 'local_enrolkeycreator'));

    // Add the settings page to the Plugins > Local plugins menu.
    $ADMIN->add('localplugins', $settings);

    // Add the enable/disable setting (kill switch).
    $name = 'local_enrolkeycreator/enabled';
    $title = new lang_string('enabled', 'local_enrolkeycreator');
    $description = new lang_string('enabled_desc', 'local_enrolkeycreator');
    $default = 0;
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, $default));
}
