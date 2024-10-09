// Filtro Global
$('#globalFilter').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    filterTable();
});

// Filtro por Coluna
$('.filter').on('keyup', function () {
    filterTable();
});

function filterTable() {
    var globalValue = $('#globalFilter').val().toLowerCase();

    $('#sortableTable tbody tr').filter(function () {
        var row = $(this);
        var showRow = true;

        // Aplicar filtro global
        if (globalValue && row.text().toLowerCase().indexOf(globalValue) === -1) {
            showRow = false;
        }

        // Aplicar filtro por coluna
        $('.filter').each(function () {
            var columnIndex = $(this).data('column');
            var columnValue = $(this).val().toLowerCase();
            var cell = row.find('td').eq(columnIndex).text().toLowerCase();

            if (columnValue && cell.indexOf(columnValue) === -1) {
                showRow = false;
            }
        });

        row.toggle(showRow);
    });
}

// Botão Resetar Filtros
$('#resetBtn').on('click', function () {
    $('#globalFilter').val('');
    $('.filter').val('');
    filterTable();
});

// Ordenação das Colunas
$('th').on('click', function () {
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tbody tr').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) rows = rows.reverse();
    table.children('tbody').empty().html(rows);
});

function comparer(index) {
    return function (a, b) {
        var valA = getCellValue(a, index),
            valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
    };
}

function getCellValue(row, index) {
    return $(row).children('td').eq(index).text();
}

/* Evita que os inputs do cabeçalho ordenem as colunas */
function clicouNoFilho(event) {
    event.stopPropagation();  // Isso impede o clique de propagar para o pai
    console.log('Clicou no filho');
}