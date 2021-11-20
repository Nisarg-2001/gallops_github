$('#productForm').validate({
    rules: {
        name: {
            required: true,
            xssProtection: true
        },
        alias: {
            required: true,
            xssProtection: true
        },
    },
    messages: {
        name: {
            required: "Please enter a Product Name",
        },
        alias: {
            required: "Please enter a Product alias Name",
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