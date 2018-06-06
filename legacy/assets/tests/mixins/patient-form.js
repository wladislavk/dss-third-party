describe('Patient Form Mixin', function () {
    var module, ajaxCall, timeout = 100;

    function setupModule (getAuth) {
        module = new Vue({
            mixins: [PatientFormMixin],
            data: {
                mixin: {
                    apiEndPoint: '/local-api/'
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
            }
        });

        spyOn(module, '$update').and.callThrough();

        spyOn(module, 'formData').and.callThrough();
        spyOn(module, 'getResponseData').and.callThrough();
        spyOn(module, 'onReady').and.callThrough();

        spyOn(module, 'onLoadSuccess').and.callThrough();
        spyOn(module, 'onLoadError').and.callThrough();
        spyOn(module, 'onSave').and.callThrough();

        spyOn(module, 'onSaveSuccess').and.callThrough();
        spyOn(module, 'onSaveError').and.callThrough();
        spyOn(module, 'onInvalidToken').and.callThrough();

        module.$mount().$appendTo('body');
    }

    function setupBeforeEach (getAuth) {
        window.apiToken = '123';
        Vue.http.headers.common['Authorization'] = 'Bearer ' + window.apiToken;

        jasmine.Ajax.install();
        setupModule(!!getAuth);
    }

    function setupTimeout (type, status, next) {
        setupBeforeEach();

        ajaxCall = jasmine.Ajax.requests.mostRecent();
        ajaxCall.respondWith(response(type, status));

        setTimeout(next, timeout);
    }

    function responseValue (type) {
        var options = {
            scalar: 1,
            string: 'string',
            array: [1, 2, 3],
            object: {
                nested: true
            },
            valid: {
                data: {
                    array: {
                        2: {
                            left: true
                        },
                        4: {
                            incomplete: true
                        }
                    }
                }
            },
            invalid: {
                data: null
            }
        };

        return options[type];
    }

    function response (type, status) {
        return {
            status: status,
            responseText: JSON.stringify(responseValue(type))
        };
    }

    beforeEach(function () {
        timeout = 1000;
    });

    afterEach(function () {
        module.$destroy(true);
        jasmine.Ajax.uninstall();
    });

    describe('Setup', function () {
        beforeEach(function () {
            setupBeforeEach();
        });

        it('should contain mixin data', function () {
            expect(module.$get('mixin')).toBeObject();
            expect(module.$get('mixin.apiEndPoint')).toBeString();
            expect(module.$get('mixin.messages')).toBeObject();
        });

        it('should contain form data', function () {
            expect(module.formData()).toBeObject();
        });

        it('should block module UI', function () {
            expect(Modal.showBusy).toHaveBeenCalledWith(module.mixin.messages.loading, module.$el);
        });
    });

    describe('On load', function () {
        /**
         * This method is not testable, as it is called before the instance is returned
         */
        xdescribe('First action', function () {
            beforeEach(function (done) {
                setupTimeout('scalar', 200, done);
            });

            it('should call onReady (untestable)', function () {
                expect(module.onReady).toHaveBeenCalled();
            });
        });

        describe('should make a single GET request', function () {
            it('without auth token in request params', function () {
                setupBeforeEach();
                ajaxCall = jasmine.Ajax.requests.mostRecent();

                expect(jasmine.Ajax.requests.count()).toEqual(1);
                expect(ajaxCall.url).toBe('/local-api/');
                expect(ajaxCall.method).toBe('GET');
                expect(ajaxCall.params).toBeFalsy();
                expect(ajaxCall.requestHeaders.Authorization).toBe('Bearer 123');
            });

            it('with auth token in request params', function () {
                setupBeforeEach(true);
                ajaxCall = jasmine.Ajax.requests.mostRecent();

                expect(jasmine.Ajax.requests.count()).toEqual(1);
                expect(ajaxCall.url).toBe('/local-api/?token=123');
                expect(ajaxCall.method).toBe('GET');
                expect(ajaxCall.params).toBeFalsy();
                expect(ajaxCall.requestHeaders.Authorization).toBe('Bearer 123');
            });
        });

        describe('Response is a 400 error (token not provided)', function () {
            beforeEach(function (done) {
                setupTimeout('scalar', 400, done);
            });

            it('should call onInvalidToken', function () {
                expect(module.onInvalidToken).toHaveBeenCalledWith(jasmine.any(Object), true);
            });

            it('should notify of error', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.showBusy).toHaveBeenCalledWith(jasmine.any(String), module.$el);
            });
        });

        describe('Response is a 401 error (token expired)', function () {
            beforeEach(function (done) {
                setupTimeout('scalar', 401, done);
            });

            it('should call onInvalidToken', function () {
                expect(module.onInvalidToken).toHaveBeenCalledWith(jasmine.any(Object), true);
            });

            it('should notify of error', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.showBusy).toHaveBeenCalledWith(jasmine.any(String), module.$el);
            });
        });

        describe('Response is any other error', function () {
            beforeEach(function (done) {
                setupTimeout('scalar', 500, done);
            });

            it('should call onLoadError', function () {
                expect(module.onLoadError).toHaveBeenCalled();
            });

            it('should notify of error', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).toHaveBeenCalledWith(module.mixin.messages.getError, undefined, jasmine.any(Number));
            });
        });

        describe('Response is a scalar', function () {
            var type = 'scalar';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should not assign the value', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(module.formData()).not.toEqualAsDotNotation(responseValue(type));
            });
        });

        describe('Response is a string', function () {
            var type = 'string';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should not assign the value', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(module.formData()).not.toEqualAsDotNotation(responseValue(type));
            });
        });

        describe('Response is an array', function () {
            var type = 'array';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should not assign the value', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(module.formData()).not.toEqualAsDotNotation(responseValue(type));
            });
        });

        describe('Response is any object', function () {
            var type = 'object';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should not assign the value', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(module.formData()).not.toEqualAsDotNotation(responseValue(type));
            });
        });

        describe('Response is an invalid object', function () {
            var type = 'invalid';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should not assign the value', function () {
                expect(module.$update).not.toHaveBeenCalled();
                expect(module.formData()).not.toEqualAsDotNotation(responseValue(type).data);
            });
        });

        describe('Response is a valid object', function () {
            var type = 'valid';

            beforeEach(function (done) {
                setupTimeout(type, 200, done);
            });

            it('should call onLoadSuccess', function () {
                expect(module.onLoadSuccess).toHaveBeenCalled();
            });

            it('should unblock the UI', function () {
                expect(Modal.unblock).toHaveBeenCalledWith(module.$el);
                expect(Modal.notifyAction).not.toHaveBeenCalled();
            });

            it('should assign the value', function () {
                expect(module.$update).toHaveBeenCalledWith('form', responseValue(type).data);
                expect(module.formData()).toEqualAsDotNotation(responseValue(type).data);
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

        it('should block UI', function () {
            expect(event.preventDefault).toHaveBeenCalled();
            expect(Modal.showBusy).toHaveBeenCalledWith(module.mixin.messages.saving, undefined);
        });

        it('should make a single POST request', function () {
            expect(jasmine.Ajax.requests.count()).toEqual(1);
            expect(ajaxCall.url).toBe('/local-api/');
            expect(ajaxCall.method).toBe('PUT');
            expect(ajaxCall.params).toBe(JSON.stringify(responseValue(type).data));
            expect(ajaxCall.requestHeaders.Authorization).toBe('Bearer 123');
        });

        describe('Response is a 400 error (token not provided)', function () {
            beforeEach(function (done) {
                ajaxCall.respondWith(response('invalid', 400));
                setTimeout(done, timeout);
            });

            it('should call onInvalidToken', function () {
                expect(module.onInvalidToken).toHaveBeenCalledWith(jasmine.any(Object), false);
            });

            it('should notify of error', function () {
                expect(Modal.notifyAction).toHaveBeenCalledWith(jasmine.any(String), module.$el, jasmine.any(Number));
            });
        });

        describe('Response is a 401 error (token expired)', function () {
            beforeEach(function (done) {
                ajaxCall.respondWith(response('invalid', 401));
                setTimeout(done, timeout);
            });

            it('should call onInvalidToken', function () {
                expect(module.onInvalidToken).toHaveBeenCalledWith(jasmine.any(Object), false);
            });

            it('should notify of error', function () {
                expect(Modal.notifyAction).toHaveBeenCalledWith(jasmine.any(String), module.$el, jasmine.any(Number));
            });
        });

        describe('Response is any other error', function () {
            beforeEach(function (done) {
                ajaxCall.respondWith(response('invalid', 500));
                setTimeout(done, timeout);
            });

            it('should call onSaveError', function () {
                expect(module.onSaveError).toHaveBeenCalled();
            });

            it('should notify of error', function () {
                expect(Modal.notifyAction).toHaveBeenCalledWith(
                    module.mixin.messages.postError, undefined, jasmine.any(Number)
                );
            });
        });

        describe('Response is success', function () {
            beforeEach(function (done) {
                ajaxCall.respondWith(response('invalid', 200));
                setTimeout(done, timeout);
            });

            it('should call onSaveSuccess', function () {
                expect(module.onSaveSuccess).toHaveBeenCalled();
            });

            it('should notify of success', function () {
                expect(Modal.notifyAction).toHaveBeenCalledWith(
                    module.mixin.messages.saved, undefined, jasmine.any(Number)
                );
            });
        });
    });
});
