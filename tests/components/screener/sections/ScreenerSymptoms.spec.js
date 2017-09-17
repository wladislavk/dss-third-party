import Vue from 'vue'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'

const ScreenerSymptomsComponent = require('../../../../src/components/screener/sections/ScreenerSymptoms.vue').default

describe('ScreenerSymptoms', () => {
  beforeEach(function () {
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

    const routes = [
      {
        name: 'screener-diagnoses',
        path: '/diagnoses'
      }
    ]

    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    const vueOptions = {
      template: '<div><screener-symptoms></screener-symptoms></div>',
      components: {
        screenerSymptoms: ScreenerSymptomsComponent
      }
    }

    this.vue = TestCase.getVue(vueOptions, routes)
    this.vm = this.vue.$mount()

    this.setSymptoms = function () {
      for (let symptom of this.vue.$store.state.screener[symbols.state.symptoms]) {
        if (this.answers.hasOwnProperty(symptom.name)) {
          const answer = this.answers[symptom.name]
          let answerNumber
          if (answer) {
            answerNumber = 1
          } else {
            answerNumber = 2
          }
          const input = this.vm.$el.querySelector('input#' + symptom.name + answerNumber)
          input.click()
        }
      }
    }
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
  })

  it('should display existing fields', function (done) {
    const allLabels = this.vm.$el.querySelectorAll('div#sect3 > div.sepH_b')
    expect(allLabels.length).toBe(12)

    const getLabel = (number) => {
      const css = 'label.question'
      const index = number - 1
      return allLabels[index].querySelector(css).textContent.trim()
    }

    expect(getLabel(1)).toBe('Have you ever been told you stop breathing while asleep?')
    expect(getLabel(2)).toBe('Have you ever fallen asleep or nodded off while driving?')

    done()
  })

  it('should update data when all fields are set', function (done) {
    const nextButton = this.vm.$el.querySelector('a#sect3_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    this.setSymptoms()

    nextButton.click()

    this.vm.$nextTick(() => {
      const symptoms = this.vue.$store.state.screener[symbols.state.symptoms]
      for (let symptom of symptoms) {
        const answer = this.answers[symptom.name]
        if (answer) {
          expect(symptom.selected).toBe('' + symptom.weight)
        } else {
          expect(symptom.selected).toBe('0')
        }
      }

      expect(nextButton.classList.contains('disabled')).toBe(true)
      expect(this.vue.$router.currentRoute.name).toBe('screener-diagnoses')
      done()
    })
  })

  it('should throw error when some fields are not set', function (done) {
    const nextButton = this.vm.$el.querySelector('a#sect3_next')
    expect(nextButton.classList.contains('disabled')).toBe(false)

    delete this.answers.snore
    delete this.answers.headaches
    this.setSymptoms()

    nextButton.click()

    this.vm.$nextTick(() => {
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const errorDivs = this.vm.$el.querySelectorAll('div.msg_error > div.error')
      expect(errorDivs.length).toBe(2)
      expect(errorDivs[0].textContent).toContain('Do you snore or have you ever been told that you snore?')
      expect(errorDivs[1].textContent).toContain('Do you wake up with headaches during the night or in the morning?')

      done()
    })
  })
})
