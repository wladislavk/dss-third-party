Feature: Software tutorials

  Scenario: View software tutorials
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see "SW Tutorials" link
    When I click "SW Tutorials" link
    Then I see "Software Tutorials and Training" text
