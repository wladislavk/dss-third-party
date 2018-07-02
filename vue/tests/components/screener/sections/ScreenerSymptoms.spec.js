import symbols from '../../../../src/symbols'
import ScreenerSymptomsComponent from '../../../../src/components/screener/sections/ScreenerSymptoms.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerSymptoms', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.answers = {
      breathing: true,
      driving: false,
      gasping: true,
      sleepy: false,
      snore: true,
      weight_gain: false,
      blood_pressure: true,
      jerk: false,
      burning: true,
      headaches: false,
      falling_asleep: true,
      staying_asleep: false
    }

    this.testCase.setComponent(ScreenerSymptomsComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-diagnoses',
        path: '/diagnoses'
      }
    ])

    this.setSymptoms = function () {
      for (let symptom of store.state.screener[symbols.state.symptoms]) {
        if (this.answers.hasOwnProperty(symptom.name)) {
          const answer = this.answers[symptom.name]
          const payload = {
            name: symptom.name,
            value: 0
          }
          if (answer) {
            payload.value = symptom.weight
          }
          store.commit(symbols.mutations.addStoredSymptom, payload)
        }
      }
    }
  })

  afterEach(function () {
    store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should display existing fields', function () {
    const vm = this.testCase.mount()

    const allLabels = vm.$el.querySelectorAll('div#sect3 > div.sepH_b')
    expect(allLabels.length).toBe(12)

    const getLabel = (number) => {
      const css = 'label.question'
      const index = number - 1
      return allLabels[index].querySelector(css).textContent.trim()
    }

    expect(getLabel(1)).toBe('Have you ever been told you stop breathing while asleep?')
    expect(getLabel(2)).toBe('Have you ever fallen asleep or nodded off while driving?')
  })

  it('should update data when all fields are set', function (done) {
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect3_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    this.setSymptoms()

    nextButton.click()

    vm.$nextTick(() => {
      const symptoms = store.state.screener[symbols.state.symptoms]
      for (let symptom of symptoms) {
        const answer = this.answers[symptom.name]
        if (answer) {
          expect(symptom.selected).toBe(symptom.weight)
        } else {
          expect(symptom.selected).toBe(0)
        }
      }

      expect(nextButton.classList.contains('disabled')).toBe(true)
      expect(vm.$router.currentRoute.name).toBe('screener-diagnoses')
      done()
    })
  })

  it('should throw error when some fields are not set', function (done) {
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect3_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    delete this.answers.snore
    delete this.answers.headaches
    this.setSymptoms()

    nextButton.click()

    vm.$nextTick(() => {
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const errorDivs = vm.$el.querySelectorAll('div.msg_error > div.error')
      expect(errorDivs.length).toBe(2)
      expect(errorDivs[0].textContent).toContain('Snore:')
      expect(errorDivs[1].textContent).toContain('Headaches:')

      done()
    })
  })
})
