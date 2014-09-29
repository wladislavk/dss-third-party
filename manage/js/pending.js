function redirect(loc){
    if(prompt('Enter the password to use this function:')=='dss789'){
        window.location = loc;
    }else{
        alert('Incorrect password');
    }
    return false;
}