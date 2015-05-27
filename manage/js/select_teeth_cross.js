function cal_send_per()
{
    dd = document.selfrm;
    tt = dd.t_text.value;

    d_count = 0;
    d_msg = '';
    for(i = 0; i < dd.elements.length; i++) {
        if(dd.elements[i].name == 'per_teeth[]' && dd.elements[i].checked) {
            if(d_msg != '') {
                d_msg = d_msg + '/';
            }
            d_msg = d_msg + dd.elements[i].value;
            d_count++;
        }
    }

    if(d_count == 2) {
        if(tt != '') {
            tt = tt + '\n';
        }

        tt = tt + d_msg;
        dd.t_text.value = tt;
        
        for(i = 0; i < dd.elements.length; i++) {
            if(dd.elements[i].name == 'per_teeth[]' && dd.elements[i].checked) {
                dd.elements[i].checked = false;
            }
        }
    }
}

function cal_send_pri()
{
    dd = document.selfrm;
    tt = dd.t_text.value;

    d_count = 0;
    d_msg = '';
    for(i = 0; i < dd.elements.length; i++) {
        if(dd.elements[i].name == 'pri_teeth[]' && dd.elements[i].checked) {
            if(d_msg != '') {
                d_msg = d_msg + '/';
            }
            d_msg = d_msg + dd.elements[i].value;
            d_count++;
        }
    }
    
    if(d_count == 2) {
        if(tt != '') {
            tt = tt + '\n';
        }

        tt = tt + d_msg;
        dd.t_text.value = tt;
        
        for(i = 0; i < dd.elements.length; i++) {
            if(dd.elements[i].name == 'pri_teeth[]' && dd.elements[i].checked) {
                dd.elements[i].checked = false;
            }
        }
    }
}

function fill_up()
{
    fa = document.selfrm.t_text.value;
    var tx = getParameterByName('tx');
    fa = fa.replace(/\n/g,', ');
    parent.$("#ex_page4frm [name='" + tx + "']").val(fa);
    parent.disablePopupRefClean();
}
