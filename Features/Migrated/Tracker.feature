Feature: Patient Tracker

  Scenario: View patient trackers
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then I see top right patient buttons:
      | name                |
      | View Calendar Appts |
      | Request HST         |
    And today tracker section has a list of treatments:
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
    And next steps tracker section has the list of steps:
      | name                  |
      | SELECT NEXT STEP      |
      | Initial Contact       |
      | Baseline Sleep Test   |
      | Consult               |
      | Device Delivery       |
      | Check/Follow Up       |
      | Titration Sleep Study |
      | Treatment Complete    |
      | Annual Recall         |
      | Not a Candidate       |
      | Delaying Tx/Waiting   |
      | Pt. Non-compliant     |
      | Refused Treatment     |
      | Termination           |
    And treatment summary tracker section has the list of treatments:
      | date       | name            | selected    | letters | link |
      | 03/27/2015 | Impressions     | Dorsal Hard | 0       | yes  |
      | 02/17/2015 | Consult         |             | 0       | yes  |
      | 02/04/2015 | Initial Contact |             | 0       | no   |
    And treatment summary row "Impressions" has a sub-select list:
      | name                 |
      |                      |
      | TAP 3 Durasoft       |
      | Dorsal Flex          |
      | Dorsal Hard          |
      | Dorsal Reverse Flex  |
      | Dorsal Reverse Hard  |
      | Narval               |
      | PM Positioner Thermo |
      | Herbst               |
      | Full Breath          |
      | Lamberg Sleepwell    |
      | Respire              |
      | SUAD Ultra Elite     |
      | SUAD Hard            |
      | SUAD Thermo          |
      | EMA                  |
      | TAP Elite Thermacryl |
      | TAP Elite Durasoft   |
      | TAP 3 Thermacryl     |
    When I type "dra" into patient search form
    And I click on "Drake, John S" in list of patients
    Then I see top right patient buttons:
      | name                |
      | View Calendar Appts |
      | Order HST           |
    And today tracker section has a list of treatments:
      | name                  | color | link |
      | Initial Contact       | blue  | no   |
      | Baseline Sleep Test   | blue  | yes  |
      | Consult               | blue  | yes  |
      | Impressions           | blue  | yes  |
      | Device Delivery       | blue  | yes  |
      | Check/Follow Up       | blue  | yes  |
      | Titration Sleep Study | blue  | yes  |
      | Treatment Complete    | blue  | yes  |
      | Annual Recall         | blue  | yes  |
      | Not a Candidate       | grey  | yes  |
      | Delaying Tx/Waiting   | grey  | yes  |
      | Pt. Non-compliant     | grey  | yes  |
      | Refused Treatment     | grey  | yes  |
      | Termination           | grey  | yes  |
    And treatment summary tracker section has the list of treatments:
      | date       | name                  | selected             | letters | link |
      | 02/03/2016 | Refused Treatment     |                      | 6       | yes  |
      | 02/03/2016 | Delaying Tx / Waiting | Insurance            | 5       | yes  |
      | 02/17/2014 | Consult               |                      | 0       | yes  |
      | 02/17/2014 | Impressions           | TAP Elite Thermacryl | 0       | yes  |
      | 02/17/2014 | Impressions           | SUAD Hard            | 0       | yes  |
      | 02/06/2014 | Annual Recall         |                      | 1       | yes  |
      | 12/09/2013 | Impressions           | SUAD Hard            | 1       | yes  |
      | 11/20/2013 | Treatment Complete	   |                      | 5       | yes  |
      | 11/18/2013 | Impressions           | SUAD Hard            | 0       | yes  |
      | 10/23/2013 | Pt. Non-Compliant     | Pain/Discomfort      | 5       | yes  |
      | 10/20/2013 | Check / Follow Up     |                      |	5       | yes  |
      | 10/20/2013 | Device Delivery       | SUAD Hard            |	0       | yes  |
      | 10/19/2013 | Impressions           | SUAD Hard            |	0       | yes  |
      | 07/24/2013 | Not a Candidate       |                      | 4       | yes  |
      | 07/08/2013 | Check / Follow Up     |                      | 4       | yes  |
      | 06/07/2013 | Impressions           | SUAD Hard            | 0       | yes  |
      | 06/06/2013 | Titration Sleep Study | HST Titration        | 0       | yes  |
      | 05/29/2013 | Initial Contact       |                      | 0       | no   |
      | 11/13/2012 | Check / Follow Up     |                      | 0       | yes  |
      | 04/30/2012 | Device Delivery       | SUAD Hard            | 0       | yes  |

  Scenario: Edit tracker data
    Given I am logged in as "doc1f"
    When I go to "start" page
    Then I see patient search form
    When I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    And I click on "Titration Sleep Study" in today tracker section
    Then I see a modal window with heading "What type of sleep test will be performed on Pat Smith?"
    And I see a list of study types:
      | name          |
      |               |
      | HST Titration |
      | PSG Titration |
    When I choose "HST Titration" as study type
    And I click button with text "Submit"
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Titration Sleep Study | HST Titration | 0       | yes  |
      | 03/27/2015 | Impressions           | Dorsal Hard   | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    And treatment summary row "Sleep Study" has a sub-select list:
      | name          |
      | Select type   |
      | HST Titration |
      | PSG Titration |
    When I click on logo in top left corner
    And I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then today tracker section has a list of treatments:
      | name                  | color | link |
      | Initial Contact       | blue  | no   |
      | Baseline Sleep Test   | blue  | yes  |
      | Consult               | blue  | yes  |
      | Impressions           | blue  | yes  |
      | Device Delivery       | blue  | yes  |
      | Check/Follow Up       | blue  | yes  |
      | Titration Sleep Study | white | yes  |
      | Treatment Complete    | white | yes  |
      | Annual Recall         | white | yes  |
      | Not a Candidate       | grey  | yes  |
      | Delaying Tx/Waiting   | grey  | yes  |
      | Pt. Non-compliant     | grey  | yes  |
      | Refused Treatment     | grey  | yes  |
      | Termination           | grey  | yes  |
    When I change treatment summary row "Titration Sleep Study" to "PSG Titration"
    And I change date on treatment summary row "Titration Sleep Study" to "05/25/2017"
    And I click on logo in top left corner
    And I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | 05/25/2017 | Titration Sleep Study | PSG Titration | 0       | yes  |
      | 03/27/2015 | Impressions           | Dorsal Hard   | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    And next steps tracker section has the list of steps:
      | name                  |
      | SELECT NEXT STEP      |
      | Treatment Complete    |
      | Check/Follow Up       |
      | Titration Sleep Study |
      | Delaying Tx/Waiting   |
      | Pt. Non-compliant     |
      | Refused Treatment     |
      | Termination           |
    When I click delete button next to treatment summary row "Titration Sleep Study"
    And I confirm browser alert
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | 03/27/2015 | Impressions           | Dorsal Hard   | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I create next appointment with data:
      | type                | date       | notes |
      | Delaying Tx/Waiting | today + 10 | foo   |
    And I click on logo in top left corner
    And I type "smi" into patient search form
    And I click on "Smith, Pat" in list of patients
    Then next steps tracker section is filled with data:
      | type                | date       | after   | notes |
      | Delaying Tx/Waiting | today + 10 | 10 days | foo   |
    When I click on "Device Delivery" in today tracker section
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Device Delivery       | Dorsal Hard   | 0       | yes  |
      | 03/27/2015 | Impressions           | Dorsal Hard   | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I click delete button next to treatment summary row "Device Delivery"
    And I confirm browser alert
    And I click delete button next to treatment summary row "Impressions"
    And I confirm browser alert
    And I click on "Device Delivery" in today tracker section
    Then I see a modal window with heading "What device will you make for Pat Smith?"
    And I see a list of devices:
      | name                 |
      |                      |
      | TAP 3 Durasoft       |
      | Dorsal Flex          |
      | Dorsal Hard          |
      | Dorsal Reverse Flex  |
      | Dorsal Reverse Hard  |
      | Narval               |
      | PM Positioner Thermo |
      | Herbst               |
      | Full Breath          |
      | Lamberg Sleepwell    |
      | Respire              |
      | SUAD Ultra Elite     |
      | SUAD Hard            |
      | SUAD Thermo          |
      | EMA                  |
      | TAP Elite Thermacryl |
      | TAP Elite Durasoft   |
      | TAP 3 Thermacryl     |
    When I choose "Narval" as device
    And I click button with text "Submit"
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I click on "Treatment Complete" in today tracker section
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Treatment Complete    |               | 3       | yes  |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I click on "Baseline Sleep Test" in today tracker section
    Then I see a modal window with heading "What type of sleep test will be performed on Pat Smith?"
    And I see a list of sleep test types:
      | name         |
      |              |
      | HST Baseline |
      | PSG Baseline |
    When I choose "PSG Baseline" as sleep test type
    And I click button with text "Submit"
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Baseline Sleep Test   | PSG Baseline  | 0       | yes  |
      | today      | Treatment Complete    |               | 3       | yes  |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I click on "Delaying Tx/Waiting" in today tracker section
    Then I see a modal window with heading "What is the reason for delaying treatment for Pat Smith?"
    And I see a list of delay reasons:
      | name        |
      | Insurance   |
      | Dental Work |
      | Deciding    |
      | Sleep Study |
      | Other       |
    When I choose "Deciding" as delay reason
    And I click button with text "Submit"
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Delaying Tx/Waiting   | Deciding      | 2       | yes  |
      | today      | Baseline Sleep Test   | PSG Baseline  | 0       | yes  |
      | today      | Treatment Complete    |               | 3       | yes  |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    When I click on "Pt. Non-compliant" in today tracker section
    Then I see a modal window with heading "What is the reason Pat Smith is non-compliant?"
    And I see a list of non-compliance reasons:
      | name               |
      | Pain/Discomfort    |
      | Lost Device        |
      | Device Not Working |
      | Other              |
    When I choose "Other" as non-compliance reason
    And I click button with text "Submit"
    Then I see a modal window with heading "Reason for Patient Non-Compliant"
    And I add text "foo bar" in modal text area
    And I click button with text "Submit Reason"
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Pt. Non-Compliant     | Other         | 3       | yes  |
      | today      | Delaying Tx/Waiting   | Deciding      | 2       | yes  |
      | today      | Baseline Sleep Test   | PSG Baseline  | 0       | yes  |
      | today      | Treatment Complete    |               | 3       | yes  |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    And I see link with text "Show Reason" below "Pt. Non-Compliant" row in treatment summary tracker section
    When I click link with text "Show Reason" below "Pt. Non-Compliant" row in treatment summary tracker section
    Then I see a modal window with heading "Reason for Patient Non-Compliant"
    And I see text "foo bar" in modal text area
    When I close the modal window
    And I change treatment summary row "Pt. Non-Compliant" to "Lost Device"
    And I confirm browser alert
    Then treatment summary tracker section has the list of treatments:
      | date       | name                  | selected      | letters | link |
      | today      | Pt. Non-Compliant     | Lost Device   | 3       | yes  |
      | today      | Delaying Tx/Waiting   | Deciding      | 2       | yes  |
      | today      | Baseline Sleep Test   | PSG Baseline  | 0       | yes  |
      | today      | Treatment Complete    |               | 3       | yes  |
      | today      | Device Delivery       | Narval        | 0       | yes  |
      | 02/17/2015 | Consult               |               | 0       | yes  |
      | 02/04/2015 | Initial Contact       |               | 0       | no   |
    And I do not see links below "Pt. Non-Compliant" row in treatment summary tracker section
