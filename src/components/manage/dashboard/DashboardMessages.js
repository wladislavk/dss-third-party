import endpoints from '../../../endpoints'
import handlerMixin from '../../../modules/handler/HandlerMixin'
import http from '../../../services/http'

export default {
  data () {
    return {
      memos: []
    }
  },
  mixins: [handlerMixin],
  created () {
    http.post(endpoints.memos.current).then((response) => {
      this.memos = response.data.data
    }).catch((response) => {
      this.handleErrors('getCurrentMemos', response)
    })
  }
}
