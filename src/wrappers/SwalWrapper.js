import swal from 'sweetalert'

export default {
  callSwal (object, method) {
    swal(object, method)
  },
  close () {
    swal.close()
  },
  showInputError (text) {
    swal.showInputError(text)
  }
}
