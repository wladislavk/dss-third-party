export default {
  loadScriptFrom (path, toElement) {
    const targetElement = document.getElementById(toElement)
    if (!targetElement) {
      return
    }
    const scriptElement = document.createElement('script')
    scriptElement.src = path
    scriptElement.async = true

    targetElement.append(scriptElement)
  }
}
