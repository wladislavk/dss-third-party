Feature: Manage Profile

  Scenario: Check practice profile
    Given I am logged in as "doc1f"
    When I visit start page
    And I run mouse over "Admin" menu point
    Then I see "Profile" link
    When I click "Profile" link
    Then I see "Manage Profile" page
    And I see practice profile form that is filled with data:
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
      | Do you use a separate NPI number... | No                       | radio |
