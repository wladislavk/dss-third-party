Feature: Staff
  In order to view, add and edit staff
  As a user
  I want to have a view staff page and edit staff form

  Scenario: Manage staff
    Given I am logged in as "doc1f"
    When I visit start page
    And I run mouse over "Admin" menu point
    Then I see "Staff" link
    When I click "Staff" link
    Then I see "Manage Staff" page
    And I see the staff list:
      | username         | name                      | producer | grey |
      | abertstaff       | staff Bert                | no       | no   |
      | DentalTest4.6.10 | Miss TellsMeWhatToDo      | no       | no   |
      | doc1staffStage   | Nathan TestStaffDoc1Stage | no       | no   |
      | FirstLast        | First Last                | no       | no   |
      | newEDXstaff      | edx test                  | no       | no   |
      | staff1doc1       | Staff 1 Doc 1             | no       | yes  |
      | staff3doc155     | Staff 3 Doc 1             | yes      | no   |
      | susan            | Susan LaValley            | no       | no   |
    And I see add button with text "Add New Staff"
    When I click add button with text "Add New Staff"
    Then I see add staff form:
      | field                            | type     | required |
      | Username                         | text     | yes      |
      | Password                         | text     | yes      |
      | First Name                       | text     | yes      |
      | Last Name                        | text     | yes      |
      | Email                            | text     | yes      |
      | Dentist/Producer                 | checkbox | no       |
      | Sign Progress Notes / Order HST? | checkbox | no       |
      | Use Course?                      | checkbox | no       |
      | Manage Staff/Codes?              | checkbox | no       |
      | Post Ledger Adjustments?         | checkbox | no       |
      | Edit Ledger Entries?             | checkbox | no       |
      | Status                           | select   | no       |
