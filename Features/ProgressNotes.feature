Feature: Patient progress notes

  Scenario: Add progress note for patient
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    And I click on "Progress Notes" patient chart menu point
    Then I see add button with text "+ Add New Progress Note"
    When I click add button with text "+ Add New Progress Note"
    Then I see progress note frame for patient "Smith Pat"
    And I see text templates select list
    And the main progress note text field is empty
    When I select "ESS" in text templates select list
    Then the main progress note text field contains text "ESS 17 high risk"
