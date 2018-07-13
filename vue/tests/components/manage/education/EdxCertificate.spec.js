import endpoints from '../../../../src/endpoints'
import EdxCertificateComponent from '../../../../src/components/manage/education/EdxCertificate.vue'
import TestCase from '../../../cases/ComponentTestCase'

describe('EdxCertificate component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.stubRequest({
      url: endpoints.edxCertificates.byUser,
      response: [
        {
          id: 1,
          url: 'http://some_url.com',
          course_name: 'Course001',
          course_section: 'Now',
          course_subsection: 'Section 1',
          number_ce: 1
        },
        {
          id: 2,
          url: 'http://some_url2.com',
          course_name: 'DSS10',
          course_section: 'Always',
          course_subsection: 'Module 1: Introduction / Getting Started',
          number_ce: 1
        }
      ]
    })

    this.testCase.setComponent(EdxCertificateComponent)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should show certificate links', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const children = vm.$el.querySelectorAll('ul li a')
      expect(children.length).toEqual(2)
      expect(children[0].getAttribute('href')).toEqual('http://some_url.com')
      expect(children[1].getAttribute('href')).toEqual('http://some_url2.com')
      done()
    })
  })
})
