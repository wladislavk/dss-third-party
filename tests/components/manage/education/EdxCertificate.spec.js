import Vue from 'vue'
import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import store from '../../../../src/store'
import EdxCertificateComponent from '../../../../src/components/manage/education/EdxCertificate.vue'

describe('EdxCertificate component', () => {
  beforeEach(function () {
    moxios.install()

    moxios.stubRequest(http.formUrl(endpoints.education.edxCertificates), {
      status: 200,
      responseText: {
        data: [
          {
            id: 1,
            url: 'http://some_url.com',
            edx_id: 3,
            course_name: 'Course001',
            course_section: 'Now',
            course_subsection: 'Section 1',
            number_ce: 1,
            adddate: '2014-03-17 22:15:41',
            ip_address: '10.20.1.168'
          },
          {
            id: 2,
            url: 'http://some_url2.com',
            edx_id: 3,
            course_name: 'DSS10',
            course_section: 'Always',
            course_subsection: 'Module 1: Introduction / Getting Started',
            number_ce: 1,
            adddate: '2014-04-01 11:39:11',
            ip_address: '10.20.1.168'
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

  it('should show certificate HTML', function (done) {
    const vm = this.mount()
    moxios.wait(function () {
      console.log('html', vm.$el.querySelectorAll('ul')[0].innerHTML)
      const children = vm.$el.querySelectorAll('ul li')
      expect(children.length).toEqual(2)
      // const viewAllButton = vm.$el.querySelector('a.task_view_all')
      // expect(viewAllButton.getAttribute('href')).toBe(ProcessWrapper.getLegacyRoot() + 'manage/manage_tasks.php')
      done()
    })
  })
})
