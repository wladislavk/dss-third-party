import endpoints from 'endpoints'
import symbols from 'symbols'
import http from 'services/http'
import DeviceSelector from 'components/manage/modal/DeviceSelector.vue'
import $ from 'jquery'
import sliderUI from 'jquery-ui/slider'
import moxios from 'moxios'
import TestCase from '../../../cases/ComponentTestCase'

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

  it('should have correct device results', function (done) {
    const fakeData = [
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
      },
      {
        name: 'SUAD Thermo',
        id: 15,
        value: 33,
        imagePath: 'dental_device_15.gif'
      },
      {
        name: 'Dorsal Hard',
        id: 2,
        value: 33,
        imagePath: ''
      }
    ]

    this.vue.$store.commit(symbols.mutations.deviceGuideResults, fakeData)

    const deviceResultsBlock = this.vm.$el.querySelector('div#device-results-div')
    expect(deviceResultsBlock).not.toBeNull()

    this.vue.$nextTick(() => {
      const deviceResultsItems = this.vm.$el.querySelectorAll('div#device-results-div > ul > li')

      const itemWithoutImagePathIndex = 4
      expect(deviceResultsItems[itemWithoutImagePathIndex].className.length).toBe(0)
      expect(deviceResultsItems[itemWithoutImagePathIndex].childNodes[0].innerHTML).toBe(undefined)

      deviceResultsItems.forEach((el, index) => {
        const name = fakeData[index].name
        const value = fakeData[index].value
        expect(el.childNodes[2].innerHTML.trim()).toBe(`${name} (${value})`)
      })

      done()
    })
  })
})
