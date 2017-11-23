import endpoints from '../../../../src/endpoints'
import http from '../../../../src/services/http'
import moxios from 'moxios'
import TestCase from '../../../cases/ComponentTestCase'
import ViewContactComponent from '../../../../src/components/manage/contacts/ViewContact.vue'
import { LEGACY_URL } from '../../../../src/constants/main'

describe('ViewContact', () => {
  beforeEach(function () {
    moxios.install()

    this.vueOptions = {
      template: '<div><view-contact contactid="1"></view-contact></div>',
      components: {
        'viewContact': ViewContactComponent
      }
    }

    this.mockData = {
      contactid: 1,
      salutation: 'Mr',
      firstname: 'John',
      middlename: 'M',
      lastname: 'Doe',
      company: 'Acme',
      contacttype: 1,
      add1: 'address 1',
      add2: 'address 2',
      city: 'Omaha',
      state: 'NE',
      zip: '10110',
      phone1: '2233223223',
      phone2: 'abc123+def789,9383',
      fax: '',
      email: 'foo@bar.com',
      notes: 'ddd',
      corporate: 1
    }
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should render with API success and corporate', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.contacts.withContactType), {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    const vm = TestCase.getVue(this.vueOptions).$mount()

    const getSpan = (number) => {
      const css = `div#view-contact > div > div.info:nth-child(${number}) > span.value`
      return vm.$el.querySelector(css).textContent.trim()
    }

    moxios.wait(() => {
      expect(getSpan(1)).toBe('Mr John M Doe')
      expect(getSpan(2)).toBe('Acme')
      expect(getSpan(3)).toBe('1')
      expect(getSpan(4)).toBe('address 1')
      expect(getSpan(5)).toBe('address 2')
      expect(getSpan(6)).toBe('Omaha NE 10110')
      expect(getSpan(7)).toBe('(223) 322-3223')
      expect(getSpan(8)).toBe('(123) 789-9383')
      expect(getSpan(9)).toBe('')
      expect(getSpan(10)).toBe('foo@bar.com')
      expect(getSpan(11)).toBe('ddd')
      const link = vm.$el.querySelector('div#view-contact > div > a')
      expect(link.getAttribute('href')).toBe(LEGACY_URL + 'view_fcontact.php?ed=1')
      expect(link.textContent).toBe('View Full')
      done()
    })
  })

  it('should render with API success and non-corporate', function (done) {
    this.mockData.corporate = 0
    moxios.stubRequest(http.formUrl(endpoints.contacts.withContactType), {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    const vm = TestCase.getVue(this.vueOptions).$mount()

    moxios.wait(() => {
      const link = vm.$el.querySelector('div#view-contact > div > a')
      expect(link.getAttribute('href')).toBe(LEGACY_URL + 'add_contact.php?ed=1')
      expect(link.textContent).toBe('Edit')
      done()
    })
  })
})
