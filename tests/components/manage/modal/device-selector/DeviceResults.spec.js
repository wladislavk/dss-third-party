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
        image_path: 'dummy.jpg'
      },
      {
        name: 'SUAD Hard',
        id: 14,
        value: 33,
        image_path: 'dummy.jpg'
      },
      {
        name: 'Narval',
        id: 7,
        value: 33,
        image_path: 'dummy.jpg'
      },
      {
        name: 'SUAD Thermo',
        id: 15,
        value: 33,
        image_path: 'dummy.jpg'
      },
      {
        name: 'Dorsal Hard',
        id: 2,
        value: 33,
        image_path: ''
      }
    ]

    this.vue.$store.commit(symbols.mutations.deviceGuideResults, fakeData)

    const deviceResultsBlock = this.vm.$el.querySelector('div#device-results-div')
    expect(deviceResultsBlock).not.toBeNull()

    this.vue.$nextTick(() => {
      const deviceResultsItems = this.vm.$el.querySelectorAll('div#device-results-div > ul > li')

      const itemWithImagePathIndex = 0
      const itemWithoutImagePathIndex = 4
      expect(deviceResultsItems[itemWithImagePathIndex].className).toBe('box_go')
      expect(deviceResultsItems[itemWithoutImagePathIndex].className.length).toBe(0)

      expect(deviceResultsItems[itemWithImagePathIndex].firstElementChild.firstElementChild.src).toContain('dummy.jpg')
      expect(deviceResultsItems[itemWithoutImagePathIndex].firstElementChild.tagName).toBe('A')

      deviceResultsItems.forEach((el, index) => {
        const name = fakeData[index].name
        const value = fakeData[index].value
        expect(el.childNodes[2].innerHTML.trim()).toBe(`${name} (${value})`)
      })

      done()
    })
  })
})
