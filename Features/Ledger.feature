Feature: Patient Ledger
  In order to view patient claims and create claims
  As a user
  I want to access a patient ledger page

  Scenario: File a claim
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see patient search form
    When I type "hav" into patient search form
    And I click on "Havell, John" in list of patients
    And I click on "Ledger" patient chart menu point
    Then I see ledger card for "Havell John"
    And I see ledger table with "83" records
    And total ledger data is as follows:
      | charges   | credits   | adjustments | balance   |
      | 62,789.89 | 12,891.98 | 556.00      | 49,341.91 |
    And I see add button with text "Add New Transaction"
    When I click add button with text "Add New Transaction"
    Then I see add transaction form with following fields:
      | field            | type   |
      | Service Date     | date   |
      | Entry Date       | date   |
      | Producer         | select |
      | Procedure Code   | select |
      | Transaction Code | text   |
      | Amount           | text   |
    When I select "Medical Code" as procedure code
    Then I see add transaction form with following fields:
      | field            | type   |
      | Service Date     | date   |
      | Entry Date       | date   |
      | Producer         | select |
      | Procedure Code   | select |
      | Transaction Code | select |
      | Amount           | text   |

  Scenario: Ledger Reports
    Given I am logged in as "doc1f"
    When I visit start page
    And I run mouse over "Reports" menu point
    Then I see "Ledger" link
    When I click "Ledger" link
    Then I see page with heading "Today's Ledger Report" and today's date
    And I see these ledger totals sections:
      | name        | total |
      | Charges     | $0.00 |
      | Credit      | $0.00 |
      | Adjustments | $0.00 |
    And I see table with columns:
      | name        |
      | Svc Date    |
      | Entry Date  |
      | Patient     |
      | Producer    |
      | Description |
      | Charges     |
      | Credits     |
      | Adjustments |
