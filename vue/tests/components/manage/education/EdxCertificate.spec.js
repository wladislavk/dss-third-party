import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import EdxCertificateComponent from '../../../../src/components/manage/education/EdxCertificate.vue'

describe('EdxCertificate component', () => {
  beforeEach(function () {
    moxios.install()

    moxios.stubRequest(http.formUrl(endpoints.edxCertificates.byUser), {
      status: 200,
      responseText: {
        data: [
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
      }
    })

    const Component = Vue.extend(EdxCertificateComponent)
    this.mount = function () {
      return new Component({
        store: store
      }).$mount()
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should show certificate links', function (done) {
    const vm = this.mount()
    moxios.wait(() => {
      const children = vm.$el.querySelectorAll('ul li a')
      expect(children.length).toEqual(2)
      expect(children[0].getAttribute('href')).toEqual('http://some_url.com')
      expect(children[1].getAttribute('href')).toEqual('http://some_url2.com')
      done()
    })
  })
})
