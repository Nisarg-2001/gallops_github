$('#catForm').validate({
    rules: {
        title: {
            required: true,
            xssProtection: true
        },
        description: {
            required: true,
            xssProtection: true
        },
    },
    messages: {
        title: {
            required: "Please enter category title.",
        },
        description: {
            required: "Please enter description.",
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