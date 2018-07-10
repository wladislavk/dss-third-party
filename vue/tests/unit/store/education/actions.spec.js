import EducationModule from '../../../../src/store/education'
import TestCase from '../../../cases/StoreTestCase'
import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'

describe('Education module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('getEdxCertificatesData action', () => {
    it('should get Edx Certificates data', function (done) {
      const response = [
        {
          id: '1',
          url: 'http://preprod.edx.dss.xforty.com/courses/x40/Course001/Now/3/retrieve_cert',
          course_name: 'Course001',
          course_section: 'Now',
          course_subsection: 'Section 1',
          number_ce: '1'
        },
        {
          id: '2',
          url: 'http://preprod.edx.dss.xforty.com/courses/DentalSleepSolutions/DSS10/Always/3/courseware/50bfaf05aaa548bb98ca123f888bde57/retrieve_cert',
          course_name: 'DSS10',
          course_section: 'Always',
          course_subsection: 'Module 1: Introduction / Getting Started',
          number_ce: '1'
        }
      ]
      this.testCase.stubRequest({response: response})

      EducationModule.actions[symbols.actions.getEdxCertificatesData](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.edxCertificates.byUser },
          mutations: [
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
          ],
          actions: []
        })
        done()
      })
    })

    it('should handle error', function (done) {
      this.testCase.stubErrorRequest()

      EducationModule.actions[symbols.actions.getEdxCertificatesData](this.testCase.mocks)

      this.testCase.wait(() => {
        expect(this.testCase.getResults()).toEqual({
          http: { path: endpoints.edxCertificates.byUser },
          mutations: [],
          actions: [
            this.testCase.getErrorHandler('getEdxCertificatesData')
          ]
        })
        done()
      })
    })
  })
})
