$('#taxForm').validate({
    rules: {
        name: {
            required: true,
            xssProtection: true
        },
        value: {
            required: true,
            xssProtection: true
        },
    },
    messages: {
        name: {
            required: "Please enter a Tax Name",
        },
        value: {
            required: "Please provide a Value",
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});