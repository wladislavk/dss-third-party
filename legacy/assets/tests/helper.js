/**
 * https://github.com/JamieMason/Jasmine-Matchers/
 */
beforeEach(function () {
    function is (value, type) {
        return Object.prototype.toString.call(value) === '[object ' + type + ']';
    }

    function keys (object) {
        var list = [];

        for (var key in object) {
            if (object.hasOwnProperty(key)) {
                list.push(key);
            }
        }

        return list;
    }

    function createMatcher (handler) {
        return function (util, customEqualityTesters) {
            return {
                compare: function (actual, expected) {
                    return {
                        pass: handler(actual, expected, util, customEqualityTesters)
                    }
                }
            };
        };
    }

    jasmine.addMatchers({
        toBeArray: createMatcher(function (actual) {
            return is(actual, 'Array');
        }),
        toBeObject: createMatcher(function (actual) {
            return is(actual, 'Object');
        }),
        toBeString: createMatcher(function (actual) {
            return is(actual, 'String');
        }),
        toBeFunction: createMatcher(function (actual) {
            return typeof actual === 'function';
        }),
        toEqualAsJson: createMatcher(function (actual, expected) {
            return JSON.stringify(actual) === JSON.stringify(expected);
        }),
        toEqualAsDotNotation: createMatcher(function (actual, expected, util) {
            if (actual === null || expected === null || typeof actual !== 'object' || typeof expected !== 'object') {
                return false;
            }

            return util.equals(DotObject.dot(actual), DotObject.dot(expected));
        })
    });
});
