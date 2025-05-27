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
    Given enrollment key creator is "enabled"
    And I navigate to "Plugins > Enrolments > Manage enrol plugins" in site administration
    And I am on "Course 1" course homepage
    And I navigate to "Users > Enrolment methods" in current page administration
    And I add "Self enrolment" enrolment method with:
      | Custom instance name | Test self enrollment |
    Then self enrollment method for course "Course 1" should have an enrollment key

  @javascript
  Scenario: Self enrollment method should not get an enrollment key when plugin is disabled
    Given enrollment key creator is "disabled"
    And I navigate to "Plugins > Enrolments > Manage enrol plugins" in site administration
    And I click on "Disable" "link" in the "Self enrolment" "table_row"
    And I am on "Course 1" course homepage
    And I navigate to "Users > Enrolment methods" in current page administration
    And I add "Self enrolment" enrolment method with:
      | Custom instance name | Test self enrollment |
      | Enrolment key | |
    Then self enrollment method for course "Course 1" should not have an enrollment key
