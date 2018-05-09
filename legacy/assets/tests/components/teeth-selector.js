describe('Teeth Selector Component', function () {
    var module;

    beforeEach(function () {
        module = new Vue({
            template: '<form>' +
                    '<div is="teeth-selector" v-bind:selector.sync="selection" v-ref:teeth-selector></div>' +
                '</form>',
            data: {
                selection: {}
            }
        });

        module.$mount().$appendTo('body');
    });

    afterEach(function () {
        module.$destroy(true);
    });

    describe('Setup', function () {
        it('should generate a component instance', function () {
            expect(module.$refs.teethSelector).toBeObject();
            expect(module.$refs.teethSelector.$refs.teethList).toBeArray();
            expect(module.$refs.teethSelector.$refs.teethList.length).toEqual(32);

            console.info(module.$refs.teethSelector.$refs.teethList);
        });
    });
});
