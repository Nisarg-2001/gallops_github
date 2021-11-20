$.validator.addMethod(
    "phonenumber",
    function (e, t) {
        var a = e.replace(/\D/g);
        return !(parseInt(a) <= 0);
    },
    "Please enter a valid phone number."
),
    $.validator.addMethod(
        "minimum_length",
        function (e, t) {
            return $("#phone_no").val().length < 5 || $("#phone_no").val().length, !1;
        },
        "Please enter a phone number minimum 5 digits and maximum 20 digits."
    ),
    $.validator.addMethod("NotZero", function (value, element) {
        if (value <= 0) {
            return false;
        } else {
            return true;
        }
    }, "Please enter greater than zero.");
jQuery.validator.addMethod(
    "noSpace",
    function (e, t) {
        return !(e.trim().length <= 0);
    },
    "No space please and don't leave it empty"
),
    $.validator.addMethod(
        "no_url",
        function (e, t) {
            var a = $.trim(e);
            return (
                "" == a ||
                (null ==
                    a.match(
                        /\(?(?:(http|https|ftp):\/\/)?(?:((?:[^\W\s]|\.|-|[:]{1})+)@{1})?((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\## Heading ##W\s]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]]*))?([\#][^\s\n]*)?\)?/g
                    ) &&
                    0 == /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(a)) ||
                void 0
            );
        },
        "URL not allow."
    ),
    jQuery.validator.addMethod(
        "emailFormat",
        function (e, t) {
            return this.optional(t) || /^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,4})$/.test(e);
        },
        "Enter valid email format"
    ),
    jQuery.validator.addMethod(
        "messageValidation",
        function (e, t) {
            return !(!this.optional(t) && 0 != /<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/.test(e));
        },
        "Enter valid message"
    ),
    jQuery.validator.addMethod(
        "xssProtection",
        function (e, t) {
            return validateXSSInput(e);
        },
        "Please enter valid input."
    );

function occurrences(e, t) {
    for (var a = 0, n = 0; -1 != (n = e.indexOf(t, n));) a++, (n += t.length);
    return a;
}
function validateXSSInput(e) {
    for (var t = occurrences(e, "#"), a = $("<textarea/>").html(e).val(), n = 1; n <= t; n++) a = $("<textarea/>").html(a).val();
    return (
        !e.match(/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/i) &&
        !e.match(/<img|script[^>]+src/i) &&
        !a.match(/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/i) &&
        !a.match(/<img|script[^>]+src/i) &&
        !a.match(/((\%3C)|<)(|\s|\S)+((\%3E)|>)/i)
    );
}