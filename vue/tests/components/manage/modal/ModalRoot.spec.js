import sinon from 'sinon'
import store from '../../../../src/store'
import symbols from '../../../../src/symbols'
import ModalRootComponent from '../../../../src/components/manage/modal/ModalRoot.vue'
import Alerter from '../../../../src/services/Alerter'
import TestCase from '../../../cases/ComponentTestCase'

describe('ModalRoot component', () => {
  beforeEach(function () {
    this.sandbox = sinon.createSandbox()
    this.testCase = new TestCase()

    store.state.main[symbols.state.popupEdit] = false

    window.innerWidth = 1200
    window.innerHeight = 800
    window.pageYOffset = 10

    this.testCase.setComponent(ModalRootComponent)
    this.testCase.setChildComponents(['add-task'])
    this.testCase.setRenderChildren(true)
  })

  afterEach(function () {
    this.sandbox.restore()
  })

  it('does not display if no component', function () {
    const componentData = {
      name: 'foo',
      params: {}
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const rootDiv = vm.$el
    expect(rootDiv.style.display).toBe('none')
  })

  it('displays HTML for a component', function () {
    const componentData = {
      name: 'addTask',
      params: {
        first: '1'
      }
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const rootDiv = vm.$el
    expect(rootDiv.style.display).toBe('')
    const contactDiv = vm.$el.querySelector('div#popupContact')
    expect(contactDiv.style.top).toBe('210px')
    expect(contactDiv.style.left).toBe('225px')
    const contentDiv = vm.$el.querySelector('div#modal-content')
    expect(contentDiv.textContent).toContain('Add new task')
  })

  it('closes pop-up on click at X', function (done) {
    const componentData = {
      name: 'addTask',
      params: {
        first: '1'
      }
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const closeButton = vm.$el.querySelector('a#popupContactClose')
    closeButton.click()
    // nextTick does not work for some reason
    setTimeout(() => {
      const rootDiv = vm.$el
      expect(rootDiv.style.display).toBe('none')
      done()
    }, 100)
  })

  it('closes pop-up on click at background', function (done) {
    store.state.main[symbols.state.popupEdit] = true
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return true
    })
    const componentData = {
      name: 'addTask',
      params: {
        first: '1'
      }
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const background = vm.$el.querySelector('div#backgroundPopup')
    background.click()
    // nextTick does not work for some reason
    setTimeout(() => {
      const rootDiv = vm.$el
      expect(rootDiv.style.display).toBe('none')
      done()
    }, 100)
  })

  it('closes pop-up without confirmation', function (done) {
    store.commit(symbols.mutations.popupEdit, {value: true})
    this.sandbox.stub(Alerter, 'isConfirmed').callsFake(() => {
      return false
    })
    const componentData = {
      name: 'addTask',
      params: {
        first: '1'
      }
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const background = vm.$el.querySelector('div#backgroundPopup')
    background.click()
    // nextTick does not work for some reason
    setTimeout(() => {
      const rootDiv = vm.$el
      expect(rootDiv.style.display).toBe('')
      done()
    }, 100)
  })

  it('closes pop-up on key press', function (done) {
    const componentData = {
      name: 'addTask',
      params: {
        first: '1'
      }
    }
    store.state.main[symbols.state.modal] = componentData
    const vm = this.testCase.mount()

    const keyupEvent = new Event('keyup')
    keyupEvent.keyCode = 27
    window.dispatchEvent(keyupEvent)
    // nextTick does not work for some reason
    setTimeout(() => {
      const rootDiv = vm.$el
      expect(rootDiv.style.display).toBe('none')
      done()
    }, 100)
  })
})
