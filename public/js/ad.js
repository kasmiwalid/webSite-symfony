 //Ajouter une image
 $('#add-image').click(function(){
    // je recupere le numero des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    //Je recupere le prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
    
    //J'injecte ce code au sein de la div 
    $('#ad_images').append(tmpl);

    //Pour rajouter encore une autre image +1
    $('#widgets-counter').val(index + 1);

    //Je gere le button supprimer
    handleDeleteButtons();
});

//Supprimer une image
function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}
function updateCounter() {
    const count = +$('#ad_images div.form-group').lenght;  
    $('#widgets-counter').val(count);      
}
updateCounter();
handleDeleteButtons();