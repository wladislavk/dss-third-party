Feature: Forms
  In order to download various forms
  As a user
  I want to have a page with PDF download links

Scenario: Download forms
  Given I am logged in as "doc1f"
  When I go to "start" page
  And I click on "Forms" menu point
  Then I see "Manage Forms" page
  And I can see following forms:
    | name                                        |
    | Record Release                              |
    | Financial Agreement - Medicare (Non-Par)    |
    | Financial Agreement - Cash (No Insurance)   |
    | Financial Agreement - Out of Network (OON)  |
    | Release of Liability and Assumption of Risk |
    | Home Care Instructions                      |
    | Non-dentist of Record Release               |
    | Sleep Recorder Release                      |
    | Affidavit for CPAP Intolerance              |
    | Device Titration (EMA)                      |
    | Device Titration                            |
    | ESS/TSS Form                                |
    | Informed Consent                            |
    | LOMN Rx                                     |
    | Medical Hx Update                           |
    | Patient Notices                             |
    | New Patient Form                            |
    | Patient Questionnaire                       |
    | Proof of Delivery                           |
    | Advanced Beneficiary Notice Medicare        |
    | DST Progress Questionnaire                  |
