//====================================
// Ficheiro principal de JavaScript
//====================================

function gerarPassword(numLetras){
    
    // Gerar uma Password Aleatória
    let text_password = document.getElementById('text_password');

    let caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?()-%';
    let codigo = '';
    for(let i=0; i < numLetras ; i++){
        let r = Math.floor( Math.random() * caracteres.length) + 1;
        codigo += caracteres.substr(r,1);
    }

    // Coloca o Código no campo da Password
    text_password.value = codigo;    
}

// =================================================================
function checks(estado){
    $('input:checkbox').prop('checked', estado);
}