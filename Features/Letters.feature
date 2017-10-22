Feature: Manage Letters
  In order to be able to create, edit, view and send letters
  As a user
  I want to have a page for managing pending letters

  Scenario: Manage letters
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I click on "Letters" in notifications menu
    Then I see list of "285" pending letters
    And I see that I have "415" letters to review
    And I see list that contains "29" pages and I am on page "1"
    And I see letter data:
      | name             | correspondence                             | to                | method | date       |
      | LASTNAME R, TEST | TY MD Referral Pt Did Not Come In          | Doe, Dr. John     | fax    | 05/22/2011 |
      | LASTNAME R, TEST | SOAP to MD and Pt                          | 4 Contacts        | paper  | 05/23/2011 |
      | ,                | TY MD Referral Pt Not Candidate            | 2 Contacts        | paper  | 05/27/2011 |
      | ,                | TY MD Referral Pt Did Not Accept Treatment | FAIL-FAX, Dr. Joe | fax    | 06/16/2011 |
      | ,                | Progress Note to MD and Pt Non Compliance  | 3 Contacts        | paper  | 06/17/2011 |
      | ,                | To Pt Did Not Accept Treatment             | 3 Contacts        | paper  | 06/21/2011 |
      | ,                | Intro Ltr To DSS Pt of Record              | No Contacts       | paper  | 06/27/2011 |
      | ,                | Intro Ltr To DSS Pt of Record              | No Contacts       | paper  | 06/27/2011 |
      | ,                | Progress Note to MD and Pt Non Compliance  | 3 Contacts        | paper  | 06/27/2011 |
      | LASTNAME R, TEST | Welcome Ltr EMail                          | 2 Contacts        | paper  | 07/04/2011 |
    When I click on letter number "10" in the list
    Then I see that the letter contains "3" pages
    And I see "Edit Letter" button above page "1" of letter
    When I click button with text "Edit Letter" above page "1" of letter
    Then I see that page "1" of letter displays MCE editor
    And I see "Send Letter" button above page "1" of letter
    #When I click button with text "Send Letter" above page "1" of letter
    #Then I see letter preview frame
    #And I see button with text "Looks good! SEND!"

  Scenario: Manage custom letters
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Admin" menu point
    Then I see "Text" link
    When I run mouse over "Text" submenu point
    Then I see "Custom Letters" link
    When I click "Custom Letters" link
    Then I see custom letter list:
      | name                         |
      | Nathan Custom 130701         |
      | test custom dates in tracker |
      | ALL VARIABLES                |
    And I see add button with text "Add New Template"
    When I click add button with text "Add New Template"
    Then I see letter template list with "29" templates
