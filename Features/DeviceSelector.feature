Feature: Device Selector

  Scenario: Select device
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I click on "Device Selector" menu point
    Then I see a modal window
    And I see "Instructions" link
    And I see divice selector modal title
    And I see device selection sliders:
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
    And I see "Sort Devices" link
    And I see "Reset" link
    When I click "Instructions" link
    Then I see "hide" link
    And I see instructions list:
      | name                                                                 |
      | Evaluate pt for each category using sliding bar                      |
      | Choose the three most important categories (if needed)               |
      | Click on Sort Devices                                                |
      | Click the device to add to Pt chart, or click "Reset" to start over. |
    When I click "Sort Devices" link
    Then I see device list:
      | name                 | quantity |
      | SUAD Ultra Elite     | 34       |
      | SUAD Hard            | 33       |
      | Narval               | 33       |
      | SUAD Thermo          | 33       |
      | Dorsal Hard          | 33       |
      | Dorsal Flex          | 30       |
      | TAP 3 Durasoft       | 29       |
      | TAP Elite Thermacryl | 28       |
      | Full Breath          | 28       |
      | Dorsal Reverse Flex  | 27       |
      | EMA                  | 27       |
      | TAP 3 Thermacryl     | 27       |
      | TAP Elite Durasoft   | 26       |
      | Herbst               | 26       |
      | Dorsal Reverse Hard  | 10       |
      | None                 | 0        |
      | Respire              | 0        |
      | PM Positioner Thermo | 0        |
      | Lamberg Sleepwell    | 0        |
    When I click "Reset" link
    Then I don't see device list
