function check() {           
    for (var i = 0; i < document.forms[0].elements.length; i++) {
        var element = document.forms[0].elements[i];
        switch (element.type) {
            case 'text'://textbox type
                document.forms[0].elements[i].readOnly = true;
                break;
            case 'select-one'://dropdown
                document.forms[0].elements[i].readOnly = true;
                document.forms[0].elements[i].disabled = true;
                break;
            case 'checkbox'://checkbox
                document.forms[0].elements[i].disabled = true;
                break;
            case 'radio'://radiobutton
                document.forms[0].elements[i].disabled = true;
                break;
            case 'button'://button
                document.forms[0].elements[i].disabled = true;
                break;
            case 'submit'://button
                document.forms[0].elements[i].disabled = true;
                break;
            case 'textarea'://textarea
                document.forms[0].elements[i].readOnly = true;
                break;
        }
    }
}
