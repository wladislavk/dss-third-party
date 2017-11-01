import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import LocationWrapper from '../../wrappers/LocationWrapper'
import SwalWrapper from '../../wrappers/SwalWrapper'
import { LEGACY_URL } from '../../constants'

export default {
  [symbols.actions.documentCategories] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.documentCategories.active).then((response) => {
      commit(symbols.mutations.documentCategories, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getDocumentCategories', response: response})
    })
  },
  [symbols.actions.deviceSelectorModal] ({commit}) {
    commit(symbols.mutations.modal, 'device-selector')
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
  [symbols.actions.memos] ({state, commit, dispatch}) {
    http.token = state[symbols.state.mainToken]
    http.post(endpoints.memos.current).then((response) => {
      commit(symbols.mutations.memos, response.data.data)
    }).catch((response) => {
      dispatch(symbols.actions.handleErrors, {title: 'getCurrentMemos', response: response})
    })
  }
}
