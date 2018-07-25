import store from '../../../../src/store'
import PatientInnerMenuComponent from '../../../../src/components/manage/patients/PatientInnerMenu.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientInnerMenu component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.patientName] = 'John Doe'
    store.state.patients[symbols.state.medicare] = false
    store.state.patients[symbols.state.displayAlert] = false
    store.state.patients[symbols.state.headerAlertText] = ''
    store.state.patients[symbols.state.headerTitle] = 'title'
    store.state.patients[symbols.state.premedCheck] = 0
    store.state.patients[symbols.state.allergen] = false

    const props = {
      patientId: 1
    }

    this.testCase.setComponent(PatientInnerMenuComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows menu', function () {
    const vm = this.testCase.mount()

    const patientNameDiv = vm.$el
    expect(patientNameDiv.className).not.toContain('long-patient')
    const medicareLogo = patientNameDiv.querySelector('img')
    expect(medicareLogo).toBeNull()
    const patientNameSpan = patientNameDiv.querySelector('span.patient_name')
    expect(patientNameSpan.className).toBe('patient_name name')
    expect(patientNameSpan.firstChild.textContent).toBe('John Doe')
    const links = patientNameSpan.querySelectorAll('a')
    expect(links.length).toBe(0)
  })

  it('shows menu with medicare', function () {
    store.state.patients[symbols.state.medicare] = true
    const vm = this.testCase.mount()

    const patientNameDiv = vm.$el
    const medicareLogo = patientNameDiv.querySelector('img')
    expect(medicareLogo).not.toBeNull()
    const patientNameSpan = patientNameDiv.querySelector('span.patient_name')
    expect(patientNameSpan.className).toBe('patient_name medicare_name')
  })

  it('shows menu with long patient name', function () {
    store.state.patients[symbols.state.patientName] = 'Benedict J. Cumberbatch'
    const vm = this.testCase.mount()

    const patientNameDiv = vm.$el
    expect(patientNameDiv.className).toContain('long-patient')
  })

  it('shows menu with notes', function () {
    store.state.patients[symbols.state.displayAlert] = true
    store.state.patients[symbols.state.headerAlertText] = 'foo&bar'
    const vm = this.testCase.mount()

    const patientNameSpan = vm.$el.querySelector('span.patient_name')
    const links = patientNameSpan.querySelectorAll('a')
    expect(links.length).toBe(1)
    const notesLink = links[0]
    expect(notesLink.textContent).toBe('Notes')
    expect(notesLink.getAttribute('title')).toBe('Notes: foo&bar')
  })

  it('shows menu with premedcheck', function () {
    store.state.patients[symbols.state.premedCheck] = 1
    const vm = this.testCase.mount()

    const patientNameSpan = vm.$el.querySelector('span.patient_name')
    const links = patientNameSpan.querySelectorAll('a')
    expect(links.length).toBe(1)
    const medLink = links[0]
    expect(medLink.textContent).toBe('*Med')
    expect(medLink.getAttribute('title')).toBe('title')
    expect(medLink.getAttribute('href')).toContain('q_page3.php?pid=1')
  })

  it('shows menu with allergen', function () {
    store.state.patients[symbols.state.allergen] = true
    const vm = this.testCase.mount()

    const patientNameSpan = vm.$el.querySelector('span.patient_name')
    const links = patientNameSpan.querySelectorAll('a')
    expect(links.length).toBe(1)
    const medLink = links[0]
    expect(medLink.textContent).toBe('*Med')
  })
})
