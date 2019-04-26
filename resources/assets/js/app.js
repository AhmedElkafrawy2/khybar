try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
    require('./jquery.custom-file-input');
} catch (e) {}
