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
    And I add "Self enrolment" enrolment method with:
      | Custom instance name | Test self enrollment |
    And I click on "Edit" "link" in the "Self enrolment (Test self enrollment)" "table_row"
    Then the field "Enrolment key" does not match value ""

  @javascript
  Scenario: Self enrollment method should not get an enrollment key when plugin is disabled
    Given I log in as "admin"
    And I navigate to "Plugins > Enrolments > Manage enrol plugins" in site administration
    And I click on "Disable" "link" in the "Self enrolment" "table_row"
    And I am on the "Course 1" "enrolment methods" page
    And I add "Self enrolment" enrolment method with:
      | Custom instance name | Test self enrollment |
      | Enrolment key        |                      |
    And I click on "Edit" "link" in the "Self enrolment (Test self enrollment)" "table_row"
    Then the field "Enrolment key" matches value ""
