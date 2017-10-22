Feature: Dashboard
  In order to view navigation menu, notifications, tasks and messages
  As a user
  I want to have the dashboard on main page that shows a lot of stuff to me

  Scenario: View navigation
    Given I am logged in as "doc1f"
    When I go to "start" page
    # todo: move this to header test
    # Then I see right top bar with following links:
    #  | text               |
    #  | Notifications(354) |
    #  | Support (5)        |
    #  | Sign Out           |
    Then I see "Navigation" dashboard section
    And navigation menu contains the following links:
      | name             |
      | Directory        |
      | Reports          |
      | Admin            |
      | Pt. Screener App |
      | Forms            |
      | Education        |
      | SW Tutorials     |
      | Scheduler        |
      | Manage Pts       |
      | Device Selector  |
    When I run mouse over "Directory" navigation point
    Then I see navigation sub-menu for "Directory" with the following links:
      | name               |
      | Contacts           |
      | Referral List      |
      | Sleep Labs         |
      | Corporate Contacts |
    When I run mouse over "Reports" navigation point
    Then I see navigation sub-menu for "Reports" with the following links:
      | name             |
      | Ledger           |
      | Claims (6)       |
      | Performance      |
      | Pt. Screener     |
      | VOB History      |
      | Invoices         |
      | Fax History      |
      | Home Sleep Tests |
    When I run mouse over "Admin" navigation point
    Then I see navigation sub-menu for "Admin" with the following links:
      | name             |
      | Claim Setup      |
      | Profile          |
      | Text             |
      | Change List      |
      | Transaction Code |
      | Staff            |
      | Scheduler        |
      | Export MD        |
      | DSS Files        |
      | Manage Locations |
      | Data Import      |
      | Enrollments      |
    When I run mouse over "Text" sub-point for "Admin" navigation point
    Then I see navigation sub-sub-menu for "Text" under "Admin" with the following links:
      | name           |
      | Custom Text    |
      | Custom Letters |
    When I run mouse over "Scheduler" sub-point for "Admin" navigation point
    Then I see navigation sub-sub-menu for "Scheduler" under "Admin" with the following links:
      | name              |
      | Resources         |
      | Appointment Types |
    When I run mouse over "DSS Files" sub-point for "Admin" navigation point
    Then I see navigation sub-sub-menu for "DSS Files" under "Admin" with the following links:
      | name       |
      | Final test |
      | test 2     |
    When I run mouse over "Education" navigation point
    Then I see navigation sub-menu for "Education" with the following links:
      | name                                     |
      | Dental Sleep Solutions Procedures Manual |
      | Dental Sleep Medicine Manual             |
      | Quick Facts Reference                    |
      | Watch Videos                             |
      | Get C.E.                                 |
      | Certificates                             |

  Scenario: View notifications
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see "Notifications" dashboard section
    And notifications list contains the following data:
      | text                 | color |
      | 5 Web Portal         | red   |
      | 250 Letters          | red   |
      | 130 Unmailed Letters | red   |
      | 6 VOBs               | green |
      | 4 HSTs               | green |
      | 1 Unsent HSTs        | red   |
      | 6 Pending Claims     | red   |
      | 71 Unmailed Claims   | red   |
      | 3 Rejected Claims    | red   |
      | 8 Unsigned Notes     | red   |
      | 9 Pending Duplicates | red   |
      | 1 Payment Reports    | red   |
    And I see "Show All" link
    When I click "Show All" link
    Then notifications list contains the following data:
      | text                 | color |
      | 5 Web Portal         | red   |
      | 250 Letters          | red   |
      | 130 Unmailed Letters | red   |
      | 6 VOBs               | green |
      | 4 HSTs               | green |
      | 0 Rejected HSTs      | blue  |
      | 1 Unsent HSTs        | red   |
      | 6 Pending Claims     | red   |
      | 71 Unmailed Claims   | red   |
      | 3 Rejected Claims    | red   |
      | 8 Unsigned Notes     | red   |
      | 0 Alerts             | red   |
      | 0 Failed Faxes       | blue  |
      | 9 Pending Duplicates | red   |
      | 0 Email Bounces      | blue  |
      | 1 Payment Reports    | red   |
    And I see "Show Active" link
    When I run mouse over "5 Web Portal" notification
    Then I see notification sub-list for "5 Web Portal" with the following data:
      | text           | color |
      | 0 Pt Contacts  | red   |
      | 1 Pt Insurance | red   |
      | 4 Pt Changes   | red   |

  Scenario: View messages
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see "Messages" dashboard section
    And I see these messages:
      | message       |
      | Testing Again |
