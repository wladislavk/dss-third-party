Feature: Contacts
  In order to manage different kinds of contacts
  As a user
  I want to be able to view, add and edit contacts on a contacts page

  Scenario: View contacts
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Directory" menu point
    Then I see "Contacts" link
    When I click "Contacts" link
    Then I see "Manage Contact" page
    And I see list that contains "3" pages and I am on page "1"
    And I see add button with text "Add New Contact"
    When I click add button with text "Add New Contact"
    Then I see select contact type field that contains "Insurance" option
    When I select "Insurance" option for contact type
    Then I see add insurance company contact form
