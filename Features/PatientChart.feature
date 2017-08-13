Feature: Patient Chart
  In order to view patient information
  As a user
  I want to be able to access patient chart page

  Scenario: View patient chart
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see patient search form
    When I type "smi" into patient search form
    Then I see list of patients in search form:
      | name          |
      | Smith, John M |
      | Smith, Johnny |
      | Smith, Pat    |
      | Smith, John   |
      | Smith, John   |
      | Smith, John   |
    When I click on "Smith, Pat" in list of patients
    Then I see patient chart for "Pat Smith"
    And patient chart has menu with following points:
      | name           |
      | Tracker        |
      | Summary Sheet  |
      | Ledger         |
      | Insurance      |
      | Progress Notes |
      | Letters        |
      | Images         |
      | Questionnaire  |
      | Clinical Exam  |
      | Patient Info   |

  Scenario: Add patient
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see button with text "+ Add Patient"
    When I click button with text "+ Add Patient"
    Then I see add patient form
    When I fill add patient form with values:
      | field      | value          |
      | First Name | Susie          |
      | Last Name  | Test           |
      | Cell Phone | (941) 254-1111 |
#    And I click button with text "Add  Patient"
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
#    And I see "Send Registration Email" button

  Scenario: Download patient forms
    Given I am logged in as "doc1f"
    When I visit start page
    And I click on "Forms" menu point
    Then I can see following forms:
      | name                  |
      | Patient Notices       |
      | New Patient Form      |
      | Patient Questionnaire |
