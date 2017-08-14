Feature: Patient Screener
  In order to manage patient screeners
  As a user
  I want to be able to view patient screeners page

  Scenario: View patient screeners
    Given I am logged in as "doc1f"
    When I visit start page
    And I run mouse over "Reports" menu point
    Then I see "Pt. Screener" link
    When I click "Pt. Screener" link
    Then I see "Manage Patient Screeners" page
    And I see list that contains "6" pages and I am on page "1"
    And patient screeners list shows not contacted patients only
    And patient screeners list has following columns:
      | name        |
      | Date        |
      | Patient     |
      | Phone       |
      | Risk        |
      | CPAP        |
      | Epworth     |
      | Results     |
      | HST         |
      | Screened By |
      | Contacted   |
    When I click on view results link for patient number "1" in patient screeners list
    Then I see patient screener data for patient number "1" with sections:
      | name                     |
      | Epworth Sleepiness Score |
      | Health Symptoms          |
      | Co-morbidity             |
    And patient screener list has following risk levels:
      | patient | risk     | color  |
      | 1       | Severe   | red    |
      | 11      | Low      | green  |
      | 14      | Moderate | yellow |
