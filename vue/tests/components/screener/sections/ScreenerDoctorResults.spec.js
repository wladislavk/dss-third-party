import store from '../../../../src/store'
import ScreenerDoctorResultsComponent from '../../../../src/components/screener/sections/ScreenerDoctorResults.vue'
import symbols from '../../../../src/symbols'
import endpoints from '../../../../src/endpoints'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerDoctorResults component', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerDoctorResultsComponent)

    this.testCase.stubRequest({
      url: endpoints.epworthSleepinessScale.index + '?status=1&order=sortby',
      response: [
        {
          epworthid: 1,
          epworth: 'foo',
          selected: 1
        },
        {
          epworthid: 2,
          epworth: 'bar',
          selected: 0
        },
        {
          epworthid: 3,
          epworth: 'baz',
          selected: 4
        }
      ]
    })
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('shows results', function (done) {
    store.commit(symbols.mutations.surveyWeight, 12)
    store.commit(symbols.mutations.epworthWeight, 1)
    store.commit(symbols.mutations.addStoredCpap, 4)
    store.commit(symbols.mutations.cpap)

    store.state.screener[symbols.state.storedContactData] = {
      first_name: 'John',
      last_name: 'Doe',
      phone: '2233223223'
    }
    store.commit(symbols.mutations.contactData)

    store.commit(symbols.mutations.addStoredSymptom, { name: 'driving', value: 6 })
    store.commit(symbols.mutations.addStoredSymptom, { name: 'gasping', value: 0 })
    store.commit(symbols.mutations.symptoms)

    const coMorbidityData = {
      rx_stroke: true,
      rx_diabetes: true
    }
    store.commit(symbols.mutations.coMorbidity, coMorbidityData)

    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const epworthProps = {
        1: 1,
        2: 0,
        3: 4
      }
      // todo: direct store modification should not occur after mount
      store.commit(symbols.mutations.modifyEpworthProps, epworthProps)
      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        const contactDivs = vm.$el.querySelectorAll('div.contact_div')
        expect(contactDivs.length).toBe(3)
        expect(contactDivs[0].querySelector('label').textContent).toBe('First name:')
        expect(contactDivs[0].querySelector('span').textContent).toBe('John')
        expect(contactDivs[1].querySelector('label').textContent).toBe('Last name:')
        expect(contactDivs[1].querySelector('span').textContent).toBe('Doe')
        expect(contactDivs[2].querySelector('label').textContent).toBe('Phone:')
        expect(contactDivs[2].querySelector('span').textContent).toBe('2233223223')

        const epworthWeight = vm.$el.querySelector('span#r_ep_total').textContent
        expect(epworthWeight).toBe('1')

        const epworthDivs = vm.$el.querySelectorAll('div.epworth_div')
        expect(epworthDivs.length).toBe(2)
        expect(epworthDivs[1].querySelector('span').textContent).toBe('4')
        expect(epworthDivs[1].querySelector('label').textContent).toBe('baz')

        const symptomDivs = vm.$el.querySelectorAll('div.symptom_div')
        expect(symptomDivs.length).toBe(1)
        expect(symptomDivs[0].querySelector('span').textContent).toBe('Yes')
        expect(symptomDivs[0].querySelector('label').textContent).toBe('Have you ever fallen asleep or nodded off while driving?')

        const cpap = vm.$el.querySelector('span#r_rx_cpap')
        expect(cpap.textContent).toBe('Yes')

        const coMorbidityLines = vm.$el.querySelectorAll('ul#r_diagnosed > li')
        expect(coMorbidityLines.length).toBe(2)
        expect(coMorbidityLines[0].textContent).toBe('Stroke')
        expect(coMorbidityLines[1].textContent).toBe('Diabetes')

        done()
      })
    })
  })
})
