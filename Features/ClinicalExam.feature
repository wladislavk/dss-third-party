Feature: Clinical Exam

  Scenario: View patient clinical exam
    Given I am logged in as "doc1f"
    When I visit start page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    And I click on "Clinical Exam" patient chart menu point
    Then I see clinical exam menu with following sections:
      | name               |
      | Dental Exam        |
      | Vital Data/Tongue  |
      | Mallampati/Tonsils |
      | Airway Evaluation  |
      | TMJ/ROM            |
