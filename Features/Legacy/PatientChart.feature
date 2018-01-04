Feature: Patient Chart
  In order to view patient information
  As a user
  I want to be able to access patient chart page

  Scenario: View patient chart
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    And I click on "Questionnaire" patient chart menu point
    Then I see questionnaire subpoints:
      | name                |
      | Symptoms            |
      | Previous Treatments |
      | Health Hx.          |
    When I click on "Images" patient chart menu point
    Then I see add button with text "Add New Image"
    When I click add button with text "Add New Image"
    Then I see add patient image form:
      | field            | type   | required |
      | Image Type       | select | yes      |
      | Title            | text   | yes      |
      | Image            | file   | yes      |

  Scenario: Add patient
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see button with text "+ Add Patient"
    When I click button with text "+ Add Patient"
    Then I see add patient form
    When I fill add patient form with values:
      | field      | value          |
      | First Name | Susie          |
      | Last Name  | Test           |
      | Cell Phone | (941) 254-1111 |
#    And I click button with text "Add Patient"
#    Then I see warning with text "Patient info is incomplete" and missing fields:
#      | field         |
#      | Address       |
#      | Date of Birth |
#      | Gender        |
#    When I click button with text "OK"
#    Then I see patient chart for "Susie Test"
#    And I see following patient info fields:
#      | field      | value          |
#      | First Name | Susie          |
#      | Last Name  | Test           |
#      | Cell Phone | (941) 254-1111 |
#    And I see send registration email button
