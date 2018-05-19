/* eslint-env browser */
/* global DotObject */
/* exported UpdatableMixin */
var UpdatableMixin = {
  methods: {
    isUndefined: function (value) {
      return typeof value === 'undefined' || value === null
    },
    $update: function (path, data) {
      var dotted
      var index
      var parsed

      if (path === 'form' && this.isUndefined(data)) {
        return
      }

      if (path === 'form' && typeof data === 'object') {
        for (var n in data) {
          if (!data.hasOwnProperty(n) || this.isUndefined(data[n])) {
            continue
          }
          this.$update('form.' + n, data[n])
        }
        return
      }

      if (typeof data !== 'object') {
        this.$set(path, data)
        return
      }

      dotted = DotObject.dot(data)

      for (index in dotted) {
        if (!dotted.hasOwnProperty(index)) {
          continue
        }

        /**
         * Replace numerical references for square brackets equivalents
         */
        parsed = [path, index].join('.')
          .replace(/(?:^|\.)(\d+)(?:\.|$)/g, '[$1]')
          .replace(/]([^[])/g, '].$1')

        this.$set(parsed, dotted[index])
      }
    }
  }
};