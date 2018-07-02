import PatientIncompleteHstComponent from '../../../../src/components/manage/patients/PatientIncompleteHst.vue'
import { DSS_CONSTANTS } from '../../../../src/constants/main'
import TestCase from '../../../cases/ComponentTestCase'

describe('PatientIncompleteHst component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(PatientIncompleteHstComponent)

    this.propsData = {
      status: 10,
      patientId: 1,
      hstId: 2,
      dateAdded: new Date('03/02/2016'),
      dateRejected: null,
      officeNotes: 'notes',
      rejectedReason: 'reason'
    }
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows warning', function () {
    this.testCase.setPropsData(this.propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(4)
    const firstLink = vm.$el.firstChild
    expect(firstLink.getAttribute('href')).toContain('manage/hst_request.php?pid=1&hst_id=2')
    expect(firstLink.textContent).toContain('03/02/2016')
    const thirdChild = vm.$el.children[2]
    expect(thirdChild.innerHTML).toBe('<span></span>')
  })

  it('shows with status label', function () {
    this.propsData.status = 0
    this.testCase.setPropsData(this.propsData)
    const vm = this.testCase.mount()

    const thirdChild = vm.$el.children[2]
    expect(thirdChild.innerHTML).toBe('<span>Unsent</span>')
  })

  it('shows with scheduled status', function () {
    this.propsData.status = DSS_CONSTANTS.DSS_HST_SCHEDULED
    this.testCase.setPropsData(this.propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(5)
    const fourthChild = vm.$el.children[3]
    expect(fourthChild.textContent).toBe(' - notes')
  })

  it('shows with rejected status', function () {
    this.propsData.status = DSS_CONSTANTS.DSS_HST_REJECTED
    this.testCase.setPropsData(this.propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(6)
    const thirdChild = vm.$el.children[2]
    expect(thirdChild.textContent).toBe('Rejected')
    expect(thirdChild.querySelector('a')).not.toBeNull()
    const fourthChild = vm.$el.children[3]
    expect(fourthChild.textContent).toBe(' - reason')
    const sixthChild = vm.$el.children[5]
    expect(sixthChild.textContent).toContain('Click here')
  })

  it('shows with rejected with date', function () {
    this.propsData.status = DSS_CONSTANTS.DSS_HST_REJECTED
    this.propsData.dateRejected = new Date('04/03/2016')
    this.testCase.setPropsData(this.propsData)
    const vm = this.testCase.mount()

    expect(vm.$el.children.length).toBe(7)
    const fifthChild = vm.$el.children[4]
    expect(fifthChild.textContent).toBe(' - 04/03/2016 12:00 am')
  })
})
