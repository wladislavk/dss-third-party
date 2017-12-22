import endpoints from '../../../src/endpoints'
import http from '../../../src/services/http'
import sinon from 'sinon'
import symbols from '../../../src/symbols'
import SwalWrapper from '../../../src/wrappers/SwalWrapper'
import DashboardModule from '../../../src/store/dashboard'
import TestCase from '../../cases/StoreTestCase'
import LocationWrapper from '../../../src/wrappers/LocationWrapper'
import ProcessWrapper from '../../../src/wrappers/ProcessWrapper'

describe('Dashboard module actions', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  describe('documentCategories action', () => {
    it('retrieves document categories', function (done) {
      const postData = []
      const result = {
        data: {
          data: [
            { id: 1 },
            { id: 2 }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      DashboardModule.actions[symbols.actions.documentCategories](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.documentCategories,
          payload: [
            { id: 1 },
            { id: 2 }
          ]
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.documentCategories.active }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
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
            name: 'deviceSelector'
          }
        }
      ]
      expect(this.testCase.mutations).toEqual(expectedMutations)
    })
  })

  describe('memos action', () => {
    it('retrieves memos', function (done) {
      const postData = []
      const result = {
        data: {
          data: [
            { id: 1 },
            { id: 2 }
          ]
        }
      }
      this.sandbox.stub(http, 'post').callsFake((path) => {
        postData.push({
          path: path
        })
        return Promise.resolve(result)
      })

      DashboardModule.actions[symbols.actions.memos](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.memos,
          payload: [
            { id: 1 },
            { id: 2 }
          ]
        }
      ]
      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        const expectedHttp = [
          { path: endpoints.memos.current }
        ]
        expect(postData).toEqual(expectedHttp)
        done()
      }, 100)
    })
    it('handles error', function (done) {
      this.sandbox.stub(http, 'post').callsFake(() => {
        return Promise.reject(new Error())
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
      this.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        let result = null
        if (func) {
          result = func(this.inputValue)
        }
        this.swalData.push({data: data, result: result})
      })
      this.inputError = ''
      this.sandbox.stub(SwalWrapper, 'showInputError').callsFake((text) => {
        this.inputError = text
      })
      this.closed = false
      this.sandbox.stub(SwalWrapper, 'close').callsFake(() => {
        this.closed = true
      })
    })
    it('exports with good password', function () {
      let destination = ''
      this.sandbox.stub(LocationWrapper, 'goToPage').callsFake((url) => {
        destination = url
      })
      this.inputValue = '1234'
      DashboardModule.actions[symbols.actions.exportMDModal]()
      expect(this.closed).toBe(true)
      expect(this.inputError).toBe('')
      expect(destination).toBe(ProcessWrapper.getLegacyRoot() + 'manage/export_md.php')
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
      this.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        swalData.push(data)
        func(isConfirm)
      })
      let destination = ''
      this.sandbox.stub(LocationWrapper, 'goToPage').callsFake((url) => {
        destination = url
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
      expect(destination).toBe(ProcessWrapper.getLegacyRoot() + 'manage/data_import.php')
    })
    it('imports data without confirmation', function () {
      const isConfirm = false
      this.sandbox.stub(SwalWrapper, 'callSwal').callsFake((data, func) => {
        func(isConfirm)
      })
      let destination = ''
      this.sandbox.stub(LocationWrapper, 'goToPage').callsFake((url) => {
        destination = url
      })
      DashboardModule.actions[symbols.actions.dataImportModal]()
      expect(destination).toBe('')
    })
  })

  describe('has getDeviceGuideSettingOptions action', () => {
    it('which retrieves device guide setting options', function (done) {
      const result = {
        data: {
          data: [
            {
              id: 13,
              labels: ['Not Important', 'Neutral', 'Very Important'],
              name: 'Comfort',
              setting_type: 0,
              number: 3
            },
            {
              id: 3,
              labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
              name: 'Bruxism',
              setting_type: 0,
              number: 5
            }
          ]
        }
      }

      let getPath = ''
      this.sandbox.stub(http, 'get').callsFake((path) => {
        getPath = path

        return Promise.resolve(result)
      })
      DashboardModule.actions[symbols.actions.getDeviceGuideSettingOptions](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.deviceGuideSettingOptions,
          payload: [
            {
              id: 13,
              checkedOption: 0,
              impression: 0,
              labels: ['Not Important', 'Neutral', 'Very Important'],
              name: 'Comfort',
              setting_type: 0,
              number: 3
            },
            {
              id: 3,
              checkedOption: 0,
              impression: 0,
              labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
              name: 'Bruxism',
              setting_type: 0,
              number: 5
            }
          ]
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)
        expect(getPath).toEqual(endpoints.guideSettingOptions.settingIds)

        done()
      }, 100)
    })
  })

  describe('has getDeviceGuideResults action', () => {
    it('which retrieves device guide results', function (done) {
      const result = {
        data: {
          data: [
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
        }
      }

      this.testCase.setState({
        [symbols.state.deviceGuideSettingOptions]: [
          {
            id: 13,
            checkedOption: 0,
            impression: 0,
            labels: ['Not Important', 'Neutral', 'Very Important'],
            name: 'Comfort',
            setting_type: 0,
            number: 3
          },
          {
            id: 3,
            checkedOption: 0,
            impression: 0,
            labels: ['None', 'Mild', 'Mod', 'Mode/Sev', 'Severe'],
            name: 'Bruxism',
            setting_type: 0,
            number: 5
          }
        ]
      })

      let requestSettings = {}
      this.sandbox.stub(http, 'get').callsFake((path, data, config) => {
        requestSettings = {
          path: path,
          config: config
        }

        return Promise.resolve(result)
      })
      DashboardModule.actions[symbols.actions.getDeviceGuideResults](this.testCase.mocks)

      const expectedMutations = [
        {
          type: symbols.mutations.deviceGuideResults,
          payload: result.data.data
        }
      ]

      setTimeout(() => {
        expect(this.testCase.mutations).toEqual(expectedMutations)

        const expectedRequestSettings = {
          path: endpoints.guideDevices.withImages,
          config: {
            params: {
              settings: '13_1,3_1'
            }
          }
        }
        expect(requestSettings).toEqual(expectedRequestSettings)

        done()
      }, 100)
    })

    it('which handles error', function (done) {
      this.sandbox.stub(http, 'get').callsFake(() => {
        return Promise.reject(new Error())
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

  describe('has updateFlowDevice action', () => {
    it('which updates a flow device', function (done) {
      const DEVICE_ID = 7
      const PATIENT_ID = 16
      const response = {
        data: { message: 'Successfully updated.' }
      }

      let requestSettings = {}
      this.sandbox.stub(http, 'put').callsFake((path, data) => {
        requestSettings = {
          path: path,
          data: data
        }

        return Promise.resolve(response)
      })

      this.testCase.setRootState({
        patients: {
          [symbols.state.patientId]: PATIENT_ID
        }
      })

      DashboardModule.actions[symbols.actions.updateFlowDevice](this.testCase.mocks, DEVICE_ID)

      setTimeout(() => {
        const expectedRequestSettings = {
          path: endpoints.tmjClinicalExams.updateFlowDevice + '/' + DEVICE_ID,
          data: {
            patient_id: PATIENT_ID
          }
        }
        expect(requestSettings).toEqual(expectedRequestSettings)

        done()
      }, 100)
    })
  })
})
