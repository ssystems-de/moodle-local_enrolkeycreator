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
 * Standardseite für das Plugin.
 *
 * @package    local_enrolkeycreator
 * @copyright  2025 Your Name <your.email@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// Grundlegende Seiteneinrichtung
$context = context_system::instance();
require_login();
require_capability('moodle/site:config', $context);

// Seitentitel, Navigation usw. einrichten
$PAGE->set_context($context);
$PAGE->set_url('/local/enrolkeycreator/index.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_enrolkeycreator'));
$PAGE->set_heading(get_string('pluginname', 'local_enrolkeycreator'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'local_enrolkeycreator'));

// Hauptinhalt der Seite
echo html_writer::div(get_string('pluginname', 'local_enrolkeycreator') . ' ist aktiv und überwacht Kurs-Erstellungen.');

// Ausgabe des Footers
echo $OUTPUT->footer();
