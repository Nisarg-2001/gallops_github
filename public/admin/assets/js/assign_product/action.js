$('#assignProductForm').validate({
    rules: {
        vendor_id: {
            required: true,
        },
        product_id: {
            required: true,
        },
        // "tax_value[]": {
            
        // },
        "price": {
            required: true,
        },
        alias: {
            required: true,
            xssProtection: true
        },
    },
    messages: {
        "tax_value[]": {
            pattern: "Please enter a valid value."
        },
        price: {
            pattern: "Please enter a valid value."
        }
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

$(document).ready(function () {
    // getTax();
    let urlParams = new URLSearchParams(window.location.search);
    let product_id = urlParams.get('product');
    getTax(product_id);

});

$(document).on('change', '#product_id', function () {
    let product_id = $('#product_id').val();
    getTax(product_id);
});

function getTax(product_id) {
    if (!product_id) {
        return false;
    }

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