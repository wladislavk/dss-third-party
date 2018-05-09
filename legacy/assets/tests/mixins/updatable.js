describe('Updatable Mixin', function () {
    var module, updated;

    function original (index) {
        var options = {
            array: ['zero', 'one', 'two'],
            scalar: 1,
            string: 'one',
            object: {
                nested: {
                    left: true
                }
            }
        };

        return index ? options[index] : options;
    }

    function replacement (index) {
        var options = {
            scalar: 5,
            string: 'new',
            array: [null, 'first', 'second'],
            numeric: {
                0: '0:index',
                1: '1:index'
            },
            alpha: {
                a: 'a:index',
                b: 'b:index'
            }
        };

        return options[index];
    }

    beforeEach(function () {
        module = new Vue({
            mixins: [UpdatableMixin],
            data: original()
        });
    });

    afterEach(function () {
        module.$destroy(true);
    });

    it('should contain $update method', function () {
        expect(module.$update).toBeFunction();
    });

    describe('should replace target value', function () {
        describe('when target value is a scalar', function () {
            var target = 'scalar';

            it('and replacement is scalar', function () {
                var replace = 'scalar';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is a string', function () {
                var replace = 'string';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is an array', function () {
                var replace = 'array';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });

            it('and replacement is an object with numeric keys', function () {
                var replace = 'numeric';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });

            it('and replacement is an object with alphanumeric keys', function () {
                var replace = 'alpha';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });
        });

        describe('when target value is a string', function () {
            var target = 'string';

            it('and replacement is scalar', function () {
                var replace = 'scalar';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is a string', function () {
                var replace = 'string';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is an array', function () {
                var replace = 'array';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });

            it('and replacement is an object with numeric keys', function () {
                var replace = 'numeric';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });

            it('and replacement is an object with alphanumeric keys', function () {
                var replace = 'alpha';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });
        });

        describe('when target value is an array', function () {
            var target = 'array';

            it('and replacement is scalar', function () {
                var replace = 'scalar';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is a string', function () {
                var replace = 'string';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toEqual(replacement(replace));
            });

            it('and replacement is an array', function () {
                var replace = 'array';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeArray();
                expect(updated).toEqualAsDotNotation(replacement(replace));
            });
        });
    });

    describe('should merge target value', function (){
        describe('when target value is an array', function (){
            var target = 'array';

            it('and replacement is an object with numeric keys', function () {
                var replace = 'numeric';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeArray();
                expect(updated).toEqualAsDotNotation(['0:index', '1:index', 'two']);
            });

            it('and replacement is an object with alphanumeric keys (all keys are parsed as "0" index)', function () {
                var replace = 'alpha';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeArray();

                /**
                 * When the target is an array, it will interpret non-numeric indexes as "zero".
                 * Therefore, merging an object will effectively set the zero-index item several times.
                 * The final value will then be the "final" element in the object.
                 *
                 * Objects as collections with no defined order, thus the value being set depends on the
                 * js machine.
                 */
                expect(updated).toEqualAsDotNotation(['b:index', 'one', 'two']);
            });
        });

        describe('when target value is an object', function () {
            var target = 'object';

            it('and replacement is an object with numeric keys', function () {
                var replace = 'numeric';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation({
                    0: '0:index',
                    1: '1:index',
                    nested: {
                        left: true
                    }
                });
            });

            it('and replacement is an object with alphanumeric keys', function () {
                var replace = 'alpha';

                module.$update(target, replacement(replace));
                updated = module.$get(target);

                expect(updated).not.toEqual(original(target));
                expect(updated).toBeObject();
                expect(updated).toEqualAsDotNotation({
                    a: 'a:index',
                    b: 'b:index',
                    nested: {
                        left: true
                    }
                });
            });
        });
    });

    describe('should deep merge target value', function () {
        it('when target and replacement are objects, and the deep indexes match', function () {
            var target = 'object';

            module.$update(target, { nested: { right: true } });
            updated = module.$get(target);

            expect(updated).not.toEqual(original(target));
            expect(updated).toBeObject();
            expect(updated).toEqualAsDotNotation({
                nested: {
                    left: true,
                    right: true
                }
            });
        });
    });
});
