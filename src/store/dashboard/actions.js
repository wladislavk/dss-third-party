import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocationWrapper from '../../wrappers/LocationWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import { DSS_CONSTANTS } from '../../constants/main'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import Alerter from '../../services/Alerter'

export default {
  [symbols.actions.documentCategories] ({rootState, commit, dispatch}) {
    http.token = rootState.main[symbols.state.mainToken]
    http.post(endpoints.documentCategories.active).then((response) => {
      commit(symbols.mutations.documentCategories, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getDocumentCategories', response: response})
    })
  },

  [symbols.actions.deviceSelectorModal] ({commit}) {
    commit(symbols.mutations.modal, { name: 'deviceSelector' })
  },

  [symbols.actions.exportMDModal] () {
    SwalWrapper.callSwal(
      {
        title: '',
        text: 'Enter your password',
        type: 'input',
        inputType: 'password',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: 'slide-from-top',
        inputPlaceholder: 'Enter password'
      },
      (inputValue) => {
        // @todo: maybe it's not the best idea to hardcode passwords
        const goodPassword = '1234'
        if (inputValue === goodPassword) {
          SwalWrapper.close()
          LocationWrapper.goToPage(ProcessWrapper.getLegacyRoot() + 'manage/export_md.php')
          return true
        }
        if (inputValue.length > 0) {
          SwalWrapper.callSwal({
            title: 'Oops...',
            text: 'Wrong password!',
            type: 'error'
          })
          return false
        }
        const errorText = 'You need to write the password!'
        SwalWrapper.showInputError(errorText)
        return false
      }
    )
  },

  [symbols.actions.dataImportModal] () {
    SwalWrapper.callSwal(
      {
        title: '',
        text: 'Data import is supported for certain file types from certain other software. Due to the complexity of data import, you must first create a Support ticket in order to use this feature correctly.',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3CB371',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        closeOnConfirm: true,
        closeOnCancel: true
      },
      (isConfirm) => {
        if (isConfirm) {
          LocationWrapper.goToPage(ProcessWrapper.getLegacyRoot() + 'manage/data_import.php')
        }
      }
    )
  },

  [symbols.actions.memos] ({rootState, commit, dispatch}) {
    http.token = rootState.main[symbols.state.mainToken]
    http.post(endpoints.memos.current).then((response) => {
      commit(symbols.mutations.memos, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentMemos', response: response})
    })
  },
  [symbols.actions.getDeviceGuideSettingOptions] ({commit, rootState}) {
    http.token = rootState.main[symbols.state.mainToken]
    return http.get(endpoints.guideSettingOptions.settingIds)
      .then(response => {
        const data = response.data.data

        data.forEach(el => {
          el.labels = el.labels
          el.checkedOption = 0

          if (+el.setting_type === DSS_CONSTANTS.DSS_DEVICE_SETTING_TYPE_RANGE) {
            el.impression = 0
            return
          }

          el.checked = 0
        })

        commit(symbols.mutations.deviceGuideSettingOptions, data)
      })
      .catch(response => {
        this.$store.dispatch(
          symbols.actions.handleErrors,
          {title: 'getDeviceGuideSettingOptions', response: response}
        )
      })
  },
  [symbols.actions.getDeviceGuideResults] ({commit, dispatch, state, rootState}) {
    const ID_DELIMITER = '_'
    const SETTINGS_DELIMETER = ','

    let settings = []

    state[symbols.state.deviceGuideSettingOptions].forEach(el => {
      let currentSetting = el.id

      if (el.hasOwnProperty('impression') && el.impression) {
        currentSetting += ID_DELIMITER + el.impression
      }

      if (el.hasOwnProperty('checkedOption')) {
        currentSetting += ID_DELIMITER + (el.checkedOption + 1)
        settings.push(currentSetting)
        return
      }

      currentSetting += ID_DELIMITER + el.checked
      settings.push(currentSetting)
    })

    const config = {
      params: {
        settings: settings.join(SETTINGS_DELIMETER)
      }
    }
    http.token = rootState.main[symbols.state.mainToken]
    http.get(endpoints.guideDevices.withImages, {}, config).then(response => {
      const data = response.data.data

      commit(symbols.mutations.deviceGuideResults, data)
    }).catch(response => {
      dispatch(symbols.actions.handleErrors, {title: 'getDeviceGuideResults', response: response})
    })
  },
  [symbols.actions.updateFlowDevice] ({commit, dispatch, rootState}, deviceId) {
    const data = {
      patient_id: rootState.patients[symbols.state.patientId]
    }

    http.token = rootState.main[symbols.state.mainToken]
    return http.put(endpoints.tmjClinicalExams.updateFlowDevice + '/' + deviceId, data)
      .then(response => {
        Alerter.alert(response.data.message)

        commit(symbols.mutations.resetModal)
      }).catch(response => {
        dispatch(symbols.actions.handleErrors, {title: 'updateFlowDevice', response: response})
      })
  }
}
