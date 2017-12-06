import DeviceSelector from 'src/components/manage/modal/device-selector/DeviceSelector.vue'
import TestCase from '../../../../cases/ComponentTestCase'

describe('DeviceSelector', () => {
  beforeEach(function () {
    const vueOptions = {
      template: '<div><device-selector></device-selector></div>',
      components: {
        deviceSelector: DeviceSelector
      }
    }

    this.vue = TestCase.getVue(vueOptions)
    this.vm = this.vue.$mount()
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
})
