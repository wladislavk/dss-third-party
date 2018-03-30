Feature: Patient Summary
  In order to view patient summary data
  As a user
  I want to have a page that would display patient complaints, history, sleep tests etc.

  Scenario: View patient summary
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I type "test" into patient search form
    And I click on "PATIENT, TEST" in list of patients
    And I click on "Summary Sheet" patient chart menu point
    Then I see summary left menu with these points:
      | name         |
      | SUMMARY      |
      | PROG NOTES   |
      | TREATMENT Hx |
      | HEALTH Hx    |
      | LETTERS      |
      | SLEEP TESTS  |
      | SUBJ TESTS   |
    Then I see patient summary subpoints:
      | name               |
      | Contact            |
      | Complaints         |
      | History            |
      | Appt               |
      | Sleep Tests        |
      | CPAP               |
      | Medical Caregivers |
      | Notes/Personal     |
# @todo: Fix JS in legacy to test it
#    When I click on "SLEEP TESTS" patient summary left menu point
#    Then I see "Patient has no completed sleep studies" text
#    And I see input button with text "+ Add Sleep Study"
#    When I click input button with text "+ Add Sleep Study"
#    Then I see add sleep study form:
#      | field            | type   | required |
#      | Date             | date   | no       |
#      | Sleep Test Type  | select | no       |
#      | Place            | select | no       |
#      | Diagnosis        | select | yes      |
#      | Diagnosing Phys. | text   | no       |
#      | Diagnosing NPI#  | text   | no       |
#      | File             | file   | yes      |
#      | AHI              | text   | no       |
#      | AHI Supine       | text   | no       |
#      | RDI              | text   | no       |
#      | RDI Supine       | text   | no       |
#      | O2 Nadir         | text   | no       |
#      | T <= 90% O2      | text   | no       |
#      | Dental Device    | select | no       |
#      | Device Setting   | text   | no       |
#      | Notes            | text   | no       |
#    When I click on "LETTERS (1)" patient summary left menu point
#    Then I see "Pending Letters" letter table
#    And "Pending Letters" letter table contains data:
#      | Correspondence                            | Sent To           | Generated On |
#      | Progress Note to MD and Pt Non Compliance | Mr. PATIENT, TEST | 10/13/2015   |
#    And I see "Sent Letters" letter table
#    And "Sent Letters" letter table is empty
#    And I see add button with text "Create New Letter"
#    When I click add button with text "Create New Letter"
#    Then I see letter template selector
#    When I select "C1 - Nathan Custom 130701" option in letter template selector
#    Then I see select contacts checkbox list:
#      | name                      |
#      | Patient: Mr. TEST PATIENT |
#    And I see add button with text "Create Letter"

  Scenario: View sleep tests
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I type "drake" into patient search form
    And I click on "Drake, John S" in list of patients
    And I click on "Summary Sheet" patient chart menu point
    Then I see summary left menu with these points:
      | name         |
      | SUMMARY      |
      | PROG NOTES   |
      | TREATMENT Hx |
      | HEALTH Hx    |
      | LETTERS      |
      | SLEEP TESTS  |
      | SUBJ TESTS   |
    When I click on "SLEEP TESTS" patient summary left menu point
    Then I see the following sleep tests:
      | Date       | Sleep Test Type | Place       | Diagnosis                      | Diagnosing Phys.   | Diagnosing NPI# | File | AHI | AHI Supine | RDI | RDI Supine | O2 Nadir | T  90% O2 | Dental Device        | Device Setting | Notes                |
      | 12/11/2015 | HST Baseline    | test dup3   | 327.23 Obstructive Sleep Apnea | TestingSS Dropdown | 5555555555      | x    | 11  |            |     |            |          |           |                      |                |                      |
      | 08/08/2015 | HST Baseline    | Home        | 327.23 Obstructive Sleep Apnea | TestingSS Dropdown | 5555555555      | x    | xx  | xx         | xx  | xx         | xx       | xx        | Dorsal Flex          | xx             | xx                   |
      | 06/30/2013 | HST Titration   | Sleep Lab 1 | 327.23 Obstructive Sleep Apnea | Testing Ffnew      | 789789789       |      | 12  |            |     |            |          |           | SUAD Hard            |                |                      |
      | 05/30/2013 | HST Titration   |             | 327.23 Obstructive Sleep Apnea |                    |                 |      | 12  |            |     |            | 90       |           | EMA                  | 18B            |                      |
      | 04/08/2013 | HST Titration   | Sleep Lab 2 | 327.23 Obstructive Sleep Apnea |                    | 5555555555      | x    | 5   | 6          | 5   | 9          | 90%      | 0.1%      | SUAD Hard            | +3 GG          | Rem AHI 30           |
      | 05/02/2011 | PSG Baseline    | Sleep Lab 1 | 327.23 Obstructive Sleep Apnea | Smith              | 23393939        | x    | 28  | 39         | 34  | 42         | 82       | 2.5%      |                      |                | Poor slep effeciency |
