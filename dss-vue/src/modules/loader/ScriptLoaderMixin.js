module.exports = {
    methods: {
        loadScriptFrom: function(path, toElement, requiredFunction, externalFunction) {
            if (externalFunction === undefined) {
                externalFunction = () => {};
            }

            if (!requiredFunction) {
                var scriptElement   = document.createElement('script');
                scriptElement.type  = 'text/javascript';
                scriptElement.src   = path;
                scriptElement.async = true;

                $(this.$el).find(toElement).append(scriptElement);
            } else {
                externalFunction();
            }
        }
    }
}