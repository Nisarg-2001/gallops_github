var productJsonArr = JSON.parse(productJsonArr);



var i = $("table.outward-table").find("tr").length;

$('#outwardForm').validate({
    rules: {
        person_name: {
            required: true,
            xssProtection: true
        },
        "date_of_issue": {
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



$(document).on('change', '#product_id', function () {
    let product_id = $(this).val();
    if (product_id) {
        $('#outwardProductData').show();
         let uom = $('#product_id option:selected').attr('data-unit');
         $('#uom').val(uom);
    } else {
        $('#outwardProductData').hide();
    }
});


$(document).on('click', '#addOutwardProduct', function () {
    if ($('#product_id').val() === '') {
        alert('Please select product.');
        return false;
    }

    if (!$('#qty').val()) {
        alert('Please enter quantity.');
        
        return false;
    }
    let product_id = $('#product_id').val();
    let qty = $('#qty').val();
    let avl_qty = $('#product_id option:selected').attr('data-qty');
    let unit_price = $('#product_id option:selected').attr('data-price');
    

    if (parseInt(qty) > parseInt(avl_qty)) {
        alert("Please enter quantity less than available quanity.");
        return false;
    }
    
    var isValid = true;
    
    $.each(productJsonArr, function( index, value ) {
        if (product_id == value.id) {
            if (parseInt(qty) > parseInt(value.qty)) {
                alert("Please enter quantity less than available quanity.");
                isValid = false;
                return false;
            }
            
            productJsonArr[index].qty = value.qty - qty;
        }
    });
    
    if (isValid === false) {
        return false;
    }
    
    addOutwardProduct();

    return false;
});


$("table.outward-table").on('click', 'button.removethis', function (e) {

    $(this).closest('tr').remove();
    i--;
});

function addOutwardProduct() {
    let product_id = $('#product_id').val();
    let product_name = $('#product_id option:selected').attr('data-pname');
    let unit = $('#product_id option:selected').attr('data-unit');
    let unit_price = $('#product_id option:selected').attr('data-price');
    let qty = $('#qty').val();
   

    let row = '<tr id="row_' + product_id + '">';
    row += '<td>' + i + '<input type="hidden" name="product_id[]" value="' + product_id + '"></td>';
   
    row += '<td>' + product_name + '</td>';
    row += '<td align="right">' + qty + '<input type="hidden" name="qty[]" value="' + qty + '"></td>';
    row += '<td>' + unit + '<input type="hidden" name="unit[]" value="' + unit + '"></td>';
    row += '<td align="right">' + unit_price + '<input type="hidden" name="unit_price[]" value="' + unit_price  + '"></td>';
    row += '<td><button type="button" class="btn btn-danger btn-sm removethis" title="Remove"><i class="fa fa-trash"></i></button></td>';
    row += "</tr>";

    $("table.outward-table").append(row);
    
    resetData();

    i++;
    
}

function resetData() {
    $('#qty').val(1);
}