Feature: Viewing claims
  In order to view all claims with sorting and filtering
  As a user
  I want to be able to access view claims page

  Scenario: View via pending claims link
    Given I am logged in as "doc1f"
    When I visit start page
    And I click on "Pending Claims" in notifications menu
    Then I see claims table with following sections:
      | section          |
      | Pending Claims   |
      | Submitted Claims |
    And "Pending Claims" claims table section contains add buttons:
      | button                     |
      | Show Claims w Notes        |
    And "Submitted Claims" claims table section contains add buttons:
      | button                     |
      | Show Claims w Notes        |
      | Show Unpaid Claims 30 day+ |
      | Show Unmailed Claims       |

  Scenario: View via unmailed claims link
    Given I am logged in as "doc1f"
    When I visit start page
    And I click on "Unmailed Claims" in notifications menu
    Then I see claims table with following sections:
      | section          |
      | Pending Claims   |
      | Unmailed Claims  |
    And "Unmailed Claims" claims table section contains add buttons:
      | button                     |
      | Show Claims w Notes        |
      | Show Unpaid Claims 30 day+ |
      | Show All                   |
