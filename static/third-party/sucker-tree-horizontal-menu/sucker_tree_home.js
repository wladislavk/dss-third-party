// SuckerTree Horizontal Menu (Sept 14th, 06)
// By Dynamic Drive: http://www.dynamicdrive.com/style/

let menuids = ['homemenu', 'notmenu']

function buildsubmenusHorizontal () {
  for (let i = 0; i < menuids.length; i++) {
    let el = document.getElementById(menuids[i])

    if (!el) {
      continue
    }

    let ultags = el.getElementsByTagName('ul')

    for (let t = 0; t < ultags.length; t++) {
      // First level submenu
      if (ultags[t].parentNode.parentNode.id === menuids[i]) {
        ultags[t].parentNode.getElementsByTagName('a')[0].className =
                  ultags[t].parentNode.getElementsByTagName('a')[0].className + ' mainfoldericon'
      } else { // else if this is a sub level menu (ul)
        // Position menu to the right of menu item that activated it
        ultags[t].style.left = ultags[t - 1].getElementsByTagName('a')[0].offsetWidth + 'px'
        ultags[t].parentNode.getElementsByTagName('a')[0].className = 'subfoldericon'
      }

      ultags[t].parentNode.onmouseover = function () {
        this.getElementsByTagName('ul')[0].style.visibility = 'visible'
      }
      ultags[t].parentNode.onmouseout = function () {
        this.getElementsByTagName('ul')[0].style.visibility = 'hidden'
      }
    }
  }
}

if (window.addEventListener) {
  window.addEventListener('load', buildsubmenusHorizontal, false)
} else if (window.attachEvent) {
  window.attachEvent('onload', buildsubmenusHorizontal)
}
