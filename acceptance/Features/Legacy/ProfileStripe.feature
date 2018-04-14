Feature: Manage Stripe Card

  Background:
    Given I delete Stripe data from user "doc1f"
    When I am logged in as "doc1f"
    And I go to "start" page
    And I run mouse over "Admin" menu point
    And I click "Profile" link

  Scenario Outline: Update cards
    When I click "Add" link
    And I fill in the following credit card details:
      | label                        | value  |
      | 1. Card Number:              | <card> |
      | 2. Card CVC (security code): | 123    |
      | 3. Expiration Month (MM):    | 12     |
      | 4. Expiration Year (YYYY):   | 22     |
      | 5. Name on Card:             | <name> |
      | 6. Card Zipcode:             | 12345  |
    And I click button with text "Save"
    Then I see browser alert with text "<alert>" after delay
    When I confirm browser alert
    Then I see "<description>" text in card details after delay

    Examples:
    | card             | name     | alert                                         | description                              |
    | 4000000000000101 |          | Please enter valid information for all fields | No card on record.                       |
    |                  | Test Doc | Please enter valid information for all fields | No card on record.                       |
    | 4000000000000101 | Test Doc | Your card's security code is incorrect.       | No card on record.                       |
    | 4000000000000002 | Test Doc | Your card was declined.                       | No card on record.                       |
    | 5555555555554444 | Test Doc | Card saved                                    | Active card is MasterCard ending in: 444 |
