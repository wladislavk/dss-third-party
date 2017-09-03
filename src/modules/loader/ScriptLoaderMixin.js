module.exports = {
  methods: {
    loadScriptFrom (path, toElement, requiredFunction, externalFunction) {
      if (externalFunction === undefined) {
        externalFunction = () => {}
      }

      if (!requiredFunction) {
        const scriptElement = document.createElement('script')
        scriptElement.type = 'text/javascript'
        scriptElement.src = path
        scriptElement.async = true

        window.$(this.$el).find(toElement).append(scriptElement)
      } else {
        externalFunction()
      }
    }
  }
}
