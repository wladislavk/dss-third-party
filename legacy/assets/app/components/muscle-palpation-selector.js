/* eslint-env browser */
/* global Utils */
/* global apiRoot */
/* global Vue */
/* exported PatientFormMixin */
var MusclePalpationSelectorComponent = Vue.extend({
  replace: true,
  template: '<div class="muscle-palpation-selector">' +
      '<div class="selector-legend">' +
        '<span class="level level-0">' +
          '0 - No tenderness' +
        '</span>' +
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
        '<span class="level level-1" style="padding-left:10px;">' +
          '1 - Mild' +
        '</span>' +
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
        '<span class="level level-2" style="padding-left:10px;">' +
          '2 - Moderate' +
        '</span>' +
        '&nbsp;&nbsp;&nbsp;' +
        '<span class="level level-3" style="padding-left:10px;">' +
          '3 - Severe' +
        '</span>' +
        '<br>' +
        '<button v-bind:disabled="stopCallbacks" v-on:click.prevent="setToValueCallback(0)">Set all to 0</button>' +
      '</div>' +
      '<div v-bind:class="{\'muscle-palpation-list\': true, \'update-order\': updateOrder }">' +
        '<div>' +
          '<div>' +
            '<span>Left</span>' +
            '<span>&nbsp;</span>' +
            '<span>Right</span>' +
          '</div>' +
          '<div v-if="!loaded" class="text-center">' +
            '<img alt="Loading..." src="/manage/images/loading.gif" />' +
          '</div>' +
          '<div v-for="muscle in filteredMuscles" ' +
              'v-if="$index < Math.ceil(filteredMuscles.length/2)">' +
            '<span>' +
              '<select class="field text addr tbox" ' +
                'v-bind:disabled="stopCallbacks" v-model="selection[muscle.palpationid].left">' +
                '<option v-for="n in 4" class="level level-{{ n }}" v-bind:value="{{ n }}">' +
                  '{{ n }}' +
                '</option>' +
              '</select>' +
            '</span>' +
            '<span>{{ muscle.palpation }}</span>' +
            '<span>' +
              '<select class="field text addr tbox" ' +
                'v-bind:disabled="stopCallbacks" v-model="selection[muscle.palpationid].right">' +
                '<option v-for="n in 4" class="level level-{{ n }}" v-bind:value="{{ n }}">' +
                  '{{ n }}' +
                '</option>' +
              '</select>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<div>' +
          '<div>' +
            '<span>Left</span>' +
            '<span>&nbsp;</span>' +
            '<span>Right</span>' +
          '</div>' +
          '<div v-if="!loaded" class="text-center">' +
            '<img alt="Loading..." src="/manage/images/loading.gif" />' +
          '</div>' +
          '<div v-for="muscle in filteredMuscles" ' +
              'v-if="$index >= Math.ceil(filteredMuscles.length/2)">' +
            '<span>' +
              '<select class="field text addr tbox" ' +
                'v-bind:disabled="stopCallbacks" v-model="selection[muscle.palpationid].left">' +
                '<option v-for="n in 4" class="level level-{{ n }}" v-bind:value="{{ n }}">' +
                  '{{ n }}' +
                '</option>' +
              '</select>' +
            '</span>' +
            '<span>{{ muscle.palpation }}</span>' +
            '<span>' +
              '<select class="field text addr tbox" ' +
                'v-bind:disabled="stopCallbacks" v-model="selection[muscle.palpationid].right">' +
                '<option v-for="n in 4" class="level level-{{ n }}" v-bind:value="{{ n }}">' +
                  '{{ n }}' +
                '</option>' +
              '</select>' +
            '</span>' +
          '</div>' +
        '</div>' +
        '<div>' +
          '<button class="button" ' +
            'v-bind:disabled="stopCallbacks" v-if="!updateOrder" v-on:click.prevent="enableOrderCallback()">' +
            'Sort list' +
          '</button>' +
          '<div class="update-list">' +
            '<div v-for="muscle in muscles | filterBy filterBy">' +
              '<input type="text" class="field text addr tbox" v-model="muscle.sortby" ' +
                'v-on:keydown.13.prevent="noOp" debounce="750">' +
              '&nbsp;{{ muscle.palpation }}' +
            '</div>' +
          '</div>' +
          '<button class="button" v-if="updateOrder" v-on:click.prevent="saveOrderCallback()">' +
            'Done' +
          '</button>' +
        '</div>' +
      '</div>' +
    '</div>',
  data: function () {
    return {
      selection: [],
      muscles: [],
      order: [],
      apiEndPoints: {
        muscles: apiRoot + 'api/v1/palpation',
        order: apiRoot + 'api/v1/doctor-palpations'
      },
      requests: 0,
      busy: false,
      loaded: false,
      updateOrder: false
    }
  },
  props: {
    setter: {
      type: [Object]
    },
    getter: {
      twoWay: true
    },
    docId: {
      type: [Number, String],
      default: 0
    },
    stopCallbacks: {
      type: [Boolean],
      default: false
    }
  },
  watch: {
    selection: {
      handler: 'updateGetter',
      deep: true
    },
    setter: {
      handler: 'updateInternal',
      deep: true
    }
  },
  computed: {
    filteredMuscles: function () {
      var filter = Vue.filter('filterBy')
      var sort = Vue.filter('orderBy')
      var filtered

      filtered = filter(this.muscles, this.muscleFilter)
      filtered = sort(filtered, this.sortBy)

      return filtered
    }
  },
  methods: {
    noOp: function () {},
    enableOrderCallback: function () {
      this.updateOrder = true
    },
    saveOrderCallback: function () {
      var data = {
        palpation: Utils.plainObject(this.muscles)
      }

      this.updateOrder = false
      this.$http.post(this.apiEndPoints.order, data, {})
    },
    setToValueCallback: function (value) {
      var muscles = this.$get('filteredMuscles')
      var index

      value = value || 0

      for (index = 0; index < muscles.length; index++) {
        this.$set('selection[' + muscles[index].palpationid + ']', { left: value, right: value })
      }
    },

    onLoadMuscleSuccess: function (response) {
      var data = {}

      try {
        data = response.json()
      } catch (e) { /* Fall through */ }

      this.requests++
      this.$set('muscles', data.data)
      this.onLoadSuccess()
    },
    onLoadOrderSuccess: function (response) {
      var data = {}

      try {
        data = response.json()
      } catch (e) { /* Fall through */ }

      this.requests++
      this.$set('order', data.data)
      this.onLoadSuccess()
    },
    onLoadOrderError: function () {
      this.requests++
      this.onLoadSuccess()
    },
    onLoadSuccess: function () {
      if (this.requests < 2) {
        return
      }

      this.loaded = true
      this.updateMuscleOrder()
      this.updateInternal()
    },
    updateMuscleOrder: function () {
      var muscles = Utils.plainObject(this.$get('muscles'))
      var order = Utils.plainObject(this.$get('order'))
      var indexedOrder = {}

      for (var n = 0; n < order.length; n++) {
        indexedOrder[order[n].palpationid] = order[n].sortby
      }

      for (n = 0; n < muscles.length; n++) {
        if (indexedOrder.hasOwnProperty(muscles[n].palpationid) && +muscles[n].sortby) {
          muscles[n].sortby = indexedOrder[muscles[n].palpationid]
        }
      }

      this.$set('muscles', muscles)
    },
    muscleFilter: function (object) {
      return +object.status === 1 && +object.sortby >= 0
    },
    sortBy: function (a, b) {
      if (+a.sortby > +b.sortby) {
        return 1
      }

      if (+a.sortby < +b.sortby) {
        return -1
      }

      return 0
    },
    updateGetter: function () {
      var selection = this.$get('selection')
      var index

      if (this.busy) {
        return
      }

      this.busy = true

      for (index in selection) {
        if (selection.hasOwnProperty(index)) {
          this.$set('getter[' + index + ']', this.$get('selection[' + index + ']'))
        }
      }

      this.busy = false
    },
    updateInternal: function () {
      var setter = this.$get('setter')
      var index

      if (this.busy) {
        return
      }

      for (index in setter) {
        if (!setter.hasOwnProperty(index)) {
          continue
        }

        this.$set('selection[' + index + ']', {
          left: Utils.nonNullish(setter[index].left),
          right: Utils.nonNullish(setter[index].right)
        })
      }
    }
  },
  ready: function () {
    var options = {}

    this.requests = 0

    this.$http
      .get(this.apiEndPoints.muscles, options)
      .then(this.onLoadMuscleSuccess, function () {})

    this.$http
      .get(this.apiEndPoints.order, options)
      .then(this.onLoadOrderSuccess, this.onLoadOrderError)
  }
})

Vue.component('muscle-palpation-selector', MusclePalpationSelectorComponent)
