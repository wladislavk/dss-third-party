/* @global DotObject */
window.Utils = {
  nonNullish: function (value) {
    if (typeof value === 'undefined' || value === null) {
      return ''
    }
    return value
  },
  plainObject: function (item) {
    var object

    try {
      object = JSON.stringify(item);
      object = JSON.parse(object);
    } catch (e) {
      return null
    }

    return object
  },
  map: function (source, map, inverse) {
    var target = {}

    if (typeof map === 'string') {
      DotObject.str(map, source, target)
      return target
    }

    for (var path in map) {
      if (!map.hasOwnProperty(path)) {
        continue
      }

      if (inverse) {
        DotObject.copy(map[path], path, source, target)
        continue
      }

      DotObject.copy(path, map[path], source, target)
    }

    return target
  },
  merge: function (target, source) {
    var index, dotted = DotObject.dot(source)

    for (index in dotted) {
      if (dotted.hasOwnProperty(index)) {
        DotObject.str(index, dotted[index], target)
      }
    }

    return target
  },
  navigate: function (page) {
    window.location.replace(page)
  },
  tokenize: function (url) {
    return url.replace(/[^a-z0-9_]+/g, '_')
  },
  uri: function () {
    return window.location.pathname.substring(1)
  }
}
