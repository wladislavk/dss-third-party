Feature: Education manuals

  Background:
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Education" menu point

  Scenario: Check procedures manual
    Then I see "Dental Sleep Solutions Procedures Manual" link
    When I click "Dental Sleep Solutions Procedures Manual" link
    Then I see dental sleep procedures manual

  Scenario: Check medicine manual
    Then I see "Dental Sleep Medicine Manual" link
    When I click "Dental Sleep Medicine Manual" link
    Then I see dental sleep medicine manual

  Scenario: Check quick facts reference
    Then I see "Quick Facts Reference" link
    When I click "Quick Facts Reference" link
    Then I see quick facts reference

  Scenario: Check watch videos
    Then I see "Watch Videos" link
    When I click "Watch Videos" link
    Then I see videos education page

  Scenario: Check certificates
    Then I see "Certificates" link
    When I click "Certificates" link
    Then I see certificates education page
    And I see the list of certificates:
      | name                                                                   |
      | Course001 - Now - Section 1 - 1                                        |
      | DSS10 - Always - Module 1: Introduction / Getting Started - 1          |
      | DSS10 - Always - Module 2: Treatment Options - 1                       |
      | DSS10 - Always - Module 3: Screening - 1                               |
      | DSS10 - Always - Module 2: Treatment Options - 1                       |
      | DSS10 - Module 2: Treatment Options - Module 2 - 1                     |
      | DSS10 - Module 1: Introduction / Getting Started - Module One Quiz - 1 |
