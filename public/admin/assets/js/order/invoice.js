var taxList = {};
var taxData = {};
$(document).ready(function () {
    getAllTaxes();
});

$('input[name^="taxAmount"]').each(function () {
        
        totalTax = parseFloat(totalTax) + parseFloat($(this).val());

        for (const key in taxList) {
            let t = $(this).attr('tax-' + key);
            if (t) {
                taxData['tax-' + key] += parseFloat(t);
            }
        }
    });
    for (const key in taxList) {
        if (taxData['tax-' + key]) {
            $("#hiddenTotalTax_" + key).val((taxData['tax-' + key]).toFixed(2));
            $("#TotalSingleTax_" + key).html((taxData['tax-' + key]).toFixed(2));
        }
    }
function getAllTaxes() {
    $.ajax({
        url: APP_URL + 'user/order/getTaxes',
        type: 'POST',
        success: function (data) {
            data.forEach(function (currentValue, index, arr) {
                taxList[currentValue.id] = currentValue;
            });

            // reset tax
            for (const key in taxList) {
                taxData['tax-' + key] = 0;
            }
        }
    });
}