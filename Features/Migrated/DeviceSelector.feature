Feature: Device Selector

  Scenario: Select device
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then the modal window is "closed"
    When I click on "Device Selector" menu point
    Then the modal window is "open"
    Then I see device selector modal title
    And I see "Instructions" link
    And I see device selection sliders:
      | name               | value                                       |
      | Comfort            | Not Important                               |
      | Bruxism            | None                                        |
      | Tongue             | Small                                       |
      | Bite               | Deep                                        |
      | Lower Molars       | NONE present / missing two or more one side |
      | Nasal Patency      | Both nostrils OPEN                          |
      | Joint Problems     | No problems                                 |
      | Retention of Teeth | Short crowns / zero undercuts               |
      | Patient Dexterity  | GOOD coordination / site                    |
      | Cost               | Not an Issue                                |
    And I see "Sort Devices" link
    And I see "Reset" link
    When I click "Instructions" link
    Then I see device selector instructions list:
      | name                                                                 |
      | Evaluate pt for each category using sliding bar                      |
      | Choose the three most important categories (if needed)               |
      | Click on Sort Devices                                                |
      | Click the device to add to Pt chart, or click "Reset" to start over. |
    And I see "hide" link
    When I click "hide" link
    Then I do not see device selector instructions list
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
    When I click on checkbox next to device selection slider "Bruxism"
    And I click on checkbox next to device selection slider "Tongue"
    And I click "Sort Devices" link
    Then I see device list:
     | name                 | quantity |
     | SUAD Ultra Elite     | 41.5     |
     | SUAD Hard            | 39.75    |
     | SUAD Thermo          | 39.75    |
     | Narval               | 39       |
     | Dorsal Hard          | 37.5     |
     | Dorsal Flex          | 34.5     |
     | Dorsal Reverse Flex  | 32.25    |
     | TAP 3 Durasoft       | 32       |
     | TAP Elite Thermacryl | 31       |
     | Full Breath          | 31       |
     | Herbst               | 30.5     |
     | EMA                  | 30       |
     | TAP 3 Thermacryl     | 30       |
     | TAP Elite Durasoft   | 29       |
     | Dorsal Reverse Hard  | 11.5     |
     | None                 | 0        |
     | Respire              | 0        |
     | PM Positioner Thermo | 0        |
     | Lamberg Sleepwell    | 0        |
    # @todo: looks like Mink does not provide an API to test sliders. Selenium does though, so we can make additions to Mink code
    # When I move device selection slider for "Bruxism" to "Mod"
    # And I move device selection slider for "Tongue" to "Large/Scalloped"
    # And I click "Sort Devices" link
    # Then I see device list:
    #  | name                 | quantity |
    #  | SUAD Ultra Elite     | 64       |
    #  | SUAD Hard            | 59       |
    #  | Narval               | 59       |
    #  | SUAD Thermo          | 59       |
    #  | Dorsal Reverse Flex  | 49       |
    #  | Dorsal Flex          | 48       |
    #  | Dorsal Hard          | 47       |
    #  | Herbst               | 42       |
    #  | Full Breath          | 40       |
    #  | TAP 3 Durasoft       | 39       |
    #  | EMA                  | 39       |
    #  | TAP Elite Thermacryl | 38       |
    #  | TAP 3 Thermacryl     | 37       |
    #  | TAP Elite Durasoft   | 36       |
    #  | Dorsal Reverse Hard  | 16       |
    #  | None                 | 0        |
    #  | Respire              | 0        |
    #  | PM Positioner Thermo | 0        |
    #  | Lamberg Sleepwell    | 0        |
    When I click "Reset" link
    Then I don't see device list
    And all checkboxes next to device selection sliders are unchecked
