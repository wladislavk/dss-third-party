Feature: Patient Screener App

  Scenario: Test authentication
    Given user "doc1f" exists and has password "cr3at1vItY"
    When I visit screener app page
    Then I see screener app login form
    When I type in "doc1f" as login and "cr3at1vItY" as password into screener app login form
    Then I see screener left header "Dental Sleep Solutions - Patient Health Assessment"
    And I see top screener button with text "Log Out"
    When I click top screener button with text "Log Out"
    Then I see browser confirmation dialog with text "Are you sure you want to logout?"
    When I confirm browser alert
    Then I see screener app login form

  Scenario: Add patient screener information
    When I log in as "doc1f" to screener app page
    Then I see contact information form with fields:
      | name         |
      | First Name   |
      | Last Name    |
      | Phone Number |
    And I see screener button with text "Proceed »"
    When I fill contact information form with data:
      | name         | value          |
      | First Name   | John           |
      | Last Name    | Dowson         |
      | Phone Number | (223) 322-3223 |
    And I click screener button with text "Proceed »"
    Then I see screener right header "Health Assessment - John Dowson"
    And I see screener left header "Epworth Sleepiness Scale"
    And I see Epworth sleepiness scale form with questions:
      | label                                                          |
      | Sitting and reading                                            |
      | Watching TV                                                    |
      | Sitting inactive in a public place (e.g. a theater or meeting) |
      | As a passenger in a car for an hour without a break            |
      | Lying down to rest in the afternoon when circumstances permit  |
      | Sitting and talking to someone                                 |
      | Sitting quietly after a lunch without alcohol                  |
      | In a car, while stopped for a few minutes in traffic           |
      | test                                                           |
      | kifayat                                                        |
      | multiple                                                       |
    And each question in Epworth sleepiness scale form has following options:
      | option                        |
      | 0 - No chance of dozing       |
      | 1 - Slight chance of dozing   |
      | 2 - Moderate chance of dozing |
      | 3 - High chance of dozing     |
    And I see top screener button with text "Reset and Start Over"
    And I see screener button with text "Next"
    When I click top screener button with text "Reset and Start Over"
    Then I see browser confirmation dialog with text "Are you sure? All current progress will be lost."
    When I confirm browser alert
    Then I see contact information form with fields:
      | name         |
      | First Name   |
      | Last Name    |
      | Phone Number |
    When I fill contact information form with data:
      | name         | value          |
      | First Name   | John           |
      | Last Name    | Dowson         |
      | Phone Number | (223) 322-3223 |
    And I click screener button with text "Proceed »"
    And I fill Epworth sleepiness scale form with data:
      | label                                                          | choice |
      | Sitting and reading                                            | 0      |
      | Watching TV                                                    | 1      |
      | Sitting inactive in a public place (e.g. a theater or meeting) | 2      |
      | As a passenger in a car for an hour without a break            | 3      |
      | Lying down to rest in the afternoon when circumstances permit  | 0      |
      | Sitting and talking to someone                                 | 0      |
      | Sitting quietly after a lunch without alcohol                  | 1      |
      | In a car, while stopped for a few minutes in traffic           | 1      |
      | test                                                           | 2      |
      | kifayat                                                        | 1      |
      | multiple                                                       | 3      |
    When I click screener button with text "Next"
    Then I see screener left header "Health Symptoms"
    And I see health symptoms form with questions:
      | label                                                                                        |
      | Have you ever been told you stop breathing while asleep?                                     |
      | Have you ever fallen asleep or nodded off while driving?                                     |
      | Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing? |
      | Do you feel excessively sleepy during the day?                                               |
      | Do you snore or have you ever been told that you snore?                                      |
      | Have you had weight gain and found it difficult to lose?                                     |
      | Have you taken medication for, or been diagnosed with high blood pressure?                   |
      | Do you kick or jerk your legs while sleeping?                                                |
      | Do you feel burning, tingling or crawling sensations in your legs when you wake up?          |
      | Do you wake up with headaches during the night or in the morning?                            |
      | Do you have trouble falling asleep?                                                          |
      | Do you have trouble staying asleep once you fall asleep?                                     |
    And each question in health symptoms form has following options:
      | option |
      | Yes    |
      | No     |
    And I see screener button with text "Next"
    When I fill health symptoms form with data:
      | label                                                                                        | choice |
      | Have you ever been told you stop breathing while asleep?                                     | Yes    |
      | Have you ever fallen asleep or nodded off while driving?                                     | No     |
      | Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing? | No     |
      | Do you feel excessively sleepy during the day?                                               | Yes    |
      | Do you snore or have you ever been told that you snore?                                      | No     |
      | Have you had weight gain and found it difficult to lose?                                     | No     |
      | Have you taken medication for, or been diagnosed with high blood pressure?                   | Yes    |
      | Do you kick or jerk your legs while sleeping?                                                | No     |
      | Do you feel burning, tingling or crawling sensations in your legs when you wake up?          | No     |
      | Do you wake up with headaches during the night or in the morning?                            | Yes    |
      | Do you have trouble falling asleep?                                                          | No     |
      | Do you have trouble staying asleep once you fall asleep?                                     | No     |
    And I click screener button with text "Next"
    Then I see screener left header "Previous medical diagnoses"
    And previous medical diagnoses form contains yes-no questions:
      | label                           |
      | Have you ever used CPAP before? |
    And previous medical diagnoses form contains checkboxes for existing conditions:
      | label                               |
      | Heart Failure                       |
      | Stroke                              |
      | Hypertension                        |
      | Diabetes                            |
      | Metabolic Syndrome                  |
      | Obesity                             |
      | Heartburn (Gastroesophageal Reflux) |
      | Atrial Fibrillation                 |
    And I see screener button with text "Next"
    When I fill yes-no questions in previous medical diagnoses form with data:
      | label                           | choice |
      | Have you ever used CPAP before? | Yes    |
    And I fill previous medical diagnoses form existing conditions checkboxes:
      | label                               | checked |
      | Heart Failure                       | Yes     |
      | Stroke                              | No      |
      | Hypertension                        | No      |
      | Diabetes                            | Yes     |
      | Metabolic Syndrome                  | No      |
      | Obesity                             | No      |
      | Heartburn (Gastroesophageal Reflux) | Yes     |
      | Atrial Fibrillation                 | No      |
    And I click screener button with text "Next"
    Then I see screener result with risk level "Severe"
    And I see arrow image with risk level "Severe"
    And I see screener button with text "Dentist Only - Click Here »"
    When I click screener button with text "Dentist Only - Click Here »"
    Then I see screener left header "Dental Sleep Solutions - Summary of Results"
    And I see arrow image with risk level "Severe"
    And I see screener button with text "View Results"
    And I see screener button with text "Finish/Screen New Patient"
    And I see screener button with text "Request HST (Doctor Only) »"
    When I click screener button with text "View Results"
    Then I see "left" screener results section with data:
      | row                                                                                            |
      | First name: John                                                                               |
      | Last name: Dowson                                                                                 |
      | Phone: (223) 322-3223                                                                          |
      | Epworth Sleepiness Scale                                                                       |
      | 14 - Epworth Sleepiness Scale Total                                                            |
      | 1 - Slight chance of dozing - Watching TV                                                      |
      | 2 - Moderate chance of dozing - Sitting inactive in a public place (e.g. a theater or meeting) |
      | 3 - High chance of dozing - As a passenger in a car for an hour without a break                |
      | 1 - Slight chance of dozing - Sitting quietly after a lunch without alcohol                    |
      | 1 - Slight chance of dozing - In a car, while stopped for a few minutes in traffic             |
      | 2 - Moderate chance of dozing - test                                                           |
      | 1 - Slight chance of dozing - kifayat                                                          |
      | 3 - High chance of dozing - multiple                                                           |
    And I see "right" screener results section with data:
      | row                                                                                 |
      | Health Symptoms                                                                     |
      | Yes Have you ever been told you stop breathing while asleep?                        |
      | Yes Do you feel excessively sleepy during the day?                                  |
      | Yes Have you taken medication for, or been diagnosed with high blood pressure?      |
      | Yes Do you wake up with headaches during the night or in the morning?               |
      | Yes Have you ever used CPAP before?                                                 |
      | Co-morbidity                                                                        |
      | Please check any conditions for which you have been medically diagnosed or treated. |
      | Heart Failure                                                                       |
      | Diabetes                                                                            |
      | Heartburn (Gastroesophageal Reflux)                                                 |
    When I click screener button with text "Finish/Screen New Patient"
    Then I see a modal window with heading "Survey Complete"
    When I close the modal window
    And I click screener button with text "Request HST (Doctor Only) »"
    Then I see screener left header "Dental Sleep Solutions - Home Sleep Test Request"
    And I see company list in home sleep test request form:
      | company     |
      | HST Company |
    And I see home sleep test request form pre-populated with data:
      | field         | value          |
      | First Name    | John           |
      | Last Name     | Dowson         |
      | Date of Birth |                |
      | Phone Number  | (223) 322-3223 |
      | Email         |                |
    And I see screener button with text "Submit Request"
    When I fill home sleep test request form with data:
      | field         | value          |
      | First Name    | John           |
      | Last Name     | Dowson         |
      | Date of Birth |                |
      | Phone Number  | (223) 322-3223 |
      | Email         |                |
    And I click screener button with text "Submit Request"
    Then I see browser alert with text "All fields are required"
    When I choose "HST Company" as company for home sleep test request
    And I fill home sleep test request form with data:
      | field         | value          |
      | First Name    | John           |
      | Last Name     | Dowson         |
      | Date of Birth | 01/01/1970     |
      | Phone Number  | (223) 322-3223 |
      | Email         | foo@bar.com    |
    And I click screener button with text "Submit Request"
    Then I see browser alert with text "HST submitted for approval and is in your Pending HST queue."
# @todo: this cannot pass in chrome headless
#    And I see screener left header "Dental Sleep Solutions - Patient Health Assessment"
