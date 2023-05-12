$( document ).ready(function() {
    
    $('.formulario').submit(function(event){
        
        var valido = false;
        var campoNome = $('#nome');
        
        if(campoNome.val().trim() === ''){
            campoNome.css('border-color','red');
            valido = true;
        }
        if(valido){
            event.preventDefault();
        }
    });
});





