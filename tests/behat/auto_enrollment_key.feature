@local @local_enrolkeycreator
Feature: Automatic enrollment key creation
  In order to secure course enrollment
  As a teacher or administrator
  I need automatic enrollment key creation for self enrollment methods

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | 1        | teacher1@example.com |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And I log in as "admin"
    And I am on site homepage

  @javascript
  Scenario: Self enrollment method should automatically get an enrollment key when plugin is enabled
    Given I log in as "admin"
    And I am on the "Course 1" "enrolment methods" page
    And I click on "Edit" "link" in the "Self enrolment (Student)" "table_row"
    Then the field "Enrolment key" does not match value ""

  @javascript
  Scenario: Self enrollment method should not get an enrollment key when plugin is disabled
    Given I log in as "admin"
    And I navigate to "Plugins > Enrollment key creator settings" in site administration
    And I set the following fields to these values:
      | Enable automatic enrollment key creation | |
    And I press "Save changes"
    And I navigate to "Courses > Add a new course" in site administration
    And I set the following fields to these values:
      | Course full name  | Course 2             |
      | Course short name | C2                   |
      | Course category   | Category 1           |
    And I press "Save and display"
    And I am on the "Course 2" "enrolment methods" page
    And I click on "Edit" "link" in the "Self enrolment (Student)" "table_row"
    Then the field "Enrolment key" matches value ""
