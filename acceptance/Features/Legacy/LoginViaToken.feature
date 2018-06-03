Feature: Login via token

  Scenario: Invalid token fails login
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I go to "Inner Page with Invalid Token" page
    Then I see login form

  Scenario: Remove invalid token after regular login
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I go to "Inner Page with Invalid Token" page
    Then I see login form
    When I type in "doc1f" as login and "cr3at1vItY" as password
    Then I see "Inner Page with No Token" page url
    And I see main page with welcome text for user "doc1f"
    And embedded token is "new"

  Scenario: Valid token success login
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I go to "Inner Page with Valid Token" page
    Then I see "Inner Page with Valid Token" page url
    And I see main page with welcome text for user "doc1f"
    And embedded token is "valid"
