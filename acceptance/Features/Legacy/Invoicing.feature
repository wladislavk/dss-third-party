Feature: Invoicing

  @active
  Scenario: Failed charge
    Given I delete Stripe data from user "doc1f"
    And I add "4000000000000341" credit card to user "doc1f"
    When I am logged in as admin "admin"
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "User Accounts" page
    And I see "Doctor 1 doc1f" text
    When I click "46" link
    Then I see "Invoice History - Doctor 1 - Current Card Ending 0341" text
    When I click "Charge Card" link
    Then I see "Charge Doctor 1" text in admin popup window
    And I see "Amount to charge credit card ending 0341" text in admin popup window
    When I click input button with text "Charge Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "You must enter amount to be billed. Amount must be at least $0.50" after delay
    When I confirm browser alert
    And I fill in "amount" with "3" in admin popup window
    And I click input button with text "Charge Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "Credit card for Doctor 1 will be charged $3.00. Proceed?" after delay
    When I confirm browser alert
    Then I see "Your card was declined.. Please contact your Credit Card billing administrator to resolve this issue." text in admin popup window after delay

  Scenario: Successful charge
    Given I delete Stripe data from user "doc1f"
    And I add "4242424242424242" credit card to user "doc1f"
    When I am logged in as admin "admin"
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "User Accounts" page
    And I see "Doctor 1 doc1f" text
    When I click "46" link
    Then I see "Invoice History - Doctor 1 - Current Card Ending 4242" text
    When I click "Charge Card" link
    Then I see "Charge Doctor 1" text in admin popup window
    And I see "Amount to charge credit card ending 4242" text in admin popup window
    When I fill in "amount" with "3" in admin popup window
    And I click input button with text "Charge Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "Credit card for Doctor 1 will be charged $3.00. Proceed?" after delay
    When I confirm browser alert
    Then I see "Doctor 1 billed 3.00." text in admin popup window after delay

  Scenario: Refund charge
    Given I delete Stripe data from user "doc1f"
    And I add "4242424242424242" credit card to user "doc1f"
    When I am logged in as admin "admin"
    And I type "doc1f" into user search form
    And I click button with text "Search user"
    Then I see "User Accounts" page
    And I see "Doctor 1 doc1f" text
    When I click "46" link
    Then I see "Invoice History - Doctor 1 - Current Card Ending 4242" text
    When I click "Charge Card" link
    Then I see "Charge Doctor 1" text in admin popup window
    And I see "Amount to charge credit card ending 4242" text in admin popup window
    When I fill in "amount" with "3" in admin popup window
    And I click input button with text "Charge Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "Credit card for Doctor 1 will be charged $3.00. Proceed?" after delay
    When I confirm browser alert
    Then I see "Doctor 1 billed 3.00." text in admin popup window after delay
    And I see "4242 Refund" text
    When I click "Refund" link
    Then I see "Amount to refund credit card ending 4242 for $1.00" text in admin popup window
    When I fill in "amount" with "3" in admin popup window
    And I click input button with text "Refund Credit Card" in admin popup window triggering alert
    Then I see browser alert with text "Credit card for Doctor 1 will be refunded $1.00. Proceed?" after delay
    When I confirm browser alert
    Then I see "Doctor 1 refunded 1.00." text after delay
