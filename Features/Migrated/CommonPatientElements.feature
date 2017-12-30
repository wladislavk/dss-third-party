Feature: Common page patient elements
  In order to view patient menu and common patient data
  As a user
  I want to have common header section that shows on every patient-related page

  Scenario: View common patient data
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then I see the patient chart for "Pat Smith"
    And I see chart markings:
      | type | title                                   |
      | *Med | Pre-medication: Amoxil-Knee Replacement |
    And I see no medicare icon
    And I see no patient warnings
    And I see no patient tasks
    # @todo: uncomment after adding common element inside main content
    # And I see add button with text "Request HST" under patient menu
    And the patient chart has menu with the following points:
      | name           | active |
      | Tracker        | Yes    |
      | Summary Sheet  | No     |
      | Ledger         | No     |
      | Insurance      | No     |
      | Progress Notes | No     |
      | Letters        | No     |
      | Images         | No     |
      | Questionnaire  | No     |
      | Clinical Exam  | No     |
      | Patient Info   | No     |
    When I type "smi" into patient search form
    And I click on "Smith, John M" in list of patients
    Then I see the patient chart for "John Smith"
    And I see no chart markings
    And I see no medicare icon
    And I see no patient tasks
    # @todo: uncomment after adding common element inside main content
    # And I see a button with text "Order HST" under patient menu
    And I see patient warnings:
      | text                                                                                              |
      | Patient has the following Home Sleep Tests: HST was requested 12/22/2013 and is currently Pending |
    And I see "Hide Warnings" button in patient header
    When I click "Hide Warnings" button in patient header
    Then I see "Show Warnings" button in patient header
    And I see no patient warnings
    When I click "Show Warnings" button in patient header
    Then I see patient warnings:
      | text                                                                                              |
      | Patient has the following Home Sleep Tests: HST was requested 12/22/2013 and is currently Pending |
    When I type "dra" into patient search form
    And I click on "Drake, John S" in list of patients
    Then I see the patient chart for "John Drake"
    And I see medicare icon
    # @todo: uncomment after adding common element inside main content
    # And I see a button with text "Order HST" under patient menu
    And I see chart markings:
      | type  | title                                     |
      | Notes | Notes: test~!!@^&*(#$%*$^+&+_%)&+%_&)%_^( |
      | *Med  | Pre-medication: PenVK                     |
    Then I see patient task list with "2" tasks
    When I run mouse over patient task list
    Then I see these task sub-sections in "patient menu":
      | section |
      | Overdue |
    And I see checkboxes with these tasks under "Overdue" section in "patient menu":
      | task                                                     |
      | call for fu (John Drake)                                 |
      | call pt and see if hes ready to sch for imp (John Drake) |
    And I see patient warnings:
      | text                                                                                                                                                    |
      | Warning! Patient has the following rejected claims: 126 - 08/18/2015 180 - 01/19/2016                                                                   |
      | Patient has the following Home Sleep Tests: HST was requested 12/11/2015 and is currently Pending HST was requested 01/29/2016 and is currently Pending |
    # @todo: add a patient that is redirected to info
    When I click on logo in top left corner
    Then I see no patient chart
