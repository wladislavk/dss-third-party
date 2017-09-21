if (window.jQuery) {
  (function ($) {
    $(document).ready(function () {
      const mega = 1024 * 1024
      const maxFileSize = 10 * mega

      // Alert the user when the file is too big
      // Avoid adding the same handler more than once
      $('[type=file]:not(.filesize-watchdog)')
        .addClass('filesize-watchdog')
        .change(function () {
          const $this = $(this)
          let fileSize = 0

          try {
            fileSize = $this[0].files[0].size
          } catch (e) {}

          if (fileSize >= maxFileSize) {
            alert(
              'The selected file (' + (fileSize / mega).toFixed(2) + ' MB) ' +
              'exceeds the maximum allowed file size (' + (maxFileSize / mega).toFixed(2) + ' MB)\n\n' +
              'Please select a different file.'
            )
            $this.val('')
          }
        })
    })
  }(window.jQuery))
}
