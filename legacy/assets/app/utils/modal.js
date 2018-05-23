/**
 * @requires jQuery >= 1.9
 * @requires blockUI
 * @requires loadPopupRefer
 */
(function ($) {
    window.Modal = {
        defaultCss: function () {
            return {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .7,
                color: '#fff'
            };
        },
        showBusy: function (message, target) {
            this.blockUI({
                message: message
            }, target);
        },
        notifyAction: function (message, target, timeout) {
            var clickAction = $.unblockUI;

            if (target) {
                clickAction = function () {
                    $(target).unblock();
                };
            }

            this.blockUI({
                message: message,
                timeout: timeout,
                onOverlayClick: clickAction
            }, target);
        },
        blockUI: function (options, target) {
            var baseOptions = {
                    css: this.defaultCss(),
                    baseZ: 10000
                },
                extendedOptions = {},
                clickAction = $.unblockUI;

            Utils.merge(extendedOptions, baseOptions);
            Utils.merge(extendedOptions, options);

            if (target) {
                clickAction = function () {
                    $(target).unblock();
                };
            }

            if (!options.onOverlayClick) {
                options.onOverlayClick = clickAction;
            }

            if (target) {
                $(target).block(extendedOptions);
                return;
            }

            $.blockUI(extendedOptions);
        },
        unblock: function (target) {
            if (target) {
                $(target).unblock();
                return;
            }

            $.unblockUI();
        },
        showPopup: function (target, options) {
            options = options || {};
            $(target).modal(options);
        },
        hidePopup: function (target) {
            $(target).modal('hide');
        },
        customText: function (reference, field, fromVue) {
            fromVue = +!!fromVue;

            this.iframe([
                '/manage/select_custom_all.php',
                '?vue=', encodeURIComponent(fromVue),
                '&fr=', encodeURIComponent(reference),
                '&tx=', encodeURIComponent(field)
            ].join(''));
        },
        iframe: function (url) {
            if (!$('#aj_ref').length) {
                $('body').append(
                    '<div id="popupRefer" style="height:550px; width:750px;">' +
                        '<a id="popupReferClose"><button>X</button></a>' +
                        '<iframe id="aj_ref" width="100%" height="100%" ' +
                            'frameborder="0" marginheight="0" marginwidth="0"></iframe>' +
                    '</div>' +
                    '<div id="backgroundPopupRef"></div>'
                );

                $('#popupReferClose').find('button').click(function(){
                    disablePopupRefClean();
                });
            }
            
            loadPopupRefer(url);
        }
    };
}(jQuery));