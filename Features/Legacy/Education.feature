Feature: Education manuals

  Scenario: Check procedures manual
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Dental Sleep Solutions Procedures Manual" link
    When I click "Dental Sleep Solutions Procedures Manual" link
    Then I see dental sleep procedures manual

  Scenario: Check medicine manual
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Dental Sleep Medicine Manual" link
    When I click "Dental Sleep Medicine Manual" link
    Then I see dental sleep medicine manual

  Scenario: Check quick facts reference
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Quick Facts Reference" link
    When I click "Quick Facts Reference" link
    Then I see quick facts reference

  Scenario: Check watch videos
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Watch Videos" link
    When I click "Watch Videos" link
    Then I see videos

  Scenario: Check certificates
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point
    Then I see "Certificates" link
    When I click "Certificates" link
    Then I see certificates


