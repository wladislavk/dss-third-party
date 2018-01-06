import endpoints from '../../../../../src/endpoints'
import http from '../../../../../src/services/http'
import DeviceSliderComponent from '../../../../../src/components/manage/modal/device-selector/DeviceSlider.vue'
import TestCase from '../../../../cases/ComponentTestCase'
import $ from 'jquery'
import sliderUI from 'jquery-ui/slider'
import moxios from 'moxios'

describe('DeviceForm', () => {
  beforeEach(function () {
    window.$ = $
    window.$.fn.extend = sliderUI

    moxios.install()

    const vueOptions = {
      template: '<div><device-slider></device-slider></div>',
      components: {
        deviceSlider: DeviceSliderComponent
      }
    }
    this.vue = TestCase.getVue(vueOptions)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    moxios.uninstall()
  })

  it('should have correct devices settings', function (done) {
    const fakeData = [
      {
        id: 13,
        labels: 'Not Important,Neutral,Very Important',
        name: 'Comfort',
        setting_type: 0,
        number: 3
      },
      {
        id: 3,
        labels: 'None,Mild,Mod,Mode/Sev,Severe',
        name: 'Bruxism',
        setting_type: 0,
        number: 5
      },
      {
        id: 7,
        labels: 'Small,Small/Med,Normal,Large,Large/Scalloped',
        name: 'Tongue',
        setting_type: 0,
        number: 5
      },
      {
        id: 5,
        labels: 'Deep,Mod/Deep,Normal,Mod/Shallow,Shallow',
        name: 'Bite',
        setting_type: 0,
        number: 5
      }
    ]

    moxios.stubRequest(http.formUrl(endpoints.guideSettingOptions.settingIds), {
      status: 200,
      responseText: {
        data: fakeData
      }
    })

    moxios.wait(() => {
      const expectedSettingsNumber = 4
      const settings = this.vm.$el.querySelectorAll('#device_form > .setting')
      expect(settings.length).toBe(expectedSettingsNumber)
      const expectedIndexes = fakeData.map(el => el.id)
      expectedIndexes.forEach((el, index) => {
        expect(settings[index].id).toBe(`setting_${el}`)
      })
      const deviceGuideSettingsNames = this.vm.$el.querySelectorAll('.device-guide-setting-name')
      const expectedDeviceGuideSettingsNames = fakeData.map(el => el.name)
      expectedDeviceGuideSettingsNames.forEach((el, index) => {
        expect(deviceGuideSettingsNames[index].innerHTML).toBe(el)
      })
      done()
    })
  })
})
