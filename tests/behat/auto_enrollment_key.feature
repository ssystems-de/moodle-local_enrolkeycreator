@local @local_enrolkeycreator
Feature: Automatic enrollment key creation
  In order to secure course enrollment
  As a teacher or administrator
  I need automatic enrollment key creation for self enrollment methods

  @javascript
  Scenario Outline: Self enrollment method should (not) get an enrollment key
    Given the following config values are set as admin:
      | enabled         | <pluginsetting> | local_enrolkeycreator |
      | requirepassword | <coresetting>   | enrol_self            |
    When I log in as "admin"
    And I navigate to "Courses > Add a new course" in site administration
    And I set the following fields to these values:
      | Course full name  | Course 1   |
      | Course short name | C1         |
      | Course category   | Category 1 |
    And I press "Save and display"
    And I am on the "Course 1" "enrolment methods" page
    And I click on "Edit" "link" in the "Self enrolment (Student)" "table_row"
    Then the field "Enrolment key" <matchornot> value ""

    Examples:
      | coresetting | pluginsetting | matchornot     |
      | 0           | 0             | matches        |
      | 0           | 1             | does not match |
      | 1           | 0             | does not match |
      | 1           | 1             | does not match |
