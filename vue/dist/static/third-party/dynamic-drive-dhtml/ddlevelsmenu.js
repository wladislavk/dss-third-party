// ** All Levels Navigational Menu- (c) Dynamic Drive DHTML code library: http://www.dynamicdrive.com
// ** Script Download/ instructions page: http://www.dynamicdrive.com/dynamicindex1/ddlevelsmenu/
// ** Usage Terms: http://www.dynamicdrive.com/notice.htm

// ** July 7th, 08'- Creation Date

// ** July 16th, 08'- Updated to v 1.3:
// 1) Adds "Side Bar" orientation option.
// 2) Drop Down Menus now auto adjust their positioning if too close to either right or bottom window edges.
// 3) Enhanced IFRAME shim "coverage" on the page.

// ** July 19th, 08'- Updated to v 1.31: Drop down menu now positions at top of window edge if there's neither room downwards or upwards to settle.
// ** Aug 13th, 08'- v1.32: Moved "rel" attribute from menu's <li> elements to inner <a>, for validation reasons

// ** Sept 10th, 08'- Updated to v 1.4:
// 1) Added optional "sliding" animation when sub menus are revealed.
// 2) Arrow images now dynamically positioned, instead of relying on CSS's "right" property

// ** Oct 11th, 08'- Updated to v 1.5:
// 1) Sliding animation behavior tweaked
// 2) Added ability to disable iframeshim, customize speed of sliding animation

// ** Dec 23rd, 08'- Updated to v 2.0:
// 1) Animation speed refined to be function of time (ie: 1 sec)
// 2) Added two animations that can be individually enabled/disabled- "slide in" and "fade in".
// 3) Script now automatically moves HTML for all sub menus to the end of the page, to avoid any containership issues if they are nested in other elements.

// ** Jan 12, 09'- Updated to v 2.1:
// 1) Added ability to disable the arrow images from the top level items (see option "showarrow")
// 2) For Top Level Menu items containing a SPAN element (for sliding doors technique), arrow images are inserted inside SPAN.

export default {
  enableshim: true, // enable IFRAME shim to prevent drop down menus from being hidden below SELECT or FLASH elements? (tip: disable if not in use, for efficiency)

  arrowpointers: {
    downarrow: ['images/arrow-down.gif', 11, 7], // [path_to_down_arrow, arrowwidth, arrowheight]
    rightarrow: ['images/arrow-right.gif', 12, 12], // [path_to_right_arrow, arrowwidth, arrowheight]
    showarrow: {toplevel: true, sublevel: true} // Show arrow images on top level items and sub level items, respectively?
  },
  hideinterval: 200, // delay in milliseconds before entire menu disappears onmouseout.
  effects: {enableswipe: true, enablefade: true, duration: 500},
  httpsiframesrc: 'blank.htm', // If menu is run on a secure (https) page, the IFRAME shim feature used by the script should point to an *blank* page *within* the secure area to prevent an IE security prompt. Specify full URL to that page on your server (leave as is if not applicable).

  topmenuids: [], // array containing ids of all the primary menus on the page
  topitems: {}, // object array containing all top menu item links
  subuls: {}, // object array containing all ULs
  lastactivesubul: {}, // object object containing info for last mouse out menu item's UL
  topitemsindex: -1,
  ulindex: -1,
  hidetimers: {}, // object array timer
  shimadded: false,
  nonFF: !/Firefox[/\s](\d+\.\d+)/.test(navigator.userAgent), // detect non FF browsers

  getoffset (what, offsettype) {
    return (what.offsetParent) ? what[offsettype] + this.getoffset(what.offsetParent, offsettype) : what[offsettype]
  },

  getoffsetof (el) {
    el._offsets = {
      left: this.getoffset(el, 'offsetLeft'),
      top: this.getoffset(el, 'offsetTop')
    }
  },

  getwindowsize () {
    this.docwidth = window.innerWidth ? window.innerWidth - 10 : this.standardbody.clientWidth - 10
    this.docheight = window.innerHeight ? window.innerHeight - 15 : this.standardbody.clientHeight - 18
  },

  gettopitemsdimensions () {
    for (let m = 0; m < this.topmenuids.length; m++) {
      let topmenuid = this.topmenuids[m]
      for (let i = 0; i < this.topitems[topmenuid].length; i++) {
        let header = this.topitems[topmenuid][i]
        let submenu = document.getElementById(header.getAttribute('rel'))
        header._dimensions = {
          w: header.offsetWidth,
          h: header.offsetHeight,
          submenuw: submenu.offsetWidth,
          submenuh: submenu.offsetHeight
        }
      }
    }
  },

  isContained (m, e) {
    e = window.event || e
    let c = e.relatedTarget || ((e.type === 'mouseover') ? e.fromElement : e.toElement)
    while (c && c !== m) {
      try {
        c = c.parentNode
      } catch (e) {
        c = m
      }
    }
    if (c === m) {
      return true
    }
    return false
  },

  addpointer (target, imgclass, imginfo, BeforeorAfter) {
    let pointer = document.createElement('img')
    pointer.src = imginfo[0]
    pointer.style.width = imginfo[1] + 'px'
    pointer.style.height = imginfo[2] + 'px'
    if (imgclass === 'rightarrowpointer') {
      pointer.style.left = target.offsetWidth - imginfo[2] - 2 + 'px'
    }
    pointer.className = imgclass
    let targetFirstEl = target.childNodes[target.firstChild.nodeType !== 1 ? 1 : 0] // see if the first child element within A is a SPAN (found in sliding doors technique)
    if (targetFirstEl && targetFirstEl.tagName === 'SPAN') {
      target = targetFirstEl // arrow should be added inside this SPAN instead if found
    }
    if (BeforeorAfter === 'before') {
      target.insertBefore(pointer, target.firstChild)
    } else {
      target.appendChild(pointer)
    }
  },

  css (el, targetclass, action) {
    let needle = new RegExp('(^|\\s+)' + targetclass + '($|\\s+)', 'ig')
    if (action === 'check') {
      return needle.test(el.className)
    } else if (action === 'remove') {
      el.className = el.className.replace(needle, '')
    } else if (action === 'add' && !needle.test(el.className)) {
      el.className += ' ' + targetclass
    }
    return null
  },

  addshimmy (target) {
    let shim = (!window.opera) ? document.createElement('iframe') : document.createElement('div') // Opera 9.24 doesn't seem to support transparent iframes
    shim.className = 'ddiframeshim'
    shim.setAttribute('src', location.protocol === 'https:' ? this.httpsiframesrc : 'about:blank')
    shim.setAttribute('frameborder', '0')
    target.appendChild(shim)
    try {
      shim.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)'
    } catch (e) {}
    return shim
  },

  positionshim (header, scrollX, scrollY) {
    if (header._istoplevel) {
      scrollY = window.pageYOffset ? window.pageYOffset : this.standardbody.scrollTop
      let topgap = header._offsets.top - scrollY
      let bottomgap = scrollY + this.docheight - header._offsets.top - header._dimensions.h
      if (topgap > 0) {
        this.shimmy.topshim.style.left = scrollX + 'px'
        this.shimmy.topshim.style.top = scrollY + 'px'
        this.shimmy.topshim.style.width = '99%'
        this.shimmy.topshim.style.height = topgap + 'px' // distance from top window edge to top of menu item
      }
      if (bottomgap > 0) {
        this.shimmy.bottomshim.style.left = scrollX + 'px'
        this.shimmy.bottomshim.style.top = header._offsets.top + header._dimensions.h + 'px'
        this.shimmy.bottomshim.style.width = '99%'
        this.shimmy.bottomshim.style.height = bottomgap + 'px' // distance from bottom of menu item to bottom window edge
      }
    }
  },

  hideshim () {
    this.shimmy.topshim.style.width = this.shimmy.bottomshim.style.width = 0
    this.shimmy.topshim.style.height = this.shimmy.bottomshim.style.height = 0
  },

  buildmenu (mainmenuid, header, submenu, submenupos, istoplevel, dir) {
    header._master = mainmenuid // Indicate which top menu this header is associated with
    header._pos = submenupos // Indicate pos of sub menu this header is associated with
    header._istoplevel = istoplevel
    if (istoplevel) {
      this.addEvent(header, () => {
        this.hidemenu(this.subuls[this._master][parseInt(this._pos)])
      }, 'click')
    }
    this.subuls[mainmenuid][submenupos] = submenu
    header._dimensions = {
      w: header.offsetWidth,
      h: header.offsetHeight,
      submenuw: submenu.offsetWidth,
      submenuh: submenu.offsetHeight
    }
    this.getoffsetof(header)
    submenu.style.left = 0
    submenu.style.top = 0
    submenu.style.visibility = 'hidden'
    this.addEvent(header, (e) => { // mouseover event
      if (!this.isContained(this, e)) {
        let submenu = this.subuls[this._master][parseInt(this._pos)]
        if (this._istoplevel) {
          this.css(this, 'selected', 'add')
          clearTimeout(this.hidetimers[this._master][this._pos])
        }
        this.getoffsetof(header)
        let scrollX = window.pageXOffset ? window.pageXOffset : this.standardbody.scrollLeft
        let scrollY = window.pageYOffset ? window.pageYOffset : this.standardbody.scrollTop
        let submenurightedge = this._offsets.left + this._dimensions.submenuw + (this._istoplevel && dir === 'topbar' ? 0 : this._dimensions.w)
        let submenubottomedge = this._offsets.top + this._dimensions.submenuh
        // Sub menu starting left position
        let menuleft = (this._istoplevel ? this._offsets.left + (dir === 'sidebar' ? this._dimensions.w : 0) : this._dimensions.w)
        if (submenurightedge - scrollX > this.docwidth) {
          menuleft += -this._dimensions.submenuw + (this._istoplevel && dir === 'topbar' ? this._dimensions.w : -this._dimensions.w)
        }
        submenu.style.left = menuleft + 'px'
        // Sub menu starting top position
        let menutop = (this._istoplevel ? this._offsets.top + (dir === 'sidebar' ? 0 : this._dimensions.h) : this.offsetTop)
        if (submenubottomedge - scrollY > this.docheight) { // no room downwards?
          if (this._dimensions.submenuh < this._offsets.top + (dir === 'sidebar' ? this._dimensions.h : 0) - scrollY) { // move up?
            menutop += -this._dimensions.submenuh + (this._istoplevel && dir === 'topbar' ? -this._dimensions.h : this._dimensions.h)
          } else { // top of window edge
            menutop += -(this._offsets.top - scrollY) + (this._istoplevel && dir === 'topbar' ? -this._dimensions.h : 0)
          }
        }
        submenu.style.top = menutop + 'px'
        if (this.enableshim && (this.effects.enableswipe === false || this.nonFF)) { // apply shim immediately only if animation is turned off, or if on, in non FF2.x browsers
          this.positionshim(header, scrollX, scrollY)
        } else {
          submenu.FFscrollInfo = {
            x: scrollX,
            y: scrollY
          }
        }
        this.showmenu(header, submenu, dir)
      }
    }, 'mouseover')
    this.addEvent(header, (e) => { // mouseout event
      let submenu = this.subuls[this._master][parseInt(this._pos)]
      if (this._istoplevel) {
        if (!this.isContained(this, e) && !this.isContained(submenu, e)) { // hide drop down ul if mouse moves out of menu bar item but not into drop down ul itself
          this.hidemenu(submenu)
        }
      } else if (!this._istoplevel && !this.isContained(this, e)) {
        this.hidemenu(submenu)
      }
    }, 'mouseout')
  },

  setopacity (el, value) {
    el.style.opacity = value
    if (typeof el.style.opacity !== 'string') { // if it's not a string (ie: number instead), it means property not supported
      el.style.MozOpacity = value
      if (el.filters) {
        el.style.filter = 'progid:DXImageTransform.Microsoft.alpha(opacity=' + value * 100 + ')'
      }
    }
  },

  showmenu (header, submenu, dir) {
    if (this.effects.enableswipe || this.effects.enablefade) {
      let endpoint
      if (this.effects.enableswipe) {
        endpoint = (header._istoplevel && dir === 'topbar') ? header._dimensions.submenuh : header._dimensions.submenuw
        submenu.style.width = submenu.style.height = 0
        submenu.style.overflow = 'hidden'
      }
      if (this.effects.enablefade) {
        this.setopacity(submenu, 0) // set opacity to 0 so menu appears hidden initially
      }
      submenu._curanimatedegree = 0
      submenu.style.visibility = 'visible'
      clearInterval(submenu._animatetimer)
      submenu._starttime = new Date().getTime() // get time just before animation is run
      submenu._animatetimer = setInterval(() => {
        this.revealmenu(header, submenu, endpoint, dir)
      }, 10)
    } else {
      submenu.style.visibility = 'visible'
    }
  },

  revealmenu (header, submenu, endpoint, dir) {
    let elapsed = new Date().getTime() - submenu._starttime // get time animation has run
    if (elapsed < this.effects.duration) {
      if (this.effects.enableswipe) {
        if (submenu._curanimatedegree === 0) { // reset either width or height of sub menu to "auto" when animation begins
          submenu.style[header._istoplevel && dir === 'topbar' ? 'width' : 'height'] = 'auto'
        }
        submenu.style[header._istoplevel && dir === 'topbar' ? 'height' : 'width'] = (submenu._curanimatedegree * endpoint) + 'px'
      }
      if (this.effects.enablefade) {
        this.setopacity(submenu, submenu._curanimatedegree)
      }
    } else {
      clearInterval(submenu._animatetimer)
      if (this.effects.enableswipe) {
        submenu.style.width = 'auto'
        submenu.style.height = 'auto'
        submenu.style.overflow = 'visible'
      }
      if (this.effects.enablefade) {
        this.setopacity(submenu, 1)
        submenu.style.filter = ''
      }
      if (this.enableshim && submenu.FFscrollInfo) { // if this is FF browser (meaning shim hasn't been applied yet
        this.positionshim(header, submenu.FFscrollInfo.x, submenu.FFscrollInfo.y)
      }
    }
    submenu._curanimatedegree = (1 - Math.cos((elapsed / this.effects.duration) * Math.PI)) / 2
  },

  hidemenu (submenu) {
    if (typeof submenu._pos !== 'undefined') { // if submenu is outermost UL drop down menu
      this.css(this.topitems[submenu._master][parseInt(submenu._pos)], 'selected', 'remove')
      if (this.enableshim) {
        this.hideshim()
      }
    }
    clearInterval(submenu._animatetimer)
    submenu.style.left = 0
    submenu.style.top = '-1000px'
    submenu.style.visibility = 'hidden'
  },

  addEvent (target, funcref, tasktype) {
    if (target.addEventListener) {
      target.addEventListener(tasktype, funcref, false)
    } else if (target.attachEvent) {
      target.attachEvent('on' + tasktype, () => {
        return funcref.call(target, window.event)
      })
    }
  },

  init (mainmenuid, dir) {
    this.standardbody = (document.compatMode === 'CSS1Compat') ? document.documentElement : document.body
    this.topitemsindex = -1
    this.ulindex = -1
    this.topmenuids.push(mainmenuid)
    this.topitems[mainmenuid] = [] // declare array on object
    this.subuls[mainmenuid] = [] // declare array on object
    this.hidetimers[mainmenuid] = [] // declare hide entire menu timer
    if (this.enableshim && !this.shimadded) {
      this.shimmy = {}
      this.shimmy.topshim = this.addshimmy(document.body) // create top iframe shim obj
      this.shimmy.bottomshim = this.addshimmy(document.body) // create bottom iframe shim obj
      this.shimadded = true
    }
    let menubar = document.getElementById(mainmenuid)
    let alllinks = menubar.getElementsByTagName('a')
    this.getwindowsize()
    for (let i = 0; i < alllinks.length; i++) {
      if (alllinks[i].getAttribute('rel')) {
        this.topitemsindex++
        this.ulindex++
        let menuitem = alllinks[i]
        this.topitems[mainmenuid][this.topitemsindex] = menuitem // store ref to main menu links
        let dropul = document.getElementById(menuitem.getAttribute('rel'))
        document.body.appendChild(dropul) // move main ULs to end of document
        dropul.style.zIndex = 2000 // give drop down menus a high z-index
        dropul._master = mainmenuid // Indicate which main menu this main UL is associated with
        dropul._pos = this.topitemsindex // Indicate which main menu item this main UL is associated with
        this.addEvent(dropul, () => {
          this.hidemenu(this)
        }, 'click')
        let arrowclass = (dir === 'sidebar') ? 'rightarrowpointer' : 'downarrowpointer'
        let arrowpointer = (dir === 'sidebar') ? this.arrowpointers.rightarrow : this.arrowpointers.downarrow
        if (this.arrowpointers.showarrow.toplevel) {
          this.addpointer(menuitem, arrowclass, arrowpointer, (dir === 'sidebar') ? 'before' : 'after')
        }
        this.buildmenu(mainmenuid, menuitem, dropul, this.ulindex, true, dir) // build top level menu
        dropul.onmouseover = () => {
          clearTimeout(this.hidetimers[this._master][this._pos])
        }
        this.addEvent(dropul, (e) => { // hide menu if mouse moves out of main UL element into open space
          if (!this.isContained(this, e) && !this.isContained(this.topitems[this._master][parseInt(this._pos)], e)) {
            let dropul = this
            if (this.enableshim) {
              this.hideshim()
            }
            this.hidetimers[this._master][this._pos] = setTimeout(() => {
              this.hidemenu(dropul)
            }, this.hideinterval)
          }
        }, 'mouseout')
        let subuls = dropul.getElementsByTagName('ul')
        for (let c = 0; c < subuls.length; c++) {
          this.ulindex++
          let parentli = subuls[c].parentNode
          if (this.arrowpointers.showarrow.sublevel) {
            this.addpointer(parentli.getElementsByTagName('a')[0], 'rightarrowpointer', this.arrowpointers.rightarrow, 'before')
          }
          this.buildmenu(mainmenuid, parentli, subuls[c], this.ulindex, false, dir) // build sub level menus
        }
      }
    } // end for loop
    this.addEvent(window, () => {
      this.getwindowsize()
      this.gettopitemsdimensions()
    }, 'resize')
  },

  setup (mainmenuid, dir) {
    this.addEvent(window, () => {
      this.init(mainmenuid, dir)
    }, 'load')
  }
}
