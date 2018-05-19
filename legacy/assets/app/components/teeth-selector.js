(function () {
  function fromIndexToIndicator(index) {
    var indicator

    indicator = index >= 16 ? 32 - index % 16 : index + 1
    indicator = ['0', indicator.toString()].join('').substr(-2, 2)

    return indicator
  }

  function fromIndicatorToIndex(indicator) {
    var index

    indicator = parseInt(indicator, 10) - 1
    index = indicator >= 16 ? 32 - indicator % 16 : indicator + 1
    index--

    return index
  }

  var TeethSelectorComponent = Vue.extend({
    replace: true,
    template: '<div class="teeth-selector">' +
        '<style scoped>' +
          '.teeth-selector input { display: none; }' +
          '.teeth-selector table { border: none; }' +
          '.teeth-selector td { vertical-align: middle; }' +
          '.teeth-selector label {' +
            'display: inline-block; text-align: center; border: 1px solid blue; border-radius: 4px;' +
          '}' +
          '.teeth-selector label span { display: block; }' +
          '.teeth-selector .opaque { opacity: 0.5; }' +
          '.teeth-selector .opaque label { border-color: transparent; }' +
        '</style>' +
        '<table>' +
          '<tr>' +
            '<td>R</td>' +
            '<td>' +
              '<span v-for="tooth in teeth" v-bind:class="{ opaque: !tooth.checked }">' +
                '<input type="checkbox" id="teeth-{{ tooth.index }}-{{ instanceId }}"' +
                  ' v-bind:disabled="stopCallbacks" v-model="tooth.checked" />' +
                '<label for="teeth-{{ tooth.index }}-{{ instanceId }}">' +
                  '<span v-if="parseInt(tooth.index, 10) < 17">{{ tooth.index }}</span>' +
                  '<img v-bind:src="tooth.source"' +
                    ' alt="{{ tooth.index }}" title="{{ tooth.index }}"' +
                    ' height="53" border="0" width="33" />' +
                  '<span v-if="parseInt(tooth.index, 10) > 16">{{ tooth.index }}</span>' +
                '</label>' +
                '<br v-if="parseInt(tooth.index, 10) === 16" />' +
              '</span>' +
            '</td>' +
            '<td>L</td>' +
          '</tr>' +
        '</table>' +
      '</div>',
    data: function () {
      var obj = {
          teeth: [],
          instanceId: Math.random(0, 9999),
          busy: false
        },
        index, indicator

      for (index = 0; index < 32; index++) {
        indicator = fromIndexToIndicator(index)

        obj.teeth.push({
          index: indicator,
          source: ['/manage/missing_teeth/', indicator, '.png'].join(''),
          checked: false
        })
      }

      return obj
    },
    props: {
      selector: {
        twoWay: true
      },
      stopCallbacks: {
        type: [Boolean],
        default: false
      }
    },
    watch: {
      teeth: {
        handler: 'updateSelector',
        deep: true
      },
      selector: {
        handler: 'updateInternal',
        deep: true
      }
    },
    methods: {
      updateSelector: function () {
        var index, tooth

        this.busy = true

        for (index in this.teeth) {
          if (!this.teeth.hasOwnProperty(index)) {
            continue
          }
          tooth = this.teeth[index]
          this.$set(['selector[', tooth.index, ']'].join(''), !!tooth.checked)
        }

        this.busy = false
      },
      updateInternal: function () {
        var index, indicator

        if (this.busy) {
          return
        }

        for (indicator in this.selector) {
          if (!this.selector.hasOwnProperty(indicator)) {
            continue
          }
          index = fromIndicatorToIndex(indicator)
          this.$set(['teeth[', index, '].checked'].join(''), !!this.selector[indicator])
        }
      }
    },
    ready: function () {
      this.updateInternal()
    }
  })

  Vue.component('teeth-selector', TeethSelectorComponent)
}())
