module.exports = {
    get: function(key) {
        if (localStorage.getItem(key)) {
            return localStorage.getItem(key);
        }
        return null;
    },
    save: function(key, value) {
        localStorage.setItem(key, value);
    },
    remove: function(key) {
        if (localStorage.getItem(key)) {
            localStorage.removeItem(key);
        }
    }
};