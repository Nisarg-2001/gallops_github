var i = $("table.inward-table").find("tr").length;

$('#inwardForm').validate({
    rules: {
        vendor_id: {
            required: true,
        },
        order: {
            required: true,
            xssProtection: true
        },
        // "tax_value[]": {

        // },
        "billno": {
            required: true,
            xssProtection: true
        },
        "dateofreceive": {
            required: true,
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



$(document).on('change', '#vendor_id', function () {
    let vendor_id = $(this).val();
    if (vendor_id) {
        $('#vendor').val(vendor_id);

        $.ajax({
            url: APP_URL + 'user/inward/getProductByVendorId',
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
                        options += "<option value='" + value.id + "' data-unit='" + value.unit_name + "' data-price='" + value.price + "' data-tax='" + value.tax + "'>" + value.name + "</option>";
                    });
                    $('#product_id').html(options);
                    $('.select2').select2();
                }
            }
        });
    } else {
        $('#inwardProductData').hide();
        $("#vendor_id").select2({ disabled: false });
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
    console.log($('#tax').val());
    if (!$('#tax').val()) {
        alert('Please select tax.');
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

$(document).on('change', '#product_id', function () {
    let unit_price = $('#product_id option:selected').attr('data-price');
    $('#unit_price').val(unit_price);
});

function addInwardProduct() {
    let product_id = $('#product_id').val();
    let product_name = $('#product_id option:selected').text();
    let productTax = $('#product_id option:selected').attr('data-tax');
    
    productTax = JSON.parse(productTax);
    let unit = $('#product_id option:selected').attr('data-unit');
    let qty = $('#qty').val();
    let unit_price = $('#unit_price').val();
    let tax = $('#tax').val();

    var taxArr = [];

    let taxVal = 0;
    let sub_total = qty * unit_price;

    productTax.forEach(function (currentValue, index, arr) {
        if(tax.includes(currentValue.id)) {
            taxVal += (currentValue.value * sub_total) / 100;
            taxArr.push(currentValue);
        }
    });

    let taxStr = JSON.stringify(taxArr);

    let total = sub_total + taxVal;

    let cost_per_item = total / qty;
    
    
    let batch_number = $('#batch_number').val();

    let packaging_month_text = $('#packaging_month option:selected').text();
    let packaging_month = $('#packaging_month option:selected').val();

    let packaging_year = $('#packaging_year option:selected').val();

    let packaging_date = '01-' + packaging_month + '-' + packaging_year;

    let row = '<tr id="row_' + product_id + '">';
    row += '<td>' + i + '<input type="hidden" name="product_id[]" value="' + product_id + '"></td>';
    row += '<td>' + product_name + '</td>';
    row += '<td>' + unit_price + '<input type="hidden" name="unit_price[]" value="' + unit_price + '"></td>';
    row += '<td>' + qty + ' ' + unit + '<input type="hidden" name="qty[]" value="' + qty + '"></td>';
    //row += '<td>' + unit + '<input type="hidden" name="unit[]" value="' + unit + '"></td>';
    row += '<td>' + taxVal + '<input type="hidden" name="tax[]" value="' + taxVal + '">' + "<input type='hidden' name='taxStr[]' value='" + taxStr + "'></td>";
    row += '<td>' + packaging_month_text + '-' + packaging_year + '<input type="hidden" name="monthYear[]" value="' + packaging_date + '"></td>';
    row += '<td>' + batch_number + '<input type="hidden" name="batch_number[]" value="' + batch_number + '"></td>';
    row += '<td>' + cost_per_item + '<input type="hidden" name="cost_per_item[]" value="' + cost_per_item + '"></td>';
    row += '<td><button type="button" class="btn btn-danger btn-sm removethis" title="Remove"><i class="fa fa-trash"></i></button></td>';
    row += "</tr>";

    $("table.inward-table").append(row);

    resetData();

    i++;

}

function resetData() {
    const d = new Date();
    let month = d.getMonth() + 1; //months from 1-12
    let year = d.getFullYear();
    $('#product_id').val('');
    $('#unit_price').val('');
    $('#qty').val(1);
    $('#batch_number').val('');
    $('#packaging_month').val(month);
    $('#packaging_year').val(year);
    $('#tax').val(null).trigger('change');
    $('.select2').select2();
}