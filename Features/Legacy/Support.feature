Feature: Support page
  In order to view my tickets and create new tickets
  As a user
  I want to have support page

  Scenario: View and manage tickets
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I click on support link in top right bar
    Then I see "Open Tickets" support section that contains "3" pages and I am on page "1"
    And I see the following tickets in "Open Tickets" support section:
      | title                                  | body                             | company                | date       | status | action              | background |
      | sending ticket to doc1 account from BO | test                             | Insurance & Billing    | 01/20/2016 | Open   | View \| Mark Read   | blue       |
      | test sw admin ticket BO                | test sw admin ticket BO          | DSS                    | 01/20/2016 | Open   | View \| Mark Read   | blue       |
      | test from billing basic BO             | test from billing basic BO       | Insurance & Billing    | 01/19/2016 | Open   | View \| Mark Read   | blue       |
      | testing ticket from super              | test                             | Dental Sleep Solutions | 10/01/2014 | Open   | View \| Mark Read   | blue       |
      | testing co assignment                  | test billing and insurance data. | Insurance & Billing    | 10/01/2014 | Open   | View \| Mark Read   | blue       |
      | Test 123                               | Test 21345                       | Insurance & Billing    | 09/29/2014 | Open   | View                | white      |
      | fghjghj                                | ghjghjghj                        | Dental Sleep Solutions | 09/22/2014 | Open   | View \| Mark Unread | white      |
      | test                                   | lkdzjflzkd                       | Dental Sleep Solutions | 02/07/2014 | Open   | View                | white      |
      | test                                   | wlahselt                         | Dental Sleep Solutions | 02/07/2014 | Open   | View                | white      |
      | teestzlxjvz                            | lkdfg                            | Dental Sleep Solutions | 02/07/2014 | Open   | View                | white      |
    And I see "Closed Tickets" support section that contains "1" pages and I am on page "1"
    And I see the following tickets in "Closed Tickets" support section:
      | title | body        | company                | date       | status | action | background |
      | test  | jlkfajsdklf | Dental Sleep Solutions | 02/07/2014 | Closed | View   | white      |
      |       |             | Dental Sleep Solutions | 06/16/2013 | Closed | View   | white      |
    When I press button that goes to last page in "Open Tickets" support section
    Then I see "Open Tickets" support section that contains "3" pages and I am on page "3"
    And I see the following tickets in "Open Tickets" support section:
      | title                | body                 | company                | date       | status | action | background |
      | patient VOB question | asfkj;lskj ;lkjfsadf | Dental Sleep Solutions | 06/20/2013 | Open   | View   | white      |
    And I see add button with text "Add New Ticket"
    When I click add button with text "Add New Ticket"
    Then I see add ticket form:
      | field      | type     |
      | Category   | select   |
      | Send To    | select   |
      | Title      | text     |
      | Message    | textarea |
      | Attachment | file     |
