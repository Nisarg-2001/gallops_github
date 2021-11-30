var products = {};
var taxList = {};
var taxData = {};

var i = $("table.order-table tbody tr").length;

$(document).ready(function () {
    getAllProducts();
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

    


    var row = "<tr style='background-color: #f9f9f9;'><td class='text-center'>" + i + "</td>";

    row += "<td><input type='text' value='" + products[itemid].name + "' id='Item_" + i + "' name='Item[]' class='form-control ' readonly><input type='hidden' name='intItemID[]' id='intItemID_" + i + "' value='" + itemid + "'> </td>";

    row += "<td><input type='number' value='1' id='Qty_" + i + "' name='Qty[]' class='form-control filterme' min='1' max='9999'  ></td>";

    row += '<td><button type="button" class="btn btn-danger btn-sm removethis" title="Remove"><i class="fa fa-trash"></i></button></td>';

    row += "</tr>";

    $("table.order-table").append(row);


    i++;
});

$("table.order-table").on('click', 'button.removethis', function (e) {

    $(this).closest('tr').remove();

  
    // updateTotal();
});




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

