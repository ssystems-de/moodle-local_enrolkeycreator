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
 * Event observer for course events.
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_enrolkeycreator\observer;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer class for course events
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_events {

    /**
     * Observer für das course_created Event
     *
     * @param \core\event\course_created $event Das Event-Objekt
     * @return bool Immer true
     */
    public static function course_created(\core\event\course_created $event) {
        global $DB, $CFG;

        $courseid = $event->objectid;
        $course = $DB->get_record('course', ['id' => $courseid]);

        if (!$course) {
            return true;
        }

        // Protokollierung für Debugging-Zwecke
        mtrace('Kurs wurde erstellt: ' . $course->fullname . ' (ID: ' . $courseid . ')');

        // Hier könnten Sie einen Einschreibeschlüssel für diesen Kurs generieren
        // Beispiel für einen zufälligen Schlüssel
        $enrolkey = self::generate_random_key();

        // Zugriff auf die "enrol"-Tabelle, um den Einschreibeschlüssel zu setzen
        // Prüfen, ob bereits eine self-enrolment-Instanz existiert
        $enrol = $DB->get_record('enrol', ['courseid' => $courseid, 'enrol' => 'self']);

        if ($enrol) {
            // Aktualisieren der vorhandenen Instanz
            $enrol->password = $enrolkey;
            $DB->update_record('enrol', $enrol);
            mtrace('Einschreibeschlüssel aktualisiert: ' . $enrolkey);
        } else {
            // Erstellen einer neuen self-enrolment-Instanz
            $selfplugin = enrol_get_plugin('self');
            if ($selfplugin) {
                $instanceid = $selfplugin->add_instance($course, [
                    'status' => ENROL_INSTANCE_ENABLED,
                    'name' => 'Selbsteinschreibung',
                    'password' => $enrolkey,
                    'customint1' => 0, // Unbeschränkte Plätze
                    'customint2' => 0, // Kein Begrüßungstext
                    'customint3' => 0, // Max. Einschreibedauer (0 = unbegrenzt)
                    'customint4' => 1, // Startdatum aktivieren
                    'customint5' => 0, // Enddatum deaktivieren
                    'customint6' => 1, // Neue Einschreibungen erlauben
                ]);
                mtrace('Neue Self-Enrolment-Instanz erstellt mit Schlüssel: ' . $enrolkey);
            }
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
