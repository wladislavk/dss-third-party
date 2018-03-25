Feature: Education manuals

  Scenario: Check procedures manual
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Dental Sleep Solutions Procedures Manual" link
    When I click "Dental Sleep Solutions Procedures Manual" link
    Then I see dental sleep procedures manual
