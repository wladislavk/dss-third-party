/* global apiRoot */
/* global Events */
/* global Modal */
/* global moment */
/* global userTimeZone */
/* global Vue */
(function () {
  var SoapNotesDisplayComponent = Vue.extend({
    replace: true,
    template:
      '<div class="soap-notes-wrapper">' +
        '<table>' +
          '<tr>' +
            '<th>SOAP</th>' +
          '</tr>' +
          '<tr>' +
            '<td>Subjective</td>' +
          '</tr>' +
          '<tr>' +
            '<td>Objective</td>' +
          '</tr>' +
          '<tr>' +
            '<td>Assessment</td>' +
          '</tr>' +
          '<tr>' +
            '<td>Plan</td>' +
          '</tr>' +
          '<tr>' +
            '<td><button v-on:click.prevent="openNoteCallback()"> Add SOAP Note </button></td>' +
          '</tr>' +
        '</table>' +
        '<div class="soap-notes-scroller">' +
          '<div v-bind:style="{ width: (+noteWidth + 1)*notes.length + 2 + widthUnits }">' +
            '<table v-bind:style="{ width: noteWidth + widthUnits }" ' +
                'v-for="note in notes | orderBy sortBy">' +
              '<tr>' +
                '<th>{{ note.adddate | dateFormat "MM/DD/YYYY HH:mm" }}</th>' +
              '</tr>' +
              '<tr>' +
                '<td>{{ note.soap.subjective }}</td>' +
              '</tr>' +
              '<tr>' +
                '<td>{{ note.soap.objective }}</td>' +
              '</tr>' +
              '<tr>' +
                '<td>{{ note.soap.assessment }}</td>' +
              '</tr>' +
              '<tr>' +
                '<td>{{ note.soap.plan }}</td>' +
              '</tr>' +
              '<tr>' +
                '<td>' +
                  '<button v-if="!note.signed_id || !note.signed_on" ' +
                    'v-on:click.prevent="openNoteCallback(note.notesid)">' +
                    'Edit' +
                  '</button>' +
                  '<span class="red" v-if="note.signed_id && note.signed_on">' +
                    'Signed on {{ note.signed_on | dateFormat "MM/DD/YYYY HH:mm" }}' +
                  '</span>' +
                '</td>' +
              '</tr>' +
            '</table>' +
          '</div>' +
        '</div>' +
      '</div>',
    data: function () {
      return {
        notes: [],
        apiEndPoint: apiRoot + 'api/v1/notes',
        busy: false,
        loaded: false,
        dbDateFormat: 'YYYY-MM-DD HH:mm:ss',
        displayDateFormat: 'MM/DD/YYYY HH:mm'
      }
    },
    props: {
      patientId: {
        type: [Number, String],
        default: 0
      },
      userId: {
        type: [Number, String],
        default: 0
      },
      docId: {
        type: [Number, String],
        default: 0
      },
      noteWidth: {
        type: [Number, String],
        default: 20
      },
      widthUnits: {
        type: String,
        default: 'em'
      }
    },
    methods: {
      newNoteCallback: function (note) {
        var soap

        try {
          soap = JSON.parse(note.notes)
          delete note.notes
        } catch (e) {
          soap = {
            subjective: '',
            objective: '',
            assessment: '',
            plan: ''
          }
        }

        note.soap = soap
        this.notes.unshift(note)
      },
      openNoteCallback: function (noteId) {
        noteId = noteId || ''

        Modal.iframe(
          '/manage/add_notes.php?' +
          'fr=soapNotesDisplay' +
          '&' +
          'soap=1' +
          '&' +
          'pid=' + encodeURIComponent(this.patientId) +
          '&' +
          'ed=' + noteId
        )
      },
      sortBy: function (a, b) {
        var aSort = moment(a.adddate, this.dbDateFormat)
        var bSort = moment(b.adddate, this.dbDateFormat)

        if (aSort.unix() < bSort.unix()) {
          return 1
        }

        if (aSort.unix() > bSort.unix()) {
          return -1
        }

        return 0
      }
    },
    filters: {
      dateFormat: function (value, format) {
        var date = moment(value, this.dbDateFormat)

        if (!date.isValid()) {
          return value
        }

        return date.tz(userTimeZone).format(format)
      }
    },
    ready: function () {
      var self = this
      var options = {}

      Modal.showBusy('<img src="/manage/images/loading.gif" />', this.$el)

      Events.on('soapNotesDisplay.newNote', function (args) {
        self.newNoteCallback(args.note)
      })

      this.$http.get(this.apiEndPoint + '?patient_id=' + this.patientId, options)
        .then(function (response) {
          var data = {}
          var notes = []
          var orderedNotes = {}
          var note
          var soap
          var n

          try {
            data = response.json()
          } catch (e) {}

          Modal.unblock(self.$el)

          if (typeof data.data !== 'object') {
            return
          }

          for (n = 0; n < data.data.length; n++) {
            note = data.data[n]

            if (+note.docid !== +this.docId || +note.patientid !== +this.patientId) {
              continue
            }

            try {
              soap = JSON.parse(note.notes)
            } catch (e) {
              soap = null
            }

            if (soap === null) {
              continue
            }

            note['soap'] = soap
            var referenceId = +note.parentid || note.noteid
            if (!orderedNotes.hasOwnProperty(referenceId)) {
              orderedNotes[referenceId] = []
            }
            orderedNotes[referenceId].push(note)
          }

          for (n in orderedNotes) {
            if (!orderedNotes.hasOwnProperty(n)) {
              continue
            }
            notes.push(orderedNotes[n][0])
          }

          self.$set('notes', notes)
        }, function () {
          Modal.unblock(self.$el)
          Modal.notifyAction('There was a problem loading the list', self.$el)
        })
    }
  })

  Vue.component('soap-notes-display', SoapNotesDisplayComponent)
}())
