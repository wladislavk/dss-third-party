import endpoints from '../../../../src/endpoints'
import symbols from '../../../../src/symbols'
import ScreenerEpworthComponent from '../../../../src/components/screener/sections/ScreenerEpworth.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerEpworth', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerEpworthComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-symptoms',
        path: '/symptoms'
      }
    ])

    this.testCase.stubRequest({
      url: endpoints.epworthSleepinessScale.index + '?status=1&order=sortby',
      response: [
        {
          epworthid: 1,
          epworth: 'foo'
        },
        {
          epworthid: 2,
          epworth: 'bar'
        },
        {
          epworthid: 3,
          epworth: 'baz'
        }
      ]
    })
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display existing fields', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const allLabels = vm.$el.querySelectorAll('div.dp66 > div.sepH_b')
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
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const nextButton = vm.$el.querySelector('a#sect2_next')
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const firstSelect = vm.$el.querySelector('select#epworth_1')
      firstSelect.value = '0'
      firstSelect.dispatchEvent(new Event('change'))
      const secondSelect = vm.$el.querySelector('select#epworth_2')
      secondSelect.value = '1'
      secondSelect.dispatchEvent(new Event('change'))
      const thirdSelect = vm.$el.querySelector('select#epworth_3')
      thirdSelect.value = '2'
      thirdSelect.dispatchEvent(new Event('change'))

      nextButton.click()

      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        const epworthProps = store.state.screener[symbols.state.epworthProps]
        const expectedProps = [
          {
            epworthid: 1,
            epworth: 'foo',
            selected: '0',
            error: false
          },
          {
            epworthid: 2,
            epworth: 'bar',
            selected: '1',
            error: false
          },
          {
            epworthid: 3,
            epworth: 'baz',
            selected: '2',
            error: false
          }
        ]
        expect(epworthProps).toEqual(expectedProps)

        expect(nextButton.classList.contains('disabled')).toBe(true)
        expect(vm.$router.currentRoute.name).toBe('screener-symptoms')
        done()
      })
    })
  })

  it('should throw error when some fields are not set', function (done) {
    const vm = this.testCase.mount()

    this.testCase.wait(() => {
      const nextButton = vm.$el.querySelector('a#sect2_next')
      expect(nextButton.classList.contains('disabled')).toBe(false)

      const firstSelect = vm.$el.querySelector('select#epworth_1')
      firstSelect.value = '0'
      firstSelect.dispatchEvent(new Event('change'))

      nextButton.click()

      this.testCase.waitForRequest = false
      this.testCase.wait(() => {
        expect(nextButton.classList.contains('disabled')).toBe(false)

        const errorDivs = vm.$el.querySelectorAll('div.msg_error > div.error')
        expect(errorDivs.length).toBe(2)

        const allLabels = vm.$el.querySelectorAll('div.dp66 > div.sepH_b')
        expect(allLabels[0].className).not.toContain('error')
        expect(allLabels[1].className).toContain('error')
        expect(allLabels[2].className).toContain('error')

        done()
      })
    })
  })
})
