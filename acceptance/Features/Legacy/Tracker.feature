Feature: Patient Tracker

  Scenario: View patient tracker
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then today tracker section has the list of treatments:
      | name                  | color | link |
      | Initial Contact       | blue  | no   |
      | Baseline Sleep Test   | blue  | yes  |
      | Consult               | blue  | yes  |
      | Impressions           | blue  | yes  |
      | Device Delivery       | white | yes  |
      | Check/Follow Up       | white | yes  |
      | Titration Sleep Study | white | yes  |
      | Treatment Complete    | white | yes  |
      | Annual Recall         | white | yes  |
      | Not a Candidate       | grey  | yes  |
      | Delaying Tx/Waiting   | grey  | yes  |
      | Pt. Non-compliant     | grey  | yes  |
      | Refused Treatment     | grey  | yes  |
      | Termination           | grey  | yes  |
    And treatment summary tracker section has the list of treatments:
      | date       | name            | letters | link |
      | 03/27/2015 | Impressions     | 0       | yes  |
      | 02/17/2015 | Consult         | 0       | yes  |
      | 02/04/2015 | Initial Contact | 0       | no   |
