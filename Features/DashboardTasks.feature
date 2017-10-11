Feature: Show and edit tasks in dashboard and header

  Scenario: Dashboard tasks
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see "Tasks" dashboard section
    And I see these task sub-sections:
      | section |
      | Overdue |
    And I see checkboxes with these tasks under "Overdue" section:
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    When I click on task "Set up webinar for Dr. X software training." checkbox
    Then I see checkboxes with these tasks under "Overdue" section:
    And I see "My Tasks (2)" bullet in top menu
    When I run mouse over task "call for fu (John Drake)"
    Then I see "Edit" button
    When I click button with text "Edit"
    Then I see an iframe with header "Add new task (John Drake)"
    And the "Task" form field is filled with value "call for fu"
    When I close the iframe
    Then I see "View all" button
    When I click "View all" button
    Then I see "Manage Tasks" table

  Scenario: View header tasks
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see "My Tasks (3)" bullet in top menu
    When I run mouse over "My Tasks (3)" bullet in top menu
    Then I see these task sub-sections:
      | section |
      | Overdue |
    And I see checkboxes with these tasks under "Overdue" section:
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |

  # Scenario: View patient tasks
    # @todo: add task menu test for patient John Drake
