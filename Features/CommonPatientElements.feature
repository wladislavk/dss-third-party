Feature: Common page patient elements
  In order to view patient menu and common patient data
  As a user
  I want to have common header section that shows on every patient-related page

  # @todo: this scenario cannot be tested in Vue until patient tracker is migrated
  Scenario: View common patient data
  When I click on "Smith, Pat" in list of patients
  Then I see patient chart for "Pat Smith" marked as "*Med"
  And I see "Hide Warnings" button in patient header
  When I click "Hide Warnings" button in patient header
  Then I see "Show Warnings" button in patient header
  And patient chart has menu with following points:
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
  And I see DSS logo in top left corner
  When I click DSS logo
  Then I see main page with welcome text for user "doc1f"
