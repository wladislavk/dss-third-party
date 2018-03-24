var row_count = 1;

function add_row()
{
    var row = '<tr id="extra_row_'+row_count+'">';
    row += '<td valign="top">';
    row += '<input type="text" name="extra_name_'+row_count+'" value="" />';
    row += '</td><td valign="top">';
    row += '<input type="text" name="extra_service_date_'+row_count+'" value="'+date+'" />';
    row += '</td><td valign="top">';
    row += '<a href="#" onclick="$(\'#extra_row_'+row_count+'\').remove(); calcTotal();">Remove</a>';
    row += '</td><td valign="top">';
    row += '$<input type="text" class="amount" name="extra_amount_'+row_count+'" value="195.00" />';
    row += '</td></tr>';


    $('#extra_total').val(row_count);

    $(row).insertBefore('#total_row');

    row_count++;
    setupAmount();
    calcTotal();
}

function calcTotal()
{
    a = 0;
    $('.amount').each(function(){
        a += Number($(this).val());
    });
    a = a.toFixed(2);
    $('#total').html('$'+a);
}

function setupAmount()
{
    $('.amount').keyup(function(){
        calcTotal();
    });
}

setupAmount();