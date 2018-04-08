Feature: Invoicing

  Background:
    Given I am logged in as admin "admin"
    When I go to "admin start" page
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "Doctor 1" text
    And I see "doc1f" text
    When I click button with text "Edit"
    Then I see "Edit/Save Contact" text in admin popup window
    When I click button with text "Delete Stripe data for this user" in admin popup window
    Then I see marker "check" in button "Delete Stripe data for this user" in admin popup window
    When I click button with text "Close"
    And I run mouse over "NathanAdmin SuperStage" admin top menu point
    And I click "Log Out" link
    Then I see browser confirmation dialog with text "Logged out"
    When I confirm browser alert
    Then I see "Login to your DS3 account" text

  Scenario: Failed charge
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
      | 1. Card Number:              | 4000000000000341 |
      | 2. Card CVC (security code): | 123              |
      | 3. Expiration Month (MM):    | 12               |
      | 4. Expiration Year (YYYY):   | 22               |
      | 5. Name on Card:             | Test Doc         |
      | 6. Card Zipcode:             | 12345            |
    And I click button with text "Save"
    Then I see browser alert with text "Card saved" with delay
    When I confirm browser alert after delay
    Then I see "Active card is Visa ending in: 0341 Update" text with delay
    When I click "Sign Out" link
    And I confirm browser alert after delay
    Then I see "Please Enter Your Login Information" text
    When I am logged in as admin "admin"
    And I click "Users" link
    And I click "Account Analysis" link
    And I click "Invoicing" link
    Then I see "Invoicing" page
    And I see "doc1f DSS plan1 Doctor 1 0 134 48 History" text
    When I click "Bill Card" link
    Then I see "Charge Doctor 1" text in admin popup window
    And I see "Amount to charge credit card ending 0341" text in admin popup window
    When I click input button with text "Charge Credit Card" in admin popup window
    Then I see browser alert with text "You must enter amount to be billed. Amount must be at least $0.50"
    When I confirm browser alert
    And I fill in "amount" with "3" in admin popup window
    And I click input button with text "Charge Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "Credit card for Doctor 1 will be charged $3. Proceed?"
