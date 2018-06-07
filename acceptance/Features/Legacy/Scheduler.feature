Feature: Scheduler

  Scenario: View calendar
    Given I am logged in as "doc1f"
    When I go to "Scheduler" page
    Then I see "Impressions, RECURRING New event" scheduler event