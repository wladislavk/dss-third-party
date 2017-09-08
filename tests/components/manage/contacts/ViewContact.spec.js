import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

const ViewContactComponent = require('../../../../src/components/manage/contacts/ViewContact.vue').default

describe('ViewContact', () => {
  beforeAll(function () {
    this.vue = TestCase.getVue({
      template: '<div><view-contact></view-contact></div>',
      components: {
        'viewContact': ViewContactComponent
      }
    })
    this.vm = this.vue.$mount()
  })

  beforeEach(function () {
    moxios.install()

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
    moxios.stubRequest(process.env.API_PATH + 'contacts/with-contact-type', {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    this.vue.$store.dispatch(symbols.actions.setCurrentContact, { contactId: 1 })

    const getSpan = (number) => {
      const css = `div#view-contact > div > div.info:nth-child(${number}) > span.value`
      return this.vm.$el.querySelector(css).textContent.trim()
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
      const link = this.vm.$el.querySelector('div#view-contact > div > a')
      expect(link.getAttribute('href')).toBe('#/view_fcontact.php?ed=1')
      expect(link.textContent).toBe('View Full')
      done()
    })
  })

  it('should render with API success and non-corporate', function (done) {
    this.mockData.corporate = 0
    moxios.stubRequest(process.env.API_PATH + 'contacts/with-contact-type', {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    this.vue.$store.dispatch(symbols.actions.setCurrentContact, { contactId: 1 })

    moxios.wait(() => {
      const link = this.vm.$el.querySelector('div#view-contact > div > a')
      expect(link.getAttribute('href')).toBe('#/add_contact.php?ed=1')
      expect(link.textContent).toBe('Edit')
      done()
    })
  })
})
