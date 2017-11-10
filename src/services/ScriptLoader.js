import jquery from 'jquery'

export default {
  methods: {
    loadScriptFrom (path, toElement, requiredFunction, externalFunction, currentElement) {
      if (externalFunction === undefined) {
        externalFunction = () => {}
      }

      if (!requiredFunction) {
        const scriptElement = document.createElement('script')
        scriptElement.src = path
        scriptElement.async = true

        jquery(currentElement).find(toElement).append(scriptElement)
      } else {
        externalFunction()
      }
    }
  }
}
