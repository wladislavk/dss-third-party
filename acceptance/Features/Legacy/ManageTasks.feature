Feature: Task Management from Manage Tasks page
  In order to add tasks
  As a user
  I want to be able to manage tasks from Manage Tasks page

  Background:
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I click "View All" button in Tasks section

  Scenario: Display Manage Tasks page
    Then I see "Manage Tasks" page
    And I see the list of tasks:
      | name                                                     | due_date | assigned_to               |
      | asdasdasd                                                | Overdue  | Doctor 1                  |
      | call pt and see if hes ready to sch for imp (John Drake) | Overdue  | Nathan TestStaffDoc1Stage |
      | call for fu (John Drake)                                 | Overdue  | Doctor 1                  |
      | call pt back to rs consult (Suzie Test)                  | Overdue  | Miss TellsMeWhatToDo      |
      | Set up webinar for Dr. X software training.              | Overdue  | Doctor 1                  |
      | get lomn (Reg Test)                                      | Overdue  | Staff 3 Doc 1             |
      | satff assignment                                         | Overdue  | Staff 1 Doc 1             |
      | Very important task 1                                    | Overdue  | Doctor 1                  |
      | Very important task 2                                    | Overdue  | Doctor 1                  |
      | Very important task 3                                    | Overdue  | Doctor 1                  |
    And I see the list of completed tasks:
      | name                                          | due_date   | assigned_to   |
      | Schedule follow-up visit (aaron anderson)     | 12/30/2014 | Doctor 1      |
      | call patient (John Drake)                     | 10/13/2014 | Doctor 1      |
      | Review HST (John Drake)                       | 02/17/2014 | Doctor 1      |
      | Call patient to schedule a HST (John Doe2)    | 02/06/2014 | Doctor 1      |
      | Call patient to get a HST (John Drake)        | 02/06/2014 | Doctor 1      |
      | Call patient to get a HST change (John Drake) | 02/06/2014 | Doctor 1      |
      | Add general task test                         | 02/06/2014 | Doctor 1      |
      | order HST (John Drake)                        | 01/25/2014 | Staff 3 Doc 1 |
      | review HST (John Drake)                       | 01/24/2014 | Staff 3 Doc 1 |
      | vbvzvn (John Drake)                           | 01/23/2014 | Doctor 1      |

  Scenario: Paginate tasks
    Then I see the list of tasks has "2" pages
    And I see the list of completed tasks has "8" pages
    When I click "2" pagination link above incomplete tasks table
    And I click "3" pagination link above completed tasks table
    Then I see the list of tasks:
      | name                  | due_date | assigned_to |
      | Very important task 4 | Overdue  | Doctor 1    |
    And I see the list of completed tasks:
      | name                                              | due_date   | assigned_to   |
      | review sleept test (Test ddxy)                    | 09/16/2013 | Staff 1 Doc 1 |
      | Review (John Drake)                               | 08/17/2013 | Staff 1 Doc 1 |
      | yyrkrklelrwe (John Drake)                         | 08/17/2013 | Staff 1 Doc 1 |
      | call pt in 2 weeks, see chart notes (John Drake)  | 08/07/2013 | Staff 1 Doc 1 |
      | Test Task (John Doe)                              | 07/16/2013 | Staff 3 Doc 1 |
      | Need to call patient and see how doing (John Doe) | 07/15/2013 | Staff 1 Doc 1 |
      | Check on HST equipment                            | 07/14/2013 | Staff 3 Doc 1 |
      | Check on HST equipment                            | 07/13/2013 | Doctor 1      |
      | did pt call back, see chart notes (John Drake)    | 07/03/2013 | Staff 3 Doc 1 |
      | call patient and check on symptoms (John Drake)   | 06/25/2013 | Staff 3 Doc 1 |

  Scenario: Sort tasks
    When I click "Task" column in tasks table
    And I click "Task" column in completed tasks table
    Then I see the list of completed tasks:
      | name                                                  | due_date   | assigned_to   |
      | (John Drake)                                          | 06/03/2013 | Staff 3 Doc 1 |
      | 11                                                    | 05/10/2012 | Doctor 1      |
      | 33                                                    | 05/10/2012 | Doctor 1      |
      | 55                                                    | 05/10/2012 | Doctor 1      |
      | 66                                                    | 05/10/2012 | Doctor 1      |
      | aaron task addition (aaron anderson)                  | 05/11/2012 | Doctor 1      |
      | Add general task test                                 | 02/06/2014 | Doctor 1      |
      | Call Dr. Cantaro regarding a new HST/PSG (John Drake) | 06/19/2013 | Staff 3 Doc 1 |
      | call Dr. Lewis                                        | 04/30/2013 | Doctor 1      |
      | call Dr. Lewis-changes                                | 06/13/2013 | Doctor 1      |

  Scenario: Display tasks that were assigned to me
    When I click add button with text "Assigned to me"
    Then I see the list of tasks:
      | name                                        | due_date | assigned_to |
      | asdasdasd                                   | Overdue  | Doctor 1    |
      | call for fu (John Drake)                    | Overdue  | Doctor 1    |
      | Set up webinar for Dr. X software training. | Overdue  | Doctor 1    |
      | Very important task 1                       | Overdue  | Doctor 1    |
      | Very important task 2                       | Overdue  | Doctor 1    |
      | Very important task 3                       | Overdue  | Doctor 1    |
      | Very important task 4                       | Overdue  | Doctor 1    |

    And I see the list of tasks has "1" pages
    And I see the list of completed tasks:
      | name                                          | due_date   | assigned_to |
      | Schedule follow-up visit (aaron anderson)     | 12/30/2014 | Doctor 1    |
      | call patient (John Drake)                     | 10/13/2014 | Doctor 1    |
      | Review HST (John Drake)                       | 02/17/2014 | Doctor 1    |
      | Call patient to schedule a HST (John Doe2)    | 02/06/2014 | Doctor 1    |
      | Call patient to get a HST (John Drake)        | 02/06/2014 | Doctor 1    |
      | Call patient to get a HST change (John Drake) | 02/06/2014 | Doctor 1    |
      | Add general task test                         | 02/06/2014 | Doctor 1    |
      | vbvzvn (John Drake)                           | 01/23/2014 | Doctor 1    |
      | kjlkjljk;kjkljjk                              | 12/09/2013 | Doctor 1    |
      | f/u with pt see chart (John Drake)            | 10/25/2013 | Doctor 1    |
    And I see the list of completed tasks has "4" pages

  Scenario: Add task
    When I click "Add Task" button in the main section
    Then the modal window is "open"
    And I see add task form with header "Add new task"
    And add task form has following fields:
      | field       | type     | required |
      | Task        | text     | yes      |
      | Due Date    | date     | yes      |
      | Assigned To | select   | yes      |
      | Completed   | checkbox | no       |
    When I fill task form on Manage Tasks page with values:
      | field       | type     | value                  |
      | Task        | text     | Not existing test task |
      | Due Date    | date     | today                  |
      | Assigned To | select   | Doctor 1               |
      | Completed   | checkbox | No                     |
    And I click add button in the modal with text "Add Task"
    Then the modal window is "closed"
    And I see the list of tasks:
      | name                                                     | due_date | assigned_to               |
      | Not existing test task                                   | Today    | Doctor 1                  |
      | asdasdasd                                                | Overdue  | Doctor 1                  |
      | call pt and see if hes ready to sch for imp (John Drake) | Overdue  | Nathan TestStaffDoc1Stage |
      | call for fu (John Drake)                                 | Overdue  | Doctor 1                  |
      | call pt back to rs consult (Suzie Test)                  | Overdue  | Miss TellsMeWhatToDo      |
      | Set up webinar for Dr. X software training.              | Overdue  | Doctor 1                  |
      | get lomn (Reg Test)                                      | Overdue  | Staff 3 Doc 1             |
      | satff assignment                                         | Overdue  | Staff 1 Doc 1             |
      | Very important task 1                                    | Overdue  | Doctor 1                  |
      | Very important task 2                                    | Overdue  | Doctor 1                  |

  Scenario: Edit task
    When I click "Edit" button next to task "call for fu (John Drake)" on Manage Tasks page
    Then the modal window is "open"
    And I see add task form with header "Add new task (John Drake)"
    And add task form is filled with values:
      | field       | type     | value       |
      | Task        | text     | call for fu |
      | Due Date    | text     | 03/06/2014  |
      | Assigned To | select   | Doctor 1    |
      | Completed   | checkbox | No          |
    When I fill task form on Manage Tasks page with values:
      | field       | type     | value        |
      | Task        | text     | call for bar |
      | Due Date    | date     | today        |
      | Assigned To | select   | Doctor 1     |
      | Completed   | checkbox | No           |
    And I click add button in the modal with text "Add Task"
    Then the modal window is "closed"
    And I see the list of tasks:
      | name                                                     | due_date | assigned_to               |
      | call for bar (John Drake)                                | Today    | Doctor 1                  |
      | asdasdasd                                                | Overdue  | Doctor 1                  |
      | call pt and see if hes ready to sch for imp (John Drake) | Overdue  | Nathan TestStaffDoc1Stage |
      | call pt back to rs consult (Suzie Test)                  | Overdue  | Miss TellsMeWhatToDo      |
      | Set up webinar for Dr. X software training.              | Overdue  | Doctor 1                  |
      | get lomn (Reg Test)                                      | Overdue  | Staff 3 Doc 1             |
      | satff assignment                                         | Overdue  | Staff 1 Doc 1             |
      | Very important task 1                                    | Overdue  | Doctor 1                  |
      | Very important task 2                                    | Overdue  | Doctor 1                  |
      | Very important task 3                                    | Overdue  | Doctor 1                  |

  Scenario: Complete task
    When I click checkbox next to task "Set up webinar for Dr. X software training." on Manage Tasks page
    And I click "Dashboard" link
    And I click "View All" button in Tasks section
    Then I see the list of tasks:
      | name                                                     | due_date | assigned_to               |
      | asdasdasd                                                | Overdue  | Doctor 1                  |
      | call pt and see if hes ready to sch for imp (John Drake) | Overdue  | Nathan TestStaffDoc1Stage |
      | call for fu (John Drake)                                 | Overdue  | Doctor 1                  |
      | call pt back to rs consult (Suzie Test)                  | Overdue  | Miss TellsMeWhatToDo      |
      | get lomn (Reg Test)                                      | Overdue  | Staff 3 Doc 1             |
      | satff assignment                                         | Overdue  | Staff 1 Doc 1             |
      | Very important task 1                                    | Overdue  | Doctor 1                  |
      | Very important task 2                                    | Overdue  | Doctor 1                  |
      | Very important task 3                                    | Overdue  | Doctor 1                  |
      | Very important task 4                                    | Overdue  | Doctor 1                  |

    And I see the list of completed tasks:
      | name                                          | due_date   | assigned_to   |
      | Schedule follow-up visit (aaron anderson)     | 12/30/2014 | Doctor 1      |
      | call patient (John Drake)                     | 10/13/2014 | Doctor 1      |
      | Review HST (John Drake)                       | 02/17/2014 | Doctor 1      |
      | Call patient to schedule a HST (John Doe2)    | 02/06/2014 | Doctor 1      |
      | Call patient to get a HST (John Drake)        | 02/06/2014 | Doctor 1      |
      | Call patient to get a HST change (John Drake) | 02/06/2014 | Doctor 1      |
      | Add general task test                         | 02/06/2014 | Doctor 1      |
      | order HST (John Drake)                        | 01/25/2014 | Staff 3 Doc 1 |
      | review HST (John Drake)                       | 01/24/2014 | Staff 3 Doc 1 |
      | vbvzvn (John Drake)                           | 01/23/2014 | Doctor 1      |

  Scenario: Delete task from modal
    When I click "Edit" button next to task "asdasdasd" on Manage Tasks page
    Then the modal window is "open"
    When I click delete task link for "asdasdasd" from Manage Tasks page
    And I confirm browser alert
    Then the modal window is "closed"
    And I see the list of tasks:
      | name                                                     | due_date | assigned_to               |
      | call pt and see if hes ready to sch for imp (John Drake) | Overdue  | Nathan TestStaffDoc1Stage |
      | call for fu (John Drake)                                 | Overdue  | Doctor 1                  |
      | call pt back to rs consult (Suzie Test)                  | Overdue  | Miss TellsMeWhatToDo      |
      | Set up webinar for Dr. X software training.              | Overdue  | Doctor 1                  |
      | get lomn (Reg Test)                                      | Overdue  | Staff 3 Doc 1             |
      | satff assignment                                         | Overdue  | Staff 1 Doc 1             |
      | Very important task 1                                    | Overdue  | Doctor 1                  |
      | Very important task 2                                    | Overdue  | Doctor 1                  |
      | Very important task 3                                    | Overdue  | Doctor 1                  |
      | Very important task 4                                    | Overdue  | Doctor 1                  |
