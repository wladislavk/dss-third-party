describe('Multiple Endpoints Mixin', function () {
    var module, ajaxCall, timeout, endPoints;

    function setupModule () {
        module = new Vue({
            mixins: [MultipleEndpointsMixin],
            data: {
                mixin: {
                    apiEndPoints: [
                        '/left-api/',
                        '/right-api/',
                        '/both-api/'
                    ]
                },
                form: {
                    array: [{
                        left: true,
                        right: false
                    }, {
                        left: false,
                        right: false
                    }, {
                        incomplete: true
                    }]
                }
            },
            methods: {
                fireHttpGet: function (url, data, successHandler, errorHandler) {
                    Vue.http.get(url, data).then(successHandler, errorHandler);
                },
                fireHttpPut: function (url, data, options, successHandler, errorHandler) {
                    Vue.http.put(url, data, options).then(successHandler, errorHandler);
                },
                fireHttpPost: function (url, data, options, successHandler, errorHandler) {
                    Vue.http.post(url, data, options).then(successHandler, errorHandler);
                },
                onLoadSuccess: function () {
                    var a;
                    a++;
                },
                onLoadError: function () {
                    var a;
                    a++;
                },
                onSaveSuccess: function () {
                    var a;
                    a++;
                },
                onSaveError: function () {
                    var a;
                    a++;
                },
                save: function () {
                    this.onSave();
                },
                formData: function () {
                    return this.form;
                }
            },
            ready: function () {
                this.onReady();
            }
        });
    }

    function setupTimeout (types, statuses, next) {
        var index, type, status, data;

        for (index = 0; index < endPoints.length; index++) {
            type = typeof types === 'object' ? types[index] : types;
            status = typeof statuses === 'object' ? statuses[index] : statuses;
            data = response(type, status);

            ajaxCall = jasmine.Ajax.requests.at(index);
            ajaxCall.respondWith(data);
        }

        setTimeout(next, timeout);
    }

    function responseValue (type) {
        var options = {
            left: {
                array: {
                    1: {
                        left: true
                    },
                    2: {
                        left: true
                    }
                }
            },
            right: {
                array: {
                    1: {
                        right: true
                    },
                    3: {
                        right: true
                    }
                }
            },
            both: {
                array: {
                    1: {
                        both: true
                    },
                    2: {
                        both: true
                    },
                    3: {
                        both: true
                    }
                }
            },
            merged: {
                array: {
                    1: {
                        left: true,
                        right: true,
                        both: true
                    },
                    2: {
                        left: true,
                        both: true
                    },
                    3: {
                        right: true,
                        both: true
                    }
                }
            }
        };

        return options[type];
    }

    function response (type, status) {
        return {
            status: status,
            responseText: JSON.stringify({ data: responseValue(type) })
        };
    }

    beforeEach(function () {
        timeout = 200;
        endPoints = ['left', 'right', 'both'];

        jasmine.Ajax.install();
        setupModule();

        spyOn(module, 'fireHttpGet').and.callThrough();
        spyOn(module, 'fireHttpPut').and.callThrough();
        spyOn(module, 'fireHttpPost').and.callThrough();

        spyOn(module, 'save').and.callThrough();
        spyOn(module, 'onReady').and.callThrough();
        spyOn(module, 'onSave').and.callThrough();
        spyOn(module, 'formData').and.callThrough();

        spyOn(module, 'onLoadSuccess');
        spyOn(module, 'onLoadError');
        spyOn(module, 'onSaveSuccess');
        spyOn(module, 'onSaveError');

        module.$mount().$appendTo('body');
    });

    afterEach(function () {
        module.$destroy(true);
        jasmine.Ajax.uninstall();
    });

    describe('Setup', function () {
        it('should contain mixin data', function () {
            expect(module.$get('mixin')).toBeObject();
            expect(module.$get('mixin.apiEndPoints')).toBeArray();
        });

        it('should contains onReady, onSave methods', function () {
            expect(module.onReady).toBeFunction();
            expect(module.onSave).toBeFunction();
        });
    });

    describe('On load', function () {
        /**
         * This method is not testable, as it is called before the instance is returned
         */
        xdescribe('First action', function () {
            beforeEach(function (done) {
                setupTimeout(endPoints, 400, done);
            });

            it('should call onReady (untestable)', function () {
                expect(module.onReady).toHaveBeenCalled();
            });
        });

        describe('First action', function () {
            beforeEach(function (done) {
                setupTimeout(endPoints, 400, done);
            });

            it('should make multiple GET request', function () {
                var index;
                expect(jasmine.Ajax.requests.count()).toEqual(3);

                for (index = 0; index < endPoints.length; index++) {
                    ajaxCall = jasmine.Ajax.requests.at(index);

                    expect(ajaxCall.url).toBe('/' + endPoints[index] + '-api/');
                    expect(ajaxCall.method).toBe('GET');
                    expect(ajaxCall.params).toBeFalsy();
                }
            });
        });

        describe('One response is an error', function () {
            beforeEach(function (done) {
                setupTimeout(endPoints, [200, 200, 400], done);
            });

            it('should call onLoadError', function () {
                var recentCall = module.onLoadError.calls.mostRecent();

                expect(module.onLoadError).toHaveBeenCalled();
                expect(recentCall.args.length).toBe(1);
                expect(recentCall.args[0]).toBeObject();
                expect(recentCall.args[0].data).toEqualAsDotNotation({ data: responseValue('both') });
            });
        });

        describe('All responses are success', function () {
            beforeEach(function (done) {
                setupTimeout(endPoints, [200, 200, 200], done);
            });

            it('should call onLoadSuccess', function () {
                var recentCall = module.onLoadSuccess.calls.mostRecent();

                /**
                 * .toHaveBeenCalledWith() is unable to compare the objects with null/undefined properly
                 */
                expect(module.onLoadSuccess).toHaveBeenCalled();
                expect(recentCall.args.length).toBe(1);
                expect(recentCall.args[0]).toBeArray();
                expect(recentCall.args[0].length).toBe(3);

                expect(recentCall.args[0][0]).toBeObject();
                expect(recentCall.args[0][0].data).toEqualAsDotNotation({ data: responseValue('left') });

                expect(recentCall.args[0][1]).toBeObject();
                expect(recentCall.args[0][1].data).toEqualAsDotNotation({ data: responseValue('right') });

                expect(recentCall.args[0][2]).toBeObject();
                expect(recentCall.args[0][2].data).toEqualAsDotNotation({ data: responseValue('both') });
            });
        });
    });

    describe('On save', function () {
        var event, type = 'valid';

        beforeEach(function (done) {
            setupTimeout(type, 200, function () {
                event = jasmine.createSpyObj('event', ['preventDefault']);

                jasmine.Ajax.requests.reset();
                Modal.showBusy.calls.reset();
                Modal.notifyAction.calls.reset();
                Modal.blockUI.calls.reset();
                Modal.unblock.calls.reset();

                module.save(event);
                ajaxCall = jasmine.Ajax.requests.mostRecent();

                setTimeout(done, timeout);
            });
        });

        it('should call onSave', function () {
            expect(module.onSave).toHaveBeenCalled();
        });

        it('should call formData', function () {
            expect(module.formData).toHaveBeenCalled();
        });

        it('should make multiple POST request', function () {
            var index;
            expect(jasmine.Ajax.requests.count()).toEqual(3);

            for (index = 0; index < endPoints.length; index++) {
                ajaxCall = jasmine.Ajax.requests.at(index);

                expect(ajaxCall.url).toBe('/' + endPoints[index] + '-api/');
                expect(ajaxCall.method).toBe('PUT');
                expect(ajaxCall.params).toBe(JSON.stringify(module.formData()));
            }
        });

        describe('One response is an error', function () {
            beforeEach(function (done) {
                var index;

                for (index = 0; index < endPoints.length; index++) {
                    ajaxCall = jasmine.Ajax.requests.at(index);
                    ajaxCall.respondWith(response(endPoints[index], parseInt(index) === 2 ? 400 : 200));
                }

                setTimeout(done, timeout);
            });

            it('should call onSaveError', function () {
                var recentCall = module.onSaveError.calls.mostRecent();

                /**
                 * .toHaveBeenCalledWith() is unable to compare the objects with null/undefined properly
                 */
                expect(module.onSaveError).toHaveBeenCalled();
                expect(recentCall.args.length).toBe(1);
                expect(recentCall.args[0]).toBeObject();
                expect(recentCall.args[0].data).toEqualAsDotNotation({ data: responseValue('both') });
            });
        });

        describe('All responses are success', function () {
            beforeEach(function (done) {
                var index;

                for (index = 0; index < endPoints.length; index++) {
                    ajaxCall = jasmine.Ajax.requests.at(index);
                    ajaxCall.respondWith(response(endPoints[index], 200));
                }

                setTimeout(done, timeout);
            });

            it('should call onSaveSuccess', function () {
                var recentCall = module.onSaveSuccess.calls.mostRecent();

                /**
                 * .toHaveBeenCalledWith() is unable to compare the objects with null/undefined properly
                 */
                expect(module.onSaveSuccess).toHaveBeenCalled();
                expect(recentCall.args.length).toBe(1);
                expect(recentCall.args[0]).toBeArray();
                expect(recentCall.args[0].length).toBe(3);

                expect(recentCall.args[0][0]).toBeObject();
                expect(recentCall.args[0][0].data).toEqualAsDotNotation({ data: responseValue('left') });

                expect(recentCall.args[0][1]).toBeObject();
                expect(recentCall.args[0][1].data).toEqualAsDotNotation({ data: responseValue('right') });

                expect(recentCall.args[0][2]).toBeObject();
                expect(recentCall.args[0][2].data).toEqualAsDotNotation({ data: responseValue('both') });
            });
        });
    });
});
