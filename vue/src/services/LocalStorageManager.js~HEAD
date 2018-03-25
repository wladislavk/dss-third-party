module.exports = {
  get (key) {
    if (localStorage.getItem(key)) {
      return localStorage.getItem(key)
    }
    return null
  },
  save (key, value) {
    localStorage.setItem(key, value)
  },
  remove (key) {
    if (localStorage.getItem(key)) {
      localStorage.removeItem(key)
    }
  }
}
