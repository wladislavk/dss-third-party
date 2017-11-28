import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocationWrapper from '../../wrappers/LocationWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import ProcessWrapper from '../../wrappers/ProcessWrapper'
import { LEGACY_URL, DSS_CONSTANTS } from '../../constants/main'

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
    commit(symbols.mutations.modal, { name: 'device-selector' })
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
          LocationWrapper.goToPage(LEGACY_URL + 'manage/export_md.php')
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
          LocationWrapper.goToPage(LEGACY_URL + 'manage/data_import.php')
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
    return http.post(endpoints.guideSettingOptions.settingIds).then(response => {
      const data = response.data.data

      data.forEach(el => {
        el.labels = el.labels.split(',')
        el.checkedOption = 0

        if (+el.setting_type === DSS_CONSTANTS.DSS_DEVICE_SETTING_TYPE_RANGE) {
          el.checkedImp = 0
          return
        }

        el.checked = 0
      })

      commit(symbols.mutations.deviceGuideSettingOptions, data)
    })
  },
  [symbols.actions.getDeviceGuideResults] ({commit, dispatch, state, rootState}) {
    const IDS_DELIMETER = '_'
    const SETTINGS_DELIMETER = ','

    let settings = []

    state[symbols.state.deviceGuideSettingOptions].forEach(el => {
      let currentSetting = el.id

      if (el.hasOwnProperty('checkedImp') && el.checkedImp) {
        currentSetting += IDS_DELIMETER + el.checkedImp
      }

      if (el.hasOwnProperty('checkedOption')) {
        currentSetting += IDS_DELIMETER + (el.checkedOption + 1)
        settings.push(currentSetting)
        return
      }

      currentSetting += IDS_DELIMETER + el.checked
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
  [symbols.actions.updateFlowDevice] ({rootState}, deviceId) {
    const data = {
      // TODO: change to rootState.main[symbols.patient.patientId] when a certain
      // store object exists
      patient_id: 0,
      device_id: deviceId
    }

    http.token = rootState.main[symbols.state.mainToken]
    return http.post(endpoints.tmjClinicalExams.updateFlowDevice, data)
  },
  [symbols.actions.resetDeviceGuideSettingOptions] ({commit, state}) {
    const data = JSON.parse(JSON.stringify(state[symbols.state.deviceGuideSettingOptions]))

    data.forEach(el => {
      el.checkedOption = 0

      if (+el.setting_type === DSS_CONSTANTS.DSS_DEVICE_SETTING_TYPE_RANGE) {
        el.checkedImp = 0
        return
      }

      el.checked = 0
    })

    commit(symbols.mutations.deviceGuideSettingOptions, data)
    commit(symbols.mutations.deviceGuideResults, [])
  }
}
