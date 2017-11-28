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
