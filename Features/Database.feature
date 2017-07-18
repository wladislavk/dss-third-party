Feature: Database manipulation
  In order to provide example for manipulating a simple database
  As a user
  I want to be able to perform select and update queries

  Scenario: Get data
    When all data is retrieved
    Then contents are displayed:
      | id | value   |
      | 1  | value 1 |
      | 2  | value 2 |
      | 3  | value 3 |
      | 4  | value 4 |
      | 5  | value 5 |

  Scenario: Edit data
    Given record with ID "2" exists
    When record with ID "2" is updated to value "new value 2"
    And all data is retrieved
    Then contents are displayed:
      | id | value       |
      | 1  | value 1     |
      | 2  | new value 2 |
      | 3  | value 3     |
      | 4  | value 4     |
      | 5  | value 5     |

  Scenario Outline: Get data by ID
    When data is retrieved for ID "<id>"
    Then value equals "value <id>"
    Examples:
      | id |
      | 1  |
      | 2  |
      | 3  |
      | 4  |
      | 5  |
