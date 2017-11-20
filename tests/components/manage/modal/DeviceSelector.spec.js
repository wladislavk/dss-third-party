import endpoints from 'src/endpoints'
import http from 'src/services/http'
import moxios from 'moxios'
import TestCase from '../../../cases/ComponentTestCase'
import DeviceSelector from 'src/components/manage/modal/DeviceSelector.vue'
import $ from 'jquery'
import sliderUI from 'jquery-ui/slider'

describe('DeviceSelector', () => {
  beforeEach(function () {
    window.$ = $
    window.$.fn.extend = sliderUI

    moxios.install()

    const vueOptions = {
      template: '<div><device-selector></device-selector></div>',
      components: {
        deviceSelector: DeviceSelector
      }
    }

    this.vue = TestCase.getVue(vueOptions)
    this.vm = this.vue.$mount()
  })

  afterEach(function () {
    moxios.uninstall()
  })

  describe('should have Instructions block', () => {
    it('which exists', function () {
      const instructionsLink = this.vm.$el.querySelector('a#ins_show')
      expect(instructionsLink).not.toBeNull()
    })

    it('should have items', function () {
      const expectedFirstInstruction = 'Evaluate pt for each category using sliding bar'
      const items = this.vm.$el.querySelectorAll('div#instructions > ol > li')
      expect(items.length).toBe(4)
      expect(items[0].innerHTML).toBe(expectedFirstInstruction)
    })
  })

  it('should have correct device selector title', function () {
    const expectedTitle = 'Device C-Lect for ?'
    const deviceSelectorTitle = this.vm.$el.querySelector('h2#device-selector-title')

    expect(deviceSelectorTitle.innerHTML).toBe(expectedTitle)
  })

  it('should have correct devices settings', function (done) {
    moxios.stubRequest(http.formUrl(endpoints.guideSettingOptions.settingIds), {
      status: 200,
      responseText: {
        data: [
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
      }
    })

    moxios.wait(() => {
      const expectedSettingsNumber = 4
      const settings = this.vm.$el.querySelectorAll('#device_form > .setting')
      expect(settings.length).toBe(expectedSettingsNumber)

      const expectedIndexes = [13, 3, 7, 5]
      expectedIndexes.forEach((el, index) => {
        expect(settings[index].id).toBe(`setting_${el}`)
      })

      done()
    })
  })
})
