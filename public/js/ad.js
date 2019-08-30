$('#add-image').click(function(){
    // je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();
console.log(index);

    // je récupère le prototype des entrées et je le remplace par le bon numéro
    const tmpl = $('#ad_images').data('prototype').replace(/_name_/g, index);
    
    //j'inject ce code au sein de la div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // je gere la supression du bouton
    handelDeleteButtons();
});
// fonction supression dune image 
function handelDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target
        $(target).remove();
    });
}