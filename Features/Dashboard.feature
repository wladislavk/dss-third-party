Feature: Dashboard
  In order to view navigation menu, notifications, tasks and messages
  As a user
  I want to have the dashboard on main page that shows a lot of stuff to me

  Scenario: View dashboard
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see right top bar with following links:
      | text               |
      | Notifications(354) |
      | Support (5)        |
      | Sign Out           |
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
    And I see "Notifications" dashboard section
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
      | 7 Unsigned Notes     | red   |
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
      | 7 Unsigned Notes     | red   |
      | 0 Alerts             | red   |
      | 0 Failed Faxes       | blue  |
      | 9 Pending Duplicates | red   |
      | 0 Email Bounces      | blue  |
      | 1 Payment Reports    | red   |
    And I see "Show Active" link
    And I see "Messages" dashboard section
    And I see these messages:
      | message       |
      | Testing Again |
