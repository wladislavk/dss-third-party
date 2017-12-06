import symbols from 'src/symbols'
import DeviceResults from 'src/components/manage/modal/device-selector/DeviceResults.vue'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceSelector', () => {
  beforeEach(function () {
    const vueOptions = {
      template: '<div><device-results></device-results></div>',
      components: {
        deviceResults: DeviceResults
      }
    }

    this.vue = TestCase.getVue(vueOptions)
    this.vm = this.vue.$mount()
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
