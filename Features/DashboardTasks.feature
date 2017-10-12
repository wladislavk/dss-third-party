Feature: Show and edit tasks in dashboard and header

  Scenario: Dashboard tasks
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see "Tasks" dashboard section
    And I see these task sub-sections in "dashboard":
      | section |
      | Overdue |
    And I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    And I see button with text "View All"
    When I click on task "Set up webinar for Dr. X software training." checkbox in "dashboard"
    Then I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    And I see "My Tasks (2)" bullet in top menu
    When I run mouse over task "asdasdasd" in "dashboard"
    Then I see "delete" button next to task "asdasdasd" in "dashboard"
    And I see "edit" button next to task "asdasdasd" in "dashboard"
    When I click "delete" button next to task "asdasdasd" in "dashboard"
    Then I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | call for fu (John Drake)                    |
    And I see "My Tasks (1)" bullet in top menu
    # @todo: lines below will not work in Vue until add tasks and manage tasks pages are routed to legacy
    # When I run mouse over task "call for fu (John Drake)" in "dashboard"
    # And I click "edit" button next to task "call for fu (John Drake)" in "dashboard"
    # Then I see add task form with header "Add new task (John Drake)"
    # And the "Task" form field is filled with value "call for fu"
    # When I close the iframe
    # When I click button with text "View All"
    # Then I see "Manage Tasks" table

  Scenario: View header tasks
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see "My Tasks (3)" bullet in top menu
    When I run mouse over "My Tasks (3)" bullet in top menu
    Then I see these task sub-sections in "top menu":
      | section |
      | Overdue |
    And I see checkboxes with these tasks under "Overdue" section in "top menu":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |

  # Scenario: View patient tasks
    # @todo: add task menu test for patient John Drake
