/**
 * @requires Events
 * @requires Modal
 */
var CustomTextMixin = {
    data: {
        mixin: {
            namespace: null,
            events: {
                customText: function (args) {
                    this.setCustomText(['form', args.field].join('.'), args.text);
                }
            }
        }
    },
    methods: {
        loadCustomText: function (field) {
            Modal.customText(this.mixin.namespace, field, true);
        },
        setCustomText: function (field, text) {
            this.$set(field, text);
        }
    },
    ready: function () {
        var self = this, event, handler;

        if (this.mixin.namespace && this.mixin.events) {
            for (event in this.mixin.events) {
                if (!this.mixin.events.hasOwnProperty(event)) {
                    continue;
                }

                handler = this.mixin.events[event];

                if (typeof handler !== 'function') {
                    continue;
                }

                Events.on([event, this.mixin.namespace].join('.'), function (event, args) {
                    if (typeof args !== 'object' || args.namespace !== self.mixin.namespace) {
                        return;
                    }

                    try {
                        handler.apply(self, [args]);
                    } catch (e) {}
                });
            }
        }
    }
};
