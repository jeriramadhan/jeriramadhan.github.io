input.addEventListener('invalid', function(e) {
    if(input.validity.valueMissing){
        e.target.setCustomValidity("Tidak Boleh Kosong!"); 
    } else{
        e.target.setCustomValidity(""); 
    } 
}, false);