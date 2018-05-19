var ErrorsDisplayComponent = Vue.extend({
    replace: true,
    template: [
        '<style scoped>' +
            '.errors-display { text-align: center; }' +
            '.errors-display div { display: inline-block; margin: auto; text-align: left; }' +
            '.errors-display ul {' +
                'color: red;' +
                'display: block;' +
                'width: auto;' +
                'list-style: disc outside none;' +
                'margin: 1em 0 0 0;' +
                'padding-left: 40px;' +
            '}' +
            '.errors-display ul ul { list-style-type: circle; }' +
            '.errors-display ul li { display: list-item; padding: 0; }' +
        '</style>' +
        '<div class="errors-display" v-show="errors">' +
            '<div>' +
                'The form contains the following errors:' +
                '<ul>' +
                    '<li v-for="(field, list) in errors">' +
                        '<strong>{{ field }}</strong>' +
                        '<ul>' +
                            '<li v-for="error in list">{{ error }}</li>' +
                        '</ul>' +
                    '</li>' +
                '</ul>' +
            '</div>' +
        '</div>'
    ].join(''),
    props: {
        errors: {
            type: [Object, null],
            default: null
        }
    }
});

Vue.component('errors-display', ErrorsDisplayComponent);
