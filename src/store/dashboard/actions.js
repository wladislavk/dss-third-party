import swal from 'sweetalert'
import endpoints from '../../endpoints'
import http from '../../services/http'
import symbols from '../../symbols'
import { LEGACY_URL, NOTIFICATION_NUMBERS } from '../../constants'
import ErrorHandler from '../../modules/handler/HandlerMixin'

export default {
  [symbols.actions.documentCategories] ({state, commit}) {
    http.token = state[symbols.state.mainToken]

    http.post(endpoints.documentCategories.active).then((response) => {
      commit(symbols.mutations.documentCategories, response.data.data)
    }).catch((response) => {
      ErrorHandler.handleErrors('getDocumentCategories', response)
    })
  },
  [symbols.actions.populateClaims] ({state}, element) {
    const pendingClaimsNumber = state[symbols.state.notificationNumbers][NOTIFICATION_NUMBERS.pendingClaims]
    element.name += ` (${pendingClaimsNumber})`
  },
  [symbols.actions.deviceSelectorModal] ({commit}) {
    commit(symbols.mutations.modal, 'device-selector')
  },
  [symbols.actions.exportMDModal] () {
    swal(
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
        // @todo: what is 1234?
        if (inputValue === '1234') {
          swal.close()
          window.location.href = LEGACY_URL + 'manage/export_md.php'
          return true
        }
        if (inputValue.length > 0) {
          // @todo: does it work? looks like code from sweetalert 2.x
          swal('Oops...', 'Wrong password!', 'error')
          return false
        }
        const errorText = 'You need to write the password!'
        swal.showInputError(errorText)
        return false
      }
    )
  },
  [symbols.actions.dataImportModal] () {
    swal(
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
          window.location.href = LEGACY_URL + 'manage/data_import.php'
        }
      }
    )
  },
  [symbols.actions.memos] ({commit}) {
    http.post(endpoints.memos.current).then((response) => {
      commit(symbols.mutations.memos, response.data.data)
    }).catch((response) => {
      ErrorHandler.handleErrors('getCurrentMemos', response)
    })
  }
}
