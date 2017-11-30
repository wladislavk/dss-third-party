Feature: User login
  In order to check if auth is working
  As a user
  I want to be able to log in and out of the system

  Scenario: Correct login and log out
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I go to "start" page
    Then I see login form
    When I type in "doc1f" as login and "cr3at1vItY" as password
    Then I see main page with welcome text for user "doc1f"
    And I see "Sign Out" link
    When I click "Sign Out" link
    Then I see login form

  Scenario: Incorrect login
    Given user "foo" does not exist
    When I go to "start" page
    Then I see login form
    When I type in "foo" as login and "cr3at1vItY" as password
    Then I see auth error message

  Scenario: Incorrect password
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I go to "start" page
    Then I see login form
    When I type in "doc1f" as login and "qwerty" as password
    Then I see auth error message
