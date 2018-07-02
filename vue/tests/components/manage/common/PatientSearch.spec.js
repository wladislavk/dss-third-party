import moxios from 'moxios'
import PatientSearchComponent from '../../../../src/components/manage/common/PatientSearch.vue'
import http from '../../../../src/services/http'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientSearch component', () => {
  beforeEach(function () {
    moxios.install()
    this.testCase = new TestCase()

    this.testCase.setComponent(PatientSearchComponent)
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('shows options without matches', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.patients.list), {
      status: 200,
      responseText: {
        data: []
      }
    })
    const vm = this.testCase.mount()
    const searchInput = vm.$el.querySelector('input#patient_search')
    const searchHints = vm.$el.querySelector('div#search_hints')
    const patientList = vm.$el.querySelector('ul#patient_list')
    expect(searchHints.style.display).toBe('none')
    expect(patientList.style.display).toBe('none')
    searchInput.value = 'foo'
    const keyupEvent = new Event('keyup')
    keyupEvent.keyCode = 42
    searchInput.dispatchEvent(keyupEvent)
    setTimeout(() => {
      expect(searchHints.style.display).toBe('')
      expect(patientList.style.display).toBe('')
      const results = searchHints.querySelectorAll('li.template')
      expect(results.length).toBe(2)
      expect(results[0].className).toContain('no_matches')
      expect(results[0].textContent).toBe('No Matches')
      expect(results[1].className).toContain('create_new')
      expect(results[1].textContent).toBe('Add patient with this name\u2026')
      done()
    }, 600)
  })

  it('shows options with matches', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.patients.list), {
      status: 200,
      responseText: {
        data: [
          {
            patientId: 1,
            firstname: 'John',
            lastname: 'Doe'
          },
          {
            patientId: 2,
            firstname: 'John',
            lastname: 'Little'
          }
        ]
      }
    })
    const vm = this.testCase.mount()
    const searchInput = vm.$el.querySelector('input#patient_search')
    const searchHints = vm.$el.querySelector('div#search_hints')
    searchInput.value = 'John'
    const keyupEvent = new Event('keyup')
    keyupEvent.keyCode = 42
    searchInput.dispatchEvent(keyupEvent)
    setTimeout(() => {
      const results = searchHints.querySelectorAll('li.template')
      expect(results.length).toBe(2)
      expect(results[0].className).toContain('json_patient')
      expect(results[0].textContent).toBe('Doe, John')
      expect(results[1].className).toContain('json_patient')
      expect(results[1].textContent).toBe('Little, John')
      done()
    }, 600)
  })
})
