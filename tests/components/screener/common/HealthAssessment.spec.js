import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

const HealthAssessmentComponent = require('../../../../src/components/screener/common/HealthAssessment.vue').default

describe('HealthAssessment', () => {
  beforeAll(function () {
    this.vue = TestCase.getVue({
      template: '<div><health-assessment></health-assessment></div>',
      components: {
        'healthAssessment': HealthAssessmentComponent
      }
    })
    this.vm = this.vue.$mount()
  })

  it('should display full name taken from Vuex', function () {
    const contactData = this.vue.$store[symbols.state.contactData]
    for (let element of contactData) {
      if (element.camelName === 'firstName') {
        element.value = 'John'
      }
      if (element.camelName === 'lastName') {
        element.value = 'Doe'
      }
    }
    this.vue.$store.commit(symbols.mutations.contactData, contactData)

    const contents = this.vm.$el.querySelector('h5').textContent
    const expected = 'Health Assessment - John Doe'
    expect(contents).toBe(expected)
  })
})
