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
 * Event observer for enrolment events.
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_enrolkeycreator\observer;

/**
 * Event observer class for enrolment events
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {

    /**
     * Observer for enrol_instance_created event
     *
     * @param object $event Event object
     * @return bool Always true
     */
    public static function enrol_instance_created($event) {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/enrol/locallib.php');
        require_once($CFG->dirroot . '/lib/enrollib.php');

        // Check if the plugin is enabled in settings.
        $enabled = get_config('local_enrolkeycreator', 'enabled');
        if (empty($enabled)) {
            // Plugin is disabled, do nothing.
            return true;
        }

        $enrolid = $event->objectid;
        $enrol = $DB->get_record('enrol', ['id' => $enrolid]);

        if (!$enrol || $enrol->enrol !== 'self') {
            // We only process self-enrollment instances.
            return true;
        }

        // Check if requirepassword setting is enabled in Moodle.
        $requirepassword = get_config('enrol_self', 'requirepassword');
        if ($requirepassword) {
            // If requirepassword is enabled, a password has already been set by core.
            return true;
        }

        // Check if a password is already set.
        if (!empty($enrol->password)) {
            return true;
        }

        $courseid = $enrol->courseid;
        $course = $DB->get_record('course', ['id' => $courseid]);

        if (!$course) {
            return true;
        }

        $enrolkey = generate_password();
        $enrol->password = $enrolkey;
        $DB->update_record('enrol', $enrol);

        return true;
    }
}
