/**
  * @requires jQuery >= 1.9
  */
(function (jQuery) {
    window.Events = {
        self: jQuery(document),
        on: function (name, handler) {
            this.self.on(name, handler);
        },
        trigger: function () {
            var args = Array.prototype.slice.call(arguments);
            this.self.trigger.apply(this.self, [args.slice(0, 1), args.slice(1)]);
        }
    };
}(jQuery));