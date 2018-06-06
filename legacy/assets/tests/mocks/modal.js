beforeEach(function () {
    window.Modal = jasmine.createSpyObj('Modal', [
        'showBusy',
        'notifyAction',
        'blockUI',
        'unblock',
        'customText',
        'iframe'
    ]);
});