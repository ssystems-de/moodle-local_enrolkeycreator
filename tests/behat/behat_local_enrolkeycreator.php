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
 * Behat steps for testing enrol_keycreator.
 *
 * @package    local_enrolkeycreator
 * @category   test
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

/**
 * Steps definitions for enrollment key creator plugin.
 *
 * @package    local_enrolkeycreator
 * @category   test
 * @copyright  2025 Andreas Rosenthal, ssystems GmbH <arosenthal@ssystems.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_local_enrolkeycreator extends behat_base {

    /**
     * Enable or disable the enrolkeycreator plugin.
     *
     * @Given /^enrollment key creator is ("enabled"|"disabled")$/
     * @param string $status "enabled" or "disabled"
     */
    public function enrollment_key_creator_is($status) {
        set_config('enabled', ($status === '"enabled"' ? 1 : 0), 'local_enrolkeycreator');
    }

    /**
     * Check if the self enrollment method has an enrollment key set.
     *
     * @Then /^self enrollment method for course "(?P<coursename_string>(?:[^"]|\\")*)" should have an enrollment key$/
     * @param string $coursename The course name
     */
    public function self_enrollment_method_should_have_key($coursename) {
        global $DB;

        // Get the course ID.
        $courseid = $DB->get_field('course', 'id', ['fullname' => $coursename]);
        if (!$courseid) {
            throw new Exception("Course '{$coursename}' does not exist");
        }

        // Get the self enrollment method.
        $enrolid = $DB->get_field('enrol', 'id', ['courseid' => $courseid, 'enrol' => 'self']);
        if (!$enrolid) {
            throw new Exception("Self enrollment method for course '{$coursename}' does not exist");
        }

        // Get the enrollment method record.
        $enrol = $DB->get_record('enrol', ['id' => $enrolid]);

        // Check if the password is set.
        if (empty($enrol->password)) {
            throw new Exception("Self enrollment method for course '{$coursename}' does not have an enrollment key set");
        }
    }

    /**
     * Check if the self enrollment method does not have an enrollment key set.
     *
     * @Then /^self enrollment method for course "(?P<coursename_string>(?:[^"]|\\")*)" should not have an enrollment key$/
     * @param string $coursename The course name
     */
    public function self_enrollment_method_should_not_have_key($coursename) {
        global $DB;

        // Get the course ID.
        $courseid = $DB->get_field('course', 'id', ['fullname' => $coursename]);
        if (!$courseid) {
            throw new Exception("Course '{$coursename}' does not exist");
        }

        // Get the self enrollment method.
        $enrolid = $DB->get_field('enrol', 'id', ['courseid' => $courseid, 'enrol' => 'self']);
        if (!$enrolid) {
            throw new Exception("Self enrollment method for course '{$coursename}' does not exist");
        }

        // Get the enrollment method record.
        $enrol = $DB->get_record('enrol', ['id' => $enrolid]);

        // Check if the password is not set.
        if (!empty($enrol->password)) {
            throw new Exception("Self enrollment method for course '{$coursename}' has an enrollment key set but it shouldn't");
        }
    }
}
