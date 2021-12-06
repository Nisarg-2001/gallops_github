$('#resetForm').validate({
    rules: {
        ctpass: {
            required: true,
            minlength: 5,
            xssProtection: true
        },
        pass: {
            required: true,
            minlength: 5,
            xssProtection: true
        },
        cnpass: {
            required: true,
            minlength: 5,
            xssProtection: true
        },
    },
    messages: {
        ctpass: {
            required: "Please provide a Cureent Password",
            minlength: "Your password must be at least 5 characters long"
        },
        pass: {
            required: "Please provide a New Password",
            minlength: "Your password must be at least 5 characters long"
        },
        cnpass: {
            required: "Please Confirm Your Password",
            minlength: "Your password must be at least 5 characters long"
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