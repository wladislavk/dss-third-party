import PatientsModule from '../../../../src/store/patients'
import TestCase from '../../../cases/StoreTestCase'
import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'

describe('Patients module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('patientData action', () => {
    it('should get patient data', function (done) {
      const patientId = 1
      const response = {
        insurance_type: '2',
        premedcheck: '3',
        premed: 'foo',
        alert_text: 'alert',
        display_alert: '1',
        firstname: 'John',
        lastname: 'Doe',
        questionnaire_data: {
          symptoms_status: '4',
          treatments_status: '5',
          history_status: '6'
        },
        is_email_bounced: '0',
        patient_contacts_number: '7',
        patient_insurances_number: '8',
        sub_patients_number: '9',
        rejected_claims: ['foo', 'bar'],
        has_allergen: '1',
        other_allergens: 'other',
        hst_status: '10',
        incomplete_hsts: ['baz']
      }
      this.testCase.stubRequest({response: response})

      PatientsModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: [
            { path: endpoints.patients.patientData + '/1' }
          ],
          mutations: [
            {
              type: symbols.mutations.patientId,
              payload: 1
            },
            {
              type: symbols.mutations.patientData,
              payload: {
                insuranceType: '2',
                preMed: 'foo',
                preMedCheck: '3',
                alertText: 'alert',
                displayAlert: '1',
                firstName: 'John',
                lastName: 'Doe',
                questionnaireData: {
                  symptomsStatus: '4',
                  treatmentsStatus: '5',
                  historyStatus: '6'
                },
                isEmailBounced: '0',
                patientContactsNumber: '7',
                patientInsurancesNumber: '8',
                subPatientsNumber: '9',
                rejectedClaims: ['foo', 'bar'],
                hasAllergen: '1',
                otherAllergens: 'other',
                hstStatus: '10',
                incompleteHomeSleepTests: ['baz']
              }
            }
          ],
          actions: []
        })
        done()
      })
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.testCase.stubErrorRequest()

      PatientsModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: [
            { path: endpoints.patients.patientData + '/1' }
          ],
          mutations: [],
          actions: [
            {
              type: symbols.actions.handleErrors,
              payload: {
                title: 'getPatientByIdAndDocId',
                response: new Error()
              }
            }
          ]
        })
        done()
      })
    })
  })

  describe('clearPatientData action', () => {
    it('clears patient data', function () {
      PatientsModule.actions[symbols.actions.clearPatientData](this.testCase.mocks)

      expect(this.testCase.getResults()).toEqual({
        http: [],
        mutations: [
          {
            type: symbols.mutations.patientId,
            payload: 0
          },
          {
            type: symbols.mutations.clearPatientData,
            payload: {}
          }
        ],
        actions: []
      })
    })
  })
})
