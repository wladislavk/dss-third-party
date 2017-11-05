Feature: Show and edit tasks in dashboard and header

  # @todo: lines below will not work in Vue until add tasks and manage tasks pages are routed to legacy
  # Scenario: Manage tasks
    # When I run mouse over task "call for fu (John Drake)" in "dashboard"
    # And I click "edit" button next to task "call for fu (John Drake)" in "dashboard"
    # Then I see add task form with header "Add new task (John Drake)"
    # And the "Task" form field is filled with value "call for fu"
    # When I close the iframe
    # When I click button with text "View All"
    # Then I see "Manage Tasks" table

  Scenario: View header tasks
    Given I am logged in as "doc1f"
    When I go to "start" page
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
