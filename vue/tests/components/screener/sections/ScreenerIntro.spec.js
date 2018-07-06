import symbols from '../../../../src/symbols'
import ScreenerIntroComponent from '../../../../src/components/screener/sections/ScreenerIntro.vue'
import store from '../../../../src/store'
import TestCase from '../../../cases/ComponentTestCase'

describe('ScreenerIntro', () => {
  beforeEach(function () {
    this.testCase = new TestCase()

    this.testCase.setComponent(ScreenerIntroComponent)
    this.testCase.setRoutes([
      {
        name: 'screener-epworth',
        path: '/epworth'
      }
    ])
  })

  afterEach(function () {
    this.testCase.reset()
  })

  it('should display existing fields', function () {
    const vm = this.testCase.mount()

    const allLabels = vm.$el.querySelectorAll('div.dp50 > div.sepH_b')
    expect(allLabels.length).toBe(3)

    const getLabel = (number) => {
      const css = 'label'
      const index = number - 1
      return allLabels[index].querySelector(css).textContent.trim()
    }

    expect(getLabel(1)).toBe('First Name')
    expect(getLabel(2)).toBe('Last Name')
    expect(getLabel(3)).toBe('Phone Number')
  })

  it('should update data when all fields are set', function (done) {
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect1_next')

    expect(nextButton.classList.contains('disabled')).toBe(false)

    const firstNameInput = vm.$el.querySelector('input#first_name')
    firstNameInput.value = 'Jill'
    firstNameInput.dispatchEvent(new Event('change'))
    const lastNameInput = vm.$el.querySelector('input#last_name')
    lastNameInput.value = 'Jones'
    lastNameInput.dispatchEvent(new Event('change'))
    const phoneInput = vm.$el.querySelector('input#phone')
    phoneInput.value = '2233223223'
    phoneInput.dispatchEvent(new Event('change'))

    nextButton.click()

    this.testCase.wait(() => {
      const contactData = store.state.screener[symbols.state.contactData]

      let firstName
      let lastName
      let phone
      for (let element of contactData) {
        switch (element.camelName) {
          case 'firstName':
            firstName = element.value
            break
          case 'lastName':
            lastName = element.value
            break
          case 'phone':
            phone = element.value
            break
        }
      }

      expect(firstName).toBe('Jill')
      expect(lastName).toBe('Jones')
      expect(phone).toBe('2233223223')

      expect(nextButton.classList.contains('disabled')).toBe(true)
      expect(vm.$router.currentRoute.name).toBe('screener-epworth')
      done()
    })
  })

  it('should throw error when some fields are not set', function (done) {
    const vm = this.testCase.mount()

    const nextButton = vm.$el.querySelector('a#sect1_next')
    const firstNameInput = vm.$el.querySelector('input#first_name')
    firstNameInput.value = 'Jill'
    firstNameInput.dispatchEvent(new Event('change'))
    nextButton.click()

    this.testCase.wait(() => {
      expect(nextButton.classList.contains('disabled')).toBe(false)
      const allLabels = vm.$el.querySelectorAll('div.dp50 > div.sepH_b')
      expect(allLabels[0].className).not.toContain('error')
      expect(allLabels[1].className).toContain('error')
      expect(allLabels[2].className).toContain('error')
      done()
    })
  })
})
