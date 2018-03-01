import EducationModule from '../../../../src/store/education'
import sinon from 'sinon'
import TestCase from '../../../cases/StoreTestCase'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'

describe('Education module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('getEdxCertificatesData action', () => {
    it('should get Edx Certificates data', function (done) {
      const postData = []
      const result = {
        data: {
          data: [
            {
              someData: 'http://some_url.com'
            },
            {
              someData: 'http://some_url2.com'
            }
          ]
        }
      }
      this.sandbox.stub(http, 'get').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      EducationModule.actions[symbols.actions.getEdxCertificatesData](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.edxCertificatesData,
          payload: [
            {
              someData: 'http://some_url.com'
            },
            {
              someData: 'http://some_url2.com'
            }
          ]
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          {
            path: endpoints.education.edxCertificates
          }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })

    it('should handle error', function (done) {
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
      })

      EducationModule.actions[symbols.actions.getEdxCertificatesData](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getEdxCertificatesData',
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
})
