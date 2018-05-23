beforeEach(function () {
    window.Events = jasmine.createSpyObj('Events', ['on', 'trigger']);
});