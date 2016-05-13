Vue.component('Modal', {
  template: '#modal-template',
  props: ['show', 'onClose'],
  methods: {
    close: function () {
        this.onClose();
    }
  },
  ready: function () {
    document.addEventListener("keydown", (e) => {
      if (this.show && e.keyCode == 27) {
        this.onClose();
      }
    });
  }
});

Vue.component('NewPostModal', {
  template: '#new-post-modal-template',
  props: ['show'],
  data: function () {
    return {
        title: '',
        body: ''
    };
  },
  methods: {
    close: function () {
      this.show = false;
      this.title = '';
      this.body = '';
    },
    savePost: function () {
      // Insert AJAX call here...
      this.close();
    }
  }
});

new Vue({
  el: '#app',
  data: {
    showNewPostModal: false
  }
});