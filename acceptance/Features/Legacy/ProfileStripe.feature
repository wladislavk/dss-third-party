Feature: Manage Stripe Card

  Background:
    Given I am logged in as admin "admin"
    When I go to "admin start" page
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "Doctor 1" text
    And I see "doc1f" text
    When I click button with text "Edit"
    Then I see "Edit/Save Contact" text in popup window
    When I click button with text "Delete Stripe data for this user" in popup window
    Then I see marker "check" in button "Delete Stripe data for this user" in popup window
    When I click button with text "Close"
    And I run mouse over "NathanAdmin SuperStage" admin top menu point
    And I click "Log Out" link
    Then I see browser confirmation dialog with text "Logged out"
    When I confirm browser alert
    Then I see "Login to your DS3 account" text

  Scenario: Update cards
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Admin" menu point
    Then I see "Profile" link
    When I click "Profile" link
    Then I see "Manage Profile" page
    And I see "No card on record. Add" text
    When I click "Add" link
    And I fill in the following credit card details:
      | label                        | value            |
      | 1. Card Number:              | 4000000000000101 |
      | 2. Card CVC (security code): | 123              |
      | 3. Expiration Month (MM):    | 12               |
      | 4. Expiration Year (YYYY):   | 22               |
      | 5. Name on Card:             | Test Doc         |
      | 6. Card Zipcode:             | 12345            |
    And I click button with text "Save"
    Then I see browser alert with text "Your card's security code is incorrect." with delay
    When I confirm browser alert
    And I fill in the following credit card details:
      | label                        | value            |
      | 1. Card Number:              | 4000000000000002 |
      | 2. Card CVC (security code): | 123              |
      | 3. Expiration Month (MM):    | 12               |
      | 4. Expiration Year (YYYY):   | 22               |
      | 5. Name on Card:             | Test Doc         |
      | 6. Card Zipcode:             | 12345            |
    And I click button with text "Save"
    Then I see browser alert with text "Your card was declined." with delay
    When I confirm browser alert
    And I fill in the following credit card details:
      | label                        | value            |
      | 1. Card Number:              | 5555555555554444 |
      | 2. Card CVC (security code): | 123              |
      | 3. Expiration Month (MM):    | 12               |
      | 4. Expiration Year (YYYY):   | 22               |
      | 5. Name on Card:             | Test Doc         |
      | 6. Card Zipcode:             | 12345            |
    And I click button with text "Save"
    Then I see "Active card is MasterCard ending in: 4444 Update" text with delay
    When I click "Update" link
    And I fill in the following credit card details:
      | label                        | value            |
      | 1. Card Number:              | 4242424242424242 |
      | 2. Card CVC (security code): | 123              |
      | 3. Expiration Month (MM):    | 12               |
      | 4. Expiration Year (YYYY):   | 22               |
      | 5. Name on Card:             | Test Doc         |
      | 6. Card Zipcode:             | 12345            |
    And I click button with text "Update"
    Then I see "Active card is Visa ending in: 4242 Update" text with delay
