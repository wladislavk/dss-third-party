Feature: Task Management
  In order to add tasks
  As a user
  I want to be able to add base tasks and tasks for patient

  Scenario: Add base task
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see button with text "+ Add Task"
    When I click button with text "+ Add Task"
    Then I see add task form with header "Add new task"
    And add task form has following fields:
      | field       | type     | required |
      | Task        | text     | yes      |
      | Due Date    | date     | yes      |
      | Assigned To | select   | yes      |
      | Completed   | checkbox | no       |

  Scenario: Add task for patient
    Given I am logged in as "doc1f"
    When I visit start page
    And I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    When I click button with text "+ Add Task"
    Then I see add task form with header "Add a task about Pat Smith"
