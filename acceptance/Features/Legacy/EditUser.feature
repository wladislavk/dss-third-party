Feature: Edit User

  Scenario: Delete Stripe data
    Given I am logged in as admin "admin"
    When I go to "admin start" page
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "Doctor 1" text
    And I see "doc1f" text
    When I click button with text "Edit"
    Then I see "Edit/Save Contact" text in admin popup window
    When I click button with text "Delete Stripe data" in admin popup window
    Then I see "Delete Stripe data success" text in admin popup window after delay
