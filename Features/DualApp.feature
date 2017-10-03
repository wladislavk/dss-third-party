Feature: Dual legacy / Vue app authentication and navigation
  In order to use app that has some pages in legacy PHP and main page and login page in SPA-style Vue
  As a user who is authenticated in Vue only
  I want to freely navigate between legacy and Vue pages without having to re-authenticate

  Scenario: Authenticate in Vue, move to legacy and back to Vue
    Given these pages are in Vue:
      | page           |
      | Login          |
      | Main           |
      | Pending Claims |
    And these pages are in legacy:
      | page            |
      | Device Selector |
    And user "user" exists and has password "pass"
    When I go to start page
    Then I see login form
    When I type in "user" as login and "pass" as password
    Then I see main page with welcome text for user "user"
    When I click on "Pending Claims" in notifications menu
    Then I see claims table with following sections:
      | section          |
      | Pending Claims   |
      | Submitted Claims |
    When I click on "Device Selector" menu point
    Then I see device selection sliders:
      | name               |
      | Comfort            |
      | Bruxism            |
      | Tongue             |
      | Bite               |
      | Lower Molars       |
      | Nasal Patency      |
      | Joint Problems     |
      | Retention of Teeth |
      | Patient Dexterity  |
      | Cost               |
    When I click on "Pending Claims" in notifications menu
    Then I see claims table with following sections:
      | section          |
      | Pending Claims   |
      | Submitted Claims |

  Scenario: Accessing Vue page without prior auth redirects to Vue login page
    Given these pages are in Vue:
      | page           |
      | Login          |
      | Main           |
      | Pending Claims |
    And these pages are in legacy:
      | page            |
      | Device Selector |
    And user "user" exists and has password "pass"
    When I go to "Pending Claims" page
    Then I see login form

  Scenario: Accessing legacy page without prior Vue auth redirects to Vue login page
    Given these pages are in Vue:
      | page           |
      | Login          |
      | Main           |
      | Pending Claims |
    And these pages are in legacy:
      | page            |
      | Device Selector |
    And user "user" exists and has password "pass"
    When I go to "Device Selector" page
    Then I see login form
