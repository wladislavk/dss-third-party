Feature: Task Management
  In order to add tasks
  As a user
  I want to be able to add base tasks and tasks for patient

  Scenario: Add base task
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see button with text "+ Add Task"
    And the modal window is "closed"
    When I click button with text "+ Add Task"
    Then the modal window is "open"
    And I see add task form with header "Add new task"
    And add task form has following fields:
      | field       | type     | required |
      | Task        | text     | yes      |
      | Due Date    | date     | yes      |
      | Assigned To | select   | yes      |
      | Completed   | checkbox | no       |
    When I fill task form with values:
      | field       | type     | value     |
      | Task        | text     | Test task |
      | Due Date    | date     | today     |
      | Assigned To | select   | Doctor 1  |
      | Completed   | checkbox | No        |
    And I click add button with text "Add Task"
    Then the modal window is "closed"
    And I see these task sub-sections in "dashboard":
      | section  |
      | Overdue  |
      | Today    |
    And I see checkboxes with these tasks under "Today" section in "dashboard":
      | task      |
      | Test task |

  Scenario: Edit task
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then the modal window is "closed"
    And I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    When I run mouse over task "call for fu (John Drake)" in "dashboard"
    And I click "edit" button next to task "call for fu (John Drake)" in "dashboard"
    Then the modal window is "open"
    And I see add task form with header "Add new task (John Drake)"
    And add task form is filled with values:
      | field       | type     | value        |
      | Task        | text     | call for fu  |
      | Due Date    | text     | 03/06/2014   |
      | Assigned To | select   | Doctor 1     |
      | Completed   | checkbox | No           |
    When I fill task form with values:
      | field       | type     | value        |
      | Task        | text     | call for bar |
      | Due Date    | date     | today        |
      | Assigned To | select   | Doctor 1     |
      | Completed   | checkbox | No           |
    And I click add button with text "Add Task"
    Then the modal window is "closed"
    And I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | asdasdasd                                   |
    And I see checkboxes with these tasks under "Today" section in "dashboard":
      | task                                        |
      | call for bar (John Drake)                   |

  Scenario: Delete task from modal
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see checkboxes with these tasks under "Overdue" section in "dashboard":
      | task                                        |
      | Set up webinar for Dr. X software training. |
      | call for fu (John Drake)                    |
      | asdasdasd                                   |
    When I run mouse over task "asdasdasd" in "dashboard"
    And I click "edit" button next to task "asdasdasd" in "dashboard"
    Then the modal window is "open"
    When I click delete task link for "asdasdasd"
    And I confirm browser alert
    Then the modal window is "closed"
    #And I see checkboxes with these tasks under "Overdue" section in "dashboard":
    #  | task                                        |
    #  | Set up webinar for Dr. X software training. |
    #  | call for fu (John Drake)                    |

  # todo: this scenario will not pass in Vue until patient menu is migrated
  # Scenario: Add task for patient
    # Given I am logged in as "doc1f"
    # When I go to "start" page
    # Then I see patient search form
    # When I type "smi" into patient search form
    # And I click on "Smith, Pat" in list of patients
    # When I click button with text "+ Add Task"
    # Then I see add task form with header "Add a task about Pat Smith"
