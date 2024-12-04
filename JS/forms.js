document.getElementById('form-princ').addEventListener('submit', function(event) {
    var form = this;
    var elements = form.elements;

    // Loop para verificar todos os campos do formulário
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];

        // Se o campo não estiver preenchido, removemos o atributo 'name'
        if (element.type !== 'submit' && element.value === '') {
            element.removeAttribute('name');
        }
    }
});