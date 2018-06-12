Feature: Patient Upload in Dental Writer format

  Scenario:
    Given I am logged in as "doc1f"
    When I go to "start" page
    And I click on "Pending Duplicates" in notifications menu
    Then I see "Manage Pending Patients Possible Duplicates" page
    When I click button with text "Upload Dental Writer"
    And I confirm browser alert by entering "dss789"
    Then I see "Dental Writer Upload" page
    When I attach the file "patient-dw.csv" to "csv"
    And I click input button with text "Upload"
    Then I see "Manage Pending Patients Possible Duplicates" page
    When I type "fir" into patient search form
    And I click on "las'name, fir'tname mi" in list of patients
    # @todo Fix selector to parse single quotes correctly
    # Then I see the patient chart for "fir'tname las'name"
    Then I see "fir'tname las'name" text
