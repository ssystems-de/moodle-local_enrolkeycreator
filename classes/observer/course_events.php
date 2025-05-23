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
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_enrolkeycreator\observer;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer class for enrolment events
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_events {

    /**
     * Observer für das enrol_instance_created Event
     *
     * @param object $event Das Event-Objekt
     * @return bool Immer true
     */
    public static function enrol_instance_created($event) {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/enrol/locallib.php');

        $enrolid = $event->objectid;
        $enrol = $DB->get_record('enrol', ['id' => $enrolid]);

        if (!$enrol || $enrol->enrol !== 'self') {
            // Wir bearbeiten nur Self-Enrolment-Instanzen
            return true;
        }

        $courseid = $enrol->courseid;
        $course = $DB->get_record('course', ['id' => $courseid]);

        if (!$course) {
            return true;
        }

        // Protokollierung für Debugging-Zwecke
        if (function_exists('mtrace')) {
            mtrace('Self-Enrolment-Instanz erstellt für Kurs: ' . $course->fullname . ' (ID: ' . $courseid . ')');
        }

        // Generieren eines zufälligen Einschreibeschlüssels
        $enrolkey = self::generate_random_key();

        // Aktualisieren der enrol-Instanz mit dem neuen Schlüssel
        $enrol->password = $enrolkey;
        $DB->update_record('enrol', $enrol);

        if (function_exists('mtrace')) {
            mtrace('Einschreibeschlüssel generiert: ' . $enrolkey);
        }

        return true;
    }

    /**
     * Generiert einen zufälligen Einschreibeschlüssel
     *
     * @param int $length Länge des Schlüssels
     * @return string Der generierte Schlüssel
     */
    private static function generate_random_key($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $key = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $key .= $chars[random_int(0, $max)];
        }

        return $key;
    }
}
