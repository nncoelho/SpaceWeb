//=============================================
// FICHEIRO PRINCIPAL DE JAVASCRIPT
//=============================================

function gerarPassword(numLetras){
    
    // GERA UMA PASSWORD ALEATÓRIA
    let text_password = document.getElementById('text_password');

    let caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?()-%';
    let codigo = '';
    for(let i=0; i < numLetras ; i++){
        let r = Math.floor( Math.random() * caracteres.length) + 1;
        codigo += caracteres.substr(r,1);
    }

    // COLOCA O CÓDIGO NO CAMPO DA PASSWORD
    text_password.value = codigo;    
}

// CONTROL AS CHECKBOXS DAS CAIXAS DAS PERMISSOES
function checks(estado){
    $('input:checkbox').prop('checked', estado);
}