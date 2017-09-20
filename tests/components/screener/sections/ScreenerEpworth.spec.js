import Vue from 'vue'
import moxios from 'moxios'
import symbols from '../../../../src/symbols'
import TestCase from '../../../cases/ComponentTestCase'
import ScreenerEpworthComponent from '../../../../src/components/screener/sections/ScreenerEpworth.vue'

describe('ScreenerEpworth', () => {
  beforeEach(function () {
    moxios.install()

    this.routes = [
      {
        name: 'screener-symptoms',
        path: '/symptoms'
      }
    ]

    Vue.component('health-assessment', {
      template: '<div></div>'
    })

    this.vueOptions = {
      template: '<div><screener-epworth></screener-epworth></div>',
      components: {
        screenerEpworth: ScreenerEpworthComponent
      }
    }

    this.mockData = [
      {
        id: 1,
        epworth: 'foo'
      },
      {
        id: 2,
        epworth: 'bar'
      },
      {
        id: 3,
        epworth: 'baz'
      }
    ]
  })

  afterEach(function () {
    this.vue.$store.commit(symbols.mutations.restoreInitialScreener)
    moxios.uninstall()
  })

  it('should display existing fields', function (done) {
    moxios.stubRequest(process.env.API_PATH + 'epworth-sleepiness-scale/sorted-with-status', {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    moxios.wait(() => {
      const allLabels = this.vm.$el.querySelectorAll('div.dp66 > div.sepH_b')
      expect(allLabels.length).toBe(3)

      const getLabel = (number) => {
        const css = 'label'
        const index = number - 1
        return allLabels[index].querySelector(css).textContent.trim()
      }

      expect(getLabel(1)).toBe('foo')
      expect(getLabel(2)).toBe('bar')
      expect(getLabel(3)).toBe('baz')

      const options = allLabels[0].querySelectorAll('option')
      expect(options.length).toBe(5)
      expect(options[1].textContent).toBe('0 - No chance of dozing')
      done()
    })
  })

  it('should update data when all fields are set', function (done) {
    moxios.stubRequest(process.env.API_PATH + 'epworth-sleepiness-scale/sorted-with-status', {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    moxios.wait(() => {
      const nextButton = this.vm.$el.querySelector('a#sect2_next')
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const firstSelect = this.vm.$el.querySelector('select#epworth_1')
      firstSelect.value = '0'
      firstSelect.dispatchEvent(new Event('change'))
      const secondSelect = this.vm.$el.querySelector('select#epworth_2')
      secondSelect.value = '1'
      secondSelect.dispatchEvent(new Event('change'))
      const thirdSelect = this.vm.$el.querySelector('select#epworth_3')
      thirdSelect.value = '2'
      thirdSelect.dispatchEvent(new Event('change'))

      nextButton.click()

      this.vm.$nextTick(() => {
        const epworthProps = this.vue.$store.state.screener[symbols.state.epworthProps]
        const expectedProps = [
          {
            id: 1,
            epworth: 'foo',
            selected: '0',
            error: false
          },
          {
            id: 2,
            epworth: 'bar',
            selected: '1',
            error: false
          },
          {
            id: 3,
            epworth: 'baz',
            selected: '2',
            error: false
          }
        ]
        expect(epworthProps).toEqual(expectedProps)

        expect(nextButton.classList.contains('disabled')).toBe(true)
        expect(this.vue.$router.currentRoute.name).toBe('screener-symptoms')
        done()
      })
    })
  })

  it('should throw error when some fields are not set', function (done) {
    moxios.stubRequest(process.env.API_PATH + 'epworth-sleepiness-scale/sorted-with-status', {
      status: 200,
      responseText: {
        data: this.mockData
      }
    })

    this.vue = TestCase.getVue(this.vueOptions, this.routes)
    this.vm = this.vue.$mount()

    moxios.wait(() => {
      const nextButton = this.vm.$el.querySelector('a#sect2_next')
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const firstSelect = this.vm.$el.querySelector('select#epworth_1')
      firstSelect.value = '0'
      firstSelect.dispatchEvent(new Event('change'))

      nextButton.click()

      this.vm.$nextTick(() => {
        expect(nextButton.classList.contains('disabled')).toBe(false)

        const errorDivs = this.vm.$el.querySelectorAll('div.msg_error > div.error')
        expect(errorDivs.length).toBe(2)

        const allLabels = this.vm.$el.querySelectorAll('div.dp66 > div.sepH_b')
        expect(allLabels[0].className).not.toContain('error')
        expect(allLabels[1].className).toContain('error')
        expect(allLabels[2].className).toContain('error')

        done()
      })
    })
  })
})
