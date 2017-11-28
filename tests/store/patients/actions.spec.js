import PatientsModule from '../../../src/store/patients'
import sinon from 'sinon'
import TestCase from '../../cases/StoreTestCase'
import http from '../../../src/services/http'
import endpoints from '../../../src/endpoints'
import symbols from '../../../src/symbols'

describe('Patients module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('patientData action', () => {
    it('should get patient data', function (done) {
      const patientId = 1
      const postData = []
      const result = {
        data: {
          data: {
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
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      PatientsModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)

      const expectedMutations = [
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
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.patients.patientData + '/1'
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('should handle error', function (done) {
      const patientId = 1
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })

      PatientsModule.actions[symbols.actions.patientData](this.testCase.mocks, patientId)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getPatientByIdAndDocId',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('clearPatientData action', () => {
    it('clears patient data', function () {
      PatientsModule.actions[symbols.actions.clearPatientData](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.patientId,
          payload: 0
        },
        {
          type: symbols.mutations.clearPatientData,
          payload: {}
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })
})
