if (window.jQuery) {
    (function($){
        $(document).ready(function(){
            var mega = 1024*1024,
                maxFileSize = 10*mega;

            // Alert the user when the file is too big
            // Avoid adding the same handler more than once
            $('[type=file]:not(.filesize-watchdog)')
            .addClass('filesize-watchdog')
            .change(function(){
                var $this = $(this),
                    fileSize = 0;

                try {
                    fileSize = $this[0].files[0].size;
                } catch (e) {}

                if (fileSize >= maxFileSize) {
                    alert(
                        'The selected file (' + (fileSize/mega).toFixed(2) + ' MB) ' +
                            'exceeds the maximum allowed file size (' + (maxFileSize/mega).toFixed(2) + ' MB)\n\n' +
                            'Please select a different file.'
                    );
                    $this.val('');
                }
            });
        });
    }(jQuery));
}