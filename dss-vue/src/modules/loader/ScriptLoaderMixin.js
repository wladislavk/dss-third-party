module.exports = {
    methods: {
        loadScriptFrom: function(path, toElement) {
            var scriptElement   = document.createElement('script');
            scriptElement.type  = 'text/javascript';
            scriptElement.src   = path;
            scriptElement.async = true;

            console.log($(this.$el).find(toElement));

            $(this.$el).find(toElement).append(scriptElement);
        }
    }
}