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
 * Plugin functions for local_enrolkeycreator.
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Fügt Navigationselemente zum Kurse-Menü hinzu, wenn vorhanden
 *
 * @param navigation_node $navigation Der Navigationsknoten, in den das Element eingefügt werden soll
 * @param stdClass $course Das Kursobjekt
 * @param context $context Der aktuelle Kontext
 */
function local_enrolkeycreator_extend_navigation_course(navigation_node $navigation, stdClass $course, context $context) {
    global $DB;

    // Nur für Nutzer mit der Berechtigung, die Einschreibemethoden zu verwalten
    if (has_capability('enrol/self:config', $context)) {
        // Prüfen, ob für diesen Kurs eine Self-Enrolment-Instanz existiert
        $enrol = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'self']);

        if ($enrol && !empty($enrol->password)) {
            // Ein Link, um den aktuellen Einschreibeschlüssel anzuzeigen
            $url = new moodle_url('/enrol/instances.php', ['id' => $course->id]);
            $navigation->add(
                get_string('pluginname', 'local_enrolkeycreator'),
                $url,
                navigation_node::TYPE_SETTING,
                null,
                'enrolkeycreator'
            );
        }
    }
}
