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

$(document).on('change', '#product', function () {
    let product_id = $(this).val();
    getTax(product_id);
});

function getTax(product_id) {
    $.ajax({
        url: APP_URL + 'assign_product/getTax',
        type: 'POST',
        data: {
            product_id: product_id,
        },
        success: function (data) {
            $('#taxSection').html(data.data);
        }
    });
}