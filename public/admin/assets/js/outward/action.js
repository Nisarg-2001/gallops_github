var i = 1;

$('#outwardForm').validate({
    rules: {
        person_name: {
            required: true,
            xssProtection: true
        },
        "date_of_issue": {
            required: true,
            xssProtection: true
        },
    },
    messages: {

        // price: {
        //     pattern: "Please enter a valid value."
        // }
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



$(document).on('change', '#product_id', function () {
    let vendor_id = $(this).val();
    if (vendor_id) {
        $('#vendor').val(vendor_id);
        $("#vendor_id").select2({disabled:'readonly'});
        
        $.ajax({
            url: APP_URL + 'inward/getProductByVendorId',
            type: 'POST',
            data: {
                vendor_id: vendor_id,
            },
            beforeSend: function () {
                $("#inwardForm").find('input[type=submit]').attr('disabled', true);
            },
            complete: function () {
                $("#inwardForm").find('input[type=submit]').attr('disabled', false);
            },
            success: function (data) {
                if (data) {
                    $('#inwardProductData').show();
                    $('#changeVendor').show();
                    let options = '<option value="">Select Product</option>';
                    $.each(data, function (key, value) {
                        options += '<option value="' + value.id + '" data-unit="' + value.unit + '">' + value.name + '</option>';
                    });
                    $('#product_id').html(options);
                    $('.select2').select2();
                }
            }
        });
    } else {
        $('#inwardProductData').hide();
        $("#vendor_id").select2({disabled:false});
        $('#vendor').val('');
        $('#changeVendor').hide();
    }
});


$(document).on('click', '#addInwardProduct', function () {
    if ($('#product_id').val() == '') {
        alert('Please select product.');
        return false;
    }

    if (!$('#qty').val()) {
        alert('Please enter quantity.');
        return false;
    }

    if (!$('#batch_number').val()) {
        alert('Please enter batch number.');
        return false;
    }

    addInwardProduct();

    return false;
});


$("table.inward-table").on('click', 'button.removethis', function (e) {

    $(this).closest('tr').remove();
    i--;
});

function addInwardProduct() {
    let product_id = $('#product_id').val();
    let product_name = $('#product_id option:selected').text();
    let unit = $('#product_id option:selected').attr('data-unit');
    let qty = $('#qty').val();
    let batch_number = $('#batch_number').val();

    let packaging_month_text = $('#packaging_month option:selected').text();
    let packaging_month = $('#packaging_month option:selected').val();

    let packaging_year = $('#packaging_year option:selected').val();

    let row = '<tr id="row_' + product_id + '">';
    row += '<td>' + i + '<input type="hidden" name="product_id[]" value="' + product_id + '"></td>';
    row += '<td>' + product_name + '</td>';
    row += '<td>' + qty + '<input type="hidden" name="qty[]" value="' + qty + '"></td>';
    row += '<td>' + unit + '<input type="hidden" name="unit[]" value="' + unit + '"></td>';
    row += '<td>' + packaging_month_text + '-' + packaging_year + '<input type="hidden" name="monthYear[]" value="' + packaging_month + '-' + packaging_year + '"></td>';
    row += '<td>' + batch_number + '<input type="hidden" name="batch_number[]" value="' + batch_number + '"></td>';
    row += '<td><button type="button" class="btn btn-danger btn-sm removethis" title="Remove"><i class="fa fa-trash"></i></button></td>';
    row += "</tr>";

    $("table.inward-table").append(row);

    i++;
    
}