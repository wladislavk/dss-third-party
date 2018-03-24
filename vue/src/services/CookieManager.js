export default {
  removeCookie (name) {
    document.cookie = encodeURIComponent(name) + '=; domain=dentalsleepsolutions.com; path=/; max-age=0; expires=Mon, 03 Jul 2006 21:44:38 GMT'
  }
}
