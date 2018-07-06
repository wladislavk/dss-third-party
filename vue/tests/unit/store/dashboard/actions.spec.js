import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import SwalWrapper from '../../../../src/wrappers/SwalWrapper'
import DashboardModule from '../../../../src/store/dashboard'
import TestCase from '../../../cases/StoreTestCase'
import ProcessWrapper from '../../../../src/wrappers/ProcessWrapper'

describe('Dashboard module actions', () => {
  beforeEach(function () {
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.testCase.reset()
  })

  describe('documentCategories action', () => {
    it('retrieves document categories', function (done) {
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({
        method: 'post',
        response: response
      })

      DashboardModule.actions[symbols.actions.documentCategories](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.documentCategories,
          payload: response
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.documentCategories.active }
        ]
        expect(this.testCase.postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.stubRequest({
        method: 'post',
        status: 500
      })

      DashboardModule.actions[symbols.actions.documentCategories](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getDocumentCategories',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('deviceSelectorModal action', () => {
    it('opens device selector', function () {
      DashboardModule.actions[symbols.actions.deviceSelectorModal](this.testCase.mocks)
      const expectedMutations = [
        {
          type: symbols.mutations.modal,
          payload: {
            name: symbols.modals.deviceSelector,
            params: {
              white: true
            }
          }
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })

  describe('memos action', () => {
    it('retrieves memos', function (done) {
      const response = [
        { id: 1 },
        { id: 2 }
      ]
      this.testCase.stubRequest({
        method: 'post',
        response: response
      })

      DashboardModule.actions[symbols.actions.memos](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.memos,
          payload: response
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.memos.current }
        ]
        expect(this.testCase.postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.stubRequest({
        method: 'post',
        status: 500
      })

      DashboardModule.actions[symbols.actions.memos](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getCurrentMemos',
            response: new Error()
          }
        }
      ]

      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('exportMDModal action', () => {
    beforeEach(function () {
      this.swalData = []
      this.inputValue = ''
      this.testCase.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        let result = null
        if (func) {
          result = func(this.inputValue)
        }
        this.swalData.push({data: data, result: result})
      })
      this.inputError = ''
      this.testCase.sandbox.stub(SwalWrapper, 'showInputError').callsFake((text) => {
        this.inputError = text
      })
      this.closed = false
      this.testCase.sandbox.stub(SwalWrapper, 'close').callsFake(() => {
        this.closed = true
      })
    })
    it('exports with good password', function () {
      this.inputValue = '1234'
      DashboardModule.actions[symbols.actions.exportMDModal]()
      expect(this.closed).toBe(true)
      expect(this.inputError).toBe('')
      expect(this.testCase.redirectUrl).toBe(ProcessWrapper.getLegacyRoot() + 'manage/export_md.php')
      const expectedSwal = [
        {
          data: {
            title: '',
            text: 'Enter your password',
            type: 'input',
            inputType: 'password',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: 'slide-from-top',
            inputPlaceholder: 'Enter password'
          },
          result: true
        }
      ]
      expect(this.swalData).toEqual(expectedSwal)
    })
    it('exports with bad password', function () {
      this.inputValue = 'foo'
      DashboardModule.actions[symbols.actions.exportMDModal]()
      expect(this.closed).toBe(false)
      expect(this.inputError).toBe('')
      const expectedSwal = [
        {
          data: {
            title: 'Oops...',
            text: 'Wrong password!',
            type: 'error'
          },
          result: null
        },
        {
          data: {
            title: '',
            text: 'Enter your password',
            type: 'input',
            inputType: 'password',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: 'slide-from-top',
            inputPlaceholder: 'Enter password'
          },
          result: false
        }
      ]
      expect(this.swalData).toEqual(expectedSwal)
    })
    it('exports without password', function () {
      this.inputValue = ''
      DashboardModule.actions[symbols.actions.exportMDModal]()
      expect(this.closed).toBe(false)
      expect(this.inputError).toBe('You need to write the password!')
      const expectedSwal = [
        {
          data: {
            title: '',
            text: 'Enter your password',
            type: 'input',
            inputType: 'password',
            showCancelButton: true,
            closeOnConfirm: false,
            animation: 'slide-from-top',
            inputPlaceholder: 'Enter password'
          },
          result: false
        }
      ]
      expect(this.swalData).toEqual(expectedSwal)
    })
  })

  describe('dataImportModal action', () => {
    it('imports data with confirmation', function () {
      const swalData = []
      const isConfirm = true
      this.testCase.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        swalData.push(data)
        func(isConfirm)
      })
      DashboardModule.actions[symbols.actions.dataImportModal]()
      const expectedData = [
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
        }
      ]
      expect(swalData).toEqual(expectedData)
      expect(this.testCase.redirectUrl).toBe(ProcessWrapper.getLegacyRoot() + 'manage/data_import.php')
    })
    it('imports data without confirmation', function () {
      const isConfirm = false
      this.testCase.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        func(isConfirm)
      })
      DashboardModule.actions[symbols.actions.dataImportModal]()
      expect(this.testCase.redirectUrl).toBe('')
    })
  })

  describe('getDeviceGuideSettingOptions action', () => {
    it('retrieves device guide setting options', function (done) {
      const response = [
        {
          id: 13,
          labels: ['Not Important', 'Neutral', 'Very Important'],
          name: 'Comfort',
          number: 3
        },
        {
          id: 3,
          labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
          name: 'Bruxism',
          number: 5
        }
      ]
      this.testCase.stubRequest({
        method: 'get',
        response: response
      })
      DashboardModule.actions[symbols.actions.getDeviceGuideSettingOptions](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.deviceGuideSettingOptions,
          payload: response
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(this.testCase.postData).toEqual([
          { path: endpoints.guideSettingOptions.settingIds }
        ])
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 500
      })
      DashboardModule.actions[symbols.actions.getDeviceGuideSettingOptions](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getDeviceGuideSettingOptions',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('getDeviceGuideResults action', () => {
    it('retrieves device guide results', function (done) {
      const response = [
        {
          name: 'SUAD Ultra Elite',
          id: 13,
          value: 34,
          imagePath: 'dental_device_13.gif'
        },
        {
          name: 'SUAD Hard',
          id: 14,
          value: 33,
          imagePath: 'dental_device_14.gif'
        },
        {
          name: 'Narval',
          id: 7,
          value: 33,
          imagePath: 'dental_device_7.gif'
        }
      ]

      this.testCase.setState({
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 1,
            checked: false,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            number: 3
          },
          {
            id: 3,
            checkedOption: 2,
            checked: true,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            number: 5
          }
        ]
      })

      this.testCase.stubRequest({
        method: 'get',
        response: response
      })
      DashboardModule.actions[symbols.actions.getDeviceGuideResults](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.deviceGuideResults,
          payload: response
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        let expectedPath = endpoints.guideDevices.withImages + '?' + 'impressions[3]=1&impressions[13]=0&options[3]=3&options[13]=2'
        expectedPath = expectedPath.replace(/\[/g, '%5B').replace(/]/g, '%5D')
        const expectedRequestSettings = [
          { path: expectedPath }
        ]
        expect(this.testCase.postData).toEqual(expectedRequestSettings)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.testCase.stubRequest({
        method: 'get',
        status: 500
      })
      this.testCase.setState({
        [symbols.state.deviceGuideSettingOptions]: []
      })

      DashboardModule.actions[symbols.actions.getDeviceGuideResults](this.testCase.mocks)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'getDeviceGuideResults',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('updateFlowDevice action', () => {
    it('updates a flow device', function (done) {
      const DEVICE_ID = 7
      const PATIENT_ID = 16

      this.testCase.stubRequest({
        method: 'put',
        message: 'Successfully updated.'
      })
      this.testCase.rootState.patients = {
        [symbols.state.patientId]: PATIENT_ID
      }
      DashboardModule.actions[symbols.actions.updateFlowDevice](this.testCase.mocks, DEVICE_ID)

      setTimeout(() => {
        expect(this.testCase.postData).toEqual([
          {
            path: endpoints.tmjClinicalExams.updateFlowDevice + '/' + DEVICE_ID,
            payload: { patient_id: PATIENT_ID }
          }
        ])
        expect(this.testCase.alertText).toBe('Successfully updated.')
        done()
      }, 100)
    })
    it('handles error', function (done) {
      const DEVICE_ID = 7
      const PATIENT_ID = 16
      this.testCase.stubRequest({
        method: 'put',
        status: 500
      })
      this.testCase.rootState.patients = {
        [symbols.state.patientId]: PATIENT_ID
      }
      DashboardModule.actions[symbols.actions.updateFlowDevice](this.testCase.mocks, DEVICE_ID)
      const expectedActions = [
        {
          type: symbols.actions.handleErrors,
          payload: {
            title: 'updateFlowDevice',
            response: new Error()
          }
        }
      ]
      setTimeout(() => {
        expect(this.testCase.actions).toEqual(expectedActions)
        done()
      }, 100)
    })
  })

  describe('moveGuideSettingSlider action', () => {
    it('sets option value', function () {
      const data = {
        id: 1,
        value: 'bar',
        labels: {
          2: 'foo',
          4: 'bar',
          7: 'bar'
        }
      }
      DashboardModule.actions[symbols.actions.moveGuideSettingSlider](this.testCase.mocks, data)
      const expectedMutations = [
        {
          type: symbols.mutations.moveGuideSettingSlider,
          payload: {
            id: 1,
            value: 4
          }
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
    it('leaves option unchanged if value not found', function () {
      const data = {
        id: 1,
        value: 'baz',
        labels: {
          2: 'foo',
          4: 'bar',
          7: 'bar'
        }
      }
      DashboardModule.actions[symbols.actions.moveGuideSettingSlider](this.testCase.mocks, data)
      const expectedMutations = [
        {
          type: symbols.mutations.moveGuideSettingSlider,
          payload: {
            id: 1,
            value: 0
          }
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })
})
