$(document).ready(function () {
    setVendorList();
});

$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

$(document).on('change', 'select[name^="vendor"]', function () {
    //debugger
    let id = $(this).attr('data-id');
    let vendor_price = $(this).find(':selected').attr('data-price');
    let vendor_tax = $(this).find(':selected').attr('data-tax');

    JSON.parse

    $("#vendorPrice_" + id).val(vendor_price);
    $("#vendorTax_" + id).val(vendor_tax);
});

function setVendorList() {
    $('select[name^="vendor"]').each(function () {
        let product_id = $(this).attr('data-item');
        let qty = $(this).attr('data-item');
        let current_vendor = $(this).val();
        getVendorsByProduct($(this), product_id, qty, current_vendor);
    });
}

function getVendorsByProduct(element, product_id, qty, current_vendor) {
    $.ajax({
        url: APP_URL + 'admin-order/getVendorsByProduct',
        type: 'POST',
        data: { 
            product_id: product_id,
            qty: qty,
            current_vendor: current_vendor,
        },
        success: function (data) {
            if (data) {
                data.forEach(function (currentValue, index, arr) {
                    let vendorName = currentValue.vendor_name + ' (' + currentValue.vendor_total_amt.toFixed(2) + ')';
                    element.append("<option value='" + currentValue.vendor_id + "' data-price='" + currentValue.vendor_price + "' data-tax='" + currentValue.vendor_tax + "'>" + vendorName + "</option>");
                });
            }
        }
    });
}