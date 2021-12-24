var products = {};
var taxList = {};
var taxData = {};

var i = $("table.order-table tbody tr").length;

$(document).ready(function () {
    getAllProducts();
    getAllTaxes();
});

$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});

$("#product_id").change(function () {
    count = $("table.order-table tbody tr").length;
    itemid = $(this).val();

    var taxes = JSON.parse(products[itemid].tax);
    var totalTaxAmt = 0;
    var taxStr = "";

    if (taxes.length > 0) {
        taxes.forEach(function (currentValue, index, arr) {
            let t = 0;
            t = ((products[itemid].price * currentValue.value) / 100);
            totalTaxAmt += t;

            taxStr = taxStr + ' ' + 'tax-' + currentValue.id + '=' + '"' + t + '"';
        });
    }


    var row = "<tr style='background-color: #f9f9f9;'><td class='text-center'>" + i + "</td>";

    row += "<td><input type='text' value='" + products[itemid].name + "' id='Item_" + i + "' name='Item[]' class='form-control ' readonly><input type='hidden' name='intItemID[]' id='intItemID_" + i + "' value='" + itemid + "'> <input type='hidden' name='itemTax[]'  id='itemTax_" + i + "' value='" + products[itemid].tax + "' data-id='" + i + "'></td>";

    row += "<td><input type='text' value='" + products[itemid].price + "' id='NetPrice_" + i + "' name='NetPrice[]' class='form-control filterme' readonly></td>";

    row += "<td><input type='number' value='1' id='Qty_" + i + "' name='Qty_[]' class='form-control filterme' min='1' max='9999'  onkeyup=updateAmount(" + itemid + ',' + i + ", 'cd') onchange=updateAmount(" + itemid + ',' + i + ",'ab')></td>";

    row += "<td><input type='text' value='" + products[itemid].price + "' id='Amount_" + i + "' name='Amount[]' class='form-control filterme' readonly><input type='hidden' name='taxAmount[]'  id='taxAmount_" + i + "' value='" + totalTaxAmt + "' data-id='" + i + "' " + taxStr + "></td>";

    row += '<td><button type="button" class="btn btn-danger btn-sm removethis" title="Remove"><i class="fa fa-trash"></i></button></td>';

    row += "</tr>";

    $("table.order-table").append(row);

    updateTotal();

    $("#taxTotal").show();

    i++;
});

$("table.order-table").on('click', 'button.removethis', function (e) {

    $(this).closest('tr').remove();
    var ctr = $("table.order-table tbody tr").length;

    if (ctr == 1) {
        for (const key in taxList) {
            taxData['tax-' + key] = 0;
        }
        for (const key in taxList) {
            $("#hiddenTotalTax_" + key).val((taxData['tax-' + key]).toFixed(2));
            $("#TotalSingleTax_" + key).html((taxData['tax-' + key]).toFixed(2));
        }
        $("#taxTotal").hide();
    } else {
        updateTotal();
    }

    // updateTotal();
});



function updateAmount(itemid, id, e) {

    let unitprice = $("#NetPrice_" + id).val();
    let qty = $("#Qty_" + id).val();
    let amount = qty * unitprice;

    $("#Amount_" + id).val(amount.toFixed(2));

    //update tax amount
    let taxes = JSON.parse($("#itemTax_" + id).val());
    let tax_amount = 0;

    if (taxes.length > 0) {
        taxes.forEach(function (currentValue, index, arr) {
            let t = 0;
            t = (amount * currentValue.value) / 100;
            tax_amount += t;
            $("#taxAmount_" + id).attr('tax-' + currentValue.id, t);
        });
        $("#taxAmount_" + id).val(tax_amount.toFixed(2));
    }

    updateTotal();
}

function updateTotal() {
    var SubTotalAmt = '0';
    var TotalAmt = 0;
    var totalTax = 0;

    $('input[name^="Amount"]').each(function () {
        SubTotalAmt = parseFloat(SubTotalAmt) + parseFloat($(this).val());
    });

    console.log(taxData);

    $('input[name^="taxAmount"]').each(function () {
        
        totalTax = parseFloat(totalTax) + parseFloat($(this).val());

        for (const key in taxList) {
            let t = $(this).attr('tax-' + key);
            if (t) {
                taxData['tax-' + key] += parseFloat(t);
            }
        };
    });

    //calculate tax
    for (const key in taxList) {
        if (taxData['tax-' + key]) {
            $("#hiddenTotalTax_" + key).val((taxData['tax-' + key]).toFixed(2));
            $("#TotalSingleTax_" + key).html((taxData['tax-' + key]).toFixed(2));
        }
    }

    var TotalAmt = parseFloat(SubTotalAmt) + parseFloat(totalTax);

    $("#SubTotalAmt").html(parseFloat(SubTotalAmt).toFixed(2));
    $("#hiddenSubTotalAmt").val(parseFloat(SubTotalAmt).toFixed(2));

    $("#TotalAmt").html(TotalAmt.toFixed(2));
    $("#hiddenTotalAmt").val(TotalAmt.toFixed(2));

    // reset tax
    for (const key in taxList) {
        taxData['tax-' + key] = 0;
    }
}

function check() {
    count = $("table.order-table tbody tr").length;
    if (count == '1') {
        swal("Sorry!", "Please select any product to place your order.", "error");
        return false;
    } else {
        var r = confirm("Please press 'OK' to confirm your order.");
        if (r == false) {
            return false;
        }
    }
}

function getAllProducts() {
    $.ajax({
        url: APP_URL + 'order/getProduct',
        type: 'POST',
        beforeSend: function () {
            $("#orderForm").find('input[type=submit]').attr('disabled', true);
        },
        complete: function () {
            $("#orderForm").find('input[type=submit]').attr('disabled', false);
        },
        success: function (data) {
            data.forEach(function (currentValue, index, arr) {
                products[currentValue.id] = currentValue;
            });
        }
    });
}

function getAllTaxes() {
    $.ajax({
        url: APP_URL + 'order/getTaxes',
        type: 'POST',
        beforeSend: function () {
            $("#orderForm").find('input[type=submit]').attr('disabled', true);
        },
        complete: function () {
            $("#orderForm").find('input[type=submit]').attr('disabled', false);
        },
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