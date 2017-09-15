import http from '../services/http'
import symbols from '../symbols'

export default {
  state: {
    [symbols.state.doctorName]: '',
    [symbols.state.assessmentName]: '',
    [symbols.state.screenerWeights]: {
      coMorbidity: 0,
      epworth: 0,
      survey: 0
    },
    [symbols.state.contactData]: [
      {
        name: 'first_name',
        camelName: 'firstName',
        label: 'First Name',
        class: '',
        firstPage: true,
        hstColumn: 'left'
      },
      {
        name: 'last_name',
        camelName: 'lastName',
        label: 'Last Name',
        class: '',
        firstPage: true,
        hstColumn: 'left'
      },
      {
        name: 'dob',
        camelName: 'dob',
        label: 'Date of Birth',
        class: 'datemask',
        firstPage: false,
        hstColumn: 'left'
      },
      {
        name: 'phone',
        camelName: 'phone',
        label: 'Phone Number',
        class: 'phonemask',
        firstPage: true,
        hstColumn: 'right'
      },
      {
        name: 'email',
        camelName: 'email',
        label: 'Email',
        class: '',
        firstPage: false,
        hstColumn: 'right'
      }
    ],
    [symbols.state.contactProperties]: {
      firstName: '',
      lastName: '',
      phone: ''
    },
    [symbols.state.epworthProps]: [],
    [symbols.state.epworthOptions]: [
      {
        option: '0',
        label: 'No chance of dozing'
      },
      {
        option: '1',
        label: 'Slight chance of dozing'
      },
      {
        option: '2',
        label: 'Moderate chance of dozing'
      },
      {
        option: '3',
        label: 'High chance of dozing'
      }
    ],
    [symbols.state.symptoms]: [
      {
        name: 'breathing',
        label: 'Have you ever been told you stop breathing while asleep?',
        weight: 8
      },
      {
        name: 'driving',
        label: 'Have you ever fallen asleep or nodded off while driving?',
        weight: 6
      },
      {
        name: 'gasping',
        label: 'Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?',
        weight: 6
      },
      {
        name: 'sleepy',
        label: 'Do you feel excessively sleepy during the day?',
        weight: 4
      },
      {
        name: 'snore',
        label: 'Do you snore or have you ever been told that you snore?',
        weight: 4
      },
      {
        name: 'weight_gain',
        label: 'Have you had weight gain and found it difficult to lose?',
        weight: 2
      },
      {
        name: 'blood_pressure',
        label: 'Have you taken medication for, or been diagnosed with high blood pressure?',
        weight: 2
      },
      {
        name: 'jerk',
        label: 'Do you kick or jerk your legs while sleeping?',
        weight: 3
      },
      {
        name: 'burning',
        label: 'Do you feel burning, tingling or crawling sensations in your legs when you wake up?',
        weight: 3
      },
      {
        name: 'headaches',
        label: 'Do you wake up with headaches during the night or in the morning?',
        weight: 3
      },
      {
        name: 'falling_asleep',
        label: 'Do you have trouble falling asleep?',
        weight: 4
      },
      {
        name: 'staying_asleep',
        label: 'Do you have trouble staying asleep once you fall asleep?',
        weight: 4
      }
    ],
    [symbols.state.coMorbidityData]: [
      {
        name: 'rx_blood_pressure',
        label: 'High blood pressure',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_apnea',
        label: 'Sleep Apnea',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_lung_disease',
        label: 'Lung Disease',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_insomnia',
        label: 'Insomnia',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_depression',
        label: 'Depression',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_medication',
        label: 'Sleeping medication',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_restless_leg',
        label: 'Restless leg syndrome',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_headaches',
        label: 'Morning headaches',
        weight: 1,
        diagnosis: null
      },
      {
        name: 'rx_heart_disease',
        label: 'Heart Failure',
        weight: 2,
        diagnosis: 1
      },
      {
        name: 'rx_stroke',
        label: 'Stroke',
        weight: 2,
        diagnosis: 2
      },
      {
        name: 'rx_hypertension',
        label: 'Hypertension',
        weight: 1,
        diagnosis: 3
      },
      {
        name: 'rx_diabetes',
        label: 'Diabetes',
        weight: 1,
        diagnosis: 4
      },
      {
        name: 'rx_metabolic_syndrome',
        label: 'Metabolic Syndrome',
        weight: 1,
        diagnosis: 5
      },
      {
        name: 'rx_obesity',
        label: 'Obesity',
        weight: 2,
        diagnosis: 6
      },
      {
        name: 'rx_heartburn',
        label: 'Heartburn (Gastroesophageal Reflux)',
        weight: 1,
        diagnosis: 7
      },
      {
        name: 'rx_afib',
        label: 'Atrial Fibrillation',
        weight: 2,
        diagnosis: 8
      },
      {
        name: 'rx_cpap',
        label: '',
        weight: 4,
        diagnosis: null
      },
      {
        name: 'rx_narcolepsy',
        label: '',
        weight: 1,
        diagnosis: null
      }
    ]
  },
  getters: {
    [symbols.getters.fullContactData] (state) {
      const contactData = state[symbols.state.contactData]
      const contactProperties = state[symbols.state.contactProperties]
      for (let contactElement of contactData) {
        if (contactProperties.hasOwnProperty(contactElement.camelName)) {
          contactData.value = contactProperties[contactElement.camelName]
        }
      }
      return contactData
    },
    [symbols.getters.submitScreenerFailure] (state) {
      return state[symbols.state.submitScreenerFailure]
    },
    [symbols.getters.diagnosisCoMorbidity] (state) {
      const coMorbidityData = state[symbols.state.coMorbidityData]
      const filteredData = coMorbidityData.filter(function (element) {
        return element.diagnosis !== null
      })
      return filteredData.sort(function (a, b) {
        if (a.diagnosis > b.diagnosis) {
          return 1
        }
        return -1
      })
    },
    [symbols.getters.calculateRisk] (state) {
      const surveyWeight = state[symbols.state.screenerWeights].surveyWeight
      const epworthWeight = state[symbols.state.screenerWeights].epworthWeight
      const coMorbidityWeight = state[symbols.state.screenerWeights].coMorbidityWeight
      if (surveyWeight > 15 || epworthWeight > 18 || coMorbidityWeight > 3) {
        return 'severe'
      }
      if (surveyWeight > 11 || epworthWeight > 14 || coMorbidityWeight > 2) {
        return 'high'
      }
      if (surveyWeight > 7 || epworthWeight > 9 || coMorbidityWeight > 1) {
        return 'moderate'
      }
      return 'low'
    }
  },
  mutations: {
    [symbols.mutations.contactProperties] (state, payload) {
      state[symbols.state.contactProperties] = {
        firstName: payload.firstName,
        lastName: payload.lastName,
        phone: payload.phone
      }
    },
    [symbols.mutations.coMorbidityWeight] (state, weight) {
      state[symbols.state.screenerWeights].coMorbidity = weight
    },
    [symbols.mutations.epworthWeight] (state, weight) {
      state[symbols.state.screenerWeights].epworth = weight
    },
    [symbols.mutations.surveyWeight] (state, weight) {
      state[symbols.state.screenerWeights].survey = weight
    },
    [symbols.mutations.setAssessmentName] (state, assessmentName) {
      state[symbols.state.assessmentName] = assessmentName
    },
    [symbols.mutations.setEpworthProps] (state, epworthProps) {
      state[symbols.state.epworthProps] = epworthProps
    },
    [symbols.mutations.doctorName] (state, name) {
      state[symbols.state.doctorName] = name
    }
  },
  actions: {
    [symbols.actions.getDoctorData] ({ commit }, { userId }) {
      // @todo: add ajax request
      const doctorName = ''
      commit(symbols.mutations.doctorName, doctorName)
    },
    [symbols.actions.submitScreener] (context, screenerData) {
      return new Promise((resolve, reject) => {
        http.post('script/submit_screener.php', screenerData).then(
          (response) => {
            if (response.error) {
              reject(new Error())
              return
            }
            resolve(response)
          },
          () => {
            reject(new Error())
          }
        )
      })
    },

    [symbols.actions.parseScreenerResults] ({ state, commit }, { data }) {
      const screenerId = data.screenerid

      const epworthProps = []
      for (let epworth of epworthProps) {
        $('#r_epworth_' + epworth.id).text($('#epworth_' + epworth.id).val())
      }

      const symptoms = state[symbols.state.symptoms]
      for (let symptom of symptoms) {
        let inputVal = 'No'
        if (symptom.selector.val() > 0) {
          inputVal = 'Yes'
        }
        $('#r_' + symptom.name).text(inputVal)
      }

      $('#r_rx_cpap').text(($('input[name=rx_cpap]:checked').val() > 0) ? 'Yes' : 'No')

      const diagnosed = $('#r_diagnosed')

      const coMorbidityData = state[symbols.state.coMorbidityData]
      for (let coMorbidity of coMorbidityData) {
        const inputValue = +$('input[name="' + coMorbidity.name + '"]:checked').val()
        if (coMorbidity.label && inputValue) {
          diagnosed.append('<li>' + coMorbidity.label + '</li>')
        }
      }

      const resultsDivCheck = $('#results_div').find('div.check')
      resultsDivCheck.each(function () {
        const result = $(this).find('span').text()

        switch (result) {
          case '':
          // fall through
          case 'No':
          // fall through
          case 0:
            $(this).hide()
            break
          case 1:
            $(this).find('span').text('1 - Slight chance of dozing')
            break
          case 2:
            $(this).find('span').text('2 - Moderate chance of dozing')
            break
          case 3:
            $(this).find('span').text('3 - High chance of dozing')
            break
        }
      })

      let epworthWeight = 0
      for (let epworth of epworthProps) {
        epworthWeight += parseInt($('#epworth_' + epworth.id).val(), 10)
      }
      commit(symbols.mutations.epworthWeight, epworthWeight)

      let coMorbidityWeight = 0
      for (let coMorbidity of coMorbidityData) {
        if ($('input[name="' + coMorbidity.name + '"]:checked').val()) {
          coMorbidityWeight += coMorbidity.weight
        }
      }
      commit(symbols.mutations.coMorbidityWeight, coMorbidityWeight)

      let surveyWeight = 0
      for (let symptom of symptoms) {
        if (symptom.selector.val()) {
          surveyWeight += parseInt(symptom.selector.val(), 10)
        }
      }
      commit(symbols.mutations.surveyWeight, surveyWeight)

      this._updateHstDiv()

      this.$router.push({ name: 'screener-results' })
    },
    [symbols.actions.setEpworthProps] ({ commit }) {
      http.get('/epworth-sleepiness-scale/sorted-with-status').then(
        (response) => {
          const data = response.data
          commit(symbols.mutations.setEpworthProps, data)
        }
      )
    }
  }
}
