describe('Custom Text Mixin', function () {
    var module;

    beforeEach(function () {
        module = new Vue({
            mixins: [CustomTextMixin],
            data: {
                mixin: {
                    namespace: 'custom-text'
                },
                form: {
                    text: 'Initial value'
                }
            }
        });

        module.$mount().$appendTo('body');
    });

    afterEach(function () {
        module.$destroy(true);
    });

    it('should contain loadCustomText/setCustomText methods', function () {
        expect(module.loadCustomText).toBeFunction();
        expect(module.setCustomText).toBeFunction();
    });

    it('should setup the event handler', function () {
        expect(Events.on).toHaveBeenCalledWith(['customText', module.mixin.namespace].join('.'), jasmine.any(Function));
    });

    describe('Load custom text', function () {
        it('should call Modal.customText', function () {
            module.loadCustomText('text');
            expect(Modal.customText).toHaveBeenCalledWith(module.mixin.namespace, 'text');
        });
    });

    describe('Set custom text', function () {
        it('should set the value', function () {
            module.setCustomText('text', 'New value');
            expect(module.$get('text')).toEqual('New value');
        });
    });
});
