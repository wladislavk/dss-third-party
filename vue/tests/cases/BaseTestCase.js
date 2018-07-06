import sinon from 'sinon'
import LocationWrapper from '../../src/wrappers/LocationWrapper'
import Alerter from '../../src/services/Alerter'

export default class BaseTestCase {
  constructor () {
    this._initialize()

    this.alertText = ''
    this.confirmText = ''
    this.confirmDialog = true
    this.redirectUrl = ''

    this._makeStubs()

    this.fixedTimeout = 0
  }

  _initialize () {
    this.sandbox = sinon.createSandbox()
  }

  _makeStubs () {
    this.sandbox.stub(LocationWrapper, 'goToLegacyPage').callsFake((url) => {
      this.redirectUrl = url
    })
    this.sandbox.stub(LocationWrapper, 'goToPage').callsFake((url) => {
      this.redirectUrl = url
    })
    this.sandbox.stub(Alerter, 'alert').callsFake((text) => {
      this.alertText = text
    })
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake((text) => {
      this.confirmText = text
      return this.confirmDialog
    })
  }

  reset () {
    this.sandbox.restore()
  }

  wait (callback) {
    setTimeout(callback, this.fixedTimeout)
  }

  // eslint-disable-next-line no-unused-vars
  stubRequest (requestData) {
    // do nothing
  }
}
