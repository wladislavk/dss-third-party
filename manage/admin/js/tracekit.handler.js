function serialize (object, index) {
    function toString (value) {
        if (typeof value === 'string') {
            return value;
        }

        if (typeof value === 'number') {
            return value.toString();
        }

        return '';
    }

    function createIndex (key, parent) {
        var index;

        key = encodeURIComponent(toString(key));
        parent = toString(parent);

        if (!parent.length && !key.length) {
            return '';
        }

        if (parent.length && key.length) {
            index = [parent, '[', key, ']'].join('');
        } else {
            index = parent || key;
        }

        return index;
    }

    function assign (value, key, parent) {
        var index = createIndex(key, parent);

        value = encodeURIComponent(toString(value));

        if (index.length) {
            return [index, '=', value].join('');
        }

        return value;
    }

    var elements = [],
        section,
        key, n;

    if (typeof object === 'string' || typeof object === 'number') {
        return assign(object, '', index);
    }

    if (typeof object !== 'object') {
        return assign('', '', index);
    }

    for (key in object) {
        if (!object.hasOwnProperty(key) || typeof object[key] === 'function') {
            continue;
        }

        section = serialize(object[key], createIndex(key, index));

        if (typeof section === 'string') {
            section = [section];
        }

        for (n in section) {
            elements.push(section[n]);
        }
    }

    return typeof index === 'string' ? elements : elements.join('&');
}

function simpleAjax (url, type, data) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    data = serialize(data);

    xmlhttp.open(type.toUpperCase(), url, true);

    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.setRequestHeader('Content-Length', data.length);
    xmlhttp.setRequestHeader('Connection', 'close');

    xmlhttp.send(data);
}

TraceKit.report.subscribe(function errorReportLogger (errorReport) {
    try {
        if (
            typeof window.environment !== 'undefined' &&
            window.environment !== 'production' &&
            typeof console !== 'undefined'
        ) {
            console.info(errorReport);
        }

        if (typeof jQuery === 'undefined') {
            simpleAjax(
                '/manage/admin/js-error-logger.php',
                'post',
                { report: JSON.stringify(errorReport) }
            );
        } else {
            $.ajax({
                url: '/manage/admin/js-error-logger.php',
                type: 'post',
                data: {report: JSON.stringify(errorReport)}
            });
        }
    } catch (e) { /* Ignore errors here to avoid loops */ }
});

var hey = {
    claims: [{
        id: 123,
        userid: 23,
        patientid: 16,
        status: 'paid'
    }, {
        id: 368,
        userid: 23,
        patientid: 1,
        status: 'pending'
    }],
    errors: [
        'The claim was not filed.',
        'The claim is pending.'
    ],
    acknowledgements: {
        payments: {
            reports: {
                amount: 12.36,
                fields: [
                    'abc',
                    '123',
                    'doremi'
                ]
            }
        }
    }
};
