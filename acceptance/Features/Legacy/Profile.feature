Feature: Manage Profile
  Background:
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I run mouse over "Admin" menu point
    Then I see "Profile" link
    When I click "Profile" link

  Scenario: Check practice profile
    Then I see practice profile form that is filled with data:
      | field                               | value                    | type  |
      | Username                            | doc1f                    | text  |
      | NPI                                 | 1234567890               | text  |
      | Medicare Provider (NPI/DME) Number  | 1234567890               | text  |
      | Medicare PTAN Number                | 123321                   | text  |
      | Tax ID or SSN                       | 8888                     | text  |
      | EIN or SSN                          | EIN                      | radio |
      | Practice                            | Test Practice2           | text  |
      | First Name                          | Doctor                   | text  |
      | Last Name                           | 1                        | text  |
      | Email                               | email1@email.com         | text  |
      | Address                             | 125 Sleepy Hollow Lane1  | text  |
      | City                                | St Pete                  | text  |
      | State                               | CA                       | text  |
      | Zip                                 | 33333                    | text  |
      | Phone                               | (555) 444-3333           | text  |
      | Fax                                 |                          | text  |
      | Mailing Practice                    | South side2              | text  |
      | Practice Email                      |                          | text  |
      | Mailing Name                        | Dental Sleep Solutions99 | text  |
      | Mailing Address                     | 123 Test St, Ste 205     | text  |
      | Mailing City                        | St. Petersburg           | text  |
      | Mailing State                       | FL1                      | text  |
      | Mailing Zip                         | 33704                    | text  |
      | Mailing Phone                       | (555) 555-5555           | text  |
      | Mailing Fax                         | (211) 111-1111           | text  |
      | Do you use a separate NPI number... | 0                        | radio |

  Scenario: Check profile info
    Then I see profile form that is filled with data:
      | field                               | value                    | type     |
      | Username                            | doc1f                    | text     |
      | NPI                                 | 1234567890               | text     |
      | Medicare Provider (NPI/DME) Number  | 1234567890               | text     |
      | Medicare PTAN Number                | 123321                   | text     |
      | Tax ID or SSN                       | 8888                     | text     |
      | EIN or SSN                          | EIN                      | checkbox |
      | Practice                            | Test Practice2           | text     |
      | First Name                          | Doctor                   | text     |
      | Last Name                           | 1                        | text     |
      | Email                               | email1@email.com         | text     |
      | Address                             | 125 Sleepy Hollow Lane1  | text     |
      | City                                | St Pete                  | text     |
      | State                               | CA                       | text     |
      | Zip                                 | 33333                    | text     |
      | Phone                               | (555) 444-3333           | text     |

  Scenario: Update profile info
    When I fill profile form with values:
      | field                               | value                    | type     |
      | Username                            | doc777                   | text     |
      | NPI                                 | 7777777777               | text     |
      | Medicare Provider (NPI/DME) Number  | 7777777777               | text     |
      | Medicare PTAN Number                | 777777                   | text     |
      | Tax ID or SSN                       | 7777                     | text     |
      | EIN or SSN                          | SSN                      | checkbox |
      | Practice                            | Test Practice7           | text     |
      | First Name                          | Doctor7                  | text     |
      | Last Name                           | 7                        | text     |
      | Email                               | email777@email.com       | text     |
      | Address                             | 125 Sleepy Hollow Lane7  | text     |
      | City                                | St Pete7                 | text     |
      | State                               | TX                       | text     |
      | Zip                                 | 77777                    | text     |
      | Phone                               | (555) 444-7777           | text     |
    And I click on submit button with text "Update Profile"
    Then I see profile form that is filled with data:
      | field                               | value                    | type     |
      | Username                            | doc777                   | text     |
      | NPI                                 | 7777777777               | text     |
      | Medicare Provider (NPI/DME) Number  | 7777777777               | text     |
      | Medicare PTAN Number                | 777777                   | text     |
      | Tax ID or SSN                       | 7777                     | text     |
      | EIN or SSN                          | SSN                      | checkbox |
      | Practice                            | Test Practice7           | text     |
      | First Name                          | Doctor7                  | text     |
      | Last Name                           | 7                        | text     |
      | Email                               | email777@email.com       | text     |
      | Address                             | 125 Sleepy Hollow Lane7  | text     |
      | City                                | St Pete7                 | text     |
      | State                               | TX                       | text     |
      | Zip                                 | 77777                    | text     |
      | Phone                               | (555) 444-7777           | text     |

  Scenario: Update practice profile info
    When I fill practice profile form with values:
      | field                               | value                    | type  |
      | Username                            | doc777                   | text  |
      | NPI                                 | 7777777777               | text  |
      | Medicare Provider (NPI/DME) Number  | 7777777777               | text  |
      | Medicare PTAN Number                | 777777                   | text  |
      | Tax ID or SSN                       | 7777                     | text  |
      | EIN or SSN                          | SSN                      | radio |
      | Practice                            | Test Practice7           | text  |
      | First Name                          | Doctor7                  | text  |
      | Last Name                           | 7                        | text  |
      | Email                               | email777@email.com       | text  |
      | Address                             | 125 Sleepy Hollow Lane7  | text  |
      | City                                | St Pete7                 | text  |
      | State                               | TX                       | text  |
      | Zip                                 | 77777                    | text  |
      | Phone                               | (555) 444-7777           | text  |
      | Fax                                 | (777) 777-7777           | text  |
      | Mailing Practice                    | South side7              | text  |
      | Practice Email                      | email@email.com          | text  |
      | Mailing Name                        | Dental Sleep Solutions77 | text  |
      | Mailing Address                     | 123 Test St, Ste 777     | text  |
      | Mailing City                        | St. Petersburg7          | text  |
      | Mailing State                       | FL7                      | text  |
      | Mailing Zip                         | 77777                    | text  |
      | Mailing Phone                       | (555) 555-7777           | text  |
      | Mailing Fax                         | (211) 111-7777           | text  |
      | Do you use a separate NPI number... | 1                        | radio |
      | Service Name                        | MedicareName7            | text  |
      | Service Address                     | MedicareAddr7            | text  |
      | Service City                        | MedCity7                 | text  |
      | Service State                       | MedState                 | text  |
      | Service Zip                         | 77777                    | text  |
      | Service NPI                         | 77777777                 | text  |
      | Service Medicare NPI                | 77777777                 | text  |
      | Service Medicare PTAN               | 77777777                 | text  |
      | Service Tax ID or SSN               | 77777777                 | text  |
      | Service EIN or SSN                  | EIN                      | radio |
    And I click on submit button with text "Update Practice"
    Then I see practice profile form that is filled with data:
      | field                               | value                    | type  |
      | Username                            | doc777                   | text  |
      | NPI                                 | 7777777777               | text  |
      | Medicare Provider (NPI/DME) Number  | 7777777777               | text  |
      | Medicare PTAN Number                | 777777                   | text  |
      | Tax ID or SSN                       | 7777                     | text  |
      | EIN or SSN                          | SSN                      | radio |
      | Practice                            | Test Practice7           | text  |
      | First Name                          | Doctor7                  | text  |
      | Last Name                           | 7                        | text  |
      | Email                               | email777@email.com       | text  |
      | Address                             | 125 Sleepy Hollow Lane7  | text  |
      | City                                | St Pete7                 | text  |
      | State                               | TX                       | text  |
      | Zip                                 | 77777                    | text  |
      | Phone                               | (555) 444-7777           | text  |
      | Fax                                 | (777) 777-7777           | text  |
      | Mailing Practice                    | South side7              | text  |
      | Practice Email                      | email@email.com          | text  |
      | Mailing Name                        | Dental Sleep Solutions77 | text  |
      | Mailing Address                     | 123 Test St, Ste 777     | text  |
      | Mailing City                        | St. Petersburg7          | text  |
      | Mailing State                       | FL7                      | text  |
      | Mailing Zip                         | 77777                    | text  |
      | Mailing Phone                       | (555) 555-7777           | text  |
      | Mailing Fax                         | (211) 111-7777           | text  |
      | Do you use a separate NPI number... | 1                        | radio |
      | Service Name                        | MedicareName7            | text  |
      | Service Address                     | MedicareAddr7            | text  |
      | Service City                        | MedCity7                 | text  |
      | Service State                       | MedState                 | text  |
      | Service Zip                         | 77777                    | text  |
      | Service NPI                         | 77777777                 | text  |
      | Service Medicare NPI                | 77777777                 | text  |
      | Service Medicare PTAN               | 77777777                 | text  |
      | Service Tax ID or SSN               | 77777777                 | text  |
      | Service EIN or SSN                  | EIN                      | radio |

  Scenario: Update profile with duplicate email
    When I fill "Profile" form with duplicate "email"
    And I click on submit button with text "Update Profile"
    Then I see browser alert with text "Email already taken. Please choose a new email." as soon as possible
    When I confirm browser alert

  Scenario: Update practice profile with duplicate email
    When I fill "Practice Profile" form with duplicate "email"
    And I click on submit button with text "Update Practice"
    Then I see browser alert with text "Email already taken. Please choose a new email." as soon as possible
    When I confirm browser alert

  Scenario: Update profile with duplicate user name
    When I fill "Profile" form with duplicate "username"
    And I click on submit button with text "Update Profile"
    Then I see browser alert with text "Username already taken. Please choose a new username." as soon as possible
    When I confirm browser alert

  Scenario: Update practice profile with duplicate user name
    When I fill "Practice Profile" form with duplicate "username"
    And I click on submit button with text "Update Practice"
    Then I see browser alert with text "Username already taken. Please choose a new username." as soon as possible
    When I confirm browser alert
