import store from '../../../../src/store'
import PatientWarningsComponent from '../../../../src/components/manage/patients/PatientWarnings.vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientWarnings component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    store.state.patients[symbols.state.totalSubPatients] = 0
    store.state.patients[symbols.state.questionnaireStatuses].symptoms = 0
    store.state.patients[symbols.state.isEmailBounced] = false
    store.state.patients[symbols.state.rejectedClaimsForCurrentPatient] = []
    store.state.patients[symbols.state.incompleteHomeSleepTests] = []

    const props = {
      patientId: 1
    }

    this.testCase.setComponent(PatientWarningsComponent)
    this.testCase.setPropsData(props)
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows empty data', function () {
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(0)
  })

  it('shows patient changes', function () {
    store.state.patients[symbols.state.totalSubPatients] = 3
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(1)
    const firstChild = vm.$el.children[0]
    expect(firstChild.getAttribute('href')).toContain('patient_changes.php?pid=1')
    expect(firstChild.textContent).toBe('Warning! Patient has updated their PROFILE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.')
  })

  it('shows questionnaire changes', function () {
    store.state.patients[symbols.state.questionnaireStatuses].symptoms = 2
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(1)
    const firstChild = vm.$el.children[0]
    expect(firstChild.getAttribute('href')).toContain('q_page1.php?pid=1&addtopat=1')
    expect(firstChild.textContent).toBe('Warning! Patient has updated their QUESTIONNAIRE via the online patient portal, and you have not yet accepted these changes. Please click this box to review patient changes.')
  })

  it('shows bounced emails', function () {
    store.state.patients[symbols.state.isEmailBounced] = true
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(1)
    const firstChild = vm.$el.children[0]
    expect(firstChild.getAttribute('href')).toContain('add_patient.php?ed=1&pid=1&addtopat=1')
    expect(firstChild.textContent).toBe('Warning! Email sent to this patient has bounced. Please click to check patients email.')
  })

  it('shows rejected claims', function () {
    store.state.patients[symbols.state.rejectedClaimsForCurrentPatient] = [
      {
        insuranceId: 1,
        addDate: new Date('12/10/2017')
      },
      {
        insuranceId: 2,
        addDate: new Date('12/11/2017')
      }
    ]
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(1)
    const firstChild = vm.$el.children[0]
    const claims = firstChild.querySelectorAll('span')
    expect(claims.length).toBe(2)
    const firstLink = claims[0].querySelector('a')
    expect(firstLink.getAttribute('href')).toContain('view_claim.php?claimid=1&pid=1')
    expect(claims[0].textContent.trim()).toBe('1 - 12/10/2017')
    const secondLink = claims[1].querySelector('a')
    expect(secondLink.getAttribute('href')).toContain('view_claim.php?claimid=2&pid=1')
    expect(claims[1].textContent.trim()).toBe('2 - 12/11/2017')
  })

  it('shows incomplete HSTs', function () {
    store.state.patients[symbols.state.incompleteHomeSleepTests] = [
      {
        id: 1,
        status: 2,
        patientId: 3,
        addDate: new Date('12/10/2017'),
        rejectedDate: null,
        officeNotes: 'notes',
        rejectedReason: 'reason'
      },
      {
        id: 2,
        status: 2,
        patientId: 3,
        addDate: new Date('12/10/2017'),
        rejectedDate: null,
        officeNotes: 'notes',
        rejectedReason: 'reason'
      }
    ]
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(1)
    const firstChild = vm.$el.children[0]
    const subComponents = firstChild.children
    expect(subComponents.length - 1).toBe(2)
  })
})
