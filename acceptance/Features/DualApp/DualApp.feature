Feature: Dual legacy / Vue app authentication and navigation
  In order to use app that has some pages in legacy PHP and main page and login page in SPA-style Vue
  As a user who is authenticated in Vue only
  I want to freely navigate between legacy and Vue pages without having to re-authenticate

  Scenario: Authenticate in Vue, move to legacy and back to Vue
    Given these pages are in Vue:
      | page      |
      | Login     |
      | Main      |
      | Tutorials |
    And these pages are in legacy:
      | page      |
      | Support   |
    And I am logged in as "doc1f"
    When I go to "start" page
    Then I see main page with welcome text for user "doc1f"
    And I see "SW Tutorials" link
    When I click "SW Tutorials" link
    Then I see "Software Tutorials and Training" text
    When I click on support link in top right bar
    Then I see "Open Tickets" support section that contains "3" pages and I am on page "1"
    When I click on logo in top left corner
    Then I see "Navigation" dashboard section

  Scenario: Verify session data
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see main page with welcome text for user "doc1f"
    When I click on "Letters" in notifications menu
    Then I see the following filter letter type list:
      | type                                            |
      |                                                 |
      | 2 - Intro Ltr to MD from Franchisee             |
      | 3 - Intro Ltr To DSS Pt of Record               |
      | 4 - Cover Ltr for Sleep Screening Questionnaire |
      | 5 - Welcome Ltr EMail                           |
      | 6 - Welcome Ltr Mail                            |
      | 7 - TY MD Referral Pt Not Candidate             |
      | 8 - To Pt Did Not Accept Treatment              |
      | 9 - TY MD Referral                              |
      | 10 - TY MD Referral Pt Waiting On               |
      | 11 - TY MD Referral Pt Did Not Accept Treatment |
      | 12 - TY MD Referral Pt Did Not Come In          |
      | 13 - To MD Mutual Pt Plan to Treat              |
      | 14 - SOAP Cover Ltr to Pt                       |
      | 15 - SOAP to MD and Pt                          |
      | 16 - Progress Note to MD and Pt                 |
      | 17 - Progress Note to MD and Pt Non Compliance  |
      | 18 - Progress Note to Pt Non Compliance         |
      | 19 - Ltr To MD and Pt after HST                 |
      | 20 - Ltr To Pt Treatment Complete               |
      | 21 - To Pt Annual Follow Up                     |
      | 22 - Appeal to Insurance Company                |
      | 23 - Thirty Month Follow Up                     |
      | 24 - Thank you Pat. Referral                    |
      | 25 - Pat. Termination                           |
      | 178 - Pedo Referral                             |
