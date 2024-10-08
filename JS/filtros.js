 // Filtro Global
 $('#globalFilter').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    $('#sortableTable tbody tr').filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// Filtro por Coluna
$('.filter').on('keyup', function () {
    var column = $(this).data('column');
    var value = $(this).val().toLowerCase();
    $('#sortableTable tbody tr').each(function () {
        var cell = $(this).find('td').eq(column);
        $(this).toggle(cell.text().toLowerCase().indexOf(value) > -1);
    });
});

// Botão Resetar Filtros
$('#resetBtn').on('click', function () {
    $('#globalFilter').val('');
    $('.filter').val('');
    $('#sortableTable tbody tr').show();
});
