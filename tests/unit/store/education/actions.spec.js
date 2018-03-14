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
              id: '1',
              url: 'http://preprod.edx.dss.xforty.com/courses/x40/Course001/Now/3/retrieve_cert',
              edx_id: '3',
              course_name: 'Course001',
              course_section: 'Now',
              course_subsection: 'Section 1',
              number_ce: '1',
              adddate: '2014-03-17 22:15:41',
              ip_address: '10.20.1.168'
            },
            {
              id: '2',
              url: 'http://preprod.edx.dss.xforty.com/courses/DentalSleepSolutions/DSS10/Always/3/courseware/50bfaf05aaa548bb98ca123f888bde57/retrieve_cert',
              edx_id: '3',
              course_name: 'DSS10',
              course_section: 'Always',
              course_subsection: 'Module 1: Introduction / Getting Started',
              number_ce: '1',
              adddate: '2014-04-01 11:39:11',
              ip_address: '10.20.1.168'
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
              id: 1,
              url: 'http://preprod.edx.dss.xforty.com/courses/x40/Course001/Now/3/retrieve_cert',
              courseName: 'Course001',
              courseSection: 'Now',
              courseSubsection: 'Section 1',
              numberCe: 1
            },
            {
              id: 2,
              url: 'http://preprod.edx.dss.xforty.com/courses/DentalSleepSolutions/DSS10/Always/3/courseware/50bfaf05aaa548bb98ca123f888bde57/retrieve_cert',
              courseName: 'DSS10',
              courseSection: 'Always',
              courseSubsection: 'Module 1: Introduction / Getting Started',
              numberCe: 1
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
