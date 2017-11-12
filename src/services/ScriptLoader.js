export default {
  loadScriptFrom (path, toElement) {
    const scriptElement = document.createElement('script')
    scriptElement.src = path
    scriptElement.async = true

    document.getElementById(toElement).append(scriptElement)
  }
}
