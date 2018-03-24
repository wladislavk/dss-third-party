Feature: Common page elements
  In order to view top menu and patient menu and use patient search form
  As a user
  I want to have common header section that shows on every non-login page

  Scenario: View header
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see main page with welcome text for user "doc1f"
    And I see company logo next to welcome text
    And I see right top bar with following links:
      | text               |
      | Notifications(354) |
      | Support (5)        |
      | Sign Out           |
    And I see left top bar with following links:
      | text               |
      | Scheduler          |
      | Snoozle/Help       |
      | Online CE          |
    And I see "My Tasks (3)" bullet in top menu
    When I run mouse over "My Tasks (3)" bullet in top menu
    Then I see these task sub-sections in "top menu":
      | section |
      | Overdue |
    # this step fails if tested without Selenium
    And I see checkboxes with these tasks under "Overdue" section in "top menu":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    And I see patient search form
    And I see buttons in patient search section:
      | text          |
      | + Add Patient |
      | + Add Task    |
    When I type "smi" into patient search form
    Then I see list of patients in search form:
      | name          |
      | Smith, John M |
      | Smith, Johnny |
      | Smith, Pat    |
      | Smith, John   |
      | Smith, John   |
      | Smith, John   |
